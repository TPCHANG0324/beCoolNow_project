<template>
  <MainHeader></MainHeader>
  <!-- 環保市集_商品頁面_主選單 -->
  <!-- <header class="Fp_Header_H">選單</header> -->

    <!-- 環保市集_商品頁面_商品購買 -->
    <section class="Sp_productChoice_H">
      <!-- 麵包屑導航 -->
      <nav class="breadCrumb">
        <ol>
          <li><a href="#">首頁</a></li>
          &nbsp;&gt;&nbsp;
          <li>NT$100~$200</li>
        </ol>
      </nav>

      <!-- 選擇規格及數量 -->
      <section class="Sp_productChoice_top_H">
          <!-- <figure>
            <ul>
              <li><img src="../assets/images/Sp15.jpg" alt="" /></li>
              <li><img src="../assets/images/Sp16.jpg" alt="" /></li>
              <li><img src="../assets/images/Sp17.jpg" alt="" /></li>
              <li><img src="../assets/images/Sp18.jpg" alt="" /></li>
            </ul> -->
            <!-- <div><img src="../assets/images/Sp15.jpg" alt="" /></div> -->
            <!-- <slider></slider> -->
          <!-- </figure>  -->
        <figure>
          <!-- 桌機版 (當螢幕 > 430px) -->
        <div v-if="!isMobile">
          <div class="desktop-view">
            <!-- 大圖 -->
            <div class="main-image">
              <img :src="selectedImage" alt="Main Image" />
            </div>
            <!-- 小圖swiper滑動 -->
            <swiper
                ref="thumbnailSwiper"
                v-if="isMounted"
                class="thumbnail-swiper"
                :modules="modules"
                :slides-per-view="4"  
                :space-between="20"
                direction="vertical"  
                :mousewheel="true" 
                :css-mode="false"
                :free-mode="true"
                v-bind="swiperParams"
                @mouseenter="startAutoScroll"
                @mouseleave="stopAutoScroll"
              
              >
                  <swiper-slide
                    v-for="(image, index) in images"
                    :key="index"
                    @click="selectImage(image, index)"
                  >
                    <img :src="image" alt="Thumbnail" />
                  </swiper-slide>
                </swiper>
          </div>
        </div>

          <!-- 手機版 (當螢幕 ≤ 430px) -->
        <template>
          <div>
            <swiper
              ref="mainImageSwiper"
              v-if="isMobile"
              :key="swiperKey"
              class="main-image-swiper"
              :modules="modules"
              :slides-per-view="1"
              :space-between="10"
              :loop="true"
              :breakpoints="{
                  430: {
                    slidesPerView: 'auto',  // 可以調整為顯示單張圖片，也可以自定設定展示數量
                    spaceBetween: 10,       // 間距設置
                    loop: true              // 或設置為循環顯示
                  },
                }"
              :autoplay= "swiperParams.autoplay"
              :enabled="swiperParams.enabled"
              :pagination="{ clickable: true }"
              :navigation="true"
              @swiper="setMainImageSwiper"
            >
              <swiper-slide v-for="(image, index) in images" :key="index">
                <img :src="image" alt="Main Image" class="main-image"/>
              </swiper-slide>
            </swiper>
                <!-- Desktop View -->
          <div v-else>
              <div class="main-image-container">
                <img :src="selectedImage" alt="Main Image" class="main-image" />
              </div>
              <swiper
                :key="swiperKey"
                :modules="modules"
                :slides-per-view="4"
                :space-between="10"
                :breakpoints="{
                  430: {
                    slidesPerView: 'auto',  // 可以調整為顯示單張圖片，也可以自定設定展示數量
                    spaceBetween: 10,       // 間距設置
                    loop: true              // 或設置為循環顯示
                  },
                }"
                :autoplay="{ delay: 3000, disableOnInteraction: false }"
                @swiper="setThumbnailSwiper"
                @mouseenter="stopAutoScroll"
                @mouseleave="startAutoScroll"
              >
                <swiper-slide v-for="(image, index) in images" :key="index" @click="selectImage(image)">
                  <img :src="image" alt="Thumbnail" class="thumbnail-image" />
                </swiper-slide>
              </swiper>
            </div>

          </div>
        </template>
        </figure>


        <aside class="Sp_productChoice_info_H">
          <section>
            <div>
              <h3>再生材質環保杯</h3>
              <span>NT$299</span>
            </div>

            <ul>
              <li>重量僅有300g</li>
              <li>輕巧好攜帶</li>
              <li>質感必備</li>
            </ul>
          </section>

          <section>
              <p>規格</p>

              <!-- <div class="Sp_productChoice_btnGroup_H">
                <button type="button">200ml</button>
                <button type="button">350ml</button>
                <button type="button">500ml</button>
                <button type="button">750ml</button>
              </div> -->
              <div class="Sp_productChoice_btnGroup_H">
              <select 
                    v-model="selectedSize" 
                    @change="selectSize"
                    class="form-select"
                  >
                  <option value="" disabled>請選擇容量</option>
                    <option 
                      v-for="(size, index) in sizes" 
                      :key="index" 
                      :value="size"
                    >
                    {{ size }}
                  </option>
              </select>
             </div>

              <!-- <div class="Sp_productChoice_inputGroup_H">
                <input type="text" class="input" />
              </div> -->
              <div class="Sp_productChoice_inputGroup_H">
                  <!-- 數量調整 -->
                <div class="quantity-input-group">
                  <!-- 減少按鈕 -->
                  <button class="btn-minus" @click="decrement">-</button>
      
                  <!-- 數量輸入框 -->
                  <input 
                    type="text" 
                    v-model="quantity" 
                    @input="handleInput" 
                    min="0" 
                    class="quantity-input"
                  />
                  
                  <!-- 增加按鈕 -->
                  <button class="btn-plus" @click="increment">+</button>
                </div>
                <!-- <p>數量: {{ quantity }}</p> -->
              </div>


              <div class="Sp_productChoice_buyNow_H">
                <button type="button" @click="addToCart">加入購物車</button>
                <button type="button">立即購買</button>
              </div>
             
              <!-- 遮罩層 -->
            
              <div v-if="isCartPopupVisible" class="overlay" 
              @click="isCartPopupVisible = false"></div>
            
              <!-- 🛒 購物車彈窗 -->
              <div v-if="isCartPopupVisible" class="cart-popup">
                <div class="cart-popup-content">
                  <h2>商品已加入購物車！</h2>
                  <button @click="closeCartPopup">關閉</button>
                  <div class="cart-item">
                    <img :src="selectedImage" alt="商品圖片" class="cart-image"/>
                    <div class="cart-info">
                      <p>商品：再生材質環保杯</p>
                      <p>規格：{{ selectedSize || "未選擇" }}</p>
                      <p>數量：{{ quantity }}</p>
                      <p>總價：NT$ {{ quantity * 299 }}</p>
                    </div>
                  </div>
                  <div class="cart-popup-actions">
                    <button class="checkout-btn" @click="goToCheckout">立即結帳</button>
                    <button class="continue-btn" @click="isCartPopupVisible = false">繼續購物</button>
                  </div>
                </div>
              </div>
           </section>
          </aside>
      </section>
    </section>

    <!-- 環保市集_商品頁面_商品詳情 -->
    <section class="Sp_productChoice_details_H">
      <article class="Sp_productChoice_detailsBlock1_H">
        <h3>商品詳情</h3>
        <p>
          這款再生材質環保馬克杯，選用回收寶特瓶 (rPET)
          及天然纖維製成，耐用且輕盈，適合日常使用。杯身設計簡約時尚，防漏耐熱，無毒無味，符合食品級安全標準。每使用一次，即為地球減少一份負擔，讓你的飲品更添環保意識，喝出綠色生活態度。
        </p>
      </article>
      <figure>
        <img src="../assets/images/Sp20.jpg" alt="" />
      </figure>
      <article class="Sp_productChoice_detailsBlock2_H">
        <img src="../assets/images/Sp21.jpg" alt="" />
        <div>
          <h3>規格</h3>
          <p>成份：回收寶特瓶(rPET)及天然纖維製成<br />產地：台灣</p>
        </div>
      </article>
      <figure>
        <img src="../assets/images/Sp22.jpg" alt="" />
      </figure>
      <article class="Sp_productChoice_detailsBlock3_H">
        <img src="../assets/images/Sp23.jpg" alt="" />
        <div>
          <p>常見尺寸(容量):</p>
          <ol>
            <li>小型: 200ml (7 oz)</li>
            <li>中型: 350ml (12 oz)</li>
            <li>大型: 500ml (17 oz)</li>
            <li>特大: 750ml以上 (26 oz)</li>
          </ol>
        </div>
      </article>
    </section>

    <!-- 環保市集_商品頁面_相關商品 -->
    <!-- <section class="Sp_productChoice_related_H">
      <h3>相關商品</h3>
      <ol>
        <li>
          <a href="">
            <img src="../assets/images/Sp04.jpg" alt="" />
            <p>環保吸管3</p>
          </a>
        </li>
        <li>
          <a href="">
            <img src="../assets/images/Sp11.jpg" alt="" />
            <p>環保筷子1</p>
          </a>
        </li>
        <li>
          <a href="">
            <img src="../assets/images/Sp09.jpg" alt="" />
            <p>環保杯子2</p>
          </a>
        </li>
        <li>
          <a href="">
            <img src="../assets/images/Sp06.jpg" alt="" />
            <p>環保袋子2</p>
          </a>
        </li>
        <li>
          <a href="">
            <img src="../assets/images/Sp08.jpg" alt="" />
            <p>環保杯子1</p>
          </a>
        </li>
      </ol>
    </section> -->
 
  <!-- 環保市集_商品頁面_相關商品 -->
  <section class="Sp_productChoice_related_H">
    <h3>相關商品</h3>
    <ol>
      <li>
        <a href="">
          <img src="../assets/images/Sp04.jpg" alt="" />
          <p>環保吸管3</p>
        </a>
      </li>
      <li>
        <a href="">
          <img src="../assets/images/Sp11.jpg" alt="" />
          <p>環保筷子1</p>
        </a>
      </li>
      <li>
        <a href="">
          <img src="../assets/images/Sp09.jpg" alt="" />
          <p>環保杯子2</p>
        </a>
      </li>
      <li>
        <a href="">
          <img src="../assets/images/Sp06.jpg" alt="" />
          <p>環保袋子2</p>
        </a>
      </li>
      <li>
        <a href="">
          <img src="../assets/images/Sp08.jpg" alt="" />
          <p>環保杯子1</p>
        </a>
      </li>
    </ol>
  </section>

    <!-- 環保市集_商品頁面_頁尾 -->
    <!-- <footer class="Fp_Footer_H">頁尾</footer> -->
    <MainFooter></MainFooter>
 
</template>

<script>
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
import { ref, onMounted, onUnmounted, nextTick} from 'vue';
import { Navigation, Pagination, Scrollbar, A11y, Mousewheel, Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';

export default {
  name: "ProductChoice", // Vue 組件名稱
  // name: 'SizeSelector',
  components: { 
    Swiper, 
    SwiperSlide,
    MainHeader,
    MainFooter,
  },
  setup() {
    // 判斷是否為手機 (小於等於 430px)
    const isMobile = ref(window.innerWidth <= 430);
    const isMounted = ref(false);
    const swiperKey = ref(0);
    const thumbnailSwiper = ref(null);
    const mainImageSwiper = ref(null);
    const images = [
        new URL("../../public/images/Sp15.jpg", import.meta.url).href,
        new URL("../../public/images/Sp16.jpg", import.meta.url).href,
        new URL("../../public/images/Sp17.jpg", import.meta.url).href,
        new URL("../../public/images/Sp18.jpg", import.meta.url).href,
        new URL("../../public/images/Sp19.jpg", import.meta.url).href,
      // require("../assets/images/Sp15.jpg"),
      // require("../assets/images/Sp16.jpg"),
      // require("../assets/images/Sp17.jpg"),
      // require("../assets/images/Sp18.jpg"),
    ];
    const selectedImage = ref(images[0]); // 預設顯示第一張圖片
    const sizes = ref(['200ml', '350ml', '500ml', '750ml']);
    const selectedSize = ref('');
    const quantity = ref(1);

    const selectImage = (image) => {
      selectedImage.value = image;
    }; 

    const swiperParams = ref({
      autoplay: false,
      enabled: false
    });
    // 控制 Swiper 自動滾動
     const startAutoScroll = () => {
            swiperParams.value = {
            autoplay: {
            delay: 1000,
            disableOnInteraction: false
            },
            enabled: true
          };
        };

    const stopAutoScroll = () => {
      swiperParams.value = {
      autoplay: false,
      enabled: false
      };
    };

    const increment = () => {
      quantity.value++;
    };

    const decrement = () => {
      if (quantity.value > 0) quantity.value--;
    };

      // 監聽視窗大小變化

    const updateScreenSize = () => {
        isMobile.value = window.innerWidth <= 430;
        swiperKey.value = isMobile.value ? 1 : 0; // 強制切換 Swiper
      };
      swiperParams.value = {
        autoplay: isMobile.value ? { delay: 1000, disableOnInteraction: false } : false,
        enabled: isMobile.value
      };
      const setMainImageSwiper = (swiper) => {
      mainImageSwiper.value = swiper;
    };
    const isCartPopupVisible = ref(false);
    const openCartPopup = () => {
      isCartPopupVisible.value = true;
    };

    const closeCartPopup = () => {
      isCartPopupVisible.value = false;
    };

    const cart = ref([]);
    const addToCart = () => { 
      if (!selectedImage.value || !selectedSize.value) {
        alert("請選擇商品規格再加入購物車！");
        return;
    }
    const product = {
    image: selectedImage.value, // 圖片
    size: selectedSize.value,   // 商品規格
    quantity: quantity.value,   // 數量
    price: 299,                 // 假設商品單價
    };
      cart.value.push(product); // 加入購物車
      isCartPopupVisible.value = true; // 顯示彈窗
    };
    const goToCheckout = () => {
    console.log("跳轉到結帳頁面..."); //  這裡可以改為 `router.push('/checkout')`
    };
    
      onMounted(async () => {
        isMounted.value = true;
        isMobile.value = window.innerWidth <= 430;
        await nextTick(); // 確保 DOM 更新後取得 Swiper

      if (thumbnailSwiper.value?.swiper) {
        thumbnailSwiper.value.swiper.autoplay.stop(); // 確保初始狀態是停止的
      }
      updateScreenSize();
      window.addEventListener("resize", updateScreenSize);

        // 手動更新 Swiper
        if (mainImageSwiper.value?.swiper) {
          mainImageSwiper.value.swiper.update();
        }
    });

      onUnmounted(() => {
        window.removeEventListener("resize", updateScreenSize);
      });

      return {
      isMobile,
      isMounted,
      swiperKey,
      images,
      selectedImage,
      selectImage,
      addToCart,
      startAutoScroll,
      stopAutoScroll,
      thumbnailSwiper,
      sizes,
      selectedSize,
      quantity,
      increment,
      decrement,
      cart,
      isCartPopupVisible,
      mainImageSwiper,
      setMainImageSwiper,
      openCartPopup,
      closeCartPopup,
      goToCheckout,
      modules: [Navigation, Pagination, Scrollbar, A11y, Mousewheel, Autoplay],
    };
  },
  // data() {
  //   return {
  //     // sizes: ['200ml', '350ml', '500ml', '750ml'], // 按鈕選項
  //     // selectedSize: '', // 當前選中的按鈕
  //     // quantity: 1, // 初始化數量
  //   };
  // },
  // methods: {
  // //   selectSize(size) {
  // //     this.selectedSize = size; // 設定選中的按鈕
  // //     // this.$emit('size-selected', size); // 傳遞事件給父組件
  // //   },
  //   // increment() {
  //   //   this.quantity++;
  //   // },
  //   // decrement() {
  //   //   if (this.quantity > 0) this.quantity--;
  //   // },
  
};
</script>
