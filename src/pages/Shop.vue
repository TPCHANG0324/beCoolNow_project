
<template>
  <MainHeader></MainHeader>
  <div class="Sp-X">
    <!-- 頁面 Banner 區域 -->
    <div class="Sp-banner">
      <video autoplay muted loop playsinline>
  <source src="/src/assets/videos/recycle_shop.mp4" type="video/mp4">
</video>
      <h1>環保市集
        <br /> Eco-Friendly Shop
      </h1>
    </div>

    <div class="Sp-wrapper-S">
      <!-- 左側價格篩選區域 -->
      <div class="fliter_section_S">
        <ul>
          <li 
  v-for="(priceRange, index) in priceRanges" 
  :key="index"
  :class="{ 'active': selectedPriceRange === priceRange.value }"
  @click.prevent="filterByPrice(priceRange.value)"
>
  <a href="javascript:void(0)">{{ priceRange.label }}</a>
</li>
        </ul>
      </div>

      <!-- 右側商品容器 -->
      <div class="Sp_container_S">
        <!-- 排序選單 -->
        <div class="store_title_S">
          <p class="Sp_spend_category">{{ currentCategory }}</p>
          <div class="select-box">
            <select v-model="selectedSort" @change="sortProducts">
              <option value="default">默認排序</option>
              <option value="newest">上架時間：由新至舊</option>
              <option value="oldest">上架時間：由舊至新</option>
              <option value="priceDesc">價格：由高至低</option>
              <option value="priceAsc">價格：由低至高</option>
            </select>
          </div>
        </div>

        <!-- 商品列表 -->
        <div class="Sp-product_S">
          <ul class="product-grid_S">
            <li 
              v-for="product in filteredAndSortedProducts" 
              :key="product.id" 
                class="product-card_S"
                 @click="handleProductClick(product.id)"
                  >
              <div class="product-box_S">
                  <img :src="product.image" :alt="product.name" class="product-img" />
                  <p class="shop-add-to-cart-X" @click.stop="handleAddToCart(product.id)">加入購物車</p>
              </div>
              <div class="product-info">
                <h3 class="product-card-name-X">{{ product.name }}</h3>
                <p class="product-price">價格：NT${{ product.price }}</p>
              </div>
              <button class="shop-add-to-cart-btn_S" @click.stop="handleAddToCart(product.id)">加入購物車</button>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <MainFooter></MainFooter>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import MainHeader from '@/components/layout/MainHeader.vue'
import MainFooter from '@/components/layout/MainFooter.vue'

const router = useRouter()

// 處理商品點擊的方法
const handleProductClick = (productId) => {
  if (productId === 1) {
    router.push('/shop_product/')
  } else {
    router.push(`/shop_product/${productId}`)
  }
}

  // 處理加入購物車的方法
  const handleAddToCart = (productId) => {
  // 檢查用戶是否登入
  const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
  const userEmail = localStorage.getItem('userEmail');
  
  // 獲取或初始化購物車數據
  let cartItems = [];
  if (isLoggedIn) {
    // 如果用戶已登入，使用用戶特定的購物車
    cartItems = JSON.parse(localStorage.getItem(`cartItems_${userEmail}`) || '[]');
  } else {
    // 如果用戶未登入，使用訪客購物車
    cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
  }

  // 檢查商品是否已在購物車中
  const existingItem = cartItems.find(item => item.productId === productId);
  
  if (existingItem) {
    // 如果商品已存在，增加數量
    existingItem.quantity += 1;
  } else {
    // 如果商品不存在，添加新商品
    cartItems.push({
      productId: productId,
      quantity: 1,
      addedAt: new Date().toISOString()
    });
  }

  // 計算總數量
  const totalCount = cartItems.reduce((sum, item) => sum + item.quantity, 0);

  // 保存更新後的購物車數據
  if (isLoggedIn) {
    localStorage.setItem(`cartItems_${userEmail}`, JSON.stringify(cartItems));
  } else {
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
  }

  // 更新購物車總數
  localStorage.setItem('cartCount', totalCount.toString());

  // 觸發更新事件
  window.dispatchEvent(new Event('updateCartCount'));
}


// 導入影片
// import shopVideo from '@/assets/videos/shop.mp4'

// 導入所有圖片
import Sp15 from '@/assets/images/Sp15.jpg'
import Sp03 from '@/assets/images/Sp03.jpg'
import Sp04 from '@/assets/images/Sp04.jpg'
import Sp05 from '@/assets/images/Sp05.jpg'
import Sp06 from '@/assets/images/Sp06.jpg'
import Sp07 from '@/assets/images/Sp07.jpg'
import Sp08 from '@/assets/images/Sp08.jpg'
import Sp09 from '@/assets/images/Sp09.jpg'
import Sp10 from '@/assets/images/Sp10.jpg'
import Sp11 from '@/assets/images/Sp11.jpg'
import Sp12 from '@/assets/images/Sp12.jpg'
import Sp13 from '@/assets/images/Sp13.jpg'

// 商品資料
const products = ref([
  { id: 1, name: '再生環保杯', price: 299, image: Sp15, createdAt: '2024-02-01' },
  { id: 2, name: '環保吸管1', price: 160, image: Sp03, createdAt: '2024-01-15' },
  { id: 3, name: '環保吸管2', price: 200, image: Sp04, createdAt: '2024-02-10' },
  { id: 4, name: '環保袋子1', price: 250, image: Sp05, createdAt: '2024-01-20' },
  { id: 5, name: '環保袋子2', price: 500, image: Sp06, createdAt: '2024-02-05' },
  { id: 6, name: '環保袋子3', price: 395, image: Sp07, createdAt: '2024-01-25' },
  { id: 7, name: '環保杯子1', price: 310, image: Sp08, createdAt: '2024-02-15' },
  { id: 8, name: '環保杯子2', price: 200, image: Sp09, createdAt: '2024-01-10' },
  { id: 9, name: '環保杯子3', price: 450, image: Sp10, createdAt: '2024-02-20' },
  { id: 10, name: '環保筷子1', price: 280, image: Sp11, createdAt: '2024-01-30' },
  { id: 11, name: '環保筷子2', price: 200, image: Sp12, createdAt: '2024-02-07' },
  { id: 12, name: '環保筷子3', price: 320, image: Sp13, createdAt: '2024-01-05' }
])
// 價格區間定義
const priceRanges = [
  { value: '0-199', label: 'NT$0~$199' },
  { value: '200-299', label: 'NT$200~$299' },
  { value: '300-399', label: 'NT$300~$399' },
  { value: '400-499', label: 'NT$400~$499' },
  { value: '500+', label: 'NT$500 以上' }
]

// 響應式狀態
const selectedPriceRange = ref(null)  // 選中的價格區間
const selectedSort = ref('default')   // 選中的排序方式
// 依據選擇的價格區間，動態顯示當前分類文字
const currentCategory = computed(() => {
  // 沒有選擇價格區間時，顯示全部商品
  if (!selectedPriceRange.value) return '全部商品'
  
  // 如果是範圍式的價格，例如 "0-199"
  if (selectedPriceRange.value.includes('-')) {
    const [min, max] = selectedPriceRange.value.split('-')
    return `NT$${min}~NT$${max} 商品`
  }
  
  // 如果是 500+ 這種形式
  if (selectedPriceRange.value.endsWith('+')) {
    const num = selectedPriceRange.value.slice(0, -1)
    return `NT$${num}以上 商品`
  }
  
  // 其他情況預設回傳全部商品
  return '全部商品'
})


// 價格篩選方法
const filterByPrice = (range) => {
  // 如果點擊已選中的價格區間，則取消選擇
  if (selectedPriceRange.value === range) {
    selectedPriceRange.value = null
  } else {
    selectedPriceRange.value = range
  }
  selectedSort.value = 'default'
}

// 計算屬性：篩選和排序後的商品
const filteredAndSortedProducts = computed(() => {
  // 創建商品副本，避免直接修改原始數據
  let result = [...products.value]

  // 價格篩選
  if (selectedPriceRange.value) {
    result = result.filter(product => {
      // 特殊處理 500+ 區間
      if (selectedPriceRange.value === '500+') {
        return product.price >= 500
      }
      
      // 解析其他區間
      const [min, max] = selectedPriceRange.value.split('-').map(Number)
      return product.price >= min && product.price <= max
    })
  }

  // 排序
  switch(selectedSort.value) {
    case 'newest':
      result.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt))
      break
    case 'oldest':
      result.sort((a, b) => new Date(a.createdAt) - new Date(b.createdAt))
      break
    case 'priceDesc':
      result.sort((a, b) => b.price - a.price)
      break
    case 'priceAsc':
      result.sort((a, b) => a.price - b.price)
      break
    default:
      // 預設排序，不做變動
      break
  }

  return result
})

// 排序方法（由計算屬性處理）
const sortProducts = () => {
  // 排序邏輯已在 filteredAndSortedProducts 中實現
}
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