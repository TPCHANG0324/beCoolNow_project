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

          <div class="Sp_productChoice_btnGroup_H">
            <select v-model="selectedSize" class="form-select" @change="selectSize">
              <option value="" disabled>請選擇容量</option>
              <option v-for="(size, index) in sizes" :key="index" :value="size">
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
              <input v-model="quantity" type="number" min="0" class="quantity-input" @input="handleInput" />

              <!-- 增加按鈕 -->
              <button class="btn-plus" @click="increment">+</button>
            </div>
            <!-- <p>數量: {{ quantity }}</p> -->
          </div>

          <div class="Sp_productChoice_buyNow_H">
            <button type="button">加入購物車</button>
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
  <MainFooter></MainFooter>
</template>

<script>
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
// import { Swiper, SwiperSlide } from 'swiper/vue';
// import { Navigation, Pagination } from 'swiper';
import BreadcrumbNavigation from '@/components/BreadcrumbNavigation.vue'
import { PRICE_RANGES } from '@/store/priceRanges.js'

export default {
  
  name: 'ProductChoiceButtonGroup',
  name: 'SizeSelector',
  components: {
    BreadcrumbNavigation
  },
  data() {
    return {
      productPrice:299,
      sizes: ['200ml', '350ml', '500ml', '750ml'], // 按鈕選項
      selectedSize: '', // 當前選中的按鈕

      quantity: 1, // 初始化數量
      // currentPriceRange: PRICE_RANGES[0].value // 新增價格區間
    };
  },
  computed: {
    currentPriceRange() {
      // 根據商品價格找到對應區間
      const range = PRICE_RANGES.find(
        range => this.productPrice > range.min && this.productPrice <= range.max
      );
      return range ? range.value : 'NT$300以上';
    },
  },
  methods: {
    selectSize(size) {
      this.selectedsizes = size; // 設定選中的按鈕
      // console.log('選擇的容量:', this.selectedSize)
      this.$emit('size-selected', size);
    },
    increment() {
      this.quantity++;
    },
    // 減少數量，不能小於 0
    decrement() {
      if (this.quantity > 0) {
        this.quantity--;
      }
    },
   // 可以新增更新價格區間的方法
   updatePriceRange(priceRange) {
      this.currentPriceRange = priceRange;}
  },
};


</script>
