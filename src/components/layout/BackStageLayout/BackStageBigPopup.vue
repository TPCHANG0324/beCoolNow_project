<template>
  <div class="BackBigOverlay">
    <!-- 後臺管理系統 大彈窗 width: 800 -->
    <section class="BackStageBigPopup">
      <slot></slot>
    </section>
  </div>
</template>

<script>
export default {
  name: 'BackStageBigPopup',
};
</script>

<style scoped>
.BackBigOverlay{
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 500;
}
</style>
