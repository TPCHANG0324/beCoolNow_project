<template>
  <div class="be-cool-now-container">
    <!-- 已經 RWD 820/ 430 完成 -->
    <RouterLink to="/home"><div class="be-cool-now-button be-cool-now-front-btn">前台</div></RouterLink>
    <div class="be-cool-now-logo">
      <img src="../assets/images/logo_color4.svg" alt="涼城即時 Be Cool Now LOGO" />
    </div>
    <RouterLink to="/BackStagePages"><div class="be-cool-now-button be-cool-now-back-btn">後台</div></RouterLink>
  </div>
</template>

<script>
import { RouterLink } from 'vue-router';
export default {
  name: 'loginPageMobile',
  components: RouterLink,
};
</script>

<style lang="scss" scoped>
  .be-cool-now-container{
    align-items: center;
    height: 100vh;
    background: url("@/assets/images/loginpagenew.png") no-repeat center center;
    background-size: cover;
    font-family: "DM Sans", sans-serif;
    color: #ffffff;
    text-align: center;
    width: 100%;
  }
</style>
