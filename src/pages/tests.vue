<template>
  <MainHeader></MainHeader>
  <div class="si_container_R">
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
          <h2>合計:NT$600</h2>
          <!-- 點擊 p.toggle-details 切換明細顯示/隱藏 -->
          <p class="toggle-details" @click="toggleDetails">
            購物車(1件)
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

            <div class="si_orderbottom2_R">
              <div class="middle_item1">
                <a href="#">
                  <img :src="'/tid103/g1/images/Sp13.jpg'" style="width: 50px" />
                  <label>環保筷子</label>
                </a>
              </div>
              <div class="middle_item2">暫定優惠</div>
              <div class="middle_item3">NT$500</div>
              <div class="middle_item4">1</div>
              <div class="middle_item5">NT$500</div>
            </div>

            <div class="si_orderbottom3_R">
              <div class="bottom3_1">
                <span class="pull-left">小計:</span>
                <span class="pull-right">NT$500</span>
              </div>
              <div class="bottom3_2">
                <span class="pull-left">運費:</span>
                <span class="pull-right">NT$80</span>
              </div>
              <div class="bottom3_3">
                <span class="pull-left">合計:</span>
                <span class="pull-right">NT$580</span>
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
          <section class="Si_customerinfo_R">
            <div class="Si_customerinfo_header">顧客資料</div>
            <div class="Si_customerinfo_body">
              <label for="customerName">顧客名稱</label>
              <input type="text" class="input" v-model="customerName" />
              <p v-if="errors.customerName" class="error">{{ errors.customerName }}</p>

              <label for="email">電子信箱</label>
              <input type="email" class="input" v-model="email" />
              <p v-if="errors.email" class="error">{{ errors.email }}</p>

              <label for="">電話號碼</label>
              <div class="si_phonenumber_R">
                <div class="si_leftphone_R">
                  <select v-model="countryCode">
                    <option value="TW+886">TW+886</option>
                  </select>
                </div>
                <div class="si_rightphone_R">
                  <input type="text" class="input" v-model="phoneNumber" />
                </div>
              </div>
              <p v-if="errors.phoneNumber" class="error">{{ errors.phoneNumber }}</p>

              <label for="gender">性別(選填)</label>
              <select id="gender" v-model="gender">
                <option value="">請選擇</option>
                <option value="男">男</option>
                <option value="女">女</option>
              </select>

              <!-- <button @click="submitForm">提交</button> -->
            </div>
          </section>
          <!-- 送貨資料 -->
          <section class="Si_deliveryinfo_R">
            <div class="Si_deliveryinfo_header">送貨資料</div>
            <div class="Si_deliveryinfo_body">
              <p>已選擇的送貨方式：新竹物流宅配 / 信用卡付款</p>
              <label class="si_checkbox">
                <input id="si_check" type="checkbox" v-model="isSameAsCustomer" />
                收件人資料與顧客資料相同
              </label>
              <label for="recipientName">收件人姓名</label>
              <input type="text" class="input" v-model="recipientName" :disabled="isSameAsCustomer" />
              <p v-if="errors.recipientName" class="error">{{ errors.recipientName }}</p>

              <label for="recipientEmail">電子信箱</label>
              <input type="email" class="input" v-model="recipientEmail" :disabled="isSameAsCustomer" />
              <p v-if="errors.recipientEmail" class="error">{{ errors.recipientEmail }}</p>

              <label for="recipientPhone">電話號碼</label>
              <div class="si_phonenumber_R">
                <div class="si_leftphone_R">
                  <select v-model="recipientCountryCode" :disabled="isSameAsCustomer">
                    <option value="TW+886">TW+886</option>
                  </select>
                </div>
                <div class="si_rightphone_R">
                  <input type="text" class="input" v-model="recipientPhone" :disabled="isSameAsCustomer" />
                </div>
              </div>
              <p v-if="errors.recipientPhone" class="error">{{ errors.recipientPhone }}</p>

              <div id="app">
                <div class="si_address">
                  <label for="">地址</label>
                  <p>送貨地點:台灣</p>
                  <div class="si_aselect">
                    <!-- 城市選擇 -->
                    <select v-model="selectedCity">
                      <option v-for="city in cities" :value="city.name" :key="city.name">
                        {{ city.name }}
                      </option>
                    </select>
                    <p v-if="errors.selectedCity" class="error">{{ errors.selectedCity }}</p>

                    <!-- 區域選擇 -->
                    <select v-model="selectedDistrict">
                      <option value="">請選擇區域</option>
                      <option v-for="district in selectedDistricts" :value="district" :key="district">
                        {{ district }}
                      </option>
                    </select>
                    <p v-if="errors.selectedDistrict" class="error">{{ errors.selectedDistrict }}</p>
                  </div>
                  <div class="address2">
                    <input type="text" placeholder="詳細地址" class="input" v-model="addressDetail" />
                    <p v-if="errors.addressDetail" class="error">{{ errors.addressDetail }}</p>
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
              <textarea id="" placeholder="有甚麼想告訴賣家嗎?"></textarea>
            </div>
          </section>
          <!-- 付款資料 -->
          <section class="Si-payment-R">
            <div class="si_payment_header">付款資料</div>
            <div class="si_payment_body">
              <input type="text" v-model="cardNumber" placeholder="卡號" class="input" />
              <p v-if="errors.cardNumber" class="error">{{ errors.cardNumber }}</p>

              <input type="text" v-model="cardHolder" placeholder="持卡人姓名" class="input" />
              <p v-if="errors.cardHolder" class="error">{{ errors.cardHolder }}</p>


              <input type="text" v-model="expirationDate" placeholder="有效期限(MM/YY)" class="input" />
              <p v-if="errors.expirationDate" class="error">{{ errors.expirationDate }}</p>

              <input type="text" v-model="securityCode" placeholder="安全碼" class="input" />
              <p v-if="errors.securityCode" class="error">{{ errors.securityCode }}</p>

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
                <select id="" name="">
                  <option value="捐贈發票/雲端發票">捐贈發票/雲端發票</option>
                </select>
                <label for="">載具類型</label>
                <select id="" name="">
                  <option value="">個人載具</option>
                </select>
              </div>
            </section>
            <!-- <RouterLink to="/shop_finish" class="si_submit_R btn" >提交訂單</RouterLink> -->
            <button @click="handleSubmit" class="si_submit_R btn">提交訂單與付款</button>
          </div>
        </div>
      </div>
    </div>
    <MainFooter></MainFooter>
  </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import { useRouter } from 'vue-router'
import MainFooter from '@/components/layout/MainFooter.vue';
import MainHeader from '@/components/layout/MainHeader.vue';

// -- 加入「展開/收合」邏輯 --
// const isOpen = ref(false)
// function toggleDetails() {
//   isOpen.value = !isOpen.value
// }
// const router = useRouter();

// 定義表單資料
const customerName = ref('');
const email = ref('');
const phoneNumber = ref('');
const countryCode = ref('TW+886'); // 預設國碼
const gender = ref('');


// 收件人資料
const recipientName = ref('');
const recipientEmail = ref('');
const recipientPhone = ref('');
const recipientCountryCode = ref('TW+886');

// 地址資料
const selectedCity = ref('');
const selectedDistrict = ref('');
const addressDetail = ref('');
  // 定義城市和區域的資料
const cities = ref([
    // {
    //   name: '台北市',
    //   districts: ['大安區', '信義區', '中正區', '中山區']
    // },
    // {
    //   name: '新北市',
    //   districts: ['板橋區', '中和區', '永和區', '新店區']
    // },
    // {
    //   name: '台中市',
    //   districts: ['西屯區', '北屯區', '南屯區', '中區']
    // }
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

  ]);

  // 根據選擇的城市取得對應區域
  const selectedDistricts = computed(() => {
    const city = cities.value.find(c => c.name === selectedCity.value);
    return city ? city.districts : [];
  });

  // 付款資料
  const cardNumber = ref('');
  const cardHolder = ref('');
  const expirationDate = ref('');
  const securityCode = ref('');

  const errors = ref({});

  // 驗證表單
  const validateForm = () => {
    errors.value = {};

    // 驗證顧客名稱
    if (!customerName.value.trim()) {
      errors.value.customerName = '顧客名稱為必填';
    } else if (customerName.value.trim().length < 2) {
      errors.value.customerName = '顧客名稱至少 2 個字';
    }

    // 驗證電子郵件
    if (!email.value.trim()) {
      errors.value.email = '電子信箱為必填';
    } else if (!/^\S+@\S+\.\S+$/.test(email.value.trim())) {
      errors.value.email = '請輸入有效的電子郵件';
    }

    // 驗證電話號碼
    if (!phoneNumber.value.trim()) {
      errors.value.phoneNumber = '電話號碼為必填';
    } else if (!/^\d{9,}$/.test(phoneNumber.value.trim())) {
      errors.value.phoneNumber = '請輸入有效的電話號碼（至少 9 碼數字）';
    }

    // 收件人姓名驗證
    if (!recipientName.value.trim()) {
        errors.value.recipientName = '收件人姓名為必填';
      }else if (recipientName.value.trim().length < 2) {
        errors.value.recipientName = '顧客名稱至少 2 個字';
      }

    // 收件人電子郵件驗證
    if (!recipientEmail.value.trim()) {
      errors.value.recipientEmail = '收件人電子信箱為必填';
    } else if (!/^\S+@\S+\.\S+$/.test(recipientEmail.value.trim())) {
      errors.value.recipientEmail = '請輸入有效的電子郵件';
    }

    // 收件人電話號碼驗證
    if (!recipientPhone.value.trim()) {
      errors.value.recipientPhone = '收件人電話號碼為必填';
    } else if (!/^\d{9,}$/.test(recipientPhone.value.trim())) {
      errors.value.recipientPhone = '請輸入有效的電話號碼（至少 9 碼數字）';
    }

        // 地址驗證
      if (!selectedCity.value) {
        errors.value.selectedCity = '請選擇城市';
      }
      if (!selectedDistrict.value) {
        errors.value.selectedDistrict = '請選擇區域';
      }
      if (!addressDetail.value.trim()) {
        errors.value.addressDetail = '請輸入詳細地址';
      }else if (!/^[\u4e00-\u9fa5a-zA-Z0-9\s\-,.]{5,}$/.test(addressDetail.value.trim())) {
      errors.value.addressDetail = '地址格式錯誤，至少 5 個字，僅允許中文、英文、數字及部分符號';
      }
      console.log(errors.value);
    // 回傳是否通過驗證
    return Object.keys(errors.value).length === 0;
  };

// 是否勾選「收件人資料與顧客資料相同」
const isSameAsCustomer = ref(false);

// 監聽 checkbox 狀態變化
watch(isSameAsCustomer, (newValue) => {
  if (newValue) {
    // 當勾選時，將顧客資料複製到收件人欄位
    recipientName.value = customerName.value;
    recipientEmail.value = email.value;
    recipientPhone.value = phoneNumber.value;
    recipientCountryCode.value = countryCode.value;
  } else {
    // 取消勾選時，清空收件人欄位
    recipientName.value = '';
    recipientEmail.value = '';
    recipientPhone.value = '';
    recipientCountryCode.value = 'TW+886';
  }
});
  // 驗證付款資訊
  const validatePayment = () => {


      // 信用卡卡號驗證（16 碼數字）
      if (!cardNumber.value.trim()) {
        errors.value.cardNumber = '卡號為必填';
      } else if (!/^\d{16}$/.test(cardNumber.value.trim())) {
        errors.value.cardNumber = '請輸入 16 碼有效的信用卡號';
      }

      // 持卡人姓名驗證（至少 2 個字，僅允許英文字母與空格）
      if (!cardHolder.value.trim()) {
        errors.value.cardHolder = '持卡人姓名為必填';
      } else if (!/^[A-Za-z\s]{2,}$/.test(cardHolder.value.trim())) {
        errors.value.cardHolder = '請輸入有效的持卡人姓名（僅允許英文字母與空格）';
      }

      // 有效期限驗證（格式 MM/YY，且需為未來日期）
      if (!expirationDate.value.trim()) {
        errors.value.expirationDate = '有效期限為必填';
      } else if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expirationDate.value.trim())) {
        errors.value.expirationDate = '請輸入正確的有效期限格式（MM/YY）';
      } else {
        const [month, year] = expirationDate.value.split('/').map(Number);
        const currentYear = new Date().getFullYear() % 100; // 取兩位數年份
        const currentMonth = new Date().getMonth() + 1;

      if (year < currentYear || (year === currentYear && month < currentMonth)) {
        errors.value.expirationDate = '有效期限需為未來日期';
      }
    }

    // 安全碼驗證（3-4 碼數字）
    if (!securityCode.value.trim()) {
      errors.value.securityCode = '安全碼為必填';
    } else if (!/^\d{3,4}$/.test(securityCode.value.trim())) {
      errors.value.securityCode = '請輸入 3 或 4 碼數字的安全碼';
    }
    console.log(errors.value);
    return Object.keys(errors.value).length === 0;
  };
  // 假設已經有 `submitForm` 和 `submitPayment`
  const submitForm = () => {
        // errors.value = {}; // 清空錯誤訊息
          if (validateForm()) {
          return true; // 訂單資訊正確
        } else {
          alert('🌏 請檢查訂單資料是否正確！');
          return false; // 訂單有錯誤
        }
    };

    // 假設這是付款資訊驗證
  const submitPayment = () => {
      // errors.value = {}; // 清空錯誤訊息
      if (validatePayment()) {
      return true; // 付款資訊正確
    } else {
      alert('🌏 請檢查付款資料是否完整！');
      return false; // 付款資料有錯誤
    }
  };

  // **綜合提交方法**
  const handleSubmit = () => {
      const formValid = validateForm();
      const paymentValid = validatePayment();
      console.log(errors.value);
      if (formValid && paymentValid) {
      alert('☘️ 訂單與付款成功！');
      router.push('/shop_finish'); // 成功後導向訂單完成頁面
      } else {
      alert('🌏 請修正錯誤後再提交');
      }
    };
//   // 提交付款資料
//   const submitPayment = () => {
//       if (validatePayment()) {
//         alert('付款資料驗證成功！');
//         router.push('/shop_finish'); // 驗證成功後跳轉
//       } else {
//         alert('請修正付款資料錯誤');
//       }
//   };


// // 提交表單
// const submitForm = () => {
//   if (validateForm()) {
//     alert('表單提交成功！');


//      // 跳轉至訂單完成頁面
//      router.push('/shop_finish');
//   } else {
//     alert('請修正表單錯誤');
//   }
// };


</script>
