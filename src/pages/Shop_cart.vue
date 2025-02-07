<template>
<<<<<<< HEAD

  <MainHeader />
=======
    <MainHeader></MainHeader>
  <!-- <MainHeader /> -->
>>>>>>> sunny
  <!-- 環保市集 - 購物車，縮寫Sp - 功能 - 代號X -->
  <main>
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

            <div class="Sp-cart-item-X" v-for="(buy, index) in buys" :key="buy.id">
              <div class="Sp-cart-item-info-X">
                <a href="#" target="_blank" :style="{ backgroundImage: `url(${buy.image})` }"></a>
                <span>{{ buy.name }}
                </span>
              </div>
              <div>{{ buy.size }}</div>
              <div>NT$ {{ buy.price }}</div>
              <div>
                <form action="">
                  <div class="Sp-cart-input-group-X">
                    <span @click="minusItem(index)"><i class="bi bi-dash"></i></span>
                    <input @input="reviseItem(index, buy.num)" @blur="blurItem(index, buy.num)" type="number"
                      v-model="buy.num" step="1" min="0">
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
            <div class="Sp-cart-addon-item-X" v-for="(item, index) in items" :key="item.id">
              <a href="#" target="_blank" class="Sp-cart-addon-item-img">
                <img :src="item.image" alt="">
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
              <select name="" id="" v-model="selectedDelivery" @change="updateDeliveryCost">
                <option :value="item" v-for="(item, index) in deliver" :key="index">{{ item }}</option>
              </select>
              <label for="">付款方式</label>
              <select name="" id="">
                <option :value="index" v-for="(item, index) in pay" :key="index">{{ item }}</option>
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
                  <input @change="revisePoints" @blur="blurPoints" type="number" v-model="usePoints" step="100" min="0">
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
              <router-link to="/shop_checkout" class="Sp-checkout-Btn">前往結帳</router-link>
            </div>
          </section>
        </section>
        <!-- 出貨提醒 -->
        <section class="Sp-shopping-reminder-X">
          <div class="Sp-shopping-reminder-header">出貨提醒</div>
          <div class="Sp-shopping-reminder-body">感謝您支持我們的環保商品！以下是您的訂單與出貨注意事項：<br>
            📦 出貨時間：<br>
            涼城即時環保市集皆為客製化生產，製作期需2-3週。<br>
            訂單成立後，我們將立即安排生產。若提前完成品檢，我們會儘速出貨。<br>
            若您選購了其他現貨商品，建議您與預購商品分開結帳，以便現貨能提前寄出。<br>
            📬 取貨注意事項：<br>
            若您選擇便利商店取貨，請確保「收件人姓名」與身分證一致，以免影響取件流程。<br>
            🔍 尺寸與材質說明：<br>
            杯子容量：350ml / 500ml / 750ml<br>
            材質：100%再生寶特瓶纖維 (rPET) + 天然纖維<br>
            耐熱程度：80°C（請避免直接加熱）<br>
            ❗ 特殊說明：<br>
            再生環保馬克杯為特殊客製化商品，非商品瑕疵，恕不接受退換貨。<br>
            若您有尺寸或其他需求疑慮，請於下單前確認商品規格。<br>
            如需重新訂製，需再等待2-3週生產期。<br>
            💳 付款方式：<br>
            本店支援 LINE Pay 結帳，歡迎使用！<br>
            如有任何問題，歡迎隨時與我們聯繫！🌱 選擇再生材質，與我們一起為地球減少負擔。</div>
        </section>

      </div>
    </div>

    <!-- <p>{{ counterStore.count }}</p> -->
    <!-- <button @click="counterStore.accumulate">測試按鈕</button> -->

    <button @click="testBtn">測試按鈕</button>


    <!-- 測試用：註冊 -->
    <form action="" @submit.prevent="register">
      帳號：<input type="text" name="account" v-model="account1">
      密碼：<input type="password" name="password" v-model="password1">
      <input type="submit" value="註冊">
    </form>
    <!-- 測試用：登入 -->
    <form action="" @submit.prevent="login">
      帳號：<input type="text" name="account" v-model="account2">
      密碼：<input type="password" name="password" v-model="password2">
      <input type="submit" value="登入">
    </form>
  </main>
<<<<<<< HEAD

  <MainFooter class="removeMT" />

=======
  <MainFooter></MainFooter>
>>>>>>> sunny
</template>

<script setup>
import MainFooter from '@/components/layout/MainFooter.vue';
import MainHeader from '@/components/layout/MainHeader.vue';
import { useCounterStore } from '@/store/cart';
import { ref, computed } from 'vue';
//---------------------測試按鈕

const testBtn = async () => {
  const res = await fetch('/tid103/g1/php/test.php')
  const data = await res.json()
  console.log(data)
}



//---------------------測試用：註冊

const account1 = ref(null)
const password1 = ref(null)

const register = async () => {
  if (!account1.value || !password1.value) {
    alert("帳號或密碼不可為空！");
    return;
  }
  const url = `/tid103/g1/php/register.php`;
  try {
    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        account: account1.value,
        password: password1.value
      })
    })
    const data = await res.json()
    console.log(data) //註冊完之後看一下成功與否

    if (data.success) {
      console.log("註冊成功！");
    } else {
      console.log(`註冊失敗：${data.error}`);
    }

  } catch (e) {
    console.log(`請求出現錯誤：${error.message}`);
  }
}

//---------------------測試用：登入

const account2 = ref(null)
const password2 = ref(null)

const login = async () => {
  if (!account2.value || !password2.value) {
    alert("帳號或密碼不可為空！");
    return;
  }
  const url = `/tid103/g1/php/login.php`;
  try {
    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        account: account2.value,
        password: password2.value
      })
    })

    const data = await res.json();
    console.log(data); //看一下登入結果

    if (data.success) {
      console.log(data.message, data)
    }
  } catch (e) {
    console.log(`請求出現錯誤：${e}`);
  }
}
//---------------------

// import { CKEditor } from '@ckeditor/ckeditor5-vue';  
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic'; 

// const editor = ClassicEditor; // 使用已导入的 ClassicEditor  
// const editorData = ref('<p>初始内容</p>'); // 使用 ref 创建响应式的数据  

// // 编辑器准备就绪的处理函数  
// const onReady = (editorInstance) => {  
//   console.log('编辑器准备好了!', editorInstance);  
// };  

// // 处理编辑器数据更改  
// const onChange = ({ editor }) => {  
//   const data = editor.getData();  
//   editorData.value = data; // 更新响应式数据  
// }; 

//---------------------














const counterStore = ref(useCounterStore());
//new URL('@/assets/images/Sp08.jpg', import.meta.url).href

//購買商品 //從資料庫取得?
const buys = ref([
  { id: 1, image: new URL('@/assets/images/Sp06.jpg', import.meta.url).href, name: '愛護地球環保袋', price: 290, size: '不織布', num: 1 },
  { id: 1, image: new URL('@/assets/images/Sp06.jpg', import.meta.url).href, name: '愛護地球環保袋', price: 290, size: '不織布', num: 1 },
])

//精選商品
const items = ref([
  { id: 1, image: new URL('@/assets/images/Sp08.jpg', import.meta.url).href, name: '愛護地球環保杯', price: 150, size: '無', num: 1 },
  { id: 2, image: new URL('@/assets/images/Sp09.jpg', import.meta.url).href, name: '愛護地球環保杯2', price: 180, size: '無', num: 1 },
  { id: 3, image: new URL('@/assets/images/Sp04.jpg', import.meta.url).href, name: '設計款 - 愛護地球環保吸管', price: 80, size: '無', num: 1 },
  { id: 4, image: new URL('@/assets/images/Sp11.jpg', import.meta.url).href, name: '愛護地球環保筷', price: 80, size: '無', num: 1 },
]);

//商品加減&刪除按鈕
const addItem = (index) => {
  buys.value[index].num++;
};

const minusItem = (index) => {
  if (buys.value[index].num <= 1) {
    let d = confirm('是否要刪除這個商品？')
    if (d) {
      buys.value.splice(index, 1)
    }
  }
  if (buys.value[index].num > 1) {
    buys.value[index].num--;
  }
};

const deleteItem = (index) => {
  const d = confirm('是否要刪除這個商品？');
  if (d) {
    buys.value.splice(index, 1)
  }
};

//商品數量的輸入框
const reviseItem = (index, newNum) => {
  if (newNum < 0) {
    alert('商品數量不可為負！');
    buys.value[index].num = 1
    return
  } else if (newNum === 0) {
    let d = confirm('是否要刪除這個商品？')
    if (d) {
      buys.value.splice(index, 1)
    } else {
      buys.value[index].num = 1
    }
  } else {
    buys.value[index].num = newNum
  }
}

const blurItem = (index, num) => {
  if (!num) {
    buys.value[index].num = 1
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
  })
}

//還沒加運費跟點數的小計 (運費上面那項)
const substotal = computed(() => {
  return buys.value.reduce((sum, item) => {
    return sum + item.price * item.num;
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
};

const addPoints = () => {
  if (points.value <= 0) {
    return
  } else {
    usePoints.value += 100;
    points.value -= 100;
  }
}

//點數的輸入框
const revisePoints = () => {
  if (usePoints.value < 0) {
    alert('點數不能為負值，已自動改為0！');
    usePoints.value = 0;
  }
  else if (usePoints.value % 100 !== 0) {
    alert('請以 100 為單位進行輸入！');
    usePoints.value = Math.round(usePoints.value / 100) * 100; // 向上或向下取整至最近的 100
  }
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
const deliver = ref(['新竹物流宅配', '台灣離島郵寄'])
const selectedDelivery = ref(deliver.value[0]);
const deliverCost = ref(100);

const updateDeliveryCost = () => {
  if (selectedDelivery.value === '新竹物流宅配') {
    deliverCost.value = 100;
  } else if (selectedDelivery.value === '台灣離島郵寄') {
    deliverCost.value = 80;
  }
};

//付款方式
const pay = ref(['信用卡 (Visa/Master/JCB)', 'Line Pay'])


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
</script>
