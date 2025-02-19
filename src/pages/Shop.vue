
<template>
  <div>
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

              >
              <!-- @click="handleProductClick(product.ID)" -->

                <div class="product-box_S">
                  <router-link :to="{name:'single-shop',params:{id:product.ID}}">
                    <img :src="`/tid103/g1/images/${product.productPic1}`" :alt="product.productName" class="product-img" />
                  </router-link>
                  <p  @click="addToCart(product)" class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <div class="product-info">
                  <h3 class="product-card-name-X">{{ product.productName }}</h3>
                  <p class="product-price">價格：NT${{ product.salePrice || product.price }}</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <MainFooter></MainFooter>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useRouter } from 'vue-router';
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';

const router = useRouter();
const products = ref([]); // 存放從後端 API 獲取的商品數據
const quantity = ref(1);

// 取得商品數據（使用 Fetch）
const fetchProducts = async () => {
  try {
    // 環境路徑變數 , 輔導老師建議用這個方法 (.env.development, .env.production )
    const base_url = import.meta.env.VITE_AJAX_URL
    const response = await fetch(`${base_url}/getAllProducts.php`);

    if (!response.ok) {
      throw new Error(`HTTP 錯誤！狀態碼: ${response.status}`);
    }

    const data = await response.json();
    // **確保 `productStatus` 轉換正確**
    products.value = data.map(product => ({
      ...product,
      productStatus: Number(product.productStatus) === 1 ? "goTop" : "goOff", // ✅ 轉換 1 ➝ "goTop"，0 ➝ "goOff"
    }));
    // products.value = data;
  } catch (error) {
    console.error('載入商品失敗:', error);
  }
};
const cartCount = ref(0);
const cartIconColor = ref('defaultColor');


onMounted(() => {
  fetchProducts();
  window.addEventListener('updateCartCount', () => {
    // 從 localStorage 取得最新購物車數量
    const count = parseInt(localStorage.getItem('cartCount')) || 0;
    // 根據 count 來變更購物車圖示顏色及顯示的數量
    cartCount.value = count;
    cartIconColor.value = count > 0 ? 'highlightColor' : 'defaultColor';
  });
});

// 點擊商品導向詳情頁
// const handleProductClick = (productId) => {
//   router.push(`/shop_product/${productId}`);
// };

// 排序與篩選
const selectedPriceRange = ref(null);
const selectedSort = ref('default');



// ✅ 轉換價格範圍，對應麵包屑
const currentPriceRange = computed(() => {
  if (!selectedPriceRange.value) return ""; // 預設顯示「全部商品」

  const ranges = {
    "0-199": "NT$0~$199",
    "200-299": "NT$200~$299",
    "300-399": "NT$300~$399",
    "400-499": "NT$400~$499",
    "500+": "NT$500 以上"
  };

  return ranges[selectedPriceRange.value] || "";
});

// ✅ 監聽價格範圍變更
watch(selectedPriceRange, (newRange) => {
  console.log("🏷️ 已選擇的價格區間:", newRange);
  console.log("📌 對應的麵包屑價格範圍:", currentPriceRange.value);
});


const filterByPrice = (range) => {
  selectedPriceRange.value = selectedPriceRange.value === range ? null : range;

  // selectedPriceRange.value = selectedPriceRange.value === range ? null : range;
  // selectedSort.value = 'default';
};

// 依據價格篩選商品
const filteredAndSortedProducts = computed(() => {
  let result = [...products.value].map(product => ({
    ...product,
    price: Number(product.salePrice) // 🚀 確保 price 是數字
  }));

  // ✅ 1️⃣ 價格篩選
  if (selectedPriceRange.value) {
    result = result.filter(product => {
      if (selectedPriceRange.value === '500+') return product.salePrice >= 500;
      const [min, max] = selectedPriceRange.value.split('-').map(Number);
      return product.salePrice >= min && product.salePrice <= max;
    });
  }

  // ✅ 1️⃣ 過濾掉 "下架" 商品
  result = result.filter(product => product.productStatus === "goTop");

   // ✅ 2️⃣ 排序
  switch (selectedSort.value) {
    case 'newest':
      result.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
      break;
    case 'oldest':
      result.sort((a, b) => new Date(a.createdAt) - new Date(b.createdAt));
      break;
    case 'priceDesc':
      result.sort((a, b) => b.salePrice - a.salePrice);
      break;
    case 'priceAsc':
      result.sort((a, b) => a.salePrice - b.salePrice);
      break;
  }

  // console.log("🟢 測試篩選後的商品:", filteredAndSortedProducts.value);
  // console.log("🟢 選擇的價格區間:", selectedPriceRange.value);
  // console.log("🟢 選擇的排序方式:", selectedSort.value);


  return result;

});
// 購物車相關方法
const updateCartCount = (count) => {
      const currentCount = parseInt(localStorage.getItem('cartCount')) || 0;
      const newCount = currentCount + count;
      localStorage.setItem('cartCount', newCount.toString());
      window.dispatchEvent(new Event('updateCartCount'));
    };


const selectedSize = ref('');
// 加入購物車
const addToCart = (product) => {

  const cartItems = JSON.parse(localStorage.getItem("cart")) || [];

  const selectedSizeOptions = product.product_details3
    ? product.product_details3.split(", ").map(size => size.trim())
    : [];

  // 決定存入的規格：
  selectedSize.value = selectedSize.value || selectedSizeOptions[0] || "未選擇";

  // 建立新的購物車項目
  const newCartItem = {
    id: product.ID,
    name: product.productName,
    price: product.salePrice,
    salePrice: product.salePrice, // 添加 salePrice 字段
    num: quantity.value, // 使用 num 替代 quantity
    image: product.productPic1, // 使用第一張圖片
    size: selectedSize.value || "未選擇" // 添加 size 字段
  };

  console.log("🔍 檢查 newCartItem:", newCartItem); // **確認數值是否正確**
  console.log("🔍 newCartItem.price (應該是數字):", typeof newCartItem.price, newCartItem.price);

  console.log(newCartItem.price);


  // 檢查商品是否已存在購物車
  const existingItem = cartItems.find(item => item.id === product.ID === newCartItem.size);

  if (existingItem) {
    existingItem.num += quantity.value; // 使用 num 替代 quantity
  } else {
    cartItems.push(newCartItem); // 如果商品不存在，新增商品
  }
    // cartItems.push({
    //   id: product.ID,
    //   name: product.productName,
    //   price: product.price,
    //   salePrice: product.salePrice,
    //   num: 1, // 數量
    //   image: product.productPic1, // 使用第一張圖片
    // });

    console.log("🔍 儲存前的購物車內容:", cartItems);
  // 更新 localStorage
  localStorage.setItem("cart", JSON.stringify(cartItems));

  console.log("🛒 購物車更新成功", cartItems);
  alert("🛒 商品已加入購物車！");
  // 更新購物車總數（此函式內部會 dispatch updateCartCount 事件）
  updateCartCount(quantity.value);
};


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
