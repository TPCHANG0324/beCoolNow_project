<template>
  <div ref="overlay" class="loding-overlay">
    <div class="loading-container">
    <img ref="earth" :src="earthImage" class="earth" />

    <div class="thermometer-container">
      <!-- ✅ 溫度計容器 -->
      <div class="thermometer">
        <!-- ✅ 刻度線區域 -->
        <div class="scale">
          <div
            v-for="tick in majorTicks"
            :key="'major-' + tick"
            class="tick major"
            :style="{ bottom: tick + '%' }"
          ></div>
          <div
            v-for="tick in minorTicks"
            :key="'minor-' + tick"
            class="tick minor"
            :style="{ bottom: tick + '%' }"
          ></div>
        </div>

        <!-- ✅ 水銀柱 -->
        <div ref="mercury" class="mercury"></div>

        <!-- ✅ 底部圓形水銀球 -->
        <div class="bulb">
          <div ref="bulbMercury" class="bulb-mercury"></div>
        </div>
      </div>

      <!-- ✅ 數字顯示 (水銀柱同步上升) -->
      <div class="temperature-display">{{ temperatureValue }}%</div>
    </div>

    </div>
  </div>

</template>




<script setup>
import { ref, onMounted, nextTick } from "vue";
import gsap from "gsap";

const earthImage = ref(new URL("@/assets/images/loadingPic.svg", import.meta.url).href);
const mercury = ref(null);
const bulbMercury = ref(null);
const temperatureValue = ref(0);
const earth = ref(null);
const overlay = ref(null);

const majorTicks = [0, 20, 40, 60, 80, 100];
const minorTicks = [10, 30, 50, 70, 90];

onMounted(() => {
  nextTick(() => {
    if (overlay.value && earth.value && mercury.value && bulbMercury.value) {
      // ✅ 遮罩淡入
      gsap.fromTo(overlay.value, { opacity: 0 }, { opacity: 1, duration: .5 });

      // ✅ 初始化
      mercury.value.style.height = "0px";
      mercury.value.style.background = "#FFA500";
      bulbMercury.value.style.opacity = "0.7";
      bulbMercury.value.style.background = "#FFA500";
      temperatureValue.value = 0;

      console.log("🎬 開始同步動畫...");

      // ✅ 地球浮動畫
      gsap.to(earth.value, {
        y: -15,
        duration: 1,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut"
      });

      // ✅ 水銀柱 & 水銀球 顏色
      const mercuryGradient = "linear-gradient(to top, #FFA500, #FF4500)";
      const bulbGradient = "linear-gradient(to bottom, #FFA500, #FF4500)";

      // ✅ GSAP Timeline 確保動畫同步
      const tl = gsap.timeline();

      tl.to([bulbMercury.value, ".bulb"], {
        background: bulbGradient,
        duration: 2.5,
        ease: "sine.inOut",
        stagger: 0.2,
        onStart: () => console.log("🎨 水銀球變色開始"),
        onComplete: () => console.log("✅ 水銀球變色完成")
      }, 0)

      .to(temperatureValue, {
        value: 100,
        duration: 2.5,
        roundProps: "value",
        ease: "sine.inOut",
        onStart: () => console.log("🔢 數字動畫開始"),
        onUpdate: () => {
          temperatureValue.value = Math.round(temperatureValue.value);
          console.log(`🔢 當前數字： ${temperatureValue.value}`);
        },
        onComplete: () => console.log("✅ 數字動畫完成")
      }, 0)

      .to(mercury.value, {
        height: "100%",
        background: mercuryGradient,
        duration: 2.5,
        ease: "sine.inOut",
        onStart: () => console.log("📏 水銀柱動畫開始"),
        onComplete: () => console.log("✅ 水銀柱動畫完成")
      }, 0)

      // ✅ **所有動畫結束後，讓地球、溫度計、數字、遮罩「同步淡出」**
      .to([earth.value, ".thermometer-container", ".temperature-display", overlay.value], {
        opacity: 0,
        duration: .5,
        ease: "sine.inOut",
        onStart: () => console.log("🎭 全部元素淡出開始"),
        onComplete: () => {
          console.log("🚀 動畫完全結束，隱藏所有元素");
        }
      }, "+=.5") // **確保在動畫結束 0.5 秒後開始淡出**

      .then(() => {
        console.log("🎉 所有動畫 & 淡出效果已完成！");
      });
    }
  });
});


</script>

<style lang="scss" scoped>
.loding-overlay{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  z-index: 1000;
  opacity: 0;
  transition: opacity .5s ease-in-out;
}

.loading-container {
  position: fixed;
  width: 600px;
  height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.earth {
  width: 60%;
  position: relative; /* ✅ 允許 GSAP 動畫影響它的位置 */
}

.thermometer-container {
  position: relative; /* ✅ 確保 `.temperature-display` 相對於 `.thermometer-container` 定位 */
  display: flex;
  flex-direction: column;
  align-items: center; /* ✅ 確保子元素（溫度計 + 數字）都在同一軸心 */
}

/* ✅ 自製溫度計 */
.thermometer {
  position: relative;
  width: 30px;
  height: 200px;
  border-radius: 15px;
  border: 2px solid #bebebe;
  // background: #f8f8f8;
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-end;
  overflow: hidden;
}

/* ✅ 刻度區 */
.scale {
  position: absolute;
  right: -15px; /* ✅ 刻度向右移動 */
  top: 0;
  width: 20px;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: space-between;
}

/* ✅ 刻度線 (取代數字標籤) */
.tick {
  position: absolute;
  background: #fffff0;
  height: 2px;
  z-index: 51;
}

/* ✅ 主要刻度線 */
.major {
  width: 20px;
}

/* ✅ 水銀柱 */
.mercury {
  width: 80%;
  height: 0%;
  border-radius: 10px;
  position: relative;
  bottom: -5px;
  background: linear-gradient(to top, #FFA500, #FF4500); /* ✅ 更柔和的漸變 */
}

/* ✅ 水銀球 */
.bulb {
  position: absolute;
  bottom: -25px;
  left: 50%;
  transform: translateX(-50%);
  width: 45px;
  height: 45px;
  border-radius: 50%;
  border: 3px solid #bebebe;
  background: #FFA500;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.3); /* ✅ 讓水銀球更立體 */
  transition: background 3s ease-in-out;
}


/* ✅ 水銀球內部水銀 */
.bulb-mercury {
  width: 90%;
  height: 90%;
  // background: blue;
  border-radius: 50%;
  /* 移除 transition */
}

/* ✅ 溫度數字顯示 */
.temperature-display {
  position: absolute;
  top: 110%; /* ✅ 確保數字在溫度計的正下方 */
  left: 50%;
  transform: translateX(-50%); /* ✅ 水平居中 */
  font-size: 20px;
  font-weight: bold;
  color: #545454;
  text-align: center;
  width: max-content;
  background: rgba(255, 255, 240, 0.5); /* ✅ 增加可讀性 */
  padding: 5px 10px;
  border-radius: 5px;
}

</style>
