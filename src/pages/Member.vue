<template>
  <div>
    <MainHeader />

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
                <span class="input_2 email-display">{{ formatEmail(userData.email) }}</span>
                <button class="button_mb" @click="editField('email')">修改</button>
              </template>
            </div>
          </div>
        </div>
      </div>

      <div class="profile_bottom">
        <div class="purchase-record-special">
          <div class="btn2_btn">
            <div class="btn2_btn_top">
              <button class="purchase-record-btn11" @click="showSection('purchase')">購買紀錄</button>
              <button class="purchase-record-btn12" @click="showSection('profile')">個人紀錄</button>
            </div>
            <div class="bt2_btn_bottom">
              <div class="profile-stats-special">
                <p>小寵物經驗值: <strong>200</strong> | 累積地球幣: <strong>300</strong></p>
              </div>
            </div>
          </div>

          <div class="table-container_mb">
            <table v-if="activeSection === 'purchase'" class="table_mb">
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
              <tbody v-for="order in purchaseRecords" :key="order.orderId">
                <tr>
                  <td>{{ order.date }}</td>
                  <td>{{ order.productName }}</td>
                  <td>{{ order.price }}</td>
                  <td>{{ order.source }}</td>
                  <td class="delivered-special">{{ order.status }}</td>
                  <td><button class="order-detail-btn" @click="showOrderDetail(order)">訂單詳情</button></td>
                </tr>
              </tbody>
            </table>

            <table v-if="activeSection === 'profile'" class="personal-record">
              <thead>
                <tr>
                  <th>日期</th>
                  <th>地球幣</th>
                  <th>經驗值</th>
                </tr>
              </thead>
              <tbody v-for="(record, index) in personalRecords" :key="index">
                <tr>
                  <td>{{ record.date }}</td>
                  <td>{{ record.points }}點</td>
                  <td>{{ record.experience }}.EXP</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <OrderDetailPopup
      :is-visible="showOrderPopup"
      :order="selectedOrder"
      @close="closeOrderPopup"
    />

    <MainFooter class="footer_member" />
  </div>
</template>

<script>
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
import OrderDetailPopup from '@/pages/popUpdetailshop.vue';

export default {
  components: {
    MainHeader,
    MainFooter,
    OrderDetailPopup
  },

  data() {
    return {
      activeSection: 'purchase',
      userData: JSON.parse(localStorage.getItem('userData')) || {
        name: '大中天',
        phone: '0912345678',
        email: 'example@email.com'
      },
      tempData: {
        name: '',
        phone: '',
        email: ''
      },
      editStates: {
        name: false,
        phone: false,
        email: false
      },
      validationErrors: {
        phone: '',
        email: ''
      },
      showOrderPopup: false,
      selectedOrder: null,
      purchaseRecords: [
      {
    orderId: "ORD001",
    date: "2024/12/25",
    productName: "環保吸管",
    price: 300,
    quantity: 1,
    status: "已送達",
    address: "台北市大安區復興南路一段390號2樓",
    source: "環保市集"
  },
  {
    orderId: "ORD002",
    date: "2024/12/20",
    productName: "可重複使用水壺",
    price: 450,
    quantity: 1,
    status: "已出貨",
    address: "新北市板橋區文化路二段",
    source: "綠色商店"
  },
  {
    orderId: "ORD003",
    date: "2024/12/15",
    productName: "竹纖維餐具組",
    price: 580,
    quantity: 1,
    status: "已送達",
    address: "台中市西屯區逢甲路",
    source: "永續生活"
  },
  {
    orderId: "ORD004",
    date: "2024/12/10",
    productName: "有機棉購物袋",
    price: 250,
    quantity: 2,
    status: "處理中",
    address: "高雄市鳳山區",
    source: "環保聯盟"
  },
  {
    orderId: "ORD005",
    date: "2024/12/05",
    productName: "天然洗髮精",
    price: 380,
    quantity: 1,
    status: "已送達",
    address: "台南市東區",
    source: "綠色生活"
  },
  {
    orderId: "ORD006",
    date: "2024/12/25",
    productName: "環保吸管",
    price: 300,
    quantity: 1,
    status: "已送達",
    address: "台北市大安區復興南路一段390號2樓",
    source: "環保市集"
  },
  {
    orderId: "ORD007",
    date: "2024/12/20",
    productName: "可重複使用水壺",
    price: 450,
    quantity: 1,
    status: "已出貨",
    address: "新北市板橋區文化路二段",
    source: "綠色商店"
  }
      ],
      personalRecords: [
        { date: "2024/12/25", points: 300, experience: 200 },
        { date: "2024/12/25", points: 300, experience: 200 },
        { date: "2024/12/25", points: 300, experience: 200 },
        { date: "2024/12/25", points: 300, experience: 200 },
        { date: "2024/12/25", points: 300, experience: 200 }
      ]
    };
  },
  methods: {
    showOrderDetail(order) {
      this.selectedOrder = order;
      this.showOrderPopup = true;
    },
    showSection(section) {
      this.activeSection = section;
    },
    closeOrderPopup() {
      this.showOrderPopup = false;
      this.selectedOrder = null;
    },
    editField(field) {
      this.tempData[field] = this.userData[field];
      this.editStates[field] = true;
      this.validationErrors[field] = '';
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
      return true;
    },
    formatEmail(email) {
      return email.replace(/(.{30})/g, '$1\n');
    },
    saveField(field) {
      if (!this.validateField(field)) {
        return;
      }
      if (this.tempData[field].trim()) {
        this.userData[field] = this.tempData[field].trim();
        localStorage.setItem('userData', JSON.stringify(this.userData));
        this.editStates[field] = false;
        this.tempData[field] = '';
        this.validationErrors[field] = '';
      }
    },
    async fetchUserData() {
      try {
        const response = await fetch('/api/user-profile');
        const data = await response.json();
        this.userData = data;
        localStorage.setItem('userData', JSON.stringify(data));
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    }
  }
}
</script>
