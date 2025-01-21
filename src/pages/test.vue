<template>
  <div>
    <div class="div1"></div>
    <div class="div2">
      <div class="square"></div>
      <div class="square2"></div>
    </div>
  </div>
</template>

<script>
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { onMounted, ref } from 'vue';
gsap.registerPlugin(ScrollTrigger);

export default {
  setup() {
    const square = ref();
    onMounted(() => {
      gsap.registerPlugin(ScrollTrigger);
      gsap.to('.square2', { x: 100, y: 200, duration: 8, scrollTrigger: '.square2' });
    });

    return {};
  },
};
</script>

<style lang="scss">
body {
  margin: 0;
}

.div1,
.div2 {
  height: 100vh;
}

.div1 {
  background-color: green;
}

.div2 {
  background-color: red;
}

.square {
  width: 150px;
  height: 150px;
  background-color: brown;
}

.square2 {
  margin-top: 30px;
  width: 150px;
  height: 150px;
  background-color: green;
}
</style>
