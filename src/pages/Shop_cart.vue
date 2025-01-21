<template>
  <main>
    <MainHeader />
    <!-- 環保市集 - 購物車，縮寫Sp - 功能 - 代號X -->
    <div class="Sp-X">
      <div class="Sp-wrapper-X">
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
        <!-- 購物車 -->
        <section class="Sp-shopping-cart-X">
          <!-- 表頭 -->
          <div class="Sp-section-header">購物車</div>
          <!-- 項目名稱 + 內容 -->
          <div class="Sp-cart-items-wrapper-X">
            <div class="Sp-table-header-X">
              <div>商品資料</div>
              <div>規格</div>
              <div>單件價格</div>
              <div>數量</div>
              <div>小計</div>
              <div></div>
            </div>

            <div v-for="(buy, index) in buys" :key="buy.id" class="Sp-cart-item-X">
              <div class="Sp-cart-item-info-X">
                <a href="#" target="_blank" :style="{ backgroundImage: `url(${buy.image})` }"></a>
                <span>{{ buy.name }} </span>
              </div>
              <div>{{ buy.size }}</div>
              <div>NT$ {{ buy.price }}</div>
              <div>
                <form action="">
                  <div class="Sp-cart-input-group-X">
                    <span @click="minusItem(index)"><i class="bi bi-dash"></i></span>
                    <input v-model="buy.num" type="number" step="1" min="0" @input="reviseItem(index, buy.num)" />
                    <span @click="addItem(index)"><i class="bi bi-plus"></i></span>
                  </div>
                </form>
              </div>
              <div>NT$ {{ buy.price * buy.num }}</div>
              <div @click="deleteItem"><i class="bi bi-trash3-fill"></i></div>
            </div>
          </div>
        </section>
        <!-- 精選商品 -->
        <section class="Sp-shopping-cart-addon-X">
          <!-- 表頭 -->
          <div class="Sp-section-header">精選商品</div>
          <!-- 項目內容 -->
          <div class="Sp-cart-addon-wrapper-X">
            <div v-for="(item, index) in items" :key="item.id" class="Sp-cart-addon-item-X">
              <a href="#" target="_blank" class="Sp-cart-addon-item-img">
                <img :src="item.image" alt="" />
              </a>
              <div class="Sp-cart-addon-item-content">
                <div class="Sp-cart-addon-item-info">
                  <p>{{ item.name }}</p>
                  <span>NT$ {{ item.price }}</span>
                </div>
                <button @click="addToCart(index)">加入購物車</button>
              </div>
            </div>
          </div>
        </section>
        <!-- 訂單：選擇付款方式 + 訂單資訊  -->
        <section class="Sp-shopping-info-X">
          <!-- 選擇付款方式 -->
          <section class="Sp-order-form-X">
            <div class="Sp-order-form-header">選擇送貨及付款方式</div>
            <div class="Sp-order-form-body">
              <label for="">送貨方式</label>
              <select id="" name="">
                <option value="新竹物流宅配">新竹物流宅配</option>
                <option value="台灣離島郵寄">台灣離島郵寄</option>
              </select>
              <label for="">付款方式</label>
              <select id="" name="">
                <option value="信用卡 (Visa/Master/JCB)">信用卡 (Visa/Master/JCB)</option>
                <option value="Line Pay">Line Pay</option>
              </select>
            </div>
          </section>
          <!-- 訂單資訊 -->
          <section class="Sp-order-summary-X">
            <div class="Sp-order-summary-header">訂單資訊</div>
            <div class="Sp-order-summary-body">
              <div class="Sp-order-summary-body-subtotal">
                <span>小計：</span>
                <span>NT$ {{ substotal }}</span>
              </div>
              <div class="Sp-order-summary-body-delivery">
                <span>運費：</span>
                <span>NT$ 100</span>
              </div>
              <div class="Sp-order-summary-body-points">
                <span>目前可用點數：</span>
                <!-- <span>250</span> -->
                <span>{{ points }}</span>
              </div>
              <div class="Sp-order-summary-body-coupon">
                <label for="">本次使用點數：</label>
                <form action="">
                  <span @click="minusPoints"><i class="bi bi-dash"></i></span>
                  <input type="number" :value="usePoints" step="100" min="0" />
                  <span @click="addPoints"><i class="bi bi-plus"></i></span>
                </form>
              </div>
              <div class="Sp-order-summary-body-discount">
                <span>折抵金額：</span>
                <span>- NT$ {{ discount }}</span>
              </div>
              <hr />
              <div class="Sp-order-summary-body-amount">
                <span>合計：</span>
                <span>NT$ {{ total }}</span>
              </div>
              <RouterLink to="/shop_checkout" class="Sp-checkout-Btn">前往結帳</RouterLink>
            </div>
          </section>
        </section>
        <!-- 出貨提醒 -->
        <section class="Sp-shopping-reminder-X">
          <div class="Sp-shopping-reminder-header">出貨提醒</div>
          <div class="Sp-shopping-reminder-body">
            感謝您支持我們的環保商品！以下是您的訂單與出貨注意事項： 📦 出貨時間：
            涼城即時環保市集皆為客製化生產，製作期需2-3週。
            訂單成立後，我們將立即安排生產。若提前完成品檢，我們會儘速出貨。
            若您選購了其他現貨商品，建議您與預購商品分開結帳，以便現貨能提前寄出。 📬 取貨注意事項：
            若您選擇便利商店取貨，請確保「收件人姓名」與身分證一致，以免影響取件流程。 🔍 尺寸與材質說明：
            杯子容量：350ml / 500ml / 750ml 材質：100%再生寶特瓶纖維 (rPET) + 天然纖維 耐熱程度：80°C（請避免直接加熱）
            ❗ 特殊說明： 再生環保馬克杯為特殊客製化商品，非商品瑕疵，恕不接受退換貨。
            若您有尺寸或其他需求疑慮，請於下單前確認商品規格。 如需重新訂製，需再等待2-3週生產期。 💳 付款方式：
            本店支援 LINE Pay 結帳，歡迎使用！ 如有任何問題，歡迎隨時與我們聯繫！🌱
            選擇再生材質，與我們一起為地球減少負擔。
          </div>
          <div class="Sp-shopping-reminder-body">
            <p>感謝您支持我們的環保商品！以下是您的訂單與出貨注意事項：</p>
            <p>📦 出貨時間：</p>
            <p>涼城即時環保市集皆為客製化生產，製作期需2-3週。</p>
            <p>訂單成立後，我們將立即安排生產。若提前完成品檢，我們會儘速出貨。</p>
            <p>若您選購了其他現貨商品，建議您與預購商品分開結帳，以便現貨能提前寄出。</p>
            <p>📬 取貨注意事項：</p>
            <p>若您選擇便利商店取貨，請確保「收件人姓名」與身分證一致，以免影響取件流程。</p>
            <p>🔍 尺寸與材質說明：</p>
            <p>杯子容量：350ml / 500ml / 750ml</p>
            <p>材質：100%再生寶特瓶纖維 (rPET) + 天然纖維</p>
            <p>耐熱程度：80°C（請避免直接加熱）</p>
            <p>❗ 特殊說明：</p>
            <p>再生環保馬克杯為特殊客製化商品，非商品瑕疵，恕不接受退換貨。</p>
            <p>若您有尺寸或其他需求疑慮，請於下單前確認商品規格。</p>
            <p>如需重新訂製，需再等待2-3週生產期。</p>
            <p>💳 付款方式：</p>
            <p>本店支援 LINE Pay 結帳，歡迎使用！</p>
            <p>如有任何問題，歡迎隨時與我們聯繫！🌱 選擇再生材質，與我們一起為地球減少負擔。</p>
          </div>
        </section>
      </div>
    </div>

    <p>{{ counterStore.count }}</p>
    <button @click="counterStore.accumulate">測試按鈕</button>
    <MainFooter />
  </main>
</template>

<script setup>
import MainFooter from '@/components/layout/MainFooter.vue';
import MainHeader from '@/components/layout/MainHeader.vue';
import { useCounterStore } from '@/store/cart';
import { ref, computed } from 'vue';

const counterStore = ref(useCounterStore());

//購買商品 //從資料庫取得?
const buys = ref([
  { id: 1, image: 'src/assets/images/Sp06.jpg', name: '愛護地球環保袋', price: 290, size: '不織布', num: 1 },
  { id: 1, image: 'src/assets/images/Sp06.jpg', name: '愛護地球環保袋', price: 290, size: '不織布', num: 1 },
]);

//精選商品
const items = ref([
  { id: 1, image: 'src/assets/images/Sp08.jpg', name: '愛護地球環保杯', price: 150, size: '無', num: 1 },
  { id: 2, image: 'src/assets/images/Sp09.jpg', name: '愛護地球環保杯2', price: 180, size: '無', num: 1 },
  { id: 3, image: 'src/assets/images/Sp04.jpg', name: '設計款 - 愛護地球環保吸管', price: 80, size: '無', num: 1 },
  { id: 4, image: 'src/assets/images/Sp11.jpg', name: '愛護地球環保筷', price: 80, size: '無', num: 1 },
]);

//商品加減&刪除按鈕
const addItem = (index) => {
  buys.value[index].num++;
};

const minusItem = (index) => {
  if (buys.value[index].num <= 1) {
    const d = confirm('是否要刪除這個商品？');
    if (d) {
      buys.value.splice(index, 1);
    }
  }
  if (buys.value[index].num > 1) {
    buys.value[index].num--;
  }
};

const deleteItem = (index) => {
  const d = confirm('是否要刪除這個商品？');
  if (d) {
    buys.value.splice(index, 1);
  }
};

//商品數量的輸入框
const reviseItem = (index, newNum) => {
  if (newNum < 0) {
    alert('商品數量不可為負！');
    buys.value[index].num = 1;
    return;
  } else if (newNum === 0) {
    const d = confirm('是否要刪除這個商品？');
    if (d) {
      buys.value.splice(index, 1);
    } else {
      buys.value[index].num = 1;
    }
  } else {
    buys.value[index].num = newNum;
  }
};

//精選商品加入購物車
const addToCart = (index) => {
  buys.value.push({
    id: buys.value.length - 1,
    image: items.value[index].image,
    name: items.value[index].name,
    price: items.value[index].price,
    size: items.value[index].size,
    num: items.value[index].num,
  });
};

//還沒加運費跟點數的小計 (運費上面那項)
const substotal = computed(() => {
  return buys.value.reduce((sum, item) => {
    return sum + item.price * item.num;
  }, 0);
});

//使用者點數：100 點折抵 1 元
const points = ref(1000); //正式應該從資料庫取得
const usePoints = ref(0);

//點數增減
const minusPoints = () => {
  if (usePoints.value <= 0) {
    return;
  } else {
    usePoints.value -= 100;
    points.value += 100;
  }
};

const addPoints = () => {
  if (points.value <= 0) {
    return;
  } else {
    usePoints.value += 100;
    points.value -= 100;
  }
};

//計算點數折抵
const discount = computed(() => {
  return usePoints.value / 100;
});

//計算合計金額
const total = computed(() => {
  return substotal.value + 100 - discount.value;
});

// 用於滑動的邏輯
const startX = ref(0);
const scrollLeft = ref(0);

const onTouchStart = (e) => {
  startX.value = e.touches[0].clientX; // 紀錄開始觸摸位置
  scrollLeft.value = e.currentTarget.scrollLeft; // 紀錄當前的滾動位置
};

const onTouchMove = (e) => {
  const x = e.touches[0].clientX; // 紀錄當前觸摸位置
  const walk = (x - startX.value) * 2; // 計算滑動距離，乘以 2 以增加滑動速度
  e.currentTarget.scrollLeft = scrollLeft.value - walk; // 更新滾動位置
};
</script>

<style lang="scss" scoped></style>
