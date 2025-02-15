<!-- 已經 RWD 820/ 430 完成 -->

<template>
  <div class="member-login-container">
    <div class="member-login-card">
      <img src="../assets/images/logo_color1.svg" alt="涼城即時 Be Cool Now" class="member-login-logo" />
      <h1 class="member-login-title">會員登入</h1>

      <!-- 在 form 標籤上添加 @submit.prevent="handleSubmit" -->
      <form class="member-login-form" @submit.prevent="handleSubmit">
        <div class="member-login-input-group">
          <label for="account">帳號</label>
          <input id="account" v-model="formData.email" type="email" placeholder="請輸入電子郵件" required />
        </div>

        <div class="member-login-input-group">
          <label for="password">密碼</label>
          <div class="password-input-wrapper">
            <input id="password" v-model="formData.password" :type="passwordVisible ? 'text' : 'password'"
              placeholder="須包含英文字母大小寫與數字" required @blur="validatePasswordFormat(formData.password)" />
            <button type="button" class="toggle-password" @click="togglePasswordVisibility">
              {{ passwordVisible ? '🙉' : '🙈' }}
            </button>
          </div>
          <span v-if="formErrors.password" class="error-message">{{ formErrors.password }}</span>
        </div>
        <button type="submit" class="member-login-submit-btn">登入</button>

        <div class="member-login-links">
          <a href="#" class="member-login-register" @click.prevent="$emit('switch')">還不是會員嗎？新會員註冊</a>
          <!-- <a href="#" class="member-login-forgot">忘記密碼?</a> -->
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { useRouter } from 'vue-router';
export default {
  name: 'member_login',
  // setup() {
  //   const router = useRouter();
  //   return { router };
  // },
  data() {
    return {
      formData: {
        email: '',
        password: '',
      },
      passwordVisible: false,
      formErrors: {
        email: '',
        password: '',
      }

    };
  },
  watch: {
    // 監聽密碼變化，即時驗證
    'formData.password'(newValue) {
      this.validatePasswordFormat(newValue);
    },
    // 監聽 email 變化，即時驗證
    'formData.email'(newValue) {
      this.validateEmailFormat(newValue);
    },
  },
  methods: {
    // methods: {
    showNewMemberPopup() {
      // 隱藏登入彈窗
      document.querySelector('.member_login').style.display = 'none';

      // 顯示註冊彈窗
      document.querySelector('.popupnewmember').style.display = 'block';
    },
    // },
    togglePasswordVisibility() {
      this.passwordVisible = !this.passwordVisible;
    },
    validatePasswordFormat(password) {
      const hasUpperCase = /[A-Z]/.test(password);
      const hasLowerCase = /[a-z]/.test(password);
      const hasNumber = /[0-9]/.test(password);

      if (!password) {
        this.formErrors.password = '請輸入密碼';
      } else if (!hasUpperCase || !hasLowerCase || !hasNumber) {
        this.formErrors.password = '密碼必須包含大寫字母、小寫字母和數字';
      } else {
        this.formErrors.password = '';
      }
      return hasUpperCase && hasLowerCase && hasNumber;
    },
    validateEmailFormat(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!email) {
        this.formErrors.email = '請輸入電子郵件';
      } else if (!emailRegex.test(email)) {
        this.formErrors.email = '請輸入有效的電子郵件地址';
      } else {
        this.formErrors.email = '';
      }
      return emailRegex.test(email);
    },
    closePopup() {  //關閉彈窗
      this.$emit('close');
    },
    async handleSubmit() {
      // 先執行驗證
      this.validateEmailFormat(this.formData.email);
      this.validatePasswordFormat(this.formData.password);

      // 檢查是否有錯誤訊息
      if (this.formErrors.email || this.formErrors.password) {
        // 如果有錯誤，不提交表單
        alert('驗證失敗：\n' +
          (this.formErrors.email ? this.formErrors.email + '\n' : '') +
          (this.formErrors.password ? this.formErrors.password : ''));
        return;
      }

      // 如果密碼驗證不通過
      if (!this.validatePasswordFormat(this.formData.password)) {
        this.formErrors.password = '密碼必須包含大寫字母、小寫字母和數字';
        alert(this.formErrors.password);
        return;
      }



      // this.resetForm();

      // 導航到會員頁面  //成功登入才導
      // this.$router.push('/member');
      // this.$emit('close');
      // 如果你想要關閉 popup
      const base_url = import.meta.env.VITE_AJAX_URL
      const url = base_url + `/login.php`;
      try {
        const res = await fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          // credentials: 'include',
          body: JSON.stringify({
            email: this.formData.email,
            password: this.formData.password
          })
        })
        const data = await res.json();
        if (data.success) {


          // const redirectPath = localStorage.getItem('redirectPath') || '/';

          // this.$router.push(redirectPath);

          // 如果所有驗證都通過
          // alert('登入成功!歡迎光臨涼城即時');
          alert(`${data.message}歡迎光臨涼城即時！`);
          // 儲存登入狀態和用戶信息到 localStorage
          localStorage.setItem('isLoggedIn', 'true');
          localStorage.setItem('userEmail', this.formData.email);
          this.resetForm();

          this.closePopup();
          // this.$router.push('/member');
        } else {
          if (data.message === '密碼錯誤，請查明後再試！') {
            alert(data.message);
            this.resetForm();
          } else if (data.message === '查無此帳號密碼，請先註冊後再登入！') {
            alert(data.message);
            this.resetForm();
            this.$emit('switch');
          }
        }

      } catch (err) {
        console.log(`請求出現錯誤：${err.message}`);
        alert(`請求出現錯誤：請洽工作人員詢問！`);
      }
    },
    resetForm() {
      this.formData = {
        email: '',
        password: '',
      };
      this.passwordVisible = false;
      this.formErrors = {
        email: '',
        password: '',
      }
    },
  },
};

</script>
