<template>
  <!-- 前臺 主要Header -->
  <header class="layout_header">
    <div class="header-wrapper">
      <div class="logo">
        <router-link to="/">
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
        <router-link to="/shop_cart" class="cart-icon-wrapper">
          <i class="bi bi-handbag"></i>
          <!-- 添加購物車計數器 -->
          <span v-if="cartCount > 0" class="cart-count">{{ cartCount }}</span>
        </router-link>
      </li>
          <li>
    <a v-if="!isLoggedIn" @click="toggleLoginPopup">
      <i class="bi bi-person-circle"></i>
    </a>
    <a v-else @click="showLogoutPopup">
      <i class="bi bi-person-circle" :class="{ 'logged-in': isLoggedIn }"></i>
    </a>
  </li>
        </ul>
      </nav>
    </div>
    <!-- 使用 v-show 來控制彈窗的顯示與隱藏 -->
   
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
  <!-- <loginPopupChange v-if="isloginPopup"></loginPopupChange> -->
     <!-- 添加遮罩層 -->
  <div 
    class="overlay_popup01" 
     v-show="isLogoutPopupVisible" 
  @click="closeLogoutPopup"
  ></div>
  <loginPopupChange v-show="isloginPopup" @close="closeLoginPopup"></loginPopupChange>
 

<!-- 登出彈窗 -->
<div class="logout-popup01" v-show="isLogoutPopupVisible">
  <div class="logout-content">
    <button class="close-btn" @click="closeLogoutPopup">&times;</button>
    <h3>是否確定登出？</h3>
    <div class="button-group">
      <button class="logout-btn" @click="handleLogout">登出並回到首頁</button>
      <button class="keep-login-btn" @click="goToMember">保持登入<br/>前往會員頁</button>
    </div>
  </div>
</div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
import loginPopupChange from '@/pages/loginPopupChange.vue';

export default {
  name: 'MainHeader',
  components: { loginPopupChange },
  setup() {
    const router = useRouter();
    const isMenuOpen = ref(false);
    const isloginPopup = ref(false);
    const isLoggedIn = ref(false);
    const isLogoutPopupVisible = ref(false);
    const cartCount = ref(0);

    const toggleMenu = () => {
      isMenuOpen.value = !isMenuOpen.value;
    };

    const checkLoginStatus = () => {
      const loginStatus = localStorage.getItem('isLoggedIn');
      isLoggedIn.value = loginStatus === 'true';
      
      // Update cart count based on login status
      if (isLoggedIn.value) {
        // If logged in, restore cart count from user-specific storage
        const userEmail = localStorage.getItem('userEmail');
        const userCartCount = localStorage.getItem(`cartCount_${userEmail}`);
        cartCount.value = parseInt(userCartCount) || 0;
      } else {
        // If logged out, clear cart count
        cartCount.value = 0;
      }
    };

    const toggleLoginPopup = () => {
      if (!isLoggedIn.value) {
        isloginPopup.value = !isloginPopup.value;
      }
    };

    const closeLoginPopup = () => {
      isloginPopup.value = false;
    };

    const showLogoutPopup = () => {
      if (isLoggedIn.value) {
        isLogoutPopupVisible.value = true;
      }
    };

    const closeLogoutPopup = () => {
      isLogoutPopupVisible.value = false;
    };

    const handleLogout = () => {
      // Store the current cart count for the user before logging out
      const userEmail = localStorage.getItem('userEmail');
      if (userEmail) {
        localStorage.setItem(`cartCount_${userEmail}`, cartCount.value.toString());
      }
      
      // Clear the displayed cart count
      cartCount.value = 0;
      localStorage.removeItem('cartCount');
      
      // Regular logout process
      localStorage.removeItem('isLoggedIn');
      localStorage.removeItem('userEmail');
      isLoggedIn.value = false;
      closeLogoutPopup();
      router.push('/');
    };

    const goToMember = () => {
      closeLogoutPopup();
      router.push('/member');
    };

    // Update cart count handler
    const handleCartCountUpdate = () => {
      if (isLoggedIn.value) {
        const userEmail = localStorage.getItem('userEmail');
        const newCount = parseInt(localStorage.getItem('cartCount')) || 0;
        cartCount.value = newCount;
        // Save user-specific cart count
        localStorage.setItem(`cartCount_${userEmail}`, newCount.toString());
      }
    };

    onMounted(() => {
      // Initialize login status
      if (!localStorage.getItem('isLoggedIn')) {
        localStorage.setItem('isLoggedIn', 'false');
      }
      checkLoginStatus();
      
      // Add event listeners
      window.addEventListener('storage', checkLoginStatus);
      window.addEventListener('updateCartCount', handleCartCountUpdate);
    });

    onUnmounted(() => {
      window.removeEventListener('storage', checkLoginStatus);
      window.removeEventListener('updateCartCount', handleCartCountUpdate);
    });

    return {
      isMenuOpen,
      isloginPopup,
      isLoggedIn,
      isLogoutPopupVisible,
      cartCount,
      toggleLoginPopup,
      toggleMenu,
      closeLoginPopup,
      showLogoutPopup,
      closeLogoutPopup,
      handleLogout,
      goToMember
    };
  }
};
</script>

<style scoped>
/* 添加購物車計數器的樣式 */
.cart-icon-wrapper {
  position: relative;
  display: inline-block;
}

.cart-count {
  position: absolute;
  top: -8px;
  right: -8px;
  background-color: #d0ad44;
  color: white;
  border-radius: 50%;
  min-width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  padding: 2px;
}
</style>