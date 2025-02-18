<template>
  <div>
    <!-- 已經 RWD 820/430 完成 -->
    <MainHeader />
    <div class="bcn-donation-container1">
      <div class="bcn-top-place1">
        <div class="bcn-donation-header1">
          <p>
            您選擇了
            <strong>
              {{ donationType === 'monthly' ? '每月捐款' : '單次捐款' }}
              新臺幣 {{ amount }}元
            </strong>
          </p>
        </div>
      </div>
      <div class="bcn-form-title_1">
        <h2>捐款人資料填寫</h2>
      </div>
      <div class="bcn-donation-form_1">
        <!-- 表單提交事件綁定 handleSubmit 函數 -->
        <form @submit.prevent="handleSubmit">
          <div class="inside_form_1">
            <div class="input-group">
              <label for="email" class="bcn-label1">* 電子郵件地址</label>
              <input id="email" type="email" v-model="formData.email" required class="bcn-input-text_1"
                @blur="validateEmail" />
              <span v-if="errors.email" class="error-message_pay1">
                {{ errors.email }}
              </span>
            </div>

            <div class="input-group">
              <label for="name" class="bcn-label1">* 捐款人姓名</label>
              <input id="name" type="text" v-model="formData.name" required class="bcn-input-text_1"
                @blur="validateName" />
              <span v-if="errors.name" class="error-message_pay1">
                {{ errors.name }}
              </span>
            </div>

            <div class="input-group">
              <label for="phone" class="bcn-label1">電話號碼</label>
              <input id="phone" type="tel" v-model="formData.phone" required placeholder="TW+886"
                class="bcn-input-text_1" @blur="validatePhone" />
              <span v-if="errors.phone" class="error-message_pay1">
                {{ errors.phone }}
              </span>
            </div>

            <!-- 隱私權政策勾選 -->
            <div class="bcn-checkbox-container_1">
              <input id="agree" type="checkbox" v-model="formData.agree" required />
              <label for="agree" class="agree1">
                我已詳細閱讀並同意
                <a href="#" class="privite" @click.prevent="showPrivacyPolicy">
                  隱私權政策
                </a>
                <!-- 隱私權政策彈出視窗 -->
                <div class="privacy-modal" v-if="isPrivacyModalOpen">
                  <div class="modal-overlay" @click="closePrivacyPolicy"></div>
                  <div class="modal-content">
                    <div class="modal-header">
                      <h2>隱私權政策</h2>
                      <button class="close-button" @click="closePrivacyPolicy">
                        &times;
                      </button>
                    </div>
                    <div class="modal-body">
                      <h3>捐款人資料保護政策</h3>
                      <p style="font-weight: 700;">
                        感謝您對涼城即時的支持。我們重視您的個人資料，並承諾依據以下原則保護您的隱私：
                      </p>
                      <h4>1. 資料蒐集目的</h4>
                      <p>我們收集您的個人資料僅用於：</p>
                      <ol>
                        <li>✔ 處理您的捐款</li>
                        <li>✔ 開立捐款收據</li>
                        <li>✔ 捐款相關通知與聯繫</li>
                        <li>✔ 依法開立及寄發年度扣除額單據</li>
                      </ol>
                      <h4>2. 資料項目</h4>
                      <p>我們收集的資料包括：</p>
                      <ol>
                        <li>✔ 姓名</li>
                        <li>✔ 聯絡電話</li>
                        <li>✔ 電子郵件地址</li>
                        <li>✔ 捐款金額與日期</li>
                      </ol>
                      <h4>3. 資料保護措施</h4>
                      <p>我們採取嚴格的安全措施保護您的資料：</p>
                      <ol>
                        <li>✔ 採用加密技術保護資料傳輸</li>
                        <li>✔ 定期更新資安系統</li>
                        <li>✔ 嚴格控管資料存取權限</li>
                      </ol>
                      <h4>4. 資料利用範圍</h4>
                      <p>
                        您的資料僅供本機構內部使用，未經您同意，我們不會將資料提供給第三方。
                      </p>
                      <h4>5. 資料當事人權利</h4>
                      <p>依個人資料保護法，您擁有以下權利：</p>
                      <ol>
                        <li>✔ 查詢或請求閱覽個人資料</li>
                        <li>✔ 請求製給複製本</li>
                        <li>✔ 請求補充或更正個人資料</li>
                        <li>✔ 請求停止蒐集、處理或利用個人資料</li>
                        <li>✔ 請求刪除個人資料</li>
                      </ol>
                    </div>
                  </div>
                </div>
              </label>
            </div>
            <button type="submit" class="bcn-btn-primary_1">
              {{ buttonText }}
            </button>
          </div>
        </form>
      </div>
      <a href="./pay1/" class="bc-prev-step-button2">
        <span class="bc-prev-step-icon2">❮</span>
        <RouterLink to="/support">
          <span class="bc-prev-step-text2">上一步</span>
        </RouterLink>
      </a>
    </div>
    <MainFooter />
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';

const base_url = import.meta.env.VITE_AJAX_URL; //路由
// 捐款類型與金額（從 URL query 取得）
const donationType = ref('');
const amount = ref(0);
// 是否顯示隱私權政策彈窗
const isPrivacyModalOpen = ref(false);

// 表單資料
const formData = reactive({
  email: '',
  name: '',
  phone: '',
  agree: false,
  amount: amount.value
});

// 各欄位錯誤訊息
const errors = reactive({
  email: '',
  name: '',
  phone: '',
});

const route = useRoute();
const router = useRouter();

// 初始化：從 URL query 取得捐款類型與金額，若無則設定預設值
// donationType.value = route.query.donationType || 'monthly';
// amount.value = route.query.amount ? Number(route.query.amount) : 0;

//根據 paymentMethod 渲染按鈕文字
const buttonText = computed(() => {
  return route.params.paymentMethod === 'linePay' ? '確認付款' : '下一步 信用卡填寫';
});


//顯示隱私權政策彈窗- 開啟彈窗並禁止背景滾動
const showPrivacyPolicy = () => {
  isPrivacyModalOpen.value = true;
  document.body.style.overflow = 'hidden';
};

//關閉隱私權政策彈窗
const closePrivacyPolicy = () => {
  isPrivacyModalOpen.value = false;
  document.body.style.overflow = 'auto';
};

//驗證捐款人姓名
const validateName = () => {
  if (!formData.name.trim()) {
    errors.name = '請輸入捐款人姓名';
    return false;
  }
  errors.name = '';
  return true;
};

//驗證電子郵件地址
const validateEmail = () => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!formData.email.trim()) {
    errors.email = '請輸入電子郵件地址';
    return false;
  } else if (!emailRegex.test(formData.email)) {
    errors.email = '請輸入有效的電子郵件地址';
    return false;
  }
  errors.email = '';
  return true;
};

//驗證電話號碼
const validatePhone = () => {
  const phoneRegex = /^09\d{8}$/;
  if (!formData.phone.trim()) {
    errors.phone = '請輸入電話號碼';
    return false;
  } else if (!phoneRegex.test(formData.phone)) {
    errors.phone = '請輸入有效的台灣手機號碼 (09xxxxxxxx)';
    return false;
  }
  errors.phone = '';
  return true;
};

//驗證所有捐款人資料欄位
const validateAll = () => {
  const isNameValid = validateName();
  const isEmailValid = validateEmail();
  const isPhoneValid = validatePhone();
  return isNameValid && isEmailValid && isPhoneValid;
};

//表單提交處理:如驗證通過則轉跳至下一步，並帶入捐款類型與金額參數
const handleSubmit = async () => {
  // 檢查必填欄位是否填寫
  if (!formData.name.trim() || !formData.email.trim() || !formData.phone.trim()) {
    alert('請填寫所有必填欄位');
    return;
  }
  // 驗證所有欄位內容
  if (!validateAll()) {
    alert('請確認所有欄位都已正確填寫');
    return;
  }
  // 檢查是否同意隱私權政策
  if (!formData.agree) {
    alert('請同意隱私權政策');
    return;
  }
  // 驗證通過後
  if (route.params.paymentMethod === 'linePay') {  //linePay付款
    // console.log(formData.email,formData.name,formData.phone) 
    const orderData = {
      amount: amount.value,
      productName: '公益捐款',
      userData: formData
    };
    
    formData.amount = amount.value
    // console.log(orderData)
    try {
      const res = await fetch(base_url + '/donate_linePay.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(orderData)
      });
      const data = await res.json();
      if (data.returnCode === '0000') {
        // 成功取得支付連結，導向 LINE Pay 付款頁面
        window.location.href = data.info.paymentUrl.web;
      } else {
        throw new Error(data.returnMessage || '付款連結產生失敗');
      }
    } catch (err) {
      console.error('付款處理錯誤:', err);
      alert('付款處理發生錯誤，請稍後再試！');
    }

  } else {
    //如果是信用卡付款則轉跳至下一頁填寫信用卡資訊
    //給瑋宸：這個query的參數會直接被放在查詢字串，看你要不要用
    router.push({
      path: '/pay2',
      query: {
        donationType: donationType.value,
        amount: amount.value,
      },
    });
  }
};


onMounted(() => {
  //從上一頁的資料撈
  donationType.value = route.query.donationType;
  amount.value = route.query.amount ? Number(route.query.amount) : 0;
  if (!donationType.value || !amount.value || amount.value <= 0) {
    alert('缺少必要的捐款資訊，請重新選擇。');
    router.push('/support'); // 導向回 support 頁面
    return;
  }
})
</script>
