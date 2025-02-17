<template>
  <div>
    <MainHeader></MainHeader>
  <!-- 環保市集_商品頁面_主選單 -->
  <!-- <header class="Fp_Header_H">選單</header> -->

  <!-- 環保市集_商品頁面_商品購買 -->
  <section class="Sp_productChoice_H">
    <!-- 麵包屑導航 -->
    <BreadcrumbNavigation :priceRange="currentPriceRange" :productName="product?.productName" />

      <!-- 選擇規格及數量 -->
      <section class="Sp_productChoice_top_H">
          <!-- <figure>
            <ul>
              <li><img src="../../public/images/Sp15.jpg" alt="" /></li>
              <li><img src="../../public/images/Sp16.jpg" alt="" /></li>
              <li><img src="../../public/images/Sp17.jpg" alt="" /></li>
              <li><img src="../../public/images/Sp18.jpg" alt="" /></li>
            </ul> -->
            <!-- <div><img src="../../public/images/Sp15.jpg" alt="" /></div> -->
            <!-- <slider></slider> -->
          <!-- </figure>  -->
        <figure>
          <!-- 桌機版 (當螢幕 > 430px) -->
        <div v-if="!isMobile">
          <div class="desktop-view">
            <!-- 大圖 -->
            <div class="main-image">
              <img :src="selectedImage" alt="載入中..." />
            </div>
            <!-- 小圖swiper滑動 -->
            <swiper
                ref="thumbnailSwiper"
                v-if="isMounted && images.length > 0"
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
                    <img :src="image" alt="載入中..." />
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
              <template v-for="(image, index) in images" :key="index" @click="selectImage(image)">
                <swiper-slide class="swiperSlideDesktop" >
                  <img :src="image" alt="測試" class="thumbnail-image"/>
                </swiper-slide>
              </template>
              </swiper>
            </div>

          </div>
        </template>
        </figure>


      <aside class="Sp_productChoice_info_H">
        <section>
          <div v-if="product.productName">
            <h3>{{ product.productName }}</h3>
            <span>NT${{ product.salePrice }}</span>
          </div>
          <p v-else>載入中...</p>



          <ul>
            <li v-html="product.feature"></li>
            <!-- <li>重量僅有300g</li>
            <li>輕巧好攜帶</li>
            <li>質感必備</li> -->
          </ul>
        </section>

        <section>
          <p>規格</p>

          <div class="Sp_productChoice_btnGroup_H">
            <select v-model="selectedSize" class="form-select">
              <option value="" disabled>請選擇容量</option>
              <option v-for="(size, index) in selectedSizeOptions" :key="index" :value="size">
                {{ size }}
              </option>
            </select>
          </div>

          <div class="Sp_productChoice_inputGroup_H">
            <div class="quantity-input-group">
              <button class="btn-minus" @click="decrementQuantity">-</button>
              <input
                v-model.number="num"
                type="number"
                min="1"
                max="99"
                class="quantity-input"
                @input="handleQuantityInput"
              />
              <button class="btn-plus" @click="incrementQuantity">+</button>
            </div>
          </div>

              <div class="Sp_productChoice_buyNow_H">
                <button type="button" @click="addToCart(false)">加入購物車</button>
                <router-link to="/shop_cart" custom v-slot="{ navigate }">
                  <button type="button" @click="addToCart">
                    立即購買
                  </button>
                </router-link>
              </div>

              <!-- 遮罩層 -->

              <div v-if="isCartPopupVisible" class="cart-overlay"
              @click="closeCartPopup"></div>

              <!-- 🛒 購物車彈窗 -->
              <div v-if="isCartPopupVisible" class="cart-popup">
                <div class="cart-popup-content">
                  <h2>商品已加入購物車！</h2>
                  <button class="close-btn" @click="closeCartPopup">X</button>
                  <div class="cart-item">
                    <img :src="selectedImage" alt="商品圖片" class="cart-image"/>
                    <div class="cart-info">
                      <p>商品：{{ product.productName }}</p>
                      <p>規格：{{ selectedSize || "未選擇" }}</p>
                      <p>數量：{{ num }}</p>
                      <p>總價：NT$ {{ num * product.salePrice }}</p>
                    </div>
                  </div>
                  <div class="cart-popup-actions">
                    <button class="checkout-btn" @click="goToCheckout">立即結帳</button>
                    <button class="continue-btn" @click="closeCartPopup">繼續購物</button>
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
        <p v-html="product.product_details1"></p>
      </article>
      <figure v-if="product.productPic5">
        <!-- <img src="../../public/images/Sp20.jpg" alt="" /> -->
        <img :src="getImageUrl(product.productPic5)" alt="商品圖片" />
      </figure>
      <article v-if="product.productPic4" class="Sp_productChoice_detailsBlock2_H">
        <!-- <img src="../../public/images/Sp21.jpg" alt="" /> -->
        <img :src="getImageUrl(product.productPic4)" alt="商品圖片" style="object-fit: cover; object-position: center center;" />
        <div>
          <h3>說明</h3>
          <p v-html="product.product_details2"></p>
        </div>
      </article>
      <figure v-if="product.productPic3">
        <!-- <img src="../../public/images/Sp22.jpg" alt="" /> -->
        <img :src="getImageUrl(product.productPic3)" alt="商品圖片" style="object-fit: cover; object-position: center center;" />
      </figure>
      <article v-if="product.productPic2" class="Sp_productChoice_detailsBlock3_H">
        <!-- <img src="../../public/images/Sp23.jpg" alt="" /> -->
        <img :src="getImageUrl(product.productPic2)" alt="商品圖片" style="object-fit: cover; object-position: center center;" />
        <div>
          <p>常見尺寸(容量):</p>
          <ol>
            <li>{{ product.product_details3 }}</li>
            <!-- <li>小型: 200ml (7 oz)</li>
            <li>中型: 350ml (12 oz)</li>
            <li>大型: 500ml (17 oz)</li>
            <li>特大: 750ml以上 (26 oz)</li> -->
          </ol>
        </div>
      </article>
    </section>


  <!-- 環保市集_商品頁面_相關商品 -->
  <section class="Sp_productChoice_related_H">
    <h3>相關商品</h3>
    <ol>
      <li>
        <a href="">
          <img src="../../public/images/Sp04.jpg" alt="" />
          <p>環保吸管3</p>
        </a>
      </li>
      <li>
        <a href="">
          <img src="../../public/images/Sp11.jpg" alt="" />
          <p>環保筷子1</p>
        </a>
      </li>
      <li>
        <a href="">
          <img src="../../public/images/Sp09.jpg" alt="" />
          <p>環保杯子2</p>
        </a>
      </li>
      <li>
        <a href="">
          <img src="../../public/images/Sp06.jpg" alt="" />
          <p>環保袋子2</p>
        </a>
      </li>
      <li>
        <a href="">
          <img src="../../public/images/Sp08.jpg" alt="" />
          <p>環保杯子1</p>
        </a>
      </li>
    </ol>
  </section>

  <!-- 環保市集_商品頁面_頁尾 -->
  <!-- <footer class="Fp_Footer_H">頁尾</footer> -->

<!-- 購物車成功加入彈窗 -->
<!-- <div class="cart-overlay" v-if="showCartPopup" @click="closeCartPopup"></div>
<div class="cart-success-popup" v-if="showCartPopup">
  <button class="close-btn" @click="closeCartPopup">&times;</button>
  <div class="popup-content">
    <h3>{{ num }}件商品已成功加入購物車!</h3>
    <div class="popup-buttons">
      <button @click="closeCartPopup" class="continue-shopping">繼續購物</button>
      <button @click="goToCart" class="view-cart">查看購物車</button>
    </div>
  </div>
</div> -->

  <MainFooter></MainFooter>
  </div>
</template>

<script>
import { useRouter } from 'vue-router';
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
import { ref, onMounted, onUnmounted, nextTick, computed, watch } from 'vue';
import { Navigation, Pagination, Scrollbar, A11y, Mousewheel, Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import { useRoute } from 'vue-router';
import BreadcrumbNavigation from "@/components/BreadcrumbNavigation.vue";
// import { useCounterStore } from '@/store/cart';

export default {
  name: 'ProductChoice',
  components: {
    MainHeader,
    MainFooter,
    Swiper,
    SwiperSlide
  },

  setup() {
    // const useCart = useCounterStore(); // 購物車pinia

    // 判斷是否為手機 (小於等於 430px)
    const router = useRouter();
    const route = useRoute();
    const isMobile = ref(window.innerWidth <= 430);
    const isMounted = ref(false);
    const swiperKey = ref(0);
    const thumbnailSwiper = ref(null);
    const mainImageSwiper = ref(null);
    const images = ref([]);

    const base_url = import.meta.env.VITE_AJAX_URL
    // const productId = ref(route.params.id);


    const product = ref({});
    // 測試用，將 product 註冊到 `window`
    window.product = product;

    const selectedImage = ref(images.value[0]); // 預設顯示第一張圖片
    const selectedSize = ref("");
    const selectedSizeOptions = ref("");

    const fetchProduct = async () => {
      try {
        const id = String(route.params.id);
        console.log("當前商品 ID:", id);

        const response = await fetch(`${base_url}/getAllProducts.php?id=${id}`);
        if (!response.ok) throw new Error(`HTTP 錯誤！狀態碼: ${response.status}`);

        const data = await response.json();
        // console.log("獲取的商品列表:", JSON.stringify(data, null, 2));

        const foundProduct = data.find(item => String(item.ID) === id) || {};  //  確保 `foundProduct` 不為 `undefined`
        // console.log("匹配到的商品:", JSON.stringify(foundProduct, null, 2));
        // console.log('foundProduct:', foundProduct);

        product.value = foundProduct;  //  Vue 追蹤變更

        // 確保圖片 URL 正確，避免 `null`
        images.value = [
          foundProduct.productPic1 ? `/tid103/g1/images/${foundProduct.productPic1}` : null,
          foundProduct.productPic2 ? `/tid103/g1/images/${foundProduct.productPic2}` : null,
          foundProduct.productPic3 ? `/tid103/g1/images/${foundProduct.productPic3}` : null,
          foundProduct.productPic4 ? `/tid103/g1/images/${foundProduct.productPic4}` : null,
          foundProduct.productPic5 ? `/tid103/g1/images/${foundProduct.productPic5}` : null,
        ].filter(Boolean);  // 過濾掉 `null` 值，確保 `images` 只有有效的圖片

        selectedImage.value = images.value.length > 0 ? images.value[0] : "";


        // 解析規格資訊
        selectedSizeOptions.value = foundProduct.product_details3
        ? foundProduct.product_details3.split(", ").map(size => size.trim())
        : [];


        console.log("解析後的商品規格:", selectedSizeOptions.value);

          // 監聽選擇的容量，確保正確更新
          watch(selectedSize, (newValue) => {
            console.log("選擇的容量:", newValue);
          });


        // console.log("原始的 product_details3:", foundProduct.product_details3);
        // console.log("✅ 更新 images.value:", images.value);
        // console.log(images.value[0]);

        // console.log(" 設定 product.value 後:", product.value);

      } catch (error) {
        console.error("載入商品詳情失敗:", error);
      }
    };

     // ✅ 計算價格區間
     const currentPriceRange = computed(() => {
      if (!product.value || !product.value.price) return "全部商品";

      const price = Number(product.value.salePrice);
      if (price >= 0 && price < 200) return "NT$0~$199";
      if (price >= 200 && price < 300) return "NT$200~$299";
      if (price >= 300 && price < 400) return "NT$300~$399";
      if (price >= 400 && price < 500) return "NT$400~$499";
      if (price >= 500) return "NT$500 以上";
      return "全部商品";
    });


    // const sizes = ref(['200ml', '350ml', '500ml', '750ml']);

    const num = ref(1);

    // 數量相關方法
    const incrementQuantity = () => {
      if (num.value < 99) {
        num.value++;
      }
    };

    const decrementQuantity = () => {
      if (num.value > 1) {
        num.value--;
      }
    };


    const selectImage = (image) => {
      selectedImage.value = image;
    };

    const swiperParams = ref({
      autoplay: false,
      enabled: false
    });

    // 抓取資料庫商品圖片
    const getImageUrl = (imagePath) => {
      return imagePath ? `/tid103/g1/images/${imagePath}` : '';
    };

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
      num.value++;
    };

    const decrement = () => {
      if (num.value > 0) num.value--;
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

    // const openCartPopup = () => {
    //   isCartPopupVisible.value = true;
    // };

    const closeCartPopup = () => {
      isCartPopupVisible.value = false;
    };

    const cart = ref(JSON.parse(localStorage.getItem("cart")) || []);

    // 加入購物車
    const addToCart = (isBuyNow = false) => {

      console.log(" 檢查商品資訊:", product.value);
      // 檢查 `product` 是否已經載入
      if (!product.value || !product.value.ID || !product.value.productName || !product.value.salePrice) {
        alert("🌏 商品資訊未載入，請稍候再試！");
        console.warn("🌏 商品資訊未載入:", product.value);
        return;
      }

      if (!selectedImage.value || !selectedSize.value) {
        alert("🌏 請選擇商品規格再加入購物車！");
        return;
      }

      const newProduct = {
        id: product.value.ID,
        name: product.value.productName,
        image: product.value.productPic1 ? `${product.value.productPic1}` : "",
        size: selectedSize.value,  // 使用使用者選擇的規格
        num: num.value,  // 使用者輸入的數量
        price: product.value.price,
        salePrice: product.value.salePrice,
      };

      console.log("🛒 加入購物車的商品資訊:", newProduct);

      // **取得 localStorage 內的購物車資料**
      let cart = JSON.parse(localStorage.getItem("cart")) || [];

      // **檢查商品是否已經在購物車內**
      const existingItem = cart.find(item => item.id === newProduct.id && item.size === newProduct.size);

      if (existingItem) {
        existingItem.num += num.value;
      } else {
        cart.push(newProduct);
      }


      // **更新 localStorage**
      localStorage.setItem("cart", JSON.stringify(cart));
      console.log("🛒 更新後的購物車:", cart);



       // 彈窗目前顯示不了
       if (!isBuyNow) {
        isCartPopupVisible.value = true; // 顯示彈窗
        console.log("🛒 商品已加入購物車:", newProduct);
      } else {
        // 如果是「立即購買」，跳轉到購物車
        router.push("/shop_cart");
      }
    };


    // 立即結帳功能
    const goToCheckout = () => {
      console.log("🌏 跳轉到結帳頁面...");
    router.push("/shop_cart");
    };

    // const showCartPopup = ref(false);

    // cartStore.addToCart(product.value, selectedSize.value, num.value);
    // console.log("購物車內容：", cartStore.cart);

      onMounted(async () => {
        isMounted.value = true;
        isMobile.value = window.innerWidth <= 430;

        fetchProduct();

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

        const storedCart = localStorage.getItem("cart");
        if (storedCart) {
          cart.value = JSON.parse(storedCart);
        }

      });



      // ✅ 當 `product` 更新時，確保 `priceRange` 正確變更
      // watch(product, (newProduct) => {
      //   console.log("🏷️ 商品價格範圍更新:", priceRange.value);
      // });




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
      // sizes,
      selectedSize,
      num,
      increment,
      incrementQuantity,
      decrement,
      decrementQuantity,
      cart,
      isCartPopupVisible,
      mainImageSwiper,
      setMainImageSwiper,
      // openCartPopup,
      closeCartPopup,
      goToCheckout,
      modules: [Navigation, Pagination, Scrollbar, A11y, Mousewheel, Autoplay],
      product,
      currentPriceRange,
      getImageUrl,
      selectedSizeOptions,
    };
  }
};
</script>
<style lang="scss" scoped>
// 新增必要的 SCSS 變量
// $Green_1: #304025;
// $Green_2: #5b774a;
// $Green_3: #7e9b75;
// $Yellow_1: #d0ad44;
// $Ivory_white: #f5f2e9;


.cart-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1000;
}

.cart-success-popup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #fffff0;
  padding: 2rem;
  border-radius: 8px;
  z-index: 1001;
  width: 400px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);

  .close-btn {
    position: absolute;
    right: 1rem;
    top: 1rem;
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #5b774a;

    &:hover {
      color: #d0ad44;
    }
  }

  .popup-content {
    text-align: center;
    box-shadow: none;
    width: 100%;
    background-color: none;

    h3 {
      color: #5b774a;
      margin-bottom: 1.5rem;
      font-size: 1.2rem;
    }

    .popup-buttons {
      display: flex;
      justify-content: center;
      gap: 1rem;

      button {
        padding: 0.8rem 1.5rem;
        border-radius: 4px;
        cursor: pointer;
        border: none;
        font-size: 1rem;
        transition: opacity 0.3s ease;

        &:hover {
          opacity: 0.9;
        }

        &.continue-shopping {
          background-color: #7e9b75;
          color: white;
        }

        &.view-cart {
          background-color: #d0ad44;
          color: white;
        }
      }
    }
  }
}

// 數量輸入框樣式優化
.quantity-input-group {
  display: flex;
  align-items: center;
  border: 1px solid #5b774a;
  border-radius: 4px;
  overflow: hidden;

  .quantity-input {
    width: 60px;
    text-align: center;
    border: none;
    padding: 0.5rem;
    font-size: 1rem;
    color: #5b774a;
    background: #fffff0;

    &::-webkit-inner-spin-button,
    &::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  }

  .btn-minus,
  .btn-plus {
    background: #7e9b75;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;

    &:hover {
      background: #5b774a;
    }
  }
}

</style>
