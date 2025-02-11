<!-- 後臺管理系統 確認彈窗 800 * 240 -->

<template>
  <div class="BackConfirmOverlay">
    <section class="backStageConfirmPopup_H">
      <slot></slot>
    </section>
  </div>
</template>

<script>
export default {
  name: 'BackStageConfirmPopup',
};
</script>

<style scoped>
.BackConfirmOverlay{
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 500;
}
</style>
