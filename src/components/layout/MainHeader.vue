<template>
  <!-- 前臺 主要Header -->
  <header class="layout_header">
    <div class="header-wrapper">
      <div class="logo">
        <router-link to="/Home">
          <img src="../../assets/images/headerlogo.png" alt="logo" />
        </router-link>
      </div>
      <nav class="nav-large">
        <ul>
          <li><router-link to="/information">島嶼危機</router-link></li>
          <li><router-link to="/activity">永續行動</router-link></li>
          <li><router-link to="/social">社群中心</router-link></li>
          <li><router-link to="/city">綠境方城市</router-link></li>
          <li><router-link to="/About">關於我們</router-link></li>
          <li><a href="#">好站連結</a></li>
          <li><router-link to="/shop">環保市集</router-link></li>
        </ul>
        <ul>
          <li>
            <router-link to="/shop_cart"><i class="bi bi-handbag"></i></router-link>
          </li>
          <li>
            <router-link to="/member"><i class="bi bi-person-circle"></i></router-link>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <header class="mobile_header">
    <div class="logo">
      <router-link to="/">
        <img src="../../assets/images/headerlogo.png" alt="logo" />
      </router-link>
    </div>
    <div>
      <ul>
        <li>
          <router-link to="/shop"><i class="bi bi-handbag"></i></router-link>
        </li>
        <li>
          <router-link to="/member"><i class="bi bi-person-circle"></i></router-link>
        </li>
      </ul>
      <!-- 漢堡線 -->
      <svg
        class="ham hamRotate ham8"
        viewBox="0 0 100 100"
        width="80"
        :class="{ active: isMenuOpen }"
        @click="toggleMenu"
      >
        <path
          class="line top"
          d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"
        />
        <path class="line middle" d="m 30,50 h 40" />
        <path
          class="line bottom"
          d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"
        />
      </svg>
    </div>
  </header>

  <!-- 子選單 -->
  <nav class="mobile_nav" :class="{ open: isMenuOpen }">
    <ul>
      <li><router-link to="/information">島嶼危機</router-link></li>
      <li><router-link to="/activity">永續行動</router-link></li>
      <li><router-link to="/social">社群中心</router-link></li>
      <li><router-link to="/city">綠境方城市</router-link></li>
      <li><router-link to="/About">關於我們</router-link></li>
      <li><a href="#">好站連結</a></li>
      <li><router-link to="/shop">環保市集</router-link></li>
    </ul>
  </nav>
</template>

<script>
import { ref } from 'vue';
import { RouterLink } from 'vue-router';
export default {
  name: 'MainHeader',
  setup() {
    const isMenuOpen = ref(false);

    const toggleMenu = () => {
      isMenuOpen.value = !isMenuOpen.value;
      // console.log('Menu toggled:', isMenuOpen.value);
    };

    return {
      isMenuOpen,
      toggleMenu,
    };
  },
};
</script>
