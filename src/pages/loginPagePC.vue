<template>
  <div class="three-container" style="overflow: hidden;">
    <!-- Three.js 畫布 -->
    <canvas ref="threeCanvas" class="three-canvas"></canvas>

     <!-- ✅ 黑色遮罩 -->
     <div v-if="isLoginPopupOpen" class="login-overlay" @click="isLoginPopupOpen = false"></div>

    <!-- ✅ Vue 控制的登入彈窗 -->
    <member_login @click="handleLogin" v-if="isLoginPopupOpen" @login-success="handleLoginSuccess" @close="isLoginPopupOpen = false" class="popupBack" />
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import * as THREE from "three";
import { RGBELoader } from "three/examples/jsm/loaders/RGBELoader.js";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls.js";
import { TextureLoader } from "three";
import { CSS3DRenderer, CSS3DObject } from "three/examples/jsm/renderers/CSS3DRenderer.js";
import logoImage from "@/assets/images/logo_color4.svg";
import member_login from "@/pages/popup.vue";
import { useRouter } from "vue-router";

const isLoaded = ref(false);
const threeCanvas = ref(null);
const hdrPath = ref(new URL("@/assets/images/threePic/kloofendal_48d_partly_cloudy_puresky_1k.hdr", import.meta.url).href);
const isLoginPopupOpen = ref(false); // ✅ Vue 內部控制彈窗開關
const isRedirecting = ref(false); // ✅ 防止多次跳轉
let animationFrameId = ref(null); // ✅ 定義動畫幀 ID，避免 `ReferenceError`
const router = useRouter();
// const texturePath = new URL("@/assets/images/threePic/sky360.hdr", import.meta.url).href; // **球體材質圖片**
// const minY = -window.innerHeight / 2; // **視窗最低點**
// const maxY = window.innerHeight / 2;  // **視窗最高點**


let scene, camera, renderer, controls;
let mouseX = 0, mouseY = 0;
let windowHalfX = window.innerWidth / 2;
let windowHalfY = window.innerHeight / 2;
let spheres = [];
let cssRenderer;
let openLoginModal; // ✅ 先用 let 定義變數

// ✅ Vue 設定全域方法，讓 Three.js 內的 `create3DHTML()` 可以開啟登入彈窗
window.openLoginModal = () => {
  isLoginPopupOpen.value = true;
  console.log("🔥 Vue 內部控制：登入彈窗開啟！");
};

// ✅ **登入成功後的處理**
const handleLoginSuccess = () => {
  if (isRedirecting.value) return; // 防止多次點擊
  isRedirecting.value = true;

  console.log("✅ 使用者登入成功，導向後台！");

  // ✅ **先關閉登入彈窗**
  isLoginPopupOpen.value = false;

  // ✅ **短暫延遲，讓 UI 更新後再跳轉**
  setTimeout(() => {
    cancelAnimationFrame(animationFrameId.value); // ✅ 停止動畫
    disposeThreeJS(); // ✅ 確保 Three.js 完全釋放資源
  }, 500);
};

const disposeThreeJS = () => {
  console.log("🔥 開始清理 Three.js 場景與動畫");

  console.log("📌 animationFrameId:", animationFrameId);
  console.log("📌 renderer:", renderer);
  console.log("📌 scene:", scene);
  console.log("📌 threeCanvas.value:", threeCanvas.value);
  console.log("📌 controls:", controls);

 // ✅ **確保 animationFrameId 存在才取消動畫**
 if (typeof animationFrameId !== "undefined" && animationFrameId !== null) {
    cancelAnimationFrame(animationFrameId);
    animationFrameId = null;
    console.log("🛑 停止動畫");
  } else {
    console.warn("⚠️ animationFrameId 不存在，跳過停止動畫");
  }

   // ✅ **確保 WebGLRenderer 存在才釋放**
   if (renderer && typeof renderer.dispose === "function") {
    console.log("✅ 釋放 WebGL 渲染器");
    renderer.dispose();

    // 🔥 **確保 WebGL 畫布也被移除**
    if (renderer.domElement && renderer.domElement.parentNode) {
      renderer.domElement.parentNode.removeChild(renderer.domElement);
      console.log("✅ WebGL 畫布已從 DOM 移除");
    } else {
      console.warn("⚠️ WebGL 畫布 (`renderer.domElement`) 不存在，跳過移除");
    }

    renderer = null;
  } else {
    console.warn("⚠️ renderer 不存在或已經被釋放，跳過釋放");
  }


  // ✅ **完全清除 CSS3DRenderer 產生的 HTML**
if (cssRenderer) {
  console.log("✅ 嘗試清除 CSS3DRenderer 產生的 HTML 物件");

  // 1️⃣ **移除 `.three-html-container` 內的 HTML**
  document.querySelectorAll(".three-html-container").forEach((obj) => {
    obj.remove();
  });
  console.log("✅ 已移除 .three-html-container 內的 HTML");

  // 2️⃣ **強制刪除 `preserve-3d` & `translateZ` 相關的 `div`**
  document.querySelectorAll("div[style*='preserve-3d'], div[style*='translateZ'], div[style*='absolute']").forEach((container) => {
    if (container.parentNode) {
      container.parentNode.removeChild(container);
      console.log("✅ 已移除 CSS3DRenderer 產生的 div (preserve-3d)");
    }
  });

  // 3️⃣ **移除 `cssRenderer.domElement`**
  if (cssRenderer.domElement && cssRenderer.domElement.parentNode) {
    cssRenderer.domElement.parentNode.removeChild(cssRenderer.domElement);
    console.log("✅ CSS3DRenderer 畫布已從 DOM 移除");
  }

  // 4️⃣ **強制 `cssRenderer` 設為 `null`，避免記憶體洩漏**
  cssRenderer = null;
  } else {
    console.warn("⚠️ cssRenderer 不存在，跳過清除");
  }


  // ✅ 確保 controls 存在才禁用
  if (controls && typeof controls.dispose === "function") {
  console.log("✅ 移除 OrbitControls");
  controls.dispose();
  controls = null;
  } else {
    console.warn("⚠️ controls 不存在，跳過移除");
  }


  // ✅ **確保 threeCanvas 存在才從 DOM 移除**
  if (threeCanvas.value && threeCanvas.value.contains(renderer?.domElement)) {
    try {
      threeCanvas.value.removeChild(renderer.domElement);
      console.log("✅ 移除 threeCanvas");
    } catch (error) {
      console.warn("⚠️ 無法移除 threeCanvas，可能已被銷毀", error);
    }
  } else {
    console.warn("⚠️ threeCanvas.value 不存在或 renderer.domElement 已被釋放，跳過 DOM 移除");
  }

  // ✅ **確保動畫完全停止**
if (animationFrameId) {
  cancelAnimationFrame(animationFrameId);
  animationFrameId = null;
  console.log("🛑 停止動畫");
}


  // ✅ **確保所有變數設為 `null`，避免記憶體洩漏**
  camera = null;
  cssRenderer = null;
  animationFrameId = null;

  console.log("🎉 Three.js 清理完成！");
};







onMounted(() => {
  initThree();
  loadHDRBackground(hdrPath.value);
  createGlassBall(80); // 新增玻璃球
  animate();
  window.addEventListener("resize", onWindowResize);
  document.addEventListener("mousemove", onDocumentMouseMove);
  initCSSRenderer();
  create3DHTML();
  document.body.style.overflow = "hidden"; // 🚀 進入此頁時隱藏滾動條
  create3DHTML(); // 🚀 **原生 JS 方式建立按鈕**
  animationFrameId = requestAnimationFrame(animate);

  // ✅ 確保 `window.openLoginModal` 被正確定義
  onMounted(() => {
  openLoginModal = () => {
    const event = new CustomEvent("open-login-modal"); // 🚀 自訂事件
    window.dispatchEvent(event);
  };

  window.openLoginModal = openLoginModal; // ✅ 讓全域變數指向它
});


});

async function loadAllResources() {
  return new Promise((resolve) => {
    initThree();
    loadHDRBackground(hdrPath.value, resolve); // **背景載入後才繼續**
  });
}

onUnmounted(() => {
  document.body.style.overflow = ""; // 🎯 離開此頁時恢復正常滾動
  cancelAnimationFrame(animationFrameId); // ✅ **確保動畫結束**
  window.removeEventListener("login-success", () => {});
  animationFrameId = null;
  console.log("🔥 清除 Three.js 場景 & 動畫");
  disposeThreeJS();
  // **取消動畫**
  cancelAnimationFrame(animationFrameId);

  // **移除監聽事件**
  window.removeEventListener("resize", onWindowResize);



  // **從 DOM 移除 Three.js 畫布**
  if (threeCanvas.value) {
    threeCanvas .value.removeChild(renderer.domElement);
  }

  // **確保 Three.js 物件設為 `null`，避免記憶體洩漏**
  scene = null;
  camera = null;
  renderer = null;
  animationFrameId = null;
});



function initThree() {
  const container = threeCanvas.value;
  scene = new THREE.Scene();

  // **設置相機**
  camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 7, 5000);
  camera.position.set(0, 0, 1200); // 調整位置

  // **渲染器**
  renderer = new THREE.WebGLRenderer({ canvas: container, antialias: true });
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setPixelRatio(window.devicePixelRatio); // 🔥 確保高解析度
  renderer.physicallyCorrectLights = true; // 確保 PBR 渲染正確
  document.body.appendChild(renderer.domElement);

  // **CSS3DRenderer（渲染 HTML 物件）**
  cssRenderer = new CSS3DRenderer();
  cssRenderer.setSize(window.innerWidth, window.innerHeight);
  cssRenderer.domElement.style.position = "absolute";
  cssRenderer.domElement.style.top = "0";
  document.body.appendChild(cssRenderer.domElement);

  // **啟用 OrbitControls，但禁止滑鼠拖動**
  controls = new OrbitControls(camera, renderer.domElement);
  controls.enableDamping = true;
  controls.dampingFactor = 0.05;
  controls.rotateSpeed = .5;
  controls.enableZoom = false;
  controls.enablePan = false;
  controls.enableRotate = false; // **禁止滑鼠拖動**
}




function loadHDRBackground(hdrUrl) {
  console.log("🔍 嘗試載入 `.hdr`: ", hdrUrl);

  const loader = new RGBELoader();
  loader.load(
    hdrUrl,
    (texture) => {
      console.log("✅ `.hdr` 解析成功", texture);
      texture.mapping = THREE.EquirectangularReflectionMapping;
      scene.background = texture; // 設置全景背景
      scene.environment = texture; // 設置環境光
      // ✅ **當背景加載完成後，顯示 `be-cool-now-container`**
    setTimeout(() => {
      const htmlContainer = document.querySelector(".be-cool-now-container");
      if (htmlContainer) {
        htmlContainer.style.display = "flex";
      }
    }, 0);
    },
    undefined,
    (error) => {
      console.error("❌ `RGBELoader` 無法載入 `.hdr`:", error);
    }
  );
}

function createGlassBall(count) {
  const textureLoader = new TextureLoader();
  // const texture = textureLoader.load(texturePath); // 載入球體材質
  const minDistance = 500; // 球體之間的最小距離

  for (let i = 0; i < count; i++) {
    let positionValid = false;
    let sphere, sphereObj;

    while (!positionValid) {
    const sphereGeometry = new THREE.SphereGeometry(40, 100, 100); // 高解析球體
    const sphereMaterial = new THREE.MeshPhysicalMaterial({
      // map: texture, // 貼圖
      color: 0xffffff,
      metalness: 0, // 金屬感
      roughness: 0, // 光滑表面
      transmission: 1, // 玻璃透明度
      envMapIntensity: 10, // 讓玻璃更能反射環境光
      ior: 2.4, // 玻璃折射率
      clearcoat: 0.7, // 額外光澤
      clearcoatRoughness: 0, // 清漆層表面光滑
      transparent: true,
      opacity: .8,
      reflectivity: .7, // 反射環境
    });

    sphere = new THREE.Mesh(sphereGeometry, sphereMaterial);

    const angle = Math.random() * Math.PI * 30;
    const radius = 400 + Math.random() * 2000; // **擴大球體距離**
    const yPosition = Math.random() * 3000 - 1000; // **更大的 Y 範圍**

    sphere.position.set(
        Math.cos(angle) * radius,
        yPosition,
        Math.sin(angle) * radius
      );

    // **檢查球體是否與其他球體距離足夠遠**
    positionValid = true;
    for (const existingSphere of spheres) {
      const dx = existingSphere.mesh.position.x - sphere.position.x;
      const dy = existingSphere.mesh.position.y - sphere.position.y;
      const dz = existingSphere.mesh.position.z - sphere.position.z;
      const distance = Math.sqrt(dx * dx + dy * dy + dz * dz);

      if (distance < minDistance) {
        positionValid = false;
        break;
      }
    }
    }

    scene.add(sphere);
    sphereObj = {
      mesh: sphere,
      angle: Math.random() * Math.PI * 2,
      radius: Math.sqrt(sphere.position.x ** 2 + sphere.position.z ** 2),
      yPosition: sphere.position.y,
      speed: Math.random() * 0.002 + 0.0007,
    };
    spheres.push(sphereObj);
  }
}

function onDocumentMouseMove(event) {
  mouseX = (event.clientX - windowHalfX) / windowHalfX;
  mouseY = (event.clientY - windowHalfY) / windowHalfY;
}

function animate() {
  if (!camera || !renderer) return; // 🚀 **避免 `null` 錯誤**
  requestAnimationFrame(animate);

  camera.rotation.y = mouseX * .5; // **讓相機跟隨滑鼠左右移動**
  camera.rotation.x = -mouseY * 1.5; // **讓相機跟隨滑鼠上下移動**

  // **讓球體公轉**
  spheres.forEach((sphereObj) => {
    if (sphereObj.mesh) { // ✅ **確保 `mesh` 存在後才執行**
      sphereObj.angle += sphereObj.speed; // **每次增加一點角度**
      // **公轉運動**
      sphereObj.mesh.position.x = Math.cos(sphereObj.angle) * sphereObj.radius;
      sphereObj.mesh.position.z = Math.sin(sphereObj.angle) * sphereObj.radius;

      // **讓球體上下浮動**
      sphereObj.mesh.position.y = sphereObj.yPosition + Math.sin(Date.now() * 0.001 + sphereObj.angle) * 15;
      }
    });

  renderer.render(scene, camera);
  cssRenderer.render(scene, camera); // **渲染 HTML 物件**

}

function onWindowResize() {
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(window.innerWidth, window.innerHeight);
}

function create3DHTML() {
  const div = document.createElement("div");
  div.classList.add("three-html-container"); // **讓它適用 CSS 樣式**
  div.innerHTML = `
    <div class="be-cool-now-container" style="display:none;">
      <a href="/tid103/g1/"><div class="be-cool-now-button be-cool-now-front-btn">前台</div></a>
      <div class="be-cool-now-logo">
        <img src="${logoImage}" alt="涼城即時 Be Cool Now LOGO" />
      </div>
      <a><div id="backend-login-btn" class="be-cool-now-button be-cool-now-back-btn">後台</div></a>
    </div>
  `;

  // ✅ 綁定點擊事件，開啟 `popup.vue` 的登入彈窗
  setTimeout(() => {
    const backendBtn = document.getElementById("backend-login-btn");
    if (backendBtn) {
      backendBtn.addEventListener("click", () => {
        console.log("🟠 進入後台登入模式");

        // ✅ **設定 `redirectPath` 為後台路徑**
        localStorage.setItem("redirectPath", "/BackStagePages");

        // ✅ **開啟登入彈窗**
        window.openLoginModal();
      });
    }
}, 100);


  const htmlObject = new CSS3DObject(div);
  htmlObject.position.set(0, 100, -500); // **放置到 Three.js 空間**
  htmlObject.scale.set(3, 3, 3); // **放大 3 倍**

  scene.add(htmlObject);

  setTimeout(() => {
    const frontBtn = div.querySelector(".be-cool-now-front-btn");
    const backBtn = div.querySelector(".be-cool-now-back-btn");

    // 滑鼠移入動畫
    frontBtn.addEventListener("mouseenter", () => {
      frontBtn.style.transform = "scale(1.2)";
      frontBtn.style.filter = "drop-shadow(0px 0px 15px #d4a548)";
      frontBtn.style.backgroundColor = "rgb(212, 165, 72, .7)";
    });

    window.openLoginModal = () => {
      isLoginPopupOpen.value = true; // 🚀 Vue3 控制彈窗開啟
    };


   // 滑鼠移出動畫
   frontBtn.addEventListener("mouseleave", () => {
    frontBtn.style.transform = "scale(1)";
    frontBtn.style.filter = "drop-shadow(0px 0px 0px #d4a548)";
    frontBtn.style.backgroundColor = "rgb(212, 165, 72, .5)";
    });

  backBtn.addEventListener("mouseleave", () => {
    backBtn.style.transform = "scale(1)";
    backBtn.style.filter = "drop-shadow(0px 0px 0px #d4a548)";
    backBtn.style.backgroundColor = "rgb(212, 165, 72, .5)";
  });

  }, 1000);

}

function initCSSRenderer() {
  cssRenderer = new CSS3DRenderer();
  cssRenderer.setSize(window.innerWidth, window.innerHeight);
  cssRenderer.domElement.style.position = "absolute";
  cssRenderer.domElement.style.top = "0";
  cssRenderer.domElement.style.left = "0";
  cssRenderer.domElement.style.width = "100vw";
  cssRenderer.domElement.style.overflow = "hidden"; // 防止滾動條
  cssRenderer.domElement.style.pointerEvents = "none"; // 避免影響 HTML 點擊
  document.body.appendChild(cssRenderer.domElement);
}

window.addEventListener("login-success", () => {
    // console.log("✅ 使用者成功登入，檢查導向路徑");

    const redirectPath = localStorage.getItem("redirectPath") || "/";
    // console.log("🔍 `redirectPath`:", redirectPath);


    // ✅ **確保導向正確的頁面**
    router.push(redirectPath);
    // ✅ **清除 `redirectPath`，防止影響下次登入**
    // localStorage.removeItem("redirectPath");
    // ✅ **清除 `redirectPath`，防止影響下次登入**
    // setTimeout(() => {
    //     localStorage.removeItem("redirectPath");
    //     console.log("🗑️ `redirectPath` 已從 localStorage 清除");
    // }, 500); // 避免 `router.push()` 尚未完成就清除
});


</script>

<style lang="scss">
.popupBack{
  top: 58%;
  z-index: 999;

  .member-login-card{
    .member-login-form{
      .member-login-links{
        .member-login-register{
          display: none !important;
        }

      }
    }
  }

}

.login-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.3); /* 半透明黑色 */
  z-index: 998; /* 確保在背景之上，彈窗之下 */
  backdrop-filter: blur(1px); /* ✅ 背景模糊效果 */
  transition: opacity 0.3s ease-in-out;
}





</style>

