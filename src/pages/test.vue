<style scoped>
.donut-container {
  position: relative;
  width: 400px; /* 甜甜圈的大小 */
  height: 400px;
  margin: 50px auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.rotatable-donut {
  position: relative;
  width: 300px;
  height: 300px;
  border-radius: 50%;
  background: conic-gradient(
    transparent 0% 25%, /* 部分 1 */
    transparent 25% 50%, /* 部分 2 */
    transparent 50% 75%, /* 部分 3 */
    transparent 75% 100% /* 部分 4 */
  );
  transform-origin: center;
  overflow: hidden;
  transition: transform 0.3s ease;
}

.donut-section {
  position: absolute;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.donut-section img {
  width: 120%;
  height: 120%;
  object-fit: cover;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 0;
}

.section-text {
  position: relative;
  z-index: 1;
  font-size: 16px;
  font-weight: bold;
  color: white;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}

.section-1 {
  transform: rotate(0deg) translateY(-120px);
}
.section-2 {
  transform: rotate(90deg) translateY(-120px);
}
.section-3 {
  transform: rotate(180deg) translateY(-120px);
}
.section-4 {
  transform: rotate(270deg) translateY(-120px);
}

.donut-center {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 100px;
  height: 100px;
  transform: translate(-50%, -50%);
  background: #fff;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  font-size: 14px;
  font-weight: bold;
  color: #333;
}

.rotate-button {
  width: 50px;
  height: 50px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 18px;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.rotate-button:hover {
  background-color: #45a049;
}

.rotate-button.left {
  position: absolute;
  left: -60px;
  top: 50%;
  transform: translateY(-50%);
}

.rotate-button.right {
  position: absolute;
  right: -60px;
  top: 50%;
  transform: translateY(-50%);
}
</style>


<template>
    <div class="donut-container">
      <!-- 左按鈕 -->
      <button class="rotate-button left" @click="rotate(-90)">◀</button>
  
      <!-- 甜甜圈 -->
      <div
        class="rotatable-donut"
        :style="{ transform: `rotate(${rotation}deg)` }"
      >
        <!-- 各部分 -->
        <div
          v-for="(section, index) in sections"
          :key="index"
          :class="['donut-section', `section-${index + 1}`]"
        >
          <img :src="section.image" alt="Section Image" />
          <p class="section-text">{{ section.text }}</p>
        </div>
  
        <!-- 中心文字 -->
        <div class="donut-center">
          <p>甜甜圈文字</p>
        </div>
      </div>
  
      <!-- 右按鈕 -->
      <button class="rotate-button right" @click="rotate(90)">▶</button>
    </div>
  </template>

<script>
import { ref } from "vue";

export default {
  name: "DonutChart",
  setup() {
    const rotation = ref(0); // 初始旋轉角度
    const sections = ref([
      {
        text: "部分 1 的文字",
        image: "../assets/images/AC_Day14.png",
      },
      {
        text: "部分 2 的文字",
        image: "@/assets/images/section2.jpg",
      },
      {
        text: "部分 3 的文字",
        image: "@/assets/images/section3.jpg",
      },
      {
        text: "部分 4 的文字",
        image: "@/assets/images/section4.jpg",
      },
    ]);

    const rotate = (angle) => {
      rotation.value += angle;
    };

    return {
      rotation,
      sections,
      rotate,
    };
  },
};
</script>

  