<template>
  <div class="backstage-overlay">
    <!-- 後臺管理系統 小彈窗 800 * 400 -->
    <!-- <section class="BackStageSmallPopup"> -->
    <div class="BackStageSmallPopup">
      <slot></slot>
    <!-- </section> -->
     </div>
  </div>
</template>

<script>
export default {
  name: 'BackStageSmallPopup',
};
</script>

<style scoped>
.backstage-overlay{
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 500;
}
</style>