<template>
  <div class="member-login-container_2">
    <div class="member-login-card_2">
      <h1 class="member-login-title_2">新會員註冊</h1>

      <form class="member-login-form_2" @submit.prevent="handleSubmit">
        <div class="member-login-input-group_2">
          <label for="name">姓名</label>
          <input id="name" v-model="formData.name" type="text" placeholder="請輸入姓名" />
        </div>

        <div class="member-login-input-group_2">
          <label for="email">帳號</label>
          <input id="email" v-model="formData.email" type="email" placeholder="請輸入電子郵件" />
        </div>

        <div class="member-login-input-group_2">
          <label for="password">密碼</label>
          <div class="password-input-wrapper">
            <input
              id="password"
              v-model="formData.password"
              :type="passwordVisible ? 'text' : 'password'"
              placeholder="須包含數字與英文字母大小寫"
            />
            <button type="button" class="toggle-password" @click="togglePasswordVisibility">
              <!-- 根據狀態顯示不同的眼睛圖示 -->
              {{ passwordVisible ? '🙉' : '🙈' }}
            </button>
          </div>
        </div>

        <div class="member-login-input-group_2">
          <label for="confirmPassword">確認密碼</label>
          <div class="password-input-wrapper">
            <input
              id="confirmPassword"
              v-model="formData.confirmPassword"
              :type="confirmPasswordVisible ? 'text' : 'password'"
              placeholder="請再確認一次密碼"
            />
            <button type="button" class="toggle-password" @click="toggleConfirmPasswordVisibility">
              <!-- 根據狀態顯示不同的眼睛圖示 -->
              {{ confirmPasswordVisible ? '🙉' : '🙈' }}
            </button>
          </div>
        </div>

        <div class="member-login-input-group_2_btn">
          <button type="button" class="member-login-submit-btn" @click="test()">取消</button>
          <button type="submit" class="member-login-submit-btn">送出</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'popupnewmember',
  data() {
    return {
      formData: {
        name: '',
        email: '',
        password: '',
        confirmPassword: '',
      },
      passwordVisible: false, // 密碼欄位的可見狀態
      confirmPasswordVisible: false, // 確認密碼欄位的可見狀態
    };
  },
  methods: {
    // 分別控制兩個密碼欄位的可見性
    togglePasswordVisibility() {
      this.passwordVisible = !this.passwordVisible;
    },
    toggleConfirmPasswordVisibility() {
      this.confirmPasswordVisible = !this.confirmPasswordVisible;
    },
    test() {
      console.log('ssss');

      this.$emit('switch');
    },
    validatePassword(password) {
      const hasUpperCase = /[A-Z]/.test(password);
      const hasLowerCase = /[a-z]/.test(password);
      const hasNumber = /[0-9]/.test(password);
      return hasUpperCase && hasLowerCase && hasNumber;
    },
    handleSubmit() {
      if (!this.formData.name || !this.formData.email || !this.formData.password || !this.formData.confirmPassword) {
        alert('請填寫所有欄位！');
        return;
      }

      if (!this.validatePassword(this.formData.password)) {
        alert('密碼必須包含大寫字母、小寫字母和數字！');
        return;
      }

      if (this.formData.password !== this.formData.confirmPassword) {
        alert('兩次輸入的密碼不一致！');
        return;
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(this.formData.email)) {
        alert('請輸入有效的電子郵件地址！');
        return;
      }

      alert('註冊成功!歡迎加入涼城即時');
      this.resetForm();
    },
    handleCancel() {
      this.resetForm();
    },
    resetForm() {
      this.formData = {
        name: '',
        email: '',
        password: '',
        confirmPassword: '',
      };
      // 重置密碼可見狀態
      this.passwordVisible = false;
      this.confirmPasswordVisible = false;
    },
  },
};
</script>

<style lang="scss" scoped></style>
