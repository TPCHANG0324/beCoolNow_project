<script setup>
import { RouterLink, RouterView } from 'vue-router';
// import HelloWorld from './components/HelloWorld.vue';
</script>

<template>
  <!-- <transition name="fade">
    <router-view />
  </transition> -->

  <router-view v-slot="{ Component }">
    <transition name="fade">
      <component :is="Component" :key="$route.fullPath" />
    </transition>
  </router-view>
</template>

<style lang="scss">
@import './assets/sass/style.scss';
.fade-leave-active {
  transition: opacity 0.4s ease;
  position: absolute;
}

.fade-leave-to {
  opacity: 0;
  position: absolute;
}

.fade-enter-from {
  opacity: 0;
  position: absolute;
}

.fade-enter-active {
  transition: opacity 0.4s 0.4s ease;
}
</style>
