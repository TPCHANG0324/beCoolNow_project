<template>
  <MainHeader></MainHeader>
  <div class="si_container_R">
    <div class="si_content_R">
      <nav class="breadcrumb">
        <div class="si_bread_r">
          <a href="#">首頁</a>
          <p>/</p>
          <a href="#">購物車</a>
        </div>
        <!-- 流程顯示 -->
        <div class="Sp-checkout-nav-X">
          <!-- 每一個圓圈 -->
          <div class="Sp-step-X active">
            <span class="Sp-badge-X">
              <div class="Sp-badge-text-X">1</div>
            </span>
            <span>購物車</span>
          </div>

          <div class="Sp-step-X">
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
      </nav>
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
                  <img src="../assets/images/Sp13.jpg" style="width: 50px" />
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
              <label for="">顧客名稱</label>
              <input type="text" class="input" />
              <label for="">電子信箱</label>
              <input type="email" class="input" />
              <label for="">電話號碼</label>
              <div class="si_phonenumber_R">
                <div class="si_leftphone_R">
                  <select id="" name="">
                    <option value="TW+886">TW+886</option>
                  </select>
                </div>
                <div class="si_rightphone_R">
                  <input type="text" class="input" />
                </div>
              </div>
              <label for="">性別(選填)</label>
              <select id="sex_R" name="">
                <option value="男">男</option>
                <option value="女">女</option>
              </select>
            </div>
          </section>
          <!-- 送貨資料 -->
          <section class="Si_deliveryinfo_R">
            <div class="Si_deliveryinfo_header">送貨資料</div>
            <div class="Si_deliveryinfo_body">
              <p>已選擇的送貨方式：新竹物流宅配 / 信用卡付款</p>
              <label class="si_checkbox">
                <input id="si_check" type="checkbox" />
                收件人資料與顧客資料相同
              </label>
              <label for="">收件人姓名</label>
              <input type="text" class="input" />
              <label for="">電子信箱</label>
              <input type="email" class="input" />
              <label for="">電話號碼</label>
              <div class="si_phonenumber_R">
                <div class="si_leftphone_R">
                  <select id="" name="">
                    <option value="TW+886">TW+886</option>
                  </select>
                </div>
                <div class="si_rightphone_R">
                  <input type="text" class="input" />
                </div>
              </div>
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
                    <!-- 區域選擇 -->
                    <select>
                      <option v-for="district in selectedDistricts" :value="district" :key="district">
                        {{ district }}
                      </option>
                    </select>
                  </div>
                  <div class="address2">
                    <input type="text" placeholder="地址" class="input" />
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
              <input type="text" placeholder="卡號" class="input" required />
              <input type="text" placeholder="持卡人姓名" class="input" required />
              <input type="text" placeholder="有效期限(MM/YY)" class="input" required />
              <input type="text" placeholder="安全碼" class="input" required />
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
            <RouterLink to="/shop_finish" class="si_submit_R btn">提交訂單</RouterLink>
          </div>
        </div>
      </div>
    </div>
    <MainFooter></MainFooter>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { RouterLink } from 'vue-router'

// -- 加入「展開/收合」邏輯 --
const isOpen = ref(false)
function toggleDetails() {
  isOpen.value = !isOpen.value
}

// 定義城市和區域的資料
const cities = [
  {
    name: '台北市',
    districts: ['大安區', '信義區', '中正區', '中山區']
  },
  {
    name: '新北市',
    districts: ['板橋區', '中和區', '永和區', '新店區']
  },
  {
    name: '台中市',
    districts: ['西屯區', '北屯區', '南屯區', '中區']
  }
]

// 當前選擇的城市
const selectedCity = ref('台北市')

// 根據選擇的城市，動態計算區域
const selectedDistricts = computed(() => {
  const city = cities.find(city => city.name === selectedCity.value)
  return city ? city.districts : []
})
</script>
