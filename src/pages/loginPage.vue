<template>
  <div class="be-cool-now-container">
    <!-- 已經 RWD 820/ 430 完成 -->
    <RouterLink to="/"><div class="be-cool-now-button be-cool-now-front-btn">前台</div></RouterLink>
    <div class="be-cool-now-logo">
      <img src="../assets/images/logo_color4.svg" alt="涼城即時 Be Cool Now LOGO" />
    </div>
    <RouterLink to="/IcB_article"><div class="be-cool-now-button be-cool-now-back-btn">後台</div></RouterLink>
  </div>
</template>

<script>
import { RouterLink } from 'vue-router';
export default {
  components: RouterLink,
};
</script>

