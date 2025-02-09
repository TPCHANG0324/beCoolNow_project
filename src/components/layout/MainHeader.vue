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
            <router-link to="/shop_cart"><i class="bi bi-handbag"></i></router-link>
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
  <div class="overlay_popup01" v-show="isLogoutPopupVisible" @click="closeLogoutPopup"></div>
  <loginPopupChange v-show="isloginPopup" @close="closeLoginPopup"></loginPopupChange>


  <!-- 登出彈窗 -->
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
import { ref, onMounted, onUnmounted, watch } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
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

    // 新增這段
    onMounted(() => {
      checkLoginStatus();
      // if (!localStorage.getItem('isLoggedIn')) {
      //   localStorage.setItem('isLoggedIn', 'false');
      // }
      // 監聽 localStorage 變化
      // window.addEventListener('storage', checkLoginStatus);
    });

    // 缺少 toggleMenu 方法
    const toggleMenu = () => {
      isMenuOpen.value = !isMenuOpen.value;
    };



    // 檢查登入狀態
    const checkLoginStatus = async () => {
      // const loginStatus = localStorage.getItem('isLoggedIn');
      // isLoggedIn.value = loginStatus === 'true';

      // const isLogged = await checkAuth();
      // isLoggedIn.value = isLogged;
      isLoggedIn.value = await checkAuth();
    };

    // onMounted(() => {
    //   checkLoginStatus();
    //   window.addEventListener('storage', checkLoginStatus); // 監聽 localStorage 變化
    // });

    // onUnmounted(() => {
    //   window.removeEventListener('storage', checkLoginStatus);
    // });

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

    const closeLogoutPopup = () => { //詢問是否要登出的彈窗消失改為異步
      return new Promise((resolve) => {
        isLogoutPopupVisible.value = false;
        setTimeout(() => {
          resolve();
        }, 100)
      })
    };

    const showLoginPopup = () => {
      isloginPopup.value = true; // 顯示登入燈箱
    };

    onMounted(() => {
      // 監聽事件
      eventBus.on('show-login-popup', showLoginPopup);
    });

    onUnmounted(() => {
      // 移除事件
      eventBus.off('show-login-popup', showLoginPopup);
    });


    //登出
    const handleLogout = async () => {
      try {
        const res = await fetch(`/tid103/g1/php/logout.php`);
        const data = await res.json();
        // console.log(data);
        if (data.success) {
          isLoggedIn.value = false;
          await closeLogoutPopup();
          alert(`${data.message}`);
          router.push('/'); //登出之後一律回到首頁
        }
      } catch (err) {
        console.error('登出操作失敗', err);
        alert('登出操作失敗，請洽工作人員詢問');
      }
    };

    const goToMember = () => {
      closeLogoutPopup();
      router.push('/member');
    };


    return {
      isMenuOpen,
      isloginPopup,
      isLoggedIn,
      isLogoutPopupVisible,
      toggleLoginPopup,
      toggleMenu,
      closeLoginPopup,
      showLogoutPopup,
      closeLogoutPopup,
      handleLogout,
      goToMember,
      userEmail
    };
  }
};
</script>