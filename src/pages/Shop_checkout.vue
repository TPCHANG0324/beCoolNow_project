<template>
  <MainHeader></MainHeader>
  <div class="si_container_R" style="color: #545454;">
    <div class="Sp-checkout-nav-X">
                  <!-- 每一個圓圈 -->
                  <div class="Sp-step-X">
                      <span class="Sp-badge-X">
                          <div class="Sp-badge-text-X">1</div>
                      </span>
                      <span>購物車</span>
                  </div>

                  <div class="Sp-step-X active">
                      <span class="Sp-badge-X">
                          <div class="Sp-badge-text-X">2</div>
                      </span>
                      <span>填寫資料</span>
                  </div>

                  <div class="Sp-step-X">
                      <span class="Sp-badge-X">
                          <div class="Sp-badge-text-X">3</div>
                      </span>
                      <span>購買完成</span>
                  </div>
    </div>
    <div class="si_content_R">

      <!-- <nav class="breadcrumb">
        <ol>
          <li><a href="#">首頁</a></li>
          &nbsp;&gt;&nbsp;
          <li>NT$100~$200</li>
        </ol>
      </nav> -->
      <!-- 步驟進度條 -->
      <!-- div... -->
      <!-- 合計 -->
      <div class="si_ordersummary_R">
        <!-- 頭部區域 -->
        <div class="si_orderhead_R">
          <h2>合計:NT${{ total }}</h2>
          <!-- 點擊 p.toggle-details 切換明細顯示/隱藏 -->
          <p class="toggle-details" @click="toggleDetails">
            購物車({{ totalItems }}件)
            <!-- 依據是否展開來切換 icon -->
            <i :class="[`fa-solid`, isOpen ? 'fa-angle-up' : 'fa-angle-down']"></i>
          </p>
        </div>

        <!-- 明細區域 -->
        <transition name="slide-fade">
          <div v-if="isOpen" class="si_orderdetails_R">
            <!-- 商品資料 -->
            <div class="si_orderbottom1_R">
              <div class="item1">商品資料</div>
              <div class="item2">優惠</div>
              <div class="item3">單件價格</div>
              <div class="item4">數量</div>
              <div class="item5">小計</div>
            </div>

            <div class="si_orderbottom2_R"  v-for="(item, index) in cartItems" :key="item.id">
              <div class="middle_item1">
                <a href="#">
                  <img :src="`/tid103/g1/images/${item.image}`" style="width: 50px" />
                  <label>{{ item.name }}</label>
                </a>
              </div>
              <div class="middle_item2">暫定優惠</div>
              <div class="middle_item3">NT${{ item.salePrice }}</div>
              <div class="middle_item4">{{ item.num }}</div>
              <div class="middle_item5">NT${{ item.salePrice * item.num }}</div>
            </div>

            <div class="si_orderbottom3_R">
              <div class="bottom3_1">
                <span class="pull-left">小計:</span>
                <span class="pull-right">NT${{ subtotal }}</span>
              </div>
              <div class="bottom3_2">
                <span class="pull-left">運費:</span>
                <span class="pull-right">NT${{ deliverCost }}</span>
              </div>
              <div class="bottom3_3">
                <span class="pull-left">折抵:</span>
                <span class="pull-right">-{{ discount }}</span>
              </div>
              <div class="bottom3_3">
                <span class="pull-left">合計:</span>
                <span class="pull-right">NT${{ total }}</span>
              </div>
            </div>

            <!-- <div class="si_orderbottom_R">
              <i class="fa-solid fa-angle-down"></i>
            </div> -->
          </div>
        </transition>
      </div>
      <!-- 下方 -->
      <div class="si_bottomsection_R">
        <div class="si_order1_R">
          <!-- 顧客資料 -->
          <section class="Si_customerinfo_R" style="border: none;">
            <div class="Si_customerinfo_header">顧客資料</div>
            <div class="Si_customerinfo_body">
              <label for="">顧客名稱</label>
              <input v-model="customerInfo.name" type="text" class="input" placeholder="緯育股份有限公司"/>
              <p v-if="errors.customerInfo.name" class="error">{{ errors.customerInfo.name }}</p>

              <label for="">電子信箱</label>
              <input v-model="customerInfo.email" type="email" class="input" placeholder="tid103@tibame.gmail.com"/>
              <p v-if="errors.customerInfo.email" class="error">{{ errors.customerInfo.email }}</p>

              <label for="">電話號碼</label>
              <div class="si_phonenumber_R" style="gap: 8px;">
                <div class="si_leftphone_R">
                  <select id="" name="" class="input" style=" padding: 0;">
                    <option value="TW+886">TW+886</option>
                  </select>
                </div>
                <div class="si_rightphone_R">
                  <input v-model="customerInfo.phone" type="text" class="input" />
                  <p v-if="errors.customerInfo.phone" class="error" style="margin-top: 13px;">{{ errors.customerInfo.phone }}</p>
                </div>
              </div>
              <label for="sex_R">性別 (選填)</label>
              <select v-model="customerInfo.gender" id="sex_R" name="" class="input" style=" padding: 0;">
                <option value="">請選擇</option>
                <option value="男">男</option>
                <option value="女">女</option>
                <option value="其他">其他</option>
              </select>
            </div>
          </section>
          <!-- 送貨資料 -->
          <section class="Si_deliveryinfo_R">
            <div class="Si_deliveryinfo_header">送貨資料</div>
            <div class="Si_deliveryinfo_body">
              <p>{{ selectedDelivery }}</p>
              <label class="si_checkbox">
                <input v-model="isSameAsCustomer" id="si_check" type="checkbox" />
                收件人資料與顧客資料相同
              </label>
              <label for="">收件人姓名</label>
              <input v-model="recipientInfo.name" type="text" class="input" placeholder="緯育股份有限公司"/>
              <p v-if="errors.recipientInfo.name" class="error">{{ errors.recipientInfo.name }}</p>

              <label for="">電子信箱</label>
              <input v-model="recipientInfo.email" type="email" class="input" placeholder= "tid103@gmail.com"/>
              <p v-if="errors.recipientInfo.email" class="error">{{ errors.recipientInfo.email }}</p>

              <label for="">電話號碼</label>
              <div class="si_phonenumber_R" style="gap: 8px;">
                <div class="si_leftphone_R">
                  <select id="" name="" class="input" style="padding: 0;">
                    <option value="TW+886">TW+886</option>
                  </select>
                </div>
                <div class="si_rightphone_R">
                  <input v-model="recipientInfo.phone" type="text" class="input" />
                  <p v-if="errors.recipientInfo.phone" class="error" style="margin-top: 13px;">{{ errors.recipientInfo.phone }}</p>
                </div>
              </div>
              <div id="app">
                <div class="si_address">
                  <div style="display: flex; justify-content: space-between;">
                    <label for="">地址</label>
                    <p>送貨地點: 台灣</p>
                  </div>
                  <div class="si_aselect">
                    <div style="width: 25%;">
                      <!-- 城市選擇 -->
                      <select v-model="selectedCity" class="input" style="width: 100%; padding: 0;" >
                        <option value="">請選擇城市</option>
                        <option v-for="city in cities" :value="city.name" :key="city.name">
                          {{ city.name }}
                        </option>
                      </select>
                      <p v-if="errors.addressInfo.selectedCity" class="error" style="margin-top: 13px;">{{ errors.addressInfo.selectedCity }}</p>
                    </div>

                    <div style="width: 25%;">
                      <!-- 區域選擇 -->
                      <select v-model="selectedDistrict" class="input" style="width: 100%; padding: 0;">
                        <option value="">請選擇區域</option>
                        <option v-for="district in selectedDistricts" :value="district" :key="district">
                          {{ district }}
                        </option>
                      </select>
                      <p v-if="errors.addressInfo.selectedDistrict" class="error" style="margin-top: 13px;">{{ errors.addressInfo.selectedDistrict }}</p>
                    </div>
                  </div>

                  <div class="address2">
                    <input v-model="recipientInfo.address" type="text" placeholder="詳細地址" class="input" />
                    <p v-if="errors.addressInfo.addressDetail" class="error" style="margin-top: 13px;">{{ errors.addressInfo.addressDetail }}</p>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
        <!-- 第二部分 -->
        <div class="si_order2_R">
          <!-- 訂單備註 -->
          <section class="Si-ordernotes-R">
            <div class="Si_ordernotes_header">訂單備註</div>
            <div class="si_ordernotes_body">
              <textarea v-model="orderNotes" class="input" style="resize: none; width: 34.5rem;" id="" placeholder="有甚麼想告訴賣家嗎?"></textarea>
            </div>
          </section>
          <!-- 付款資料 -->
          <section class="Si-payment-R">
            <div class="si_payment_header">付款資料</div>
            <div class="si_payment_body">
              <input v-model="paymentInfo.cardNumber" type="text" placeholder="卡號" class="input" maxlength="19" @input="formatCardNumber" required />
              <p v-if="errors.paymentInfo.cardNumber" class="error">{{ errors.paymentInfo.cardNumber }}</p>

              <input v-model="paymentInfo.cardHolder" type="text" placeholder="持卡人姓名" class="input" required />
              <p v-if="errors.paymentInfo.cardHolder" class="error">{{ errors.paymentInfo.cardHolder }}</p>

              <input v-model="paymentInfo.expirationDate" @input="formatExpirationDate" maxlength="5"  type="text" placeholder="有效期限(MM/YY)" class="input" required />
              <p v-if="errors.paymentInfo.expirationDate" class="error">{{ errors.paymentInfo.expirationDate }}</p>

              <input v-model="paymentInfo.securityCode" @input="formatSecurityCode" maxlength="4"  type="text" placeholder="安全碼" class="input" required />
              <p v-if="errors.paymentInfo.securityCode" class="error">{{ errors.paymentInfo.securityCode }}</p>

            </div>
          </section>
        </div>

        <div class="si_order3_R">
          <div class="si_return_R">
            <RouterLink to="/Shop_cart">返回購物車</RouterLink>
          </div>
          <!-- 第三部分 -->
          <div class="si_reciptout_R">
            <section class="Si_recipt_R">
              <div class="si_recipt_header">索取發票</div>
              <div class="si_recipt_body">
                <label for="">發票類型</label>
                <select id="" name="" class="input" style="padding: 0;">
                  <option value="捐贈發票/雲端發票">捐贈發票/雲端發票</option>
                </select>
                <label for="">載具類型</label>
                <select id="" name="" class="input" style="padding: 0;">
                  <option value="">個人載具</option>
                </select>
              </div>
            </section>
            <RouterLink to="#" @click="submitOrder" class="si_submit_R btn">提交訂單</RouterLink>
          </div>
        </div>
      </div>
    </div>
    <MainFooter></MainFooter>
  </div>
</template>


<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router';
import { RouterLink } from 'vue-router'
import MainFooter from '@/components/layout/MainFooter.vue';
import MainHeader from '@/components/layout/MainHeader.vue';


// -- 加入「展開/收合」邏輯 --
const isOpen = ref(false);
const toggleDetails = () => {
  isOpen.value = !isOpen.value
}

// **從 localStorage 讀取購物車資料**
const cartItems = ref([]);


const usePoints = ref(0);
const discount = computed(() => usePoints.value / 100); // 100 點折抵 1 元
const selectedDelivery = ref('')

onMounted(() => {
  const storedCart = localStorage.getItem("cart");
  if (storedCart) {
    cartItems.value = JSON.parse(storedCart);
  }
  console.log("🛒 結帳頁面載入購物車資料:", cartItems.value);

  const savedPoints = localStorage.getItem("usePoints");
  if (savedPoints) {
    usePoints.value = JSON.parse(savedPoints);
    console.log("✅ 從 localStorage 讀取點數折抵:", usePoints.value);
  }
  // 當頁面載入時，從 localStorage 取得運費資訊
  selectedDelivery.value = localStorage.getItem('selectedDelivery') || '新竹物流宅配';
  deliverCost.value = parseInt(localStorage.getItem('deliverCost')) || 100;

});




// 計算總價
const subtotal = computed(() => {
  return cartItems.value.reduce((sum, item) => sum + item.salePrice * item.num, 0);
});

// 運費
const deliverCost  = ref(0); // 預設運費

// 計算合計
const total = computed(() => {
  return subtotal.value + deliverCost.value - discount.value;
});

// 計算購物車內的商品總數
const totalItems = computed(() => {
  return cartItems.value.reduce((total, item) => total + item.num, 0);
});

// 定義城市和區域的資料
const cities = [
  {
    name: "台北市",
    districts: ["中正區", "大同區", "中山區", "松山區", "大安區", "萬華區", "信義區", "士林區", "北投區", "內湖區", "南港區", "文山區"]
  },
  {
    name: "新北市",
    districts: ["板橋區", "新莊區", "中和區", "永和區", "三峡區", "淡水區", "汐止區", "瑞芳區", "土城區", "三峰區", "新店區", "坪林區", "林口區", "蘆洲區", "五股區", "八里區", "深坑區", "三芝區", "石碇區", "高雄區", "板橋區", "瑞金區", "平溪區", "雙溪區", "貢寮區"]
  },
  {
    name: "桃園市",
    districts: ["桃園區", "中壢區", "大溪區", "楊梅區", "蘆竹區", "大園區", "龍潭區", "平鎮區", "八德區", "觀音區", "龜山區", "八德區"]
  },
  {
    name: "台中市",
    districts: ["中區", "東區", "南區", "西區", "北區", "北屯區", "西屯區", "南屯區", "太平區", "大里區", "霧峰區", "烏日區", "豐原區", "后里區", "石岡區", "東勢區", "和平區", "新社區", "潭子區", "大雅區", "神岡區", "大肚區", "沙鹿區", "龍井區", "梧棲區", "清水區", "大甲區", "外埔區", "大安區"]
  },
  {
    name: "台南市",
    districts: ["中西區", "東區", "南區", "北區", "安平區", "安南區", "永康區", "歸仁區", "新化區", "左鎮區", "玉井區", "楠西區", "南化區", "仁德區", "關廟區", "龍崎區", "官田區", "麻豆區", "佳里區", "西港區", "七股區", "將軍區", "學甲區", "北門區", "新營區", "後壁區", "白河區", "東山區", "六甲區", "下營區", "柳營區", "鹽水區", "善化區", "大內區", "新市區", "山上區", "安定區"]
  },
  {
    name: "高雄市",
    districts: ["鹽埕區", "鼓山區", "左營區", "楠梓區", "三民區", "新興區", "前金區", "苓雅區", "前鎮區", "旗津區", "小港區", "鳳山區", "林園區", "大寮區", "大樹區", "大社區", "仁武區", "鳥松區", "岡山區", "橋頭區", "燕巢區", "田寮區", "阿蓮區", "路竹區", "湖內區", "茄萣區", "永安區", "彌陀區", "梓官區", "旗山區", "美濃區", "六龜區", "甲仙區", "杉林區", "內門區", "茂林區", "桃源區", "那瑪夏區"]
  },
  {
    name: "基隆市",
    districts: ["中正區", "七堵區", "暖暖區", "仁愛區", "中山區", "安樂區", "信義區"]
  },
  {
    name: "新竹市",
    districts: ["東區", "北區", "香山區"]
  },
  {
    name: "嘉義市",
    districts: ["東區", "西區"]
  },
  {
    name: "新竹縣",
    districts: ["北區", "香山區", "竹北市", "湖口鄉", "新豐鄉", "芎林鄉", "關西鎮", "五峰鄉", "八里區", "橫山鄉", "峨眉鄉", "寶山鄉", "尖石鄉", "北埔鄉", "横山乡", "竹东镇"]
  },
  {
    name: "苗栗縣",
    districts: ["苗栗市", "苑裡鎮", "通霄鎮", "三義鄉", "卓蘭鎮", "竹南鎮", "大湖鄉", "南庄鄉", "大肚鄉", "頭份市", "獅潭鄉", "西湖鄉", "頭屋鄉", "公館鄉", "銅鑼鄉", "臺中市", "後龍鎮", "造橋鄉"]
  },
  {
    name: "彰化縣",
    districts: ["彰化市", "芬園鄉", "花壇鄉", "秀水鄉", "鹿港鎮", "福興鄉", "線西鄉", "和美鎮", "伸港鄉", "員林市", "社頭鄉", "永靖鄉", "埔心鄉", "溪湖鎮", "大村鄉", "埔鹽鄉", "田中鎮", "北斗鎮", "田尾鄉", "埤頭鄉", "溪州鄉", "竹塘鄉", "二林鎮", "大城鄉", "芳苑鄉", "二水鄉"]
  },
  {
    name: "南投縣",
    districts: ["南投市", "中寮鄉", "草屯鎮", "國姓鄉", "埔里鎮", "仁愛鄉", "名間鄉", "集集鎮", "水里鄉", "魚池鄉", "信義鄉", "竹山鎮", "鹿谷鄉"]
  },
  {
    name: "雲林縣",
    districts: ["斗六市", "斗南鎮", "虎尾鎮", "西螺鎮", "古坑鄉", "大埤鄉", "莿桐鄉", "二崙鄉", "崙背鄉", "麥寮鄉", "臺西鄉", "東勢鄉", "褒忠鄉", "朴子市", "太保市", "布袋鎮"]
  },
  {
    name: "嘉義縣",
    districts: ["嘉義市", "番路鄉", "梅山鄉", "竹崎鄉", "阿里山鄉", "中埔鄉", "大埔鄉", "水上鄉", "鹿草鄉", "太保市", "朴子市", "東石鄉", "六腳鄉", "新港鄉", "民雄鄉", "大林鎮", "溪口鄉", "義竹鄉", "布袋鎮"]
  },
  {
    name: "屏東縣",
    districts: ["屏東市", "三地門鄉", "霧台鄉", "瑪家鄉", "九如鄉", "里港鄉", "高樹鄉", "鹽埔鄉", "長治鄉", "麟洛鄉", "竹田鄉", "內埔鄉", "萬丹鄉", "潮州鎮", "泰武鄉", "來義鄉", "萬巒鄉", "崁頂鄉", "新埤鄉", "南州鄉", "林邊鄉", "東港鎮", "琉球鄉", "佳冬鄉", "新園鄉", "枋山鄉", "滿州鄉"]
  },
  {
    name: "宜蘭縣",
    districts: ["宜蘭市", "頭城鎮", "礁溪鄉", "壯圍鄉", "員山鄉", "羅東鎮", "三星鄉", "大同鄉", "五結鄉", "冬山鄉", "蘇澳鎮", "南澳鄉", "釣魚台"]
  },
  {
    name: "花蓮縣",
    districts: ["花蓮市", "新城鄉", "秀林鄉", "吉安鄉", "壽豐鄉", "鳳林鄉", "光復鄉", "豐濱鄉", "瑞穗鄉", "萬榮鄉", "玉里鎮", "卓溪鄉", "富里鄉"]
  },
  {
    name: "台東縣",
    districts: ["台東市", "綠島鄉", "蘭嶼鄉", "延平鄉", "卑南鄉", "鹿野鄉", "關山鎮", "海端鄉", "池上鄉", "東河鄉", "成功鄉", "長濱鄉", "太麻里鄉", "金峰鄉", "大武鄉", "達仁鄉"]
  },
  {
    name: "金門縣",
    districts: ["金城鎮", "金湖鎮", "金沙鎮", "金寧鄉", "烈嶼鄉", "烏坵鄉"]
  },
  {
    name: "連江縣",
    districts: ["南竿鄉", "北竿鄉", "莒光鄉", "東引鄉"]
  },

]

// 當前選擇的城市
const selectedCity = ref('');
const selectedDistrict = ref('');
const addressDetail = ref('');

// 根據選擇的城市，動態計算區域
const selectedDistricts = computed(() => {
  const city = cities.find(city => city.name === selectedCity.value)
  return city ? city.districts : []
})


const base_url = import.meta.env.VITE_AJAX_URL
const router = useRouter();


// 訂單相關資料
// 顧客資料
const customerInfo = ref({
  name: '',
  email: '',
  phone: '',
  gender: '',
});

// 送貨資料
const recipientInfo = ref({
  name: '',
  email: '',
  phone: '',
  address: '',
});
// 使用 `watch` 監聽這三個欄位的變化，並更新 `recipientInfo.address`
watch([selectedCity, selectedDistrict], ([city, district]) => {
  // 只有在 `recipientInfo.address` 還沒被使用者修改時，才更新它
  if (!recipientInfo.value.address || recipientInfo.value.address.trim() === '' ||
      recipientInfo.value.address.startsWith(selectedCity.value) ||
      recipientInfo.value.address.startsWith(selectedDistrict.value)) {
    recipientInfo.value.address = `${city}${district}${recipientInfo.value.address.replace(/^[\u4e00-\u9fa5]+\s*[\u4e00-\u9fa5]*\s*/, '')}`.trim();
  }
});


const orderDetails = ref({
  deliveryMethod: '新竹物流宅配',
  paymentMethod: 'Line Pay', // 預設選擇 Line Pay
  invoiceType: '雲端發票',
});


const orderNotes = ref(""); // 訂單備註

// 信用卡資料
const paymentInfo = ref({
  cardNumber: "", // 信用卡卡號
  cardHolder: "", // 持卡人姓名
  expirationDate: "", // 有效期限 MM/YY
  securityCode: "" // 安全碼 CVV
});




// **格式化卡號，讓它顯示 `xxxx-xxxx-xxxx-xxxx`**
const formatCardNumber = (event) => {
  let rawValue = event.target.value.replace(/\D/g, ''); // 移除所有非數字
  rawValue = rawValue.slice(0, 16); // 限制最多 16 碼

  // **格式化成 xxxx-xxxx-xxxx-xxxx**
  let formattedValue = rawValue.replace(/(\d{4})(?=\d)/g, '$1-');

  paymentInfo.value.cardNumber = formattedValue;
};

// 格式化 有效期限
const formatExpirationDate = (event) => {
  let value = event.target.value.replace(/\D/g, ''); // 移除非數字
  if (value.length > 4) value = value.slice(0, 4); // 限制最多 4 碼

  if (value.length >= 2) {
    let month = value.slice(0, 2);

    // **如果輸入的月份大於 12，自動改成 12**
    if (parseInt(month, 10) > 12) {
      month = '12';
    } else if (parseInt(month, 10) === 0) {
      month = '01'; // 防止 `00`
    }

    value = month + '/' + value.slice(2);
  }

  paymentInfo.value.expirationDate = value;
};

// 格式化 安全碼
const formatSecurityCode = (event) => {
  let value = event.target.value.replace(/\D/g, ''); // 只允許數字
  paymentInfo.value.securityCode = value.slice(0, 4); // 限制最多 4 碼
};



// 初始化錯誤表單
const errors = ref({
  customerInfo: {
    name: '',
    email: '',
    phone: '',
    gender: ''
  },
  recipientInfo: {
    name: '',
    email: '',
    phone: '',
    address: ''
  },
  addressInfo: {
    selectedCity: '',
    selectedDistrict: '',
    addressDetail: ''
  },
  paymentInfo: {
    cardNumber: '',
    cardHolder: '',
    expirationDate: '',
    securityCode: ''
  }
});

// 驗證表單
const validateForm = () => {
  let hasError = false;

  // 確保 `errors` 內的結構存在
  if (!errors.value.customerInfo) errors.value.customerInfo = {};
  if (!errors.value.recipientInfo) errors.value.recipientInfo = {};
  if (!errors.value.paymentInfo) errors.value.paymentInfo = {};
  if (!errors.value.addressInfo) errors.value.addressInfo = {};

  // 移除 `-` 符號後驗證
  let rawCardNumber = paymentInfo.value.cardNumber.replace(/-/g, '');
  let expDate = paymentInfo.value.expirationDate.trim();
  let cvv = paymentInfo.value.securityCode.trim();

  // 驗證顧客名稱
  if (!customerInfo.value.name || !customerInfo.value.name.trim()) {
    errors.value.customerInfo.name = '顧客名稱為必填';
    hasError = true;
  } else if (customerInfo.value.name.trim().length < 2) {
    errors.value.customerInfo.name = '顧客名稱至少 2 個字';
    hasError = true;
  } else {
    errors.value.customerInfo.name = ''; // 清除錯誤訊息
  }

  // 驗證顧客電子信箱
  if (!customerInfo.value.email || !customerInfo.value.email.trim()) {
    errors.value.customerInfo.email = '電子信箱為必填';
    hasError = true;
  } else if (!/^\S+@\S+\.\S+$/.test(customerInfo.value.email.trim())) {
    errors.value.customerInfo.email = '請輸入有效的電子信箱格式';
    hasError = true;
  } else {
    errors.value.customerInfo.email = ''; // 清除錯誤訊息
  }

  // 處理 `phone` 內部 `ref()`
  const phoneValue = customerInfo.value.phone || ''; // 取 `ref` 內的值
  if (!phoneValue.trim()) {
    errors.value.customerInfo.phone = '電話號碼為必填';
    hasError = true;
  } else if (!/^\d{9,}$/.test(phoneValue.trim())) {
    errors.value.customerInfo.phone = '請輸入有效的電話號碼（至少 9 碼數字）';
    hasError = true;
  } else {
    errors.value.customerInfo.phone = ''; // 清除錯誤訊息
  }

  // 驗證收件人姓名
  if (!recipientInfo.value.name || !recipientInfo.value.name.trim()) {
    errors.value.recipientInfo.name = '收件人姓名為必填';
    hasError = true;
  } else {
    errors.value.recipientInfo.name = ''; // 清除錯誤訊息
  }

  // 驗證收件人電子信箱
  if (!recipientInfo.value.email || !recipientInfo.value.email.trim()) {
    errors.value.recipientInfo.email = '電子信箱為必填';
    hasError = true;
  } else if (!/^\S+@\S+\.\S+$/.test(recipientInfo.value.email.trim())) {
    errors.value.recipientInfo.email = '請輸入有效的電子信箱格式';
    hasError = true;
  } else {
    errors.value.recipientInfo.email = ''; // 清除錯誤訊息
  }

  // 驗證收件人電話號碼
  if (!recipientInfo.value.phone || !recipientInfo.value.phone.trim()) {
    errors.value.recipientInfo.phone = '電話號碼為必填';
    hasError = true;
  } else if (!/^\d{9,}$/.test(recipientInfo.value.phone.trim())) {
    errors.value.recipientInfo.phone = '請輸入有效的電話號碼（至少 9 碼數字）';
    hasError = true;
  } else {
    errors.value.recipientInfo.phone = ''; // 清除錯誤訊息
  }

  // 收件人地址驗證
   if (!selectedCity.value) {
    errors.value.addressInfo.selectedCity = '請選擇城市';
    hasError = true;
  } else {
    errors.value.addressInfo.selectedCity = ''; // 清除錯誤訊息
  }

  if (!selectedDistrict.value) {
    errors.value.addressInfo.selectedDistrict = '請選擇區域';
    hasError = true;
  } else {
    errors.value.addressInfo.selectedDistrict = ''; // 清除錯誤訊息
  }

  // 確保 `recipientInfo.address` 先被更新，避免舊數據觸發錯誤
  recipientInfo.value.address = `${selectedCity.value}${selectedDistrict.value}${recipientInfo.value.address}`.trim();

  if (!recipientInfo.value.address.trim()) {
    errors.value.addressInfo.addressDetail = '請輸入詳細地址';
    hasError = true;
  } else if (!/^[\u4e00-\u9fa5a-zA-Z0-9\s\-,.]{5,}$/.test(recipientInfo.value.address.trim())) {
    errors.value.addressInfo.addressDetail = '地址格式錯誤，至少 5 個字，僅允許中文、英文、數字及部分符號';
    hasError = true;
  } else {
    errors.value.addressInfo.addressDetail = ''; // 清除錯誤訊息
  }



  // 信用卡卡號驗證（16 碼數字）
  if (!rawCardNumber.trim()) {
    errors.value.paymentInfo.cardNumber = '請輸入信用卡號';
    hasError = true;
  } else if (!/^\d{16}$/.test(rawCardNumber)) {
    errors.value.paymentInfo.cardNumber = '信用卡號須為 16 碼數字';
    hasError = true;
  } else {
    errors.value.paymentInfo.cardNumber = ''; // 清除錯誤訊息
  }


  // 持卡人姓名驗證（至少 2 個字，僅允許英文字母與空格）
  if (!paymentInfo.value.cardHolder.trim()) {
    errors.value.paymentInfo.cardHolder = '持卡人姓名為必填';
    hasError = true;
  } else if (!/^[A-Za-z\s]{2,}$/.test(paymentInfo.value.cardHolder.trim())) {
    errors.value.paymentInfo.cardHolder = '請輸入有效的持卡人姓名（僅允許英文字母與空格）';
    hasError = true;
  } else {
    errors.value.paymentInfo.cardHolder = ''; // 清除錯誤訊息
  }

  // 有效期限驗證（格式 MM/YY，且需為未來日期）
  if (!expDate) {
    errors.value.paymentInfo.expirationDate = '請輸入有效期限';
    hasError = true;
  } else if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expDate)) {
    errors.value.paymentInfo.expirationDate = '請輸入有效的 MM/YY 格式 (01/25)';
    hasError = true;
  } else {
    let [month, year] = expDate.split('/').map(Number);
    let currentYear = new Date().getFullYear() % 100; // 取兩位數年份
    let currentMonth = new Date().getMonth() + 1;

    if (year < currentYear || (year === currentYear && month < currentMonth)) {
      errors.value.paymentInfo.expirationDate = '有效期限需為未來日期';
      hasError = true;
    } else {
      errors.value.paymentInfo.expirationDate = ''; // 清除錯誤訊息
    }
  }

  // 安全碼驗證（3-4 碼數字）
  if (!cvv) {
    errors.value.paymentInfo.securityCode = '請輸入安全碼 (CVV)';
    hasError = true;
  } else if (!/^\d{3,4}$/.test(cvv)) {
    errors.value.paymentInfo.securityCode = '安全碼須為 3 或 4 碼數字';
    hasError = true;
  } else {
    errors.value.paymentInfo.securityCode = ''; // 清除錯誤訊息
  }


  return !hasError; // 若 `hasError = false`，則表示表單驗證成功
};


// 是否勾選「收件人資料與顧客資料相同」
const isSameAsCustomer = ref(false);

// 監聽 checkbox 狀態變化
watch(isSameAsCustomer, (newValue) => {
  if (newValue) {
    // 當勾選時，將顧客資料複製到收件人欄位（只複製有填寫的欄位）
    recipientInfo.value.name = customerInfo.value.name || recipientInfo.value.name;
    recipientInfo.value.email = customerInfo.value.email || recipientInfo.value.email;
    recipientInfo.value.phone = customerInfo.value.phone || recipientInfo.value.phone;
  } else {
    // 取消勾選時，清空收件人欄位
    recipientInfo.value.name = '';
    recipientInfo.value.email = '';
    recipientInfo.value.phone = '';
  }
});













// 提交訂單
const submitOrder = async () => {

  if (!validateForm()) {
    alert("請填寫相關資料！");
    return;
  }
  // 檢查使用者是否填寫完整資訊
  // if (!customerInfo.value.name || !customerInfo.value.email || !customerInfo.value.phone ||
  //     !recipientInfo.value.name || !recipientInfo.value.email || !recipientInfo.value.phone || !recipientInfo.value.address) {
  //   alert("⚠️ 請填寫完整的訂單資訊！");
  //   return;
  // }

  // if (cartItems.value.length === 0) {
  //   alert("⚠️ 購物車內沒有商品，無法提交訂單！");
  //   return;
  // }

  // **準備訂單資料**
  const orderData = {
    customer: customerInfo.value, // 顧客資訊
    recipient: recipientInfo.value, // 收件人資訊
    orderDetails: orderDetails.value, // 訂單細節
    items: cartItems.value, // 購物車商品
    total: total.value, // 總金額
    usePoints: usePoints.value, // 使用點數
    orderNotes: orderNotes.value,   // 訂單備註
    paymentInfo: paymentInfo.value, // 付款資訊
  };


  try {
    console.log("📡 發送 API 請求123:", orderData);
    const response = await fetch(`${base_url}/submitOrder.php`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(orderData),
    });

    const result = await response.json();
    console.log("✅ 訂單提交成功456:", result);

    // const text = await response.text();
    // console.log("📥 後端返回資料:", text);
    // const result = JSON.parse(text); // **嘗試解析 JSON**
    // console.log("✅ 訂單提交成功:", result);

    if (!result.success) {
      throw new Error(result.message || "訂單提交失敗");
    }

    if (result.success) {
      alert("✅ 訂單提交成功，將跳轉至付款頁面！");
      // 跳轉到付款頁面 (Line Pay / 綠界)
      // window.location.href = `${base_url}/ecpay_payment.php?Order_ID=${result.Order_ID}`;

      // 清除 localStorage
      localStorage.removeItem("cart");
      localStorage.removeItem("usePoints");

      router.push("/shop_finish");

    } else {
      alert(`❌ 訂單提交失敗：${result.message}`);
    }
  } catch (error) {
    console.error("❌ 訂單提交錯誤:", error);
    alert("❌ 伺服器錯誤，請稍後再試！");
  }
};

</script>
