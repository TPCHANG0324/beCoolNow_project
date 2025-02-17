<template>
  <div>
    <MainHeader></MainHeader>
    <div class="Support_banner_S">
      <video class="background-video" autoplay loop muted playsinline>
        <source src="@/assets/videos/supportus.mp4" type="video/mp4">
      </video>
      <h1>您的支持<br />幫助地球生態扭轉危機！</h1>
    </div>

    <div class="Support_box_S">
      <p>是的！我珍愛地球環境與生態 <br />我要與自然、社會共生共好，永續發展。</p>

      <div class="donate_choise_S">
        <button
          :class="['donate_type_month', { active: donationType === 'monthly' }]"
          @click="setDonationType('monthly')"
        >每月捐款</button>
        <buttonLinePayService
          :class="['donate_type_once', { active: donationType === 'once' }]"
          @click="setDonationType('once')"
        >單次捐款</buttonLinePayService>
      </div>

      <div class="donate_amount_S">
        <button
          v-for="amount in amounts"
          :key="amount"
          :class="['amount', { active: selectedAmount === amount }]"
          @click="setAmount(amount)"
        >${{ amount }}<br />新台幣</button>
      </div>

      <div class="custom_amount_S">
        <span>自訂金額</span>
        <input
          type="text"
          placeholder="請輸入金額，以新台幣為單位"
          class="custom_amount_input"
          v-model="customAmount"
          @input="handleCustomAmountInput"
          @keypress="validateNumberInput"
          @paste="handlePaste"
        />
      </div>

      <div class="payment_section_S">
        <div class="payment_content">
          <label>選擇付款方式<span class="marker" title="此欄位不可空白">*</span> </label>
          <div v-if="formErrors.payment" class="error-message" style="color: red;">
            請選擇付款方式
          </div>
          
          <label class="linepay" :class="{ disabled: donationType === 'monthly' }">
            <input
              v-model="payment_method"
              type="radio"
              class="payment_method"
              value="Line Pay行動支付"
              :disabled="donationType === 'monthly'"
              @change="handlePaymentMethodChange"
            />
            <span>Line Pay行動支付</span>
          </label>

          <label class="ecpay">
            <input
              v-model="payment_method"
              type="radio"
              class="payment_method"
              value="綠界金流服務(信用卡)"
              @change="handlePaymentMethodChange"
            />
            <div class="ecpay-text-wrapper">
              <span class="ecpay1">綠界金流服務(信用卡)</span>
              <span class="ecpay2">(信用卡才能進行每月定額捐款)</span>
            </div>
          </label>
        </div>

        <div class="payment_step_S">
          <button
            class="next_step"
            @click="handleNextStep"
            :disabled="!isFormValid || isProcessing"
          >
            {{ isProcessing ? '處理中...' : '下一步' }}
          </button>
        </div>
      </div>
    </div>
    <MainFooter></MainFooter>
  </div>
</template>

<script>
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
import LinePayService from '@/api/LinePayService.js';

export default {
  name: 'support',
  components: {
    MainHeader,
    MainFooter
  },
  data() {
    return {
      payment_method: '',
      donationType: 'monthly',
      selectedAmount: 800,
      customAmount: '',
      amounts: [800, 1000, 1200],
      formErrors: {
        amount: false,
        payment: false
      },
      isProcessing: false,
      linePayService: new LinePayService()
    };
  },

  computed: {
    isFormValid() {
      const hasValidAmount = this.customAmount || this.selectedAmount;
      const hasValidPayment = !!this.payment_method;

      if (this.donationType === 'monthly') {
        return hasValidAmount && this.payment_method === '綠界金流服務(信用卡)';
      }

      return hasValidAmount && hasValidPayment;
    },

    finalAmount() {
      return this.customAmount || this.selectedAmount;
    }
  },

  methods: {
    handlePaymentMethodChange() {
      if (!this.payment_method) {
        alert('🌏 請選擇付款方式！');
        this.formErrors.payment = true;
      } else {
        this.formErrors.payment = false;
      }
    },

    setDonationType(type) {
      if (!type) {
        alert('🌏 請選擇捐款類型！');
        return;
      }
      this.donationType = type;
      if (type === 'monthly' && this.payment_method === 'Line Pay行動支付') {
        this.payment_method = '';
      }
    },

    setAmount(amount) {
      if (!amount) {
        alert('🌏 請選擇捐款金額！');
        return;
      }
      this.selectedAmount = amount;
      this.customAmount = '';
      this.formErrors.amount = false;
    },

    handleCustomAmountInput(event) {
      let value = event.target.value.replace(/\D/g, '');
      if (value.length > 0) {
        value = value.replace(/^0+/, '');
      }
      this.customAmount = value;
      if (value !== '') {
        this.selectedAmount = null;
        this.formErrors.amount = false;
      }
    },

    validateNumberInput(event) {
      const keyCode = event.keyCode;
      const currentValue = event.target.value;

      if (currentValue === '' && event.key === '0') {
        event.preventDefault();
        return;
      }
      if (keyCode < 48 || keyCode > 57) {
        event.preventDefault();
        return;
      }
    },

    handlePaste(event) {
      event.preventDefault();
      const pastedText = (event.clipboardData || window.clipboardData).getData('text');
      let numericValue = pastedText.replace(/\D/g, '');
      numericValue = numericValue.replace(/^0+/, '');

      if (numericValue) {
        this.customAmount = numericValue;
        this.selectedAmount = null;
        this.formErrors.amount = false;
      }
    },

    validateForm() {
      let isValid = true;
      const errors = [];

      if (!this.donationType) {
        errors.push('請選擇捐款類型（每月捐款或單次捐款）！');
        isValid = false;
      }

      if (!this.finalAmount) {
        errors.push('請選擇或輸入捐款金額！');
        this.formErrors.amount = true;
        isValid = false;
      } else if (parseInt(this.finalAmount) <= 0) {
        errors.push('請輸入大於 0 的金額！');
        this.formErrors.amount = true;
        isValid = false;
      }

      if (!this.payment_method) {
        errors.push('請選擇付款方式！');
        this.formErrors.payment = true;
        isValid = false;
        alert('🌏 請選擇付款方式！');
        return { isValid, errors };
      }

      if (this.donationType === 'monthly' && this.payment_method !== '綠界金流服務(信用卡)') {
        errors.push('每月捐款只能使用信用卡付款！');
        this.formErrors.payment = true;
        isValid = false;
      }

      if (!isValid) {
        alert(errors.join('\n'));
      }

      return { isValid, errors };
    },

    async handleNextStep() {
  if (!this.payment_method) {
    alert('🌏 請選擇付款方式！');
    return;
  }

  const { isValid } = this.validateForm();

  if (!isValid) {
    return;
  }

  if (parseInt(this.finalAmount) <= 0) {
    alert('🌏 捐款金額必須大於 0！');
    return;
  }

  this.isProcessing = true;

  try {
    if (this.payment_method === 'Line Pay行動支付') {
      // 準備訂單資料
      const orderData = {
        amount: parseInt(this.finalAmount),
        orderId: `ORDER_${Date.now()}`,
        products: [{
          name: '公益捐款',
          quantity: 1,
          price: parseInt(this.finalAmount)
        }]
      };

      // 呼叫 LINE Pay API
      const result = await this.linePayService.createPayment(orderData);
      
      if (result.returnCode === '0000') {
        // 儲存訂單資訊
        localStorage.setItem('currentOrder', JSON.stringify({
          orderId: orderData.orderId,
          amount: this.finalAmount,
          donationType: this.donationType
        }));

        // 重導向到 LINE Pay 付款頁面
        window.location.href = result.info.paymentUrl.web;
      } else {
        throw new Error(result.returnMessage);
      }
    } else {
      // 處理綠界支付的邏輯保持不變
      this.$router.push({
        path: '/pay1',
        query: {
          donationType: this.donationType,
          amount: this.finalAmount,
          paymentMethod: this.payment_method
        }
      });
    }
  } catch (error) {
    console.error('Payment processing error:', error);
    alert('🍂 付款處理發生錯誤，請稍後再試！');
  } finally {
    this.isProcessing = false;
  }
}
  }
};
</script>