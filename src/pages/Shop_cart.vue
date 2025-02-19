<template>
  <div>
    <MainHeader></MainHeader>
    <!-- <MainHeader /> -->
    <!-- 環保市集 - 購物車，縮寫Sp - 功能 - 代號X -->
    <main style="padding-top: 80px;"> <!-- 在 main 上添加 padding -->
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
          <!-- <section v-if="cartItems.length > 0" class="Sp-shopping-cart-X"> -->
          <section class="Sp-shopping-cart-X">
            <!-- 表頭 -->
            <div class="Sp-section-header">購物車</div>
            <!-- 項目名稱 + 內容 -->
            <div v-if="buys.length > 0" class="Sp-cart-items-wrapper-X">
              <div class="Sp-table-header-X">
                <div>商品資料</div>
                <div>規格</div>
                <div>單件價格</div>
                <div>數量</div>
                <div>小計</div>
                <div></div>
              </div>

              <div class="Sp-cart-item-X" v-for="(buy, index) in buys" :key="buy.id">
                <div class="Sp-cart-item-info-X">
                  <a :href="`/tid103/g1/shop/${buy.id}`" target="_blank" :style="{ backgroundImage: `url(/tid103/g1/images/${buy.image})` }"></a>
                  <span>{{ buy.name }}
                  </span>
                </div>
                <div>{{ buy.size || '未選擇' }}</div>
                <div>NT$ {{ buy.salePrice }}</div>
                <div>
                  <form action="">
                    <div class="Sp-cart-input-group-X">
                      <span @click="minusItem(index, -1)"><i class="bi bi-dash"></i></span>
                      <input @input="reviseItem(index, buy.num)" @blur="blurItem(index, buy.num)" type="number"
                        v-model="buy.num" step="1" min="0">
                      <span @click="addItem(index, 1)"><i class="bi bi-plus"></i></span>
                    </div>
                  </form>
                </div>
                <div>NT$ {{ buy.salePrice * buy.num }}</div>
                <div @click="deleteItem(index)"><i class="bi bi-trash3-fill"></i></div>
              </div>

            </div>
            <p v-else style="height: 80px; font: 20px/80px 'DM Sans, Noto Sans'; color: #d0ad44; text-align: center;">
              哎呀！您真窮</p>
          </section>
          <!-- 精選商品 -->
          <section class="Sp-shopping-cart-addon-X">
            <!-- 表頭 -->
            <div class="Sp-section-header">精選商品</div>
            <!-- 項目內容 -->
            <div class="Sp-cart-addon-wrapper-X">
              <div class="Sp-cart-addon-item-X" v-for="(item, index) in featuredItems" :key="item.ID">
                <a :href="`/tid103/g1/shop/${item.ID}`" target="_blank" class="Sp-cart-addon-item-img">
                  <img :src="`/tid103/g1/images/${item.productPic1}`" alt="商品圖片">
                </a>
                <div class="Sp-cart-addon-item-content">
                  <div class="Sp-cart-addon-item-info">
                    <p>{{ item.productName }}</p>
                    <span>NT$ {{ item.salePrice }}</span>
                  </div>
                  <button @click="addToCart(item)">加入購物車</button>
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
                <select name="" id="" v-model="selectedDelivery" @change="updateDeliveryCost">
                  <option :value="item" v-for="(item, index) in deliver" :key="index">{{ item }}</option>
                </select>
                <label for="">付款方式</label>
                <select v-model="selectedPayMethod" name="" id="">
                  <option :value="item.id" v-for="(item, index) in pay" :key="index">{{ item.name }}</option>
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
                  <span>NT$ {{ deliverCost }}</span>
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
                    <input @change="revisePoints" @blur="blurPoints" type="number" v-model="usePoints" step="100"
                      min="0">
                    <span @click="addPoints"><i class="bi bi-plus"></i></span>
                  </form>
                </div>
                <div class="Sp-order-summary-body-discount">
                  <span>折抵金額：</span>
                  <span>- NT$ {{ discount }}</span>
                </div>
                <hr>
                <div class="Sp-order-summary-body-amount">
                  <span>合計：</span>
                  <span>NT$ {{ total }}</span>
                </div>
                <!-- <router-link to="/shop_checkout" class="Sp-checkout-Btn">前往結帳</router-link> -->
                <a class="Sp-checkout-Btn" @click="goToPay">前往結帳</a>

              </div>
            </section>
          </section>
          <!-- 出貨提醒 -->
          <section class="Sp-shopping-reminder-X">
            <div class="Sp-shopping-reminder-header">出貨提醒</div>
            <div class="Sp-shopping-reminder-body">感謝您支持我們的環保商品！以下是您的訂單與出貨注意事項：<br>
              📦 出貨時間：<br>
              涼城即時環保市集皆為環保選品，現貨商品於下單後 3-5 個工作天內出貨，部分商品為客製化生產，製作期需2-3週。<br>
              訂單成立後，我們將立即安排生產。若提前完成品檢，我們會儘速出貨。<br>
              若您選購了其他現貨商品，建議您與預購商品分開結帳，以便現貨能提前寄出。<br>
              📬 取貨注意事項：<br>
              若您選擇便利商店取貨，請確保「收件人姓名」與身分證一致，以免影響取件流程。<br>
              選擇 超商取貨 時，請確保「收件人姓名」與身分證一致，以免影響取件流程。<br>
              宅配/郵寄 服務請確認地址資訊無誤，以確保順利送達。<br>
              🔍 產品規格與材質說明：<br>
              材質：各商品詳見商品頁說明，皆為環保、可回收或永續材質。<br>
              耐熱程度：請參考商品標示，部分商品請避免高溫直熱。<br>
              商品尺寸：依商品規格說明為準。<br>
              ❗ 特殊說明：<br>
              環保商品多為特殊客製化設計，非商品瑕疵恕不接受退換貨。<br>
              下單前請確認商品規格，若有疑問請聯繫客服。<br>
              若需訂製專屬商品，需等待額外生產期 2-3 週。<br>
              <!-- 🔍 尺寸與材質說明：<br>
              杯子容量：350ml / 500ml / 750ml<br>
              材質：100%再生寶特瓶纖維 (rPET) + 天然纖維<br>
              耐熱程度：80°C（請避免直接加熱）<br>
              ❗ 特殊說明：<br>
              再生環保馬克杯為特殊客製化商品，非商品瑕疵，恕不接受退換貨。<br>
              若您有尺寸或其他需求疑慮，請於下單前確認商品規格。<br>
              如需重新訂製，需再等待2-3週生產期。<br> -->
              💳 付款方式：<br>
              本店支援 LINE Pay 結帳，歡迎使用！<br>
              如有任何問題，歡迎隨時與我們聯繫！<br>
              🌱 選擇再生材質，與我們一起為地球減少負擔。
            </div>
          </section>

        </div>
      </div>
    </main>
    <MainFooter></MainFooter>
  </div>
</template>

<script setup>
import MainFooter from '@/components/layout/MainFooter.vue';
import MainHeader from '@/components/layout/MainHeader.vue';
// import { useCounterStore } from '@/store/cart';
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

// const counterStore = ref(useCounterStore());
//new URL('@/assets/images/Sp08.jpg', import.meta.url).href


//購買商品 //從資料庫取得?
// const buys = ref([
//   { id: 1, image: new URL('@/assets/images/Sp06.jpg', import.meta.url).href, name: '愛護地球環保袋', price: 290, size: '不織布', num: 1 },
//   { id: 1, image: new URL('@/assets/images/Sp06.jpg', import.meta.url).href, name: '愛護地球環保袋', price: 290, size: '不織布', num: 1 },
// ])


const base_url = import.meta.env.VITE_AJAX_URL
const buys = ref([]); // 商品資料取自localStorage


const minusItem = (index) => {
  if (buys.value[index].num <= 1) {
    if (confirm('是否要刪除這個商品？')) {
      buys.value.splice(index, 1);
    }
    // let d = confirm('是否要刪除這個商品？')
    // if (d) {
    //   buys.value.splice(index, 1)
    // }
  }
  // if (buys.value[index].num > 1) {
  //   buys.value[index].num--;
  // }
  else {
    buys.value[index].num--;
  }
  updateLocalStorage();
};

const deleteItem = (index) => {
  if (confirm('是否要刪除這個商品？')) {
    buys.value.splice(index, 1);
    updateLocalStorage();
  }
  // const d = confirm('是否要刪除這個商品？');
  // if (d) {
  //   buys.value.splice(index, 1);
  //   updateLocalStorage();
  // }
};

//商品數量的輸入框
const reviseItem = (index, newNum) => {
  if (newNum < 0) {
    alert('🌏商品數量不可為負！');
    buys.value[index].num = 1
    return
  } else if (newNum === 0) {
    let d = confirm('🌏是否要刪除這個商品？')
    if (d) {
      buys.value.splice(index, 1)
    } else {
      buys.value[index].num = 1
    }
  } else {
    buys.value[index].num = newNum
  }
  updateLocalStorage();
};

const blurItem = (index, num) => {
  if (!num) {
    buys.value[index].num = 1
  }
  updateLocalStorage();
};

// 所有商品
const allProducts = ref([]);

// 精選商品
const featuredItems = ref([]);

// 重新計算購物車內所有商品的總數
const updateCartCount = () => {
  const totalCount = buys.value.reduce((sum, item) => sum + item.num, 0);
  localStorage.setItem('cartCount', totalCount.toString());
  window.dispatchEvent(new Event('updateCartCount'));
};

// 資料庫取所有商品資料
const fetchAllProducts = async () => {
  try {
    const response = await fetch(`${base_url}/getAllProducts.php`); // 你的 API 路徑
    if (!response.ok) throw new Error("獲取商品失敗");
    allProducts.value = await response.json();
    console.log("☘️ 獲取的所有商品:", allProducts.value);

    // ✅ 生成精選商品（確保不重複）
    generateFeaturedItems();
  } catch (error) {
    console.error("🍂 無法獲取商品:", error);
  }
};

// 隨機選取 `n` 個不與購物車內重複的商品
const getRandomItems = (arr, n, excludeIds) => {
  
  // 排除購物車內的商品
  let filteredItems = arr.filter(item => !excludeIds.includes(item.ID));

  // 如果剩下的商品不足 4 種，就全部回傳
  if (filteredItems.length <= n) return [...filteredItems];

  // 洗牌並選取前 `n` 個
  return [...filteredItems].sort(() => 0.5 - Math.random()).slice(0, n);
};
// 隨機挑選 4 種不重複商品
const generateFeaturedItems = () => {
    const cartItemIds = buys.value.map(item => item.id); // 取得購物車內的商品 ID
    featuredItems.value = getRandomItems(allProducts.value, 4, cartItemIds);
};


//精選商品
// const items = ref([
//   { id: 1, image: new URL('@/assets/images/Sp08.jpg', import.meta.url).href, name: '愛護地球環保杯', price: 150, size: '無', num: 1 },
//   { id: 2, image: new URL('@/assets/images/Sp09.jpg', import.meta.url).href, name: '愛護地球環保杯2', price: 180, size: '無', num: 1 },
//   { id: 3, image: new URL('@/assets/images/Sp04.jpg', import.meta.url).href, name: '設計款 - 愛護地球環保吸管', price: 80, size: '無', num: 1 },
//   { id: 4, image: new URL('@/assets/images/Sp11.jpg', import.meta.url).href, name: '愛護地球環保筷', price: 80, size: '無', num: 1 },
// ]);

//商品加減&刪除按鈕
const addItem = (index) => {
  buys.value[index].num++;
  updateLocalStorage();
};

const cartItems = ref([]);
// const buys = ref([]); // 購物車商品
// const selectedSize = ref({});
const product = ref({});
// const num = ref(1);


//精選商品加入購物車
const addToCart = (selectedProduct) => {
  // 檢查商品資訊是否完整
  if (!selectedProduct || !selectedProduct.ID || !selectedProduct.productName || !selectedProduct.salePrice) {
    alert("商品資訊不完整，請稍候再試！");
    return;
  }

  // 解析 `product_details3` 為規格選項陣列
  const sizeOptions = selectedProduct.product_details3
    ? selectedProduct.product_details3.split(", ").map(size => size.trim())
    : [];

  // 如果未選擇規格，則預設為第一個規格或 "未選擇"
  const finalSize = sizeOptions[0] || "未選擇";

    // 建立新商品對象
    const newCartItem = {
      id: selectedProduct.ID,
      // image: selectedProduct.productPic1 ? `${selectedProduct.productPic1}` : "",
      image: selectedProduct.productPic1 || "",
      name: selectedProduct.productName,
      price: selectedProduct.salePrice,
      salePrice: selectedProduct.salePrice,
      size: finalSize,
      num: 1, // 預設數量 1
    };
   
    // // 找到對應的商品（根據 id 與規格）
    // const index = cart.findIndex(cartItem => cartItem.id === item.id && cartItem.size === item.size);
    // if (index !== -1) {
    //   cart[index].num = item.num;
    // }
    // // 更新 localStorage
    // localStorage.setItem("cart", JSON.stringify(cart));
    // buys.value = cart; // 同步更新 reactive 購物車資料
    // updateCartItemCount();
    // alert("🛒 商品已加入購物車！");
    // return;
    
    // 從 localStorage 取得現有購物車資料
    const storedCart = localStorage.getItem("cart");
    let cartData = storedCart ? JSON.parse(storedCart) : [];

    // const selectedProduct = featuredItems.value[index];
    // if (!selectedProduct) {
    //   console.warn("🍂 找不到該商品！");
    //   return;
    // }

    // 檢查是否已經存在相同商品（依據 `id` + `size`）
    const existingIndex = cartData.findIndex(item =>
      item.id === selectedProduct.ID && item.size === finalSize
    );

    if (existingIndex !== -1) {
      // 如果存在，累加數量
      cartData[existingIndex].num += 1;
      } else {
      // 若不存在，加入新商品
      cartData.push(newCartItem);
    }
    // 如果商品不存在，新增到購物車
    // const newCartItem = {
    //   id: selectedProduct.ID,
    //   image: selectedProduct.productPic1
    //     ? `${selectedProduct.productPic1}`
    //     : "",
    //   name: selectedProduct.productName,
    //   price: selectedProduct.salePrice,
    //   salePrice: selectedProduct.salePrice,
    //   size: finalSelectedSize || "未選擇",
    //   num: 1, // 預設數量 1
    // };

    // cart.push(newCartItem);

    // **更新 localStorage**
     // 更新 localStorage 與 reactive 狀態
    localStorage.setItem("cart", JSON.stringify(cartData));
    buys.value = cartData;
    updateCartItemCount();

    console.log("☘️ 商品已加入購物車:", cartData);
    alert("🛒 商品已加入購物車！");
   
    // 每次加入購物車後重新生成精選商品
    generateFeaturedItems();
  };
  
  const cartItemCount = ref(0);

  const updateCartItemCount = () => {
    const storedCart = localStorage.getItem("cart");
    const cart = storedCart ? JSON.parse(storedCart) : [];
    const count = cart.reduce((total, item) => total + Number(item.num), 0);
    cartItemCount.value = count;
    localStorage.setItem("cartCount", count.toString());
    window.dispatchEvent(new Event('updateCartCount'));
  };

  // buys.value.push({
  //   id: buys.value.length - 1,
  //   image: buys.value[index].productPic1,
  //   name: buys.value[index].productName,
  //   price: buys.value[index].price,
  //   size: buys.value[index].product_details3,
  //   num: buys.value[index].num,
  // })
  // updateLocalStorage();


  // 載入 localStorage 內的購物車商品
  const loadCart = () => {
    buys.value = JSON.parse(localStorage.getItem("cart")) || [];
    console.log("🛒 載入購物車資料:", buys.value);
  };

    //還沒加運費跟點數的小計 (運費上面那項)
    const substotal = computed(() => {
      return buys.value.reduce((sum, item) => {
      // 確保 salePrice 和 num 都是數字類型
      const price = Number(item.salePrice);
      const quantity = Number(item.num);
      return sum + (price * quantity);
      // return sum + item.salePrice * item.num;
      }, 0)
    })



//使用者點數：100 點折抵 1 元
const points = ref(1000); //正式應該從資料庫取得
const usePoints = ref(0);

//點數增減
const minusPoints = () => {
  if (usePoints.value <= 0) {
    return
  } else {
    usePoints.value -= 100;
    points.value += 100;
  }
  updateLocalStorage();
};

const addPoints = () => {
  if (points.value <= 0) {
    return
  } else {
    usePoints.value += 100;
    points.value -= 100;
  }
  updateLocalStorage();
}

//點數的輸入框
const revisePoints = () => {
  if (usePoints.value < 0) {
    alert('🌏 點數不能為負值，已自動改為0！');
    usePoints.value = 0;
  }
  else if (usePoints.value % 100 !== 0) {
    alert('🌏 請以 100 為單位進行輸入！');
    usePoints.value = Math.round(usePoints.value / 100) * 100; // 向上或向下取整至最近的 100
  }
  updateLocalStorage();
}

const blurPoints = () => {
  if (usePoints.value === '' || usePoints.value === null) {
    usePoints.value = 0;
  }
}

//計算點數折抵
const discount = computed(() => {
  return usePoints.value / 100;
});

//送貨方式
const deliver = ref(['新竹物流宅配', '台灣離島郵寄']);
const selectedDelivery = ref(localStorage.getItem('selectedDelivery') || deliver.value[0]);
const deliverCost = ref(parseInt(localStorage.getItem('deliverCost')) || 100);

// 更新運費
const updateDeliveryCost = () => {
  if (buys.value.length === 0) {
    deliverCost.value = 0; // 購物車沒商品，運費設為 0
  } else if (selectedDelivery.value === '新竹物流宅配') {
    deliverCost.value = 100;
  } else if (selectedDelivery.value === '台灣離島郵寄') {
    deliverCost.value = 80;
  }


  // 存入 localStorage
  localStorage.setItem('selectedDelivery', selectedDelivery.value);
  localStorage.setItem('deliverCost', deliverCost.value);
};
// **監聽 selectedDelivery 變化，更新運費**
watch(selectedDelivery, updateDeliveryCost);

//付款方式
const pay = ref([
  { id: 0, name: "信用卡 (Visa/Master/JCB)" },
  { id: 1, name: "Line Pay" },
]);

// 使用者選擇的付款方式（從 localStorage 讀取，如果沒有則預設為 0）
const selectedPayMethod = ref(
  parseInt(localStorage.getItem("payMethod")) || 0
);

// 監聽 `selectedPayMethod`，當使用者選擇時存入 `localStorage`
watch(selectedPayMethod, (newValue) => {
  localStorage.setItem("payMethod", newValue);
});



//計算合計金額
const total = computed(() => {
  return substotal.value + deliverCost.value - discount.value;
})


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

// const updateLocalStorage = () => {
//   localStorage.setItem("cart", JSON.stringify(buys.value));
//   localStorage.setItem("usePoints", JSON.stringify(usePoints.value)); // 🔹 存入折抵點數
//   console.log("🛒 購物車更新:", buys.value);
//   console.log("🛒 更新購物車 & 點數折抵:", buys.value, "折抵點數:", usePoints.value);
// };

//判定購物車內有沒有商品，沒有的話就導回環保商店購物
const updateLocalStorage = () => {
  localStorage.setItem("usePoints", JSON.stringify(usePoints.value));
  if (buys.value.length === 0) {
    localStorage.removeItem('cart');
    alert('目前購物車無商品，請前往環保商店選購');
    router.push('/shop');
  } else {
    localStorage.setItem('cart', JSON.stringify(buys.value));
  }
  updateCartCount();
};

//前往結帳
const goToPay = () => {
  let paymentMethodPath = ''
  if(selectedPayMethod.value === 0){ //信用卡結帳
    paymentMethodPath = 'creditCard';
  }else{ //linePay 結帳
    paymentMethodPath = 'linePay';
  }
  router.push({
    path:`/shop_cart/${paymentMethodPath}`
  })
}




onMounted(() => {
  const storedCart = localStorage.getItem("cart");
  if (storedCart) {
    const parsedCart = JSON.parse(storedCart);
    cartItems.value = parsedCart;
    buys.value = parsedCart;
  }
  console.log("📦 載入購物車資料:", buys.value);
  if (!storedCart) {
    alert('目前購物車無商品，請前往環保商店選購');
    router.push('/shop');
    return;
  }
  loadCart();
  fetchAllProducts();

  // 當頁面載入時，確保運費已存入 `localStorage`
  if (!localStorage.getItem('deliverCost')) {
    localStorage.setItem('deliverCost', 100);
    localStorage.setItem('selectedDelivery', '新竹物流宅配');
    deliverCost.value = 100;
  }
});

</script>


<style lang="scss" scoped>
.Sp-checkout-nav-X {
  text-align: center;
  margin-top: 60px;
}
</style>
