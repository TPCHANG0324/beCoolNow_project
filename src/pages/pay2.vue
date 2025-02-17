<template>
  <!-- 已經 RWD 820/ 430 完成 -->
  <div>
    <MainHeader></MainHeader>
    <div class="bcn-donation-container">
      <div class="bcn-top-place">
        <div class="bcn-donation-header">
          <p>您選擇了 <strong>{{ donationType === 'monthly' ? '每月捐款' : '單次捐款' }} 新臺幣 {{ amount }}元</strong></p>
        </div>
        <!-- <button class="bcn-btn-secondary">重新選擇捐款</button> -->
      </div>

      <div class="bcn-donation-form2">
        <form @submit.prevent="handleSubmit">
          <div class="bcn-form-title">
            <h2>付款資料</h2>
          </div>
          <div class="inside_form2">
            <div class="input-group">
            <!-- <label for="email" class="bcn-label">* 電子郵件地址</label> -->
            
            <span v-if="errors.cardNumber" class="error-message">{{ errors.cardNumber }}</span>
            <input 
        id="cardNumber" 
        type="text" 
        v-model="formData.cardNumber"
        @input="formatCardNumber"
        @blur="validateCardNumber"
        placeholder="卡號" 
        required 
        class="bcn-input-text"
        maxlength="19" 
         autocomplete="off"
      />
          
</div>

<div class="input-group">
            <!-- <label for="name" class="bcn-label">* 捐款人姓名</label> -->
            <input 
        id="cardHolder" 
        type="text" 
        v-model="formData.cardHolder"
        @blur="validateCardHolder"
        placeholder="持卡人姓名" 
        required 
        class="bcn-input-text" 
       autocomplete="off"
      />
            <span v-if="errors.cardHolder" class="error-message">{{ errors.cardHolder }}</span>
          </div>

          <div class="input-group">
            <!-- <label for="phone" class="bcn-label">電話號碼</label> -->
            <input 
        type="text" 
        v-model="formData.expiryDate"
        @input="formatExpiryDate"
        @blur="validateExpiryDate"
        placeholder="有效期限 (MM/YY)" 
        required 
        class="bcn-input-text"
        maxlength="5"
      autocomplete="off"
      />
            <span v-if="errors.expiryDate" class="error-message">{{ errors.expiryDate }}</span>
          </div>
            <!-- <option value="TW+886">TW +886</option> -->
            <!-- <label for="name" class="bcn-label">* 捐款人姓名</label> -->
            <div class="input-group">
            <input 
              id="cvv" 
              type="text" 
              v-model="formData.cvv"
              @input="formatCVV"
              @blur="validateCVV"
              placeholder="安全碼" 
              required 
              class="bcn-input-text"
              maxlength="3"
               autocomplete="off"
            />
            <span v-if="errors.cvv" class="error-message">{{ errors.cvv }}</span>
          </div>
            <!-- ✅ 修正 checkbox 與文字的排列
            <div class="bcn-checkbox-container">
                <input type="checkbox" id="agree" name="agree">
                <label for="agree">我已詳細閱讀並同意隱私權政策</label>
            </div> -->
          </div>
          <button type="submit" class="bcn-btn-primary">立即以 信用卡 捐款</button>
        </form>
      </div>
      <a href="./pay1/" class="bc-prev-step-button">
        <span class="bc-prev-step-icon">❮</span>
        <RouterLink to="/pay1"><span class="bc-prev-step-text">上一步</span></RouterLink>
      </a>
    </div>
    <MainFooter></MainFooter>
  </div>
</template>

<script>
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
import emailjs from '@emailjs/browser';
export default {
  name: 'pay2',
  components: {
    MainHeader,
    MainFooter
  },
  data() {
    return {
      donationType: '',
      amount: '',
      formData: {
        cardNumber: '',
        cardHolder: '',
        expiryDate: '',
        cvv: ''
      },
      errors: {
        cardNumber: '',
        cardHolder: '',
        expiryDate: '',
        cvv: ''
      }
    };
  },
  created() {
   // 從 URL 查詢參數中獲取值
   this.donationType = this.$route.query.donationType
    this.amount = this.$route.query.amount
  },
  methods: {
    formatCardNumber(event) {
      let value = event.target.value.replace(/\D/g, '');
      value = value.substring(0, 16);
      value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
      this.formData.cardNumber = value;
    },
    validateCardNumber() {
      const cardNumber = this.formData.cardNumber.replace(/\s/g, '');
      if (!cardNumber) {
        this.errors.cardNumber = '請輸入信用卡卡號';
        return false;
      }
      if (!/^\d{16}$/.test(cardNumber)) {
        this.errors.cardNumber = '請輸入有效的16位信用卡卡號';
        return false;
      }
      this.errors.cardNumber = '';
      return true;
    },
    validateCardHolder() {
      if (!this.formData.cardHolder.trim()) {
        this.errors.cardHolder = '請輸入持卡人姓名';
        return false;
      }
      this.errors.cardHolder = '';
      return true;
    },
    formatExpiryDate(event) {
      let value = event.target.value.replace(/\D/g, '');
      if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
      }
      this.formData.expiryDate = value;
    },
    validateExpiryDate() {
      if (!this.formData.expiryDate) {
        this.errors.expiryDate = '請輸入有效期限';
        return false;
      }
      const [month, year] = this.formData.expiryDate.split('/');
      const currentDate = new Date();
      const currentYear = currentDate.getFullYear() % 100;
      const currentMonth = currentDate.getMonth() + 1;

      if (!/^\d{2}\/\d{2}$/.test(this.formData.expiryDate)) {
        this.errors.expiryDate = '請輸入正確的格式 (MM/YY)';
        return false;
      }
      if (parseInt(month) < 1 || parseInt(month) > 12) {
        this.errors.expiryDate = '請輸入有效的月份 (01-12)';
        return false;
      }
      if (parseInt(year) < currentYear || 
         (parseInt(year) === currentYear && parseInt(month) < currentMonth)) {
        this.errors.expiryDate = '信用卡已過期';
        return false;
      }
      this.errors.expiryDate = '';
      return true;
    },
    formatCVV(event) {
      this.formData.cvv = event.target.value.replace(/\D/g, '').substring(0, 3);
    },
    validateCVV() {
      if (!this.formData.cvv) {
        this.errors.cvv = '請輸入安全碼';
        return false;
      }
      if (!/^\d{3}$/.test(this.formData.cvv)) {
        this.errors.cvv = '請輸入有效的3位數安全碼';
        return false;
      }
      this.errors.cvv = '';
      return true;
    },
    validateAll() {
      const isCardNumberValid = this.validateCardNumber();
      const isCardHolderValid = this.validateCardHolder();
      const isExpiryDateValid = this.validateExpiryDate();
      const isCVVValid = this.validateCVV();
      return isCardNumberValid && isCardHolderValid && isExpiryDateValid && isCVVValid;
    },
    async handleSubmit() {
      if (!this.validateAll()) {
        alert('🌏 請確認所有欄位都已正確填寫');
        return;
      }

      try {
        const response = await emailjs.send(
          'service_2p5x0aa',
          'template_xc5rnqm',
          {
            to_name: this.formData.cardHolder,
            site_name: '涼城即時',
            donation_date: new Date(),
            donation_amount: this.amount,
            to_email: 'sunny.h.ho@gmail.com',
          }
        );
        console.log('SUCCESS!', response.status);
        // 成功後的處理，例如導向感謝頁面
        this.$router.push('/donatefinish/');
      } catch (error) {
        console.error('Error:', error);
        alert('🍂 發送失敗，請稍後再試');
      }
    }
  }
};

</script>
