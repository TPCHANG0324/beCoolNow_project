<template>
  <div>
    <MainHeader />
    <div class="Support_banner_S">
      <video class="background-video" autoplay loop muted playsinline>
        <source src="@/assets/videos/supportus.mp4" type="video/mp4" />
      </video>
      <h1>您的支持<br>&nbsp;&nbsp;幫助地球生態扭轉危機！</h1>
    </div>

    <div class="Support_box_S">
      <p>
        是的！我珍愛地球環境與生態 <br />
        我要與自然、社會共生共好，永續發展。
      </p>
      <div class="dona-wrap">
        <!-- 捐款類型選擇 -->
        <div class="donate_choise_S">
          <button :class="['donate_type_month', { active: donationType === 'monthly' }]"
            @click="setDonationType('monthly')">
            每月捐款
          </button>
          <button :class="['donate_type_once', { active: donationType === 'once' }]" @click="setDonationType('once')">
            單次捐款
          </button>
        </div>

        <!-- 固定金額選項 -->
        <div class="donate_amount_S">
          <button v-for="amount in amounts" :key="amount" :class="['amount', { active: selectedAmount === amount }]"
            @click="setAmount(amount)">
            ${{ amount }}<br />新台幣
          </button>
        </div>


        <!-- 自訂金額輸入 -->
        <div class="custom_amount_S">
          <span>自訂金額：</span>
          <input type="text" placeholder="請輸入金額，以新台幣為單位" class="custom_amount_input" v-model="customAmount"
            @input="handleCustomAmountInput" @keypress="validateNumberInput" @paste="handlePaste" />
        </div>

        <!-- 付款方式選擇 -->
        <div class="payment_section_S">
          <div class="payment_content">
            <label class="how">
              <span class="marker" title="此欄位不可空白">*</span>
              選擇付款方式：
            </label>
            <!-- 當錯誤時會顯示訊息 -->
            <div v-if="formErrors.payment" class="error-message" style="color: red;">
              請選擇付款方式
            </div>
            <!-- Line Pay 只提供單次捐款使用 -->
            <label class="linepay" :class="{ disabled: donationType === 'monthly' }">
              <input type="radio" class="payment_method" value="Line Pay行動支付" v-model="payment_method"
                :disabled="donationType === 'monthly'" @change="handlePaymentMethodChange" />
              <span>Line Pay行動支付</span>
            </label>
            <label class="ecpay">
              <input type="radio" class="payment_method" value="綠界金流服務(信用卡)" v-model="payment_method"
                @change="handlePaymentMethodChange" />
              <div class="ecpay-text-wrapper">
                <span class="ecpay1">綠界金流服務(信用卡)</span>
                <span class="ecpay2">(信用卡才能進行每月定額捐款)</span>
              </div>
            </label>
          </div>

          <!-- 下一步按鈕 -->
          <div class="payment_step_S">
            <button class="next_step" @click="handleNextStep">
              {{ isProcessing ? '處理中...' : '下一步' }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <MainFooter />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import MainHeader from '@/components/layout/MainHeader.vue'
import MainFooter from '@/components/layout/MainFooter.vue'

const donationType = ref('monthly')      // 捐款類型：'monthly' 或 'once'
const selectedAmount = ref(800)            // 固定選項金額（若使用者點擊固定金額，就會設定此值）
const customAmount = ref('')               // 自訂金額（使用者自行輸入）
const amounts = ref([800, 1000, 1200])       // 固定金額列表
const payment_method = ref('')             // 付款方式
const formErrors = ref({ amount: false, payment: false })
const isProcessing = ref(false)
const route = useRoute();
const router = useRouter();

// 最終捐款金額：如果有自訂金額，就採用自訂；否則採用固定選項
const finalAmount = computed(() => {
  return customAmount.value ? parseInt(customAmount.value, 10) : selectedAmount.value;
})

// 表單驗證：必須有有效金額，並依照捐款類型符合付款方式規則
const isFormValid = computed(() => {
  const amount = finalAmount.value;
  const validAmount = amount && amount > 0;
  let validPayment = false;
  if (donationType.value === 'monthly') {
    // 每月捐款只能使用信用卡
    validPayment = payment_method.value === '綠界金流服務(信用卡)';
  } else if (donationType.value === 'once') {
    // 單次捐款只要有選擇付款方式即可
    validPayment = !!payment_method.value;
  }
  return validAmount && validPayment;
});


// 付款方式改變時，若有選擇就清除錯誤訊息
const handlePaymentMethodChange = () => {
  if (payment_method.value) {
    formErrors.value.payment = false;
  }
}

// 設定捐款類型，並在每月捐款時若付款方式為 Line Pay，則清除付款方式
const setDonationType = (type) => {
  if (!type) {
    alert('🌏請選擇捐款類型！');
    return;
  }
  donationType.value = type;
  if (type === 'monthly' && payment_method.value === 'Line Pay行動支付') {
    payment_method.value = '';
  }
}

// 點擊固定金額按鈕時：設定固定金額，同時清除自訂金額
const setAmount = (amount) => {
  if (!amount) return;
  selectedAmount.value = amount;
  customAmount.value = ''; // 清除自訂金額
  formErrors.value.amount = false;
}

// 當使用者輸入自訂金額時，僅保留數字，並清除固定金額選擇
const handleCustomAmountInput = (event) => {
  let value = event.target.value.replace(/\D/g, '');
  value = value.replace(/^0+/, '');
  customAmount.value = value;
  if (value !== '') {
    // 清除固定選項
    selectedAmount.value = null;
    formErrors.value.amount = false;
  }
}

// 限制鍵盤輸入只能輸入數字
const validateNumberInput = (event) => {
  if (!/[0-9]/.test(event.key)) {
    event.preventDefault();
  }
}

// 處理貼上事件，僅保留數字內容
const handlePaste = (event) => {
  event.preventDefault();
  const pastedText = (event.clipboardData || window.clipboardData).getData('text');
  let numericValue = pastedText.replace(/\D/g, '').replace(/^0+/, '');
  if (numericValue) {
    customAmount.value = numericValue;
    selectedAmount.value = null;
    formErrors.value.amount = false;
  }
}

// 驗證表單資料
const validateForm = () => {
  let isValid = true;
  const errors = [];

  if (!donationType.value) {
    errors.push('請選擇捐款類型（每月捐款或單次捐款）！');
    isValid = false;
  }

  if (!finalAmount.value || finalAmount.value <= 0) {
    errors.push('請輸入大於 0 的金額！');
    formErrors.value.amount = true;
    isValid = false;
  }

  if (!payment_method.value) {
    errors.push('請選擇付款方式！');
    formErrors.value.payment = true;
    isValid = false;
  }

  if (donationType.value === 'monthly' && payment_method.value !== '綠界金流服務(信用卡)') {
    errors.push('每月捐款只能使用信用卡付款！');
    formErrors.value.payment = true;
    isValid = false;
  }

  if (!isValid) {
    alert(errors.join('\n'));
  }
  return { isValid, errors };
}

//下一步：根據付款方式導入不同 path
const handleNextStep = () => {

  const { isValid } = validateForm();
  if (!isValid) return;

  if (finalAmount.value <= 0) {
    alert('🌏捐款金額必須大於 0！');
    return;
  }
  isProcessing.value = true;
  // console.log(payment_method.value)
  // console.log(donationType.value,finalAmount.value)
  let paymentMethodPath = '';
  if (payment_method.value === 'Line Pay行動支付') {
    paymentMethodPath = 'linePay';
  } else if (payment_method.value === '綠界金流服務(信用卡)') {
    paymentMethodPath = 'creditCard';
  }

  router.push({
    path: `/support/${paymentMethodPath}`,
    query: {
      donationType: donationType.value, // 捐款類型
      amount: finalAmount.value,        // 捐款金額
    },
  });

}
</script>
