<script setup>
import { RouterLink, RouterView } from 'vue-router';
// import HelloWorld from './components/HelloWorld.vue';
</script>

<template>
  <header>
    <!-- <img alt="Vue logo" class="logo" src="@/assets/logo.svg" width="125" height="125" /> -->

    <!-- <div class="wrapper">
      <HelloWorld msg="You did it!" />

      <nav>
        <RouterLink to="/"></RouterLink>
        <RouterLink to="/Ac.vue"></RouterLink>
      </nav>
    </div> -->
  </header>

  <RouterView />
</template>

<style lang="scss">
@import "./assets/sass/style.scss";
</style>
