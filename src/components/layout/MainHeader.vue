<template>
  <!-- 前臺 主要Header -->
  <header class="layout_header">
    <div class="header-wrapper">
      <div class="logo">
        <router-link to="/home">
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
          <li><a href="https://tibamef2e.com/tid103/g2/home">好站連結</a></li>
          <li><router-link to="/shop">環保市集</router-link></li>
        </ul>
        <ul>
          <li>
            <router-link to="/shop_cart" class="cart-icon-wrapper">
              <i class="bi bi-handbag"></i>
              <span class="cart-count" v-if="cartCount > 0">{{ cartCount }}</span>
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
  </header>

  <header class="mobile_header">
    <div class="logo">
      <router-link to="/home">
        <img src="../../assets/images/headerlogo.png" alt="logo" />
      </router-link>
    </div>
    <div>
      <ul>
        <li>
          <router-link to="/shop_cart" class="cart-icon-wrapper">
            <i class="bi bi-handbag"></i>
            <span class="cart-count" v-if="cartCount > 0">{{ cartCount }}</span>
          </router-link>
        </li>
        <li>
          <router-link to="/member"><i class="bi bi-person-circle"></i></router-link>
        </li>
      </ul>
      <svg class="ham hamRotate ham8" viewBox="0 0 100 100" width="80" :class="{ active: isMenuOpen }"
        @click="toggleMenu">
        <path class="line top"
          d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20" />
        <path class="line middle" d="m 30,50 h 40" />
        <path class="line bottom"
          d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20" />
      </svg>
    </div>
  </header>

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

  <div class="overlay_popup01" v-show="isLogoutPopupVisible" @click="closeLogoutPopup"></div>
  <loginPopupChange v-show="isloginPopup" @close="closeLoginPopup"></loginPopupChange>

  <div class="logout-popup01" v-show="isLogoutPopupVisible">
    <div class="logout-content">
      <button class="close-btn" @click="closeLogoutPopup">&times;</button>
      <h3>是否確定登出？</h3>
      <div class="button-group">
        <button class="logout-btn" @click="handleLogout">登出並回到首頁</button>
        <button class="keep-login-btn" @click="goToMember">保持登入<br />前往會員頁</button>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuth } from '@/utils/useAuth';
import eventBus from '@/utils/eventBus';
import loginPopupChange from '@/pages/loginPopupChange.vue';

export default {
  name: 'MainHeader',
  components: { loginPopupChange },

  setup() {
    const router = useRouter();
    const { userEmail, checkAuth } = useAuth();
    const isMenuOpen = ref(false);
    const isloginPopup = ref(false);
    const isLoggedIn = ref(false);
    const isLogoutPopupVisible = ref(false);
    const cartCount = ref(0);
    const base_url = import.meta.env.VITE_AJAX_URL

    // 檢查登入狀態
    const checkLoginStatus = async () => {
      isLoggedIn.value = await checkAuth();

      if (isLoggedIn.value) {
        const userEmail = localStorage.getItem('userEmail');
        const storedCount = localStorage.getItem(`cartCount_${userEmail}`);
        cartCount.value = parseInt(storedCount) || 0;
      } else {
        const generalCount = localStorage.getItem('cartCount');
        cartCount.value = parseInt(generalCount) || 0;
      }
    };

    const toggleMenu = () => {
      isMenuOpen.value = !isMenuOpen.value;
    };

    const toggleLoginPopup = () => {
      if (!isLoggedIn.value) {
        isloginPopup.value = !isloginPopup.value;
      }
    };

    const closeLoginPopup = () => {
      isloginPopup.value = false;
      checkLoginStatus();
      if (localStorage.getItem('redirectPath')) {
        localStorage.removeItem('redirectPath');
      }
    };

    const showLogoutPopup = () => {
      if (isLoggedIn.value) {
        isLogoutPopupVisible.value = true;
      }
    };

    //詢問是否要登出的彈窗消失改為異步
     const closeLogoutPopup = () => {
      return new Promise((resolve) => {
        isLogoutPopupVisible.value = false;
        setTimeout(() => {
          resolve();
        }, 100)
      })
    };

    // 顯示登入燈箱
    const showLoginPopup = () => {
      isloginPopup.value = true;
    };

    //登出
    const handleLogout = async () => {
      const base_url = import.meta.env.VITE_AJAX_URL
      try {

        const res = await fetch(`${base_url}/logout.php`);
        const data = await res.json();

        if (data.success) {
          const userEmail = localStorage.getItem('userEmail');
          if (userEmail) {
            localStorage.setItem(`cartCount_${userEmail}`, cartCount.value.toString());
          }

          // 清除購物車數量
          cartCount.value = 0;
          localStorage.removeItem('cartCount');
          // 清除手機號碼 -- 加入這一行
          localStorage.removeItem('userPhone');
          localStorage.removeItem('isLoggedIn');
          // cartCount.value = 0;
          // localStorage.removeItem('cartCount');
          isLoggedIn.value = false;
          await closeLogoutPopup();
          alert(data.message);
          router.push('/home');
        }
      } catch (err) {
        console.error('登出操作失敗', err);
        alert('🍂 登出操作失敗，請洽工作人員詢問');
      }
    };

    const goToMember = () => {
      closeLogoutPopup();
      router.push('/member');
    };

    const handleCartCountUpdate = () => {
      if (isLoggedIn.value) {
        const userEmail = localStorage.getItem('userEmail');
        const newCount = parseInt(localStorage.getItem('cartCount')) || 0;
        cartCount.value = newCount;
        localStorage.setItem(`cartCount_${userEmail}`, newCount.toString());
      } else {
        const newCount = parseInt(localStorage.getItem('cartCount')) || 0;
        cartCount.value = newCount;
      }
    };

    onMounted(() => {
      // if (!localStorage.getItem('isLoggedIn')) {
      //   localStorage.setItem('isLoggedIn', 'false');
      // }
      // window.addEventListener('storage', checkLoginStatus);
      checkLoginStatus();
      window.addEventListener('updateCartCount', handleCartCountUpdate);
      eventBus.on('show-login-popup', showLoginPopup);
    });

    onUnmounted(() => {
      // window.removeEventListener('storage', checkLoginStatus);
      window.removeEventListener('updateCartCount', handleCartCountUpdate);
      eventBus.off('show-login-popup', showLoginPopup);
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
      goToMember,
      userEmail,
      base_url,
    };
  }
};
</script>

<style scoped>

.logout-popup01 .close-btn {
    position: absolute;
    right: 1rem;
    /* top: 1rem; */
    background: none;
    border: none;
    font-size: 2rem;
    cursor: pointer;
    color: #545454;
    box-shadow: none;

    &:hover {
      color: #d0ad44;
      /* box-shadow: #545454; */
    }
}
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
  padding: 2px;
  font-size: 12px;
}
</style>
