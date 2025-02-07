<template>
  <div>
    <!-- 已經 RWD 820/ 430 完成 -->
    <MainHeader></MainHeader>
    <div class="bcn-donation-container1">
      <div class="bcn-top-place1">
        <div class="bcn-donation-header1">
          <p>您選擇了 <strong>{{ donationType === 'monthly' ? '每月捐款' : '單次捐款' }} 新臺幣 {{ amount }}元</strong></p>
        </div>
      </div>
      <div class="bcn-form-title_1">
        <h2>捐款人資料填寫</h2>
      </div>
      <div class="bcn-donation-form_1">
        <form @submit.prevent="handleSubmit">  <!-- 添加 form 標籤 -->
          <div class="inside_form_1">  <!-- 添加 inside_form_1 容器 -->
        <div class="input-group">
          <!-- 移除 action 和 method，改用 @submit.prevent -->
          <label for="email" class="bcn-label1">* 電子郵件地址</label>
      <input 
        id="email" 
        type="email" 
        v-model="formData.email" 
        required 
        class="bcn-input-text_1"
        @blur="validateEmail"
      />
      <span v-if="errors.email" class="error-message_pay1">{{ errors.email }}</span>
    </div>

    <div class="input-group">
      <label for="name" class="bcn-label1">* 捐款人姓名</label>
      <input 
        id="name" 
        type="text" 
        v-model="formData.name" 
        required 
        class="bcn-input-text_1"
        @blur="validateName" 
      />
      <span v-if="errors.name" class="error-message_pay1">{{ errors.name }}</span>
    </div>

    <div class="input-group">
      <label for="phone" class="bcn-label1">電話號碼</label>
      <input 
        id="phone" 
        type="tel" 
        v-model="formData.phone" 
        required
        placeholder="TW+886" 
        class="bcn-input-text_1"
        @blur="validatePhone"
      />
      <span v-if="errors.phone" class="error-message_pay1">{{ errors.phone }}</span>
    </div>
            <!-- <option value="TW+886">TW +886</option> -->
            <!-- </select> -->

            <!-- ✅ 修正 checkbox 與文字的排列 -->
            <div class="bcn-checkbox-container_1">
              <input 
                id="agree" 
                type="checkbox" 
                v-model="formData.agree"
                required 
              />
              <label for="agree" class="agree1"
                >我已詳細閱讀並同意
                <!-- ✅ 添加 href 以及 target="_blank" 讓連結能夠導外並開新分頁 -->
                <a href="#" class="privite" @click.prevent="showPrivacyPolicy">隱私權政策</a>

                <!-- 新增彈出視窗元件 -->
<div class="privacy-modal" v-if="isPrivacyModalOpen">
  <div class="modal-overlay" @click="closePrivacyPolicy"></div>
  <div class="modal-content">
    <div class="modal-header">
      <h2>隱私權政策</h2>
      <button class="close-button" @click="closePrivacyPolicy">&times;</button>
    </div>
    <div class="modal-body">
      <h3>捐款人資料保護政策</h3>
      <p style="font-weight: 700;">感謝您對涼城即時的支持。我們重視您的個人資料，並承諾依據以下原則保護您的隱私：</p>
      
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
      <p>您的資料僅供本機構內部使用，未經您同意，我們不會將資料提供給第三方。</p>

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
<button type="submit" class="bcn-btn-primary_1">下一步 信用卡填寫</button>
            
          </div>
          </form>
      </div>
      <a href="./pay1/" class="bc-prev-step-button2">
        <span class="bc-prev-step-icon2">❮</span>
        <router-link to="/support"><span class="bc-prev-step-text2">上一步</span></router-link>
      </a>
    </div>
    <MainFooter></MainFooter>
  </div>
</template>

<script>
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';

export default {
  name: 'pay1',
components: {
    MainHeader,
    MainFooter
  },
  data() {
    return {
      donationType: '',
      amount: 0,
      isPrivacyModalOpen: false,
      formData: {
        email: '',
        name: '',
        phone: '',
        agree: false,
        
      },
      errors: {
        email: '',
        name: '',
        phone: ''
      }
    };
  },
  created() {
    // 從 URL query 參數中獲取值
    const { donationType, amount } = this.$route.query;
    this.donationType = donationType || 'monthly'; // 如果沒有值，預設為 'monthly'
    this.amount = amount || 0; // 如果沒有值，預設為 0
  },

  methods: {
    showPrivacyPolicy() {
    this.isPrivacyModalOpen = true;
    document.body.style.overflow = 'hidden'; // 防止背景滾動
  },
  closePrivacyPolicy() {
    this.isPrivacyModalOpen = false;
    document.body.style.overflow = 'auto'; // 恢復背景滾動
  },
    validateName() {
      if (!this.formData.name.trim()) {
        this.errors.name = '請輸入捐款人姓名';
        return false;
      }
      this.errors.name = '';
      return true;
    },
    validateEmail() {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!this.formData.email.trim()) {
        this.errors.email = '請輸入電子郵件地址';
        return false;
      } else if (!emailRegex.test(this.formData.email)) {
        this.errors.email = '請輸入有效的電子郵件地址';
        return false;
      }
      this.errors.email = '';
      return true;
    },    
    validatePhone() {
      const phoneRegex = /^09\d{8}$/;
      if (!this.formData.phone.trim()) {
        this.errors.phone = '請輸入電話號碼';
        return false;
      } else if (!phoneRegex.test(this.formData.phone)) {
        this.errors.phone = '請輸入有效的台灣手機號碼 (09xxxxxxxx)';
        return false;
      }
      this.errors.phone = '';
      return true;
    },

    validateAll() {
      const isNameValid = this.validateName();
      const isEmailValid = this.validateEmail();
      const isPhoneValid = this.validatePhone();
      return isNameValid && isEmailValid && isPhoneValid;
    },
    handleSubmit() {
      // 檢查是否有空白欄位
      if (!this.formData.name.trim() || !this.formData.email.trim() || !this.formData.phone.trim()) {
        alert('請填寫所有必填欄位');
        return;
      }

      // 進行所有欄位的驗證
      if (!this.validateAll()) {
        alert('請確認所有欄位都已正確填寫');
        return;
      }

      // 檢查是否同意隱私權政策
      if (!this.formData.agree) {
        alert('請同意隱私權政策');
        return;
      }

      // 修改路由跳轉，加入查詢參數
  this.$router.push({
    path: '/pay2',
    query: {
      donationType: this.donationType,
      amount: this.amount
    }
  });
    }
  }
}
</script>
