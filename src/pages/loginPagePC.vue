<template>
  <div class="three-container" style="overflow: hidden;">
    <!-- Three.js 畫布 -->
    <canvas ref="threeCanvas" class="three-canvas"></canvas>
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

const isLoaded = ref(false);
const threeCanvas = ref(null);
const hdrPath = ref(new URL("@/assets/images/threePic/kloofendal_48d_partly_cloudy_puresky_8k.hdr", import.meta.url).href);
// const texturePath = new URL("@/assets/images/threePic/sky360.hdr", import.meta.url).href; // **球體材質圖片**
// const minY = -window.innerHeight / 2; // **視窗最低點**
// const maxY = window.innerHeight / 2;  // **視窗最高點**


let scene, camera, renderer, controls;
let mouseX = 0, mouseY = 0;
let windowHalfX = window.innerWidth / 2;
let windowHalfY = window.innerHeight / 2;
let spheres = [];
let cssRenderer;


onMounted(() => {
  initThree();
  loadHDRBackground(hdrPath.value);
  createGlassBall(100); // 新增玻璃球
  animate();
  window.addEventListener("resize", onWindowResize);
  document.addEventListener("mousemove", onDocumentMouseMove);
  initCSSRenderer();
  create3DHTML();
  document.body.style.overflow = "hidden"; // 🚀 進入此頁時隱藏滾動條
});

async function loadAllResources() {
  return new Promise((resolve) => {
    initThree();
    loadHDRBackground(hdrPath.value, resolve); // **背景載入後才繼續**
  });
}

onUnmounted(() => {
  document.body.style.overflow = ""; // 🎯 離開此頁時恢復正常滾動
  console.log("🔥 清除 Three.js 場景 & 動畫");

      // **取消動畫**
      cancelAnimationFrame(animationFrameId);

      // **移除監聽事件**
      window.removeEventListener("resize", onWindowResize);

      // **釋放 WebGL 資源**
      renderer.dispose();

      // **清除場景中的所有物件**
      scene.traverse((object) => {
        if (!object.isMesh) return;
        object.geometry.dispose();
        object.material.dispose();
      });

      // **從 DOM 移除 Three.js 畫布**
      if (threeContainer.value) {
        threeContainer.value.removeChild(renderer.domElement);
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
  requestAnimationFrame(animate);

  camera.rotation.y = mouseX * .5; // **讓相機跟隨滑鼠左右移動**
  camera.rotation.x = -mouseY * 1.5; // **讓相機跟隨滑鼠上下移動**

  // **讓球體公轉**
  spheres.forEach((sphereObj) => {
    sphereObj.angle += sphereObj.speed; // **每次增加一點角度**
    // **公轉運動**
    sphereObj.mesh.position.x = Math.cos(sphereObj.angle) * sphereObj.radius;
    sphereObj.mesh.position.z = Math.sin(sphereObj.angle) * sphereObj.radius;

    // **讓球體上下浮動**
    sphereObj.mesh.position.y = sphereObj.yPosition + Math.sin(Date.now() * 0.001 + sphereObj.angle) * 15;
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
      <a href="/tid103/g1/BackStagePages"><div class="be-cool-now-button be-cool-now-back-btn">後台</div></a>
    </div>
  `;

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

    backBtn.addEventListener("mouseenter", () => {
      backBtn.style.transform = "scale(1.2)";
      backBtn.style.filter = "drop-shadow(0px 0px 15px #d4a548)";
      backBtn.style.backgroundColor = "rgb(212, 165, 72, .7)";
    });


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

</script>

