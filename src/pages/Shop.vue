
<template>
  <MainHeader></MainHeader>
  <div class="Sp-X">
    <div class="Sp-banner">
      <video autoplay muted loop playsinline>
        <source src="/src/assets/videos/recycle_shop.mp4" type="video/mp4">
      </video>
      <h1>環保市集 <br /> Eco-Friendly Shop</h1>
    </div>

    <div class="Sp-wrapper-S">
      <div class="fliter_section_S">
        <ul>
          <li
            v-for="(priceRange, index) in [
              { value: '0-199', label: 'NT$0~$199' },
              { value: '200-299', label: 'NT$200~$299' },
              { value: '300-399', label: 'NT$300~$399' },
              { value: '400-499', label: 'NT$400~$499' },
              { value: '500+', label: 'NT$500 以上' }
            ]"
            :key="index"
            :class="{ 'active': selectedPriceRange === priceRange.value }"
            @click.prevent="filterByPrice(priceRange.value)"
          >
            <a href="javascript:void(0)">{{ priceRange.label }}</a>
          </li>
        </ul>
      </div>

      <div class="Sp_container_S">
        <div class="store_title_S">
          <p class="Sp_spend_category">全部商品</p>
          <div class="select-box">
            <select v-model="selectedSort">
              <option value="default">默認排序</option>
              <option value="newest">上架時間：由新至舊</option>
              <option value="oldest">上架時間：由舊至新</option>
              <option value="priceDesc">價格：由高至低</option>
              <option value="priceAsc">價格：由低至高</option>
            </select>
          </div>
        </div>

        <div class="Sp-product_S">
          <ul class="product-grid_S">
            <li
              v-for="product in filteredAndSortedProducts"
              :key="product.ID"
              class="product-card_S"
              @click="handleProductClick(product.ID)"
            >
              <div class="product-box_S">
                <img :src="`/images/${product.productPic1}`" :alt="product.name" class="product-img" />
              </div>
              <div class="product-info">
                <h3 class="product-card-name-X">{{ product.name }}</h3>
                <p class="product-price">價格：NT${{ product.salePrice || product.price }}</p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <MainFooter></MainFooter>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';

const router = useRouter();
const products = ref([]); // 存放從後端 API 獲取的商品數據

// 取得商品數據（使用 AJAX）
const fetchProducts = () => {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', 'http://34.58.74.78/tid103/g1/php/getAllProducts.php', true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        products.value = JSON.parse(xhr.responseText);
      } catch (error) {
        console.error('解析 JSON 失敗:', error);
      }
    }
  };
  xhr.send();
};

// 頁面載入時執行 AJAX 請求
onMounted(fetchProducts);

// 點擊商品導向詳情頁
const handleProductClick = (productId) => {
  router.push(`/shop_product/${productId}`);
};

// 排序與篩選
const selectedPriceRange = ref(null);
const selectedSort = ref('default');

const filterByPrice = (range) => {
  selectedPriceRange.value = selectedPriceRange.value === range ? null : range;
  selectedSort.value = 'default';
};

// 依據價格篩選商品
const filteredAndSortedProducts = computed(() => {
  let result = [...products.value];

  // 價格篩選
  if (selectedPriceRange.value) {
    result = result.filter(product => {
      if (selectedPriceRange.value === '500+') return product.price >= 500;
      const [min, max] = selectedPriceRange.value.split('-').map(Number);
      return product.price >= min && product.price <= max;
    });
  }

  // 排序
  switch (selectedSort.value) {
    case 'newest':
      result.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
      break;
    case 'oldest':
      result.sort((a, b) => new Date(a.createdAt) - new Date(b.createdAt));
      break;
    case 'priceDesc':
      result.sort((a, b) => b.price - a.price);
      break;
    case 'priceAsc':
      result.sort((a, b) => a.price - b.price);
      break;
  }

  return result;
});
</script>
<style lang="scss" scoped>
.Sp-X {
  .fliter_section_S {
    li:hover{
      background-color: #5b774a;
      a {
        color: white;
      }
    }
    li.active {
      background-color: #5b774a;
      a {
        color: white;
      }
    }
  }
}

.product-card_S {
  cursor: pointer;
}
</style>
