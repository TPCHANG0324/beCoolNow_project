<template>
  <MainHeader></MainHeader>
  <!-- 環保市集_商品頁面_主選單 -->
  <!-- <header class="Fp_Header_H">選單</header> -->

  <!-- 環保市集_商品頁面_商品購買 -->
  <section class="Sp_productChoice_H">
    <!-- 麵包屑導航 -->
    <BreadcrumbNavigation :price-range="currentPriceRange" />

    <!-- 選擇規格及數量 -->
    <section class="Sp_productChoice_top_H">
      <figure>
        <ul>
          <li><img src="../assets/images/Sp15.jpg" alt="" /></li>
          <li><img src="../assets/images/Sp16.jpg" alt="" /></li>
          <li><img src="../assets/images/Sp17.jpg" alt="" /></li>
          <li><img src="../assets/images/Sp18.jpg" alt="" /></li>
        </ul>
        <div><img src="../assets/images/Sp15.jpg" alt="" /></div>
      </figure>

      <aside class="Sp_productChoice_info_H">
        <section>
          <div>
            <h3>再生材質環保杯</h3>
            <span>NT${{ productPrice }}</span>
          </div>

          <ul>
            <li>重量僅有300g</li>
            <li>輕巧好攜帶</li>
            <li>質感必備</li>
          </ul>
        </section>

        <section>
          <p>規格</p>

          <div class="Sp_productChoice_btnGroup_H">
            <select v-model="selectedSize" class="form-select">
              <option value="" disabled>請選擇容量</option>
              <option v-for="(size, index) in sizes" :key="index" :value="size">
                {{ size }}
              </option>
            </select>
          </div>

          <div class="Sp_productChoice_inputGroup_H">
            <div class="quantity-input-group">
              <button class="btn-minus" @click="decrementQuantity">-</button>
              <input 
                v-model.number="quantity" 
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
            <button type="button" @click="addToCart">加入購物車</button>
            <button type="button">立即購買</button>
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

  
<!-- 購物車成功加入彈窗 -->
<div class="cart-overlay" v-if="showCartPopup" @click="closeCartPopup"></div>
  <div class="cart-success-popup" v-if="showCartPopup">
    <button class="close-btn" @click="closeCartPopup">&times;</button>
    <div class="popup-content">
      <h3>{{ quantity }}件商品已成功加入購物車!</h3>
      <div class="popup-buttons">
        <button @click="closeCartPopup" class="continue-shopping">繼續購物</button>
        <button @click="goToCart" class="view-cart">查看購物車</button>
      </div>
    </div>
  </div>

  <MainFooter></MainFooter>
</template>

<script>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
import BreadcrumbNavigation from '@/components/BreadcrumbNavigation.vue';
import { PRICE_RANGES } from '@/store/priceRanges.js';

export default {
  name: 'ProductChoice',
  components: {
    MainHeader,
    MainFooter,
    BreadcrumbNavigation
  },

  setup() {
    const router = useRouter();
    const showCartPopup = ref(false);
    const quantity = ref(1);
    const selectedSize = ref('');
    const sizes = ref(['200ml', '350ml', '500ml', '750ml']);
    const productPrice = ref(299);

    // 計算當前價格區間
    const currentPriceRange = computed(() => {
      const range = PRICE_RANGES.find(
        range => productPrice.value > range.min && productPrice.value <= range.max
      );
      return range ? range.value : 'NT$300以上';
    });

    // 數量相關方法
    const incrementQuantity = () => {
      if (quantity.value < 99) {
        quantity.value++;
      }
    };

    const decrementQuantity = () => {
      if (quantity.value > 1) {
        quantity.value--;
      }
    };

    const handleQuantityInput = (event) => {
      let value = parseInt(event.target.value);
      if (isNaN(value) || value < 1) {
        quantity.value = 1;
      } else if (value > 99) {
        quantity.value = 99;
      } else {
        quantity.value = value;
      }
    };

    // 購物車相關方法
    const updateCartCount = (count) => {
      const currentCount = parseInt(localStorage.getItem('cartCount')) || 0;
      const newCount = currentCount + count;
      localStorage.setItem('cartCount', newCount.toString());
      window.dispatchEvent(new Event('updateCartCount'));
    };

    const addToCart = () => {
      if (!selectedSize.value) {
        alert('請選擇商品規格');
        return;
      }

      // 建立購物車項目
      const cartItem = {
        id: Date.now(), // 臨時ID
        name: '再生材質環保杯',
        price: productPrice.value,
        size: selectedSize.value,
        quantity: quantity.value,
        image: '/assets/images/Sp15.jpg'
      };

      // 獲取現有購物車項目
      const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
      cartItems.push(cartItem);
      localStorage.setItem('cartItems', JSON.stringify(cartItems));

      // 更新購物車數量
      updateCartCount(quantity.value);
      
      // 顯示成功彈窗
      showCartPopup.value = true;
    };

    const closeCartPopup = () => {
      showCartPopup.value = false;
    };

    const goToCart = () => {
      router.push('/shop_cart');
    };

    return {
      showCartPopup,
      quantity,
      selectedSize,
      sizes,
      productPrice,
      currentPriceRange,
      incrementQuantity,
      decrementQuantity,
      handleQuantityInput,
      addToCart,
      closeCartPopup,
      goToCart
    };
  }
};
</script>
<style lang="scss">
// 新增必要的 SCSS 變量
$Green_1: #304025;
$Green_2: #5b774a;
$Green_3: #7e9b75;
$Yellow_1: #d0ad44;
$Ivory_white: #f5f2e9;

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
    color: $Green_2;

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
      color: $Green_2;
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
          background-color: $Green_3;
          color: white;
        }

        &.view-cart {
          background-color: $Yellow_1;
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
  border: 1px solid $Green_2;
  border-radius: 4px;
  overflow: hidden;

  .quantity-input {
    width: 60px;
    text-align: center;
    border: none;
    padding: 0.5rem;
    font-size: 1rem;
    color: $Green_2;
    background: $Ivory_white;

    &::-webkit-inner-spin-button,
    &::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  }

  .btn-minus,
  .btn-plus {
    background: $Green_3;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;

    &:hover {
      background: $Green_2;
    }
  }
}
</style>