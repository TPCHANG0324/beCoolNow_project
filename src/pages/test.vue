<template>
  <div ref="container" class="canvas-container"></div>
</template>

<script>
import * as THREE from "three";

export default {
  name: "EarthScroll",
  data() {
    return {
      rotationSpeed: 0.005, // 控制旋轉速度
      currentRotation: 0,  // 當前的旋轉角度
    };
  },
  mounted() {
    this.initScene();
    this.addEarth();
    this.startAnimation();
    window.addEventListener("wheel", this.onScroll);
  },
  beforeDestroy() {
    window.removeEventListener("wheel", this.onScroll);
  },
  methods: {
    // 初始化 Three.js 場景
    initScene() {
      const container = this.$refs.container;

      this.scene = new THREE.Scene();

      this.camera = new THREE.PerspectiveCamera(
        75,
        container.offsetWidth / container.offsetHeight,
        0.1,
        1000
      );
      this.camera.position.z = 3;

      this.renderer = new THREE.WebGLRenderer({ antialias: true });
      this.renderer.setSize(container.offsetWidth, container.offsetHeight);
      container.appendChild(this.renderer.domElement);

      const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
      this.scene.add(ambientLight);

      const pointLight = new THREE.PointLight(0xffffff, 1);
      pointLight.position.set(5, 5, 5);
      this.scene.add(pointLight);
    },
    // 添加地球
    addEarth() {
      const textureLoader = new THREE.TextureLoader();
      const earthTexture = textureLoader.load(
        new URL('@/assets/images/Fp08.png', import.meta.url).href,
        () => console.log("Earth texture loaded."),
        undefined,
        (error) => console.error("Error loading Earth texture:", error)
      );

      const geometry = new THREE.SphereGeometry(1, 32, 32);
      const material = new THREE.MeshStandardMaterial({ map: earthTexture });

      this.earth = new THREE.Mesh(geometry, material);
      this.scene.add(this.earth);
    },
    // 動畫循環
    startAnimation() {
      const animate = () => {
        requestAnimationFrame(animate);

        // 更新地球旋轉
        if (this.earth) {
          this.earth.rotation.y = this.currentRotation;
        }

        this.renderer.render(this.scene, this.camera);
      };
      animate();
    },
    // 滾輪滾動事件
    onScroll(event) {
      const delta = event.deltaY; // 滾輪滾動的方向和距離
      this.currentRotation += delta * this.rotationSpeed; // 根據滾輪距離改變旋轉角度
    },
  },
};
</script>

<style>
.canvas-container {
  width: 100%;
  height: 500px;
  background-color: black; /* 黑色背景避免透明問題 */
  overflow: hidden; /* 防止出現滾動條 */
}
</style>
