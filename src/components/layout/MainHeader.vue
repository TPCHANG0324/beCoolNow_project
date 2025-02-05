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
    <i class="bi bi-person-circle" :class="{ 'logged-in': isLoggedIn }"></i>
  </a>
  <a v-else @click="confirmLogout">
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
    class="overlay_popup" 
    v-show="isloginPopup" 
    @click="closeLoginPopup"
  ></div>
  <loginPopupChange v-show="isloginPopup" @close="closeLoginPopup"></loginPopupChange>
  <!-- <div v-if="showLogoutConfirm" class="custom-modal">
  <div class="modal-content">
    <h3 style="color: red; font-size: 22px;">🚨 是否確定登出？</h3>
    <p>
      <span style="color: green; font-weight: bold;">✅ 點選確認</span>：登出後返回首頁<br>
      <span style="color: blue; font-weight: bold;">❌ 點選取消</span>：返回會員頁面
    </p>
    <div class="modal-buttons">
      <button @click="handleConfirmLogout" class="confirm-btn">確認登出</button>
      <button @click="handleCancelLogout" class="cancel-btn">取消</button>
    </div>
  </div>
</div> -->
</template>

<script>
import { ref, onMounted } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
import loginPopupChange from '@/pages/loginPopupChange.vue';
// import { ref, onMounted } from 'vue';
// import { RouterLink, useRouter } from 'vue-router'; // 添加 useRouter
// import loginPopupChange from '@/pages/loginPopupChange.vue';

export default {
  name: 'MainHeader',
  components:{loginPopupChange},
  setup() {
    const router = useRouter(); // 初始化 router
    const isMenuOpen = ref(false);
    const isloginPopup = ref(false);
    const isLoggedIn = ref(false);
    const showLogoutConfirm = ref(false);

  
     // 檢查登入狀態
     const checkLoginStatus = () => {
      const loginStatus = localStorage.getItem('isLoggedIn');
      isLoggedIn.value = loginStatus === 'true';
    };

    // 在組件掛載時檢查登入狀態
    onMounted(() => {
      checkLoginStatus();
    });

    const toggleLoginPopup = () => {
      // 只有在未登入狀態下才顯示登入彈窗
      if (!isLoggedIn.value) {
        isloginPopup.value = !isloginPopup.value;
      }
    };


    const closeLoginPopup = () => {
      isloginPopup.value = false;
    };
  
    const toggleMenu = () => {
      isMenuOpen.value = !isMenuOpen.value;
      // console.log('Menu toggled:', isMenuOpen.value);
    };

     // 新增確認登出方法
     const confirmLogout = () => {
      const confirmed = window.confirm('🚨是否確定登出？\n點選確定💔，登出後返回首頁\n點選取消❤️，返回會員頁面');
      if (confirmed) {
        // 執行登出操作
        localStorage.removeItem('isLoggedIn');
        localStorage.removeItem('userEmail');
        isLoggedIn.value = false;
        router.push('/');
      }else {
    // 若點選取消，導向 member 頁面
    router.push('/member');
  }
    };

    const handleLogout = () => {
  localStorage.removeItem('isLoggedIn');
  localStorage.removeItem('userEmail');
  router.push('/');
};

    return {
      isMenuOpen,
      isloginPopup,
      isLoggedIn,
      toggleLoginPopup,
      toggleMenu,
      closeLoginPopup,
      confirmLogout,
    };
  },
};
</script>
