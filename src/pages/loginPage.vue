<template>
  <div class="login-wrapper">
    <!-- ✅ 當 isLoading 為 true，顯示 loading.vue -->
    <Loading v-if="isLoading" />

    <!-- ✅ 當 isLoading 為 false，顯示登入組件 -->
    <component v-else :is="currentLoginComponent" key="loginComponent" />
  </div>
</template>

<script>
import { ref, computed, watch, onMounted, onUnmounted } from "vue";
import loginPagePC from "@/pages/loginPagePC.vue"; // Three.js 動畫登入頁
import loginPageMobile from "@/pages/loginPageMobile.vue"; // 靜態版登入頁
import loading from "@/components/items/loading.vue";

export default {
  name: "LoginPage",
  components: {
    loading,
  },
  setup() {
    const isLoading = ref(true);
    const screenWidth = ref(window.innerWidth);
    const loginComponentKey = ref(0); // 🚀 **增加 key 來強制更新畫面**

    // 📌 **更新螢幕寬度**
    const updateScreenWidth = () => {
      screenWidth.value = window.innerWidth;
    };

    // 📌 **監聽視窗變更**
    onMounted(() => {
       // ✅ 模擬載入過程（3 秒後顯示登入頁）
       setTimeout(() => {
        isLoading.value = false;
      }, 3000);
      window.addEventListener("resize", updateScreenWidth);
    });

    onUnmounted(() => {
      window.removeEventListener("resize", updateScreenWidth);
    });

    // 📌 **根據螢幕寬度切換登入頁**
    const currentLoginComponent = computed(() => {
      return screenWidth.value > 1100 ? loginPagePC : loginPageMobile;
    });

    // 🚀 **監聽 `screenWidth` 變更，確保 Vue 重新渲染**
    watch(screenWidth, () => {
      loginComponentKey.value++; // 🔄 **更新 key，強制 Vue 重新載入組件**
    });

    return {
      currentLoginComponent,
      loginComponentKey,
      isLoading,
    };
  },
};
</script>
