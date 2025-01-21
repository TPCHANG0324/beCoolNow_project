<template>
    <MainHeader></MainHeader>
  
    <div class="wrapperpr">
      <h1 class="profile-title">會員資訊</h1>
      <div class="profile_top">
        <div class="profile-container-special_left">
          <div class="profile-header-special">
            <img src="../assets/images/mbhead.png" alt="會員頭像" class="profile-pic-special" />
            <h1 class="profile-greeting-special">{{ userData.name }} 您好！</h1>
          </div>
        </div>
  
        <div class="profile-container-special_right">
          <div class="profile-info-special">
            <div class="profile-field">
              <label for="name" class="label_mb">姓名</label>
              <template v-if="editStates.name">
              <input 
                type="text" 
                id="name" 
                v-model="tempData.name" 
                placeholder="輸入您的姓名" 
                class="input_2 input_editing" 
                 @keyup.enter="saveField('name')"
              />
              <button class="button_mb" @click="saveField('name')">儲存</button>
            </template>
            <template v-else>
              <span class="input_2">{{ userData.name }}</span>
              <button class="button_mb" @click="editField('name')">修改</button>
            </template>
          </div>
  
            <!-- <div class="profile-field">
              <label for="password" class="label_mb">密碼</label>
              <template v-if="editStates.password">
              <input 
                type="password" 
                id="password" 
                v-model="tempData.password" 
                placeholder="輸入您的密碼" 
                class="input_2" 
              />
              <button class="button_mb" @click="saveField('password')">儲存</button>
            </template>

            <template v-else>
              <span class="input_2">********</span>
              <button class="button_mb" @click="editField('password')">修改</button>
            </template>
          </div> -->
  
          <div class="profile-field">
                <label for="phone" class="label_mb">手機</label>
            <template v-if="editStates.phone">
              <input 
                type="text" 
                id="phone" 
                v-model="tempData.phone" 
                placeholder="輸入您的手機" 
                class="input_2 input_editing" 
                 @keyup.enter="saveField('phone')"
                  :class="{ 'input-error': validationErrors.phone }"
              />
              <button class="button_mb" @click="saveField('phone')">儲存</button>
              <span v-if="validationErrors.phone" class="error-message">{{ validationErrors.phone }}</span>
            </template>

            <template v-else>
              <span class="input_2">{{ userData.phone }}</span>
              <button class="button_mb" @click="editField('phone')">修改</button>
            </template>
          </div>


  
            <div class="profile-field">
              <label for="email" class="label_mb">信箱</label>
              <template v-if="editStates.email">
              <input 
                type="email" 
                id="email" 
                v-model="tempData.email" 
                placeholder="輸入您的信箱" 
                class="input_2 input_editing" 
                @keyup.enter="saveField('email')"
                  :class="{ 'input-error': validationErrors.email }"
              />
              <button class="button_mb" @click="saveField('email')">儲存</button>
              <span v-if="validationErrors.email" class="error-message">{{ validationErrors.email }}</span>
            </template>

            <template v-else>
              <span class="input_2">{{ userData.email }}</span>
              <button class="button_mb" @click="editField('email')">修改</button>
            </template>
            </div>
          </div>
        </div>
      </div>
  
      <div class="profile_bottom">
        <div class="profile-stats-special">
          <p>小寵物經驗值: <strong>200</strong> | 累積地球幣: <strong>300</strong></p>
        </div>
  
        <div class="purchase-record-special">
          <div class="btn2_btn">
            <!-- 添加按鈕事件 -->
            <button class="purchase-record-btn11" @click="showSection('purchase')">購買紀錄</button>
            <button class="purchase-record-btn12" @click="showSection('profile')">個人紀錄</button>
          </div>
  
          <!-- 購買紀錄表格 -->
          <table class="table_mb" v-if="activeSection === 'purchase'">
            <thead>
              <tr>
                <th>日期</th>
                <th>商品名稱</th>
                <th>消費金額</th>
                <th>來源</th>
                <th>配送狀態</th>
                <th>訂單詳情</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>2024/12/25</td>
                <td>環保吸管</td>
                <td>300</td>
                <td>環保市集</td>
                <td class="delivered-special">已送達</td>
                <td><button class="order-detail-btn">訂單詳情</button></td>
              </tr>
            </tbody>
            <tbody>
              <tr>
                <td>2024/12/25</td>
                <td>環保吸管</td>
                <td>300</td>
                <td>環保市集</td>
                <td class="delivered-special">已送達</td>
                <td><button class="order-detail-btn">訂單詳情</button></td>
              </tr>
            </tbody>
            <tbody>
              <tr>
                <td>2024/12/25</td>
                <td>環保吸管</td>
                <td>300</td>
                <td>環保市集</td>
                <td class="delivered-special">已送達</td>
                <td><button class="order-detail-btn">訂單詳情</button></td>
              </tr>
            </tbody>
            <tbody>
              <tr>
                <td>2024/12/25</td>
                <td>環保吸管</td>
                <td>300</td>
                <td>環保市集</td>
                <td class="delivered-special">已送達</td>
                <td><button class="order-detail-btn">訂單詳情</button></td>
              </tr>
            </tbody>
            <tbody>
              <tr>
                <td>2024/12/25</td>
                <td>環保吸管</td>
                <td>300</td>
                <td>環保市集</td>
                <td class="delivered-special">已送達</td>
                <td><button class="order-detail-btn">訂單詳情</button></td>
              </tr>
            </tbody>
            <tbody>
              <tr>
                <td>2024/12/25</td>
                <td>環保吸管</td>
                <td>300</td>
                <td>環保市集</td>
                <td class="delivered-special">已送達</td>
                <td><button class="order-detail-btn">訂單詳情</button></td>
              </tr>
            </tbody>
            <tbody>
              <tr>
                <td>2024/12/25</td>
                <td>環保吸管</td>
                <td>300</td>
                <td>環保市集</td>
                <td class="delivered-special">已送達</td>
                <td><button class="order-detail-btn">訂單詳情</button></td>
              </tr>
            </tbody>
          </table>
  
          <!-- 個人紀錄內容 -->
          <table v-if="activeSection === 'profile'" class="personal-record">
            <thead>
              <tr>
                <th>日期</th>
                <th>地球幣</th>
                <th>經驗值</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>2024/12/25</td>
                <td>300點</td>
                <td>200.EXP</td>
              </tr>
            </tbody>
            <tbody>
              <tr>
                <td>2024/12/25</td>
                <td>300點</td>
                <td>200.EXP</td>
              </tr>
            </tbody>
            <tbody>
              <tr>
                <td>2024/12/25</td>
                <td>300點</td>
                <td>200.EXP</td>
              </tr>
            </tbody>
            <tbody>
              <tr>
                <td>2024/12/25</td>
                <td>300點</td>
                <td>200.EXP</td>
              </tr>
            </tbody>
            <tbody>
              <tr>
                <td>2024/12/25</td>
                <td>300點</td>
                <td>200.EXP</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  
    <MainFooter class="footer_member"></MainFooter>
  </template>
  
  <script>
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';

export default {
  components: {
    MainHeader,
    MainFooter,
  },

  data() {
    return {
      activeSection: 'purchase',
      // 使用者資料
      userData: {
        name: '大中天',
        password: '********', // 實際上不應該儲存明文密碼
        phone: '0912345678',
        email: 'example@email.com'
      },

      // 暫存編輯中的資料
      tempData: {
        name: '',
        password: '',
        phone: '',
        email: ''
      },
      // 各欄位的編輯狀態
      editStates: {
        name: false,
        password: false,
        phone: false,
        email: false
      },
      // 新增驗證錯誤物件
      validationErrors: {
        phone: '',
        email: ''}
    };
  },
  methods: {
    // 切換顯示區域
    showSection(section) {
      this.activeSection = section;
    },
    // 開始編輯欄位
    editField(field) {
      this.tempData[field] = field === 'password' ? '' : this.userData[field];
      this.editStates[field] = true;

      // 清除之前的驗證錯誤
      if (this.validationErrors[field]) {
        this.validationErrors[field] = '';
      }
    },

    validateField(field) {
      if (field === 'phone') {
        if (!this.tempData.phone) {
          this.validationErrors.phone = '請輸入手機號碼';
          return false;
        }

        const phoneRegex = /^09\d{8}$/;
        if (!phoneRegex.test(this.tempData.phone)) {
          this.validationErrors.phone = '請輸入正確的手機格式（09開頭共10碼）';
          return false;
        }
        this.validationErrors.phone = '';
        return true;
      }
      if (field === 'email') {
        if (!this.tempData.email) {
          this.validationErrors.email = '請輸入電子郵件';
          return false;
        }
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(this.tempData.email)) {
          this.validationErrors.email = '請輸入正確的電子郵件格式';
          return false;
        }
        this.validationErrors.email = '';
        return true;
      }
      return true; // 其他欄位不需驗證
    },

    saveField(field) {
      // 驗證欄位
      if (!this.validateField(field)) {
        return;
      }

      if (this.tempData[field].trim()) {
        this.userData[field] = this.tempData[field].trim();
        this.editStates[field] = false;
        this.tempData[field] = '';
        this.validationErrors[field] = '';
      }
    }
  }
};
   
</script>
