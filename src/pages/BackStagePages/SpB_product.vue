<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div>
          <h3 class="product_h3">商品庫存管理</h3>
          <!-- <h3>會員管理</h3> -->
          <div class="MmB_searchBar_H">
            <input id="" class="input" type="text" name="" placeholder="搜尋商品" />
            <i class="fa-solid fa-magnifying-glass"></i>
          </div>
        </div>
        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>
          <main class="IcB_table_H">
            <table class="MmB_mainTable_H">
              <thead>
                <tr>
                  <th class="SpB_number_H">商品編號</th>
                  <th>商品名稱</th>
                  <th>原價</th>
                  <th>售價</th>
                  <th>銷售量</th>
                  <th>狀態</th>
                  <!-- 按鈕呼叫 openAddPopup -->
                  <th><button class="SpB_addBtn_H" @click="openAddPopup">新增</button></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="product in paginatedProducts" :key="product.ID">
                  <td class="SpB_number_H">{{ product.ID }}</td>
                  <td>{{ product.productName }}</td>
                  <td>{{ product.price }}</td>
                  <td>{{ product.salePrice }}</td>
                  <td>{{ product.saleCount }}</td>
                  <td :class="{'text-red': product.productStatus === 'goOff'}">{{ product.productStatus === "goTop" ? "上架" : "下架" }}</td>
                  <!-- 呼叫 openEditPopup -->
                  <td><button class="MmB_editBtn_H" @click="openEditPopup(product)">編輯與查看</button></td>
                </tr>
                <!-- <tr>
                  <td class="SpB_number_H">1134444</td>
                  <td>玻璃吸管</td>
                  <td>100</td>
                  <td>100</td>
                  <td>200</td>
                  <td>上架</td>
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr>
                <tr>
                  <td class="SpB_number_H">1134444</td>
                  <td>再生環保袋</td>
                  <td>299</td>
                  <td>249</td>
                  <td>602</td>
                  <td>上架</td>
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr> -->
              </tbody>
            </table>
          </main>
        </div>
         <!-- 分頁器元件，傳入 currentPage 與 totalPages -->
         <Paginator 
          class="paginator_H"
          :currentPage="currentPage" 
          :totalPages="totalPages" 
          @page-changed="handlePageChange" 
        />
      </div>
    </div>

    <!-- 新增商品的彈窗 -->
    <transition name="fade">
      <BackStageBigPopup class="SpB_addProduct_H" v-if="isPopupVisible">
        <span>
          <p>商品資訊&nbsp;新增</p>
          <i class="fa-solid fa-x" @click="closePopup"></i>
        </span>
        <section>
          <article class="SpB_leftBlockPopup_H">
            <div>
              <p>商品編號:&nbsp;</p>
              <input class="input" type="text" />
            </div>
            <div>
              <p>商品名稱:&nbsp;</p>
              <input v-model="newProduct.productName" class="input" type="text" />
            </div>
            <div>
              <p>原價:&nbsp;</p>
              <input v-model="newProduct.price" class="input" type="number" min="0" />
            </div>

            <div>
              <p>售價:&nbsp;</p>
              <input v-model="newProduct.salePrice" class="input" type="number" min="0" />
            </div>
            <div>
              <p>庫存數量:&nbsp;</p>
              <input v-model="newProduct.inventory" class="input" type="number" min="0" />
            </div>
          </article>
          <article class="SpB_rightBlockPopup_H">
            <div>
              <p>狀態:&nbsp;</p>
              <select v-model="newProduct.productStatus">
                <option value="goTop">上架</option>
                <option value="goOff">下架</option>
              </select>
            </div>
            <figure>
              <label for="UploadPic">商品照:</label>
              <input @change="handleImageUpload" id="UploadPic" class="UploadPic" type="file" accept="image/*, image/svg+xml" />
              <div class="preview" style="overflow: hidden;">
                <img :src="imagePreview" v-if="imagePreview" style="height: 100%; object-fit: contain;" />
                <p v-else>請選擇圖片</p>
              </div>
            </figure>
          </article>
        </section>
        <div>
          <button @click="closePopup">取消</button>
          <button @click="saveProduct">儲存</button>
        </div>
      </BackStageBigPopup>
    </transition>

    <!-- 編輯商品的彈窗 -->
    <transition name="fade">
      <BackStageBigPopup class="SpB_editProduct_H" v-if="isEditPopupVisible">
        <span>
          <p>商品資訊&nbsp;編輯與查看</p>
          <!-- 這裡也可以加上 @click="closeEditPopup" 讓使用者點 X 就能關閉 -->
          <i class="fa-solid fa-x" @click="closeEditPopup"></i>
        </span>
        <section>
          <article class="SpB_leftBlockPopup_H">
            <div>
              <p>商品編號:&nbsp;</p>
              <p>{{ editingProduct.ID }}</p>
            </div>
            <div>
              <p>商品名稱:&nbsp;</p>
              <p>{{ editingProduct.productName }}</p>
            </div>
            <div>
              <p>原價:&nbsp;</p>
              <p>{{ editingProduct.price }}</p>
            </div>
            <div>
              <p>售價:&nbsp;</p>
              <p>{{ editingProduct.salePrice }}</p>
            </div>
            <div>
              <p>庫存數量:&nbsp;</p>
              <p>{{ editingProduct.inventory }}</p>
            </div>
          </article>
          <article class="SpB_rightBlockPopup_H">
            <div>
              <p>狀態:&nbsp;</p>
              <select v-model="editingProduct.productStatus">
                <!-- @change="updateProductStatus(editingProduct)" -->
                <option value="goTop">上架</option>
                <option value="goOff">下架</option>
              </select>
            </div>
            <figure>
              <label for="UploadPic">商品照:</label>
              <input @change="uploadImage" id="UploadPic" class="UploadPic" type="file" accept="image/*, image/svg+xml" />
              <!-- @change="uploadImage" -->
              <div class="preview" style="overflow: hidden;">
                <img :src="imagePreview || `/tid103/g1/images/${editingProduct.productPic1}`" v-if="imagePreview || editingProduct.productPic1" style="height: 100%; object-fit: contain;">
                <p v-else>請選擇圖片</p>
              </div>
            </figure>
          </article>
        </section>
        <div>
          <button @click="closeEditPopup">取消</button>
          <button @click="saveEditProduct">儲存</button>
        </div>
      </BackStageBigPopup>
    </transition>
  </div>
</template>

<script>
import { ref } from 'vue';
// 建議將 import 的名稱與實際用在 template 裡的名稱對應
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageBigPopup from '@/components/layout/BackStageLayout/BackStageBigPopup.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
// 引入自訂分頁器元件（請確認此元件存在）
import Paginator from '@/components/paginator.vue';

export default {
  name: 'ProductManagement',
  components: {
    BackStageHeader,
    BackStageSidebar,
    BackStagePaginator,
    BackStageBigPopup,
    Paginator,
  },
  setup() {

    const base_url = import.meta.env.VITE_AJAX_URL
    const products = ref([]);
    const loading = ref(true);
    const error = ref(null);
    const productID = ref(null);
    const newProduct = ref({
      productName: "",
      price: 0,
      salePrice: 0,
      inventory: 0,
      saleCount:0,
      productStatus: "goOff", // 預設為下架
      image: null, // 存圖片檔案
    });


    // 獲取商品資料與排序
    const fetchProducts = async () => {
      try {
        const response = await fetch(`${base_url}/getAllProducts.php`);
        if (!response.ok) {
          throw new Error("無法取得商品資料");
        }
        let data = await response.json();

        // 🚀 **確保 productStatus 是數字，並轉換成 "goTop" / "goOff"**
        data = data.map(product => {
        const numericStatus = Number(product.productStatus); // **確保 `productStatus` 是數字**
        return {
          ...product,
          productStatus: numericStatus === 1 ? "goTop" : "goOff", // **正確轉換上下架狀態**
        };
      });

        // **商品排序：上架的排前面，然後依據 ID 由小到大**
        products.value = [...data].sort((a, b) => {
          if (a.productStatus === "goTop" && b.productStatus === "goOff") return -1;
          if (a.productStatus === "goOff" && b.productStatus === "goTop") return 1;
          return a.ID - b.ID;
        });

        // products.value = await response.json();
        console.log("✅ 轉換後的商品資料:", products.value);

      } catch (err) {
        error.value = err.message;
      } finally {
        loading.value = false;
      }
    };

    // 當元件掛載時獲取資料
    onMounted(fetchProducts);

    // 控制「新增彈窗」是否顯示
    const isPopupVisible = ref(false);
    // 控制「編輯彈窗」是否顯示
    const isEditPopupVisible = ref(false);

    const imagePreview = ref(null);


    //編輯彈窗功能待整合
    // 打開編輯彈窗
    const openEditPopup = (product) => {
      console.log("選中的商品 ID:", product.ID); // ✅ 確保正確抓取 ID
      Object.assign(editingProduct, product); // ✅ 更新當前編輯的商品資訊
      productID.value = product.ID; // ✅ 設定商品 ID
      editingProduct.productStatus = product.productStatus; // ✅ 確保 `productStatus` 是最新的

      // **確保 imagePreview 總是顯示該商品的最新 productPic1**
      // imagePreview.value = product.productPic1;
      // ✅ 預設為商品原始圖片
      imagePreview.value = `/tid103/g1/images/${product.productPic1}`;
      editingProduct.newImageFile = null; // ✅ 清空暫存圖片
      isEditPopupVisible.value = true;
    };

    // 當前編輯的商品
    const editingProduct = reactive({
      ID: null,
      productName: "",
      price: 0,
      salePrice: 0,
      saleCount: 0,
      inventory: 0,
      productStatus: "上架",
    });


    // 分頁器狀態與計算屬性
    const currentPage = ref(1);
    const itemsPerPage = 10;
    const totalPages = computed(() => Math.ceil(products.value.length / itemsPerPage));
    const paginatedProducts = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage;
      return products.value.slice(start, start + itemsPerPage);
    });
    const handlePageChange = (newPage) => {
      currentPage.value = newPage;
      window.scrollTo({ top: 0, behavior: 'smooth' });
    };



    const uploadImage = async (event) => {
      const file = event.target.files[0]; // 取得使用者選擇的檔案
      if (!file) return;

      // **1️⃣ 立即更新圖片預覽（不影響資料庫）**
      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreview.value = e.target.result; // ✅ 立即顯示新圖片（但不影響 `productPic1`）
      };
      reader.readAsDataURL(file);

      // **2️⃣ 暫存圖片檔案，等待儲存時才上傳**
      editingProduct.newImageFile = file;
    };
     // 上傳圖片並更新商品圖片路徑
    // const uploadImage = async (event) => {
    //   const file = event.target.files[0]; // 取得使用者選擇的檔案
    //   if (!file || !productID.value) {
    //     alert("商品 ID 不存在，無法上傳圖片！");
    //     return;
    //   }

    //   // 建立 FormData 物件
    //   const formData = new FormData();
    //   formData.append("image", file);
    //   formData.append("productID", productID.value); // **傳遞商品 ID**

    //   try {
    //     // 發送 API 請求
    //     const response = await fetch(`${base_url}/productUploadImage.php`, {
    //       method: "POST",
    //       body: formData,
    //     });

    //     const result = await response.json();
    //     if (result.success) {
    //       console.log("圖片上傳成功，新的圖片路徑:", result.imagePath); // ✅ 確認圖片更新
    //       imagePreview.value = result.imagePath; // 存入圖片路徑

    //       // 更新該商品的 productPic1
    //       products.value = products.value.map((p) =>
    //         p.ID === productID.value ? { ...p, productPic1: result.imagePath } : p
    //       );

    //       // 同步更新編輯中的商品
    //       editingProduct.productPic1 = result.imagePath;

    //     } else {
    //       alert("圖片上傳失敗：" + result.error);
    //     }
    //   } catch (error) {
    //     console.error("圖片上傳錯誤:", error);
    //   }
    // };

    // 編輯彈窗更新商品狀態
    // const updateProductStatus = async (product) => {
    //       const newStatus = product.status === "goTop" ? 1 : 0; // ✅ 轉換為資料庫格式 (1 or 0)
    //       const confirmMessage = newStatus === 1 ? "確定要上架此商品嗎？" : "確定要下架此商品嗎？";

    //       // 🚀 **彈出確認視窗**
    //       if (!window.confirm(confirmMessage)) {
    //         return; // **使用者取消，不執行更新**
    //       }

    //       try {
    //         const response = await fetch(`${base_url}/updateProductStatus.php`, {
    //           method: "POST",
    //           headers: { "Content-Type": "application/json" },
    //           body: JSON.stringify({ productID: product.ID, status: newStatus }),
    //         });

    //         const result = await response.json();
    //         if (result.success) {
    //           console.log(`✅ 商品 ${product.ID} 狀態更新為: ${product.status} (DB 值: ${newStatus})`);

    //           // **同步更新 `products.value`，讓 `shop.vue` 立即變更**
    //           const index = products.value.findIndex((p) => p.ID === product.ID);
    //           if (index !== -1) {
    //             products.value[index].status = product.status; // ✅ 更新商品狀態
    //           }

    //           // **確保商品重新排序**
    //           products.value = [...products.value].sort((a, b) => {
    //             if (a.status === "goTop" && b.status === "goOff") return -1;
    //             if (a.status === "goOff" && b.status === "goTop") return 1;
    //             return a.ID - b.ID;
    //           });

    //         } else {
    //           alert("❌ 狀態更新失敗：" + result.error);
    //         }
    //       } catch (error) {
    //         console.error("❌ 更新狀態錯誤:", error);
    //       }
    // };

    // 暫時關閉編輯彈窗
    // const saveEditProduct = () => {
    //   isEditPopupVisible.value = false;
    // }



    // 關閉「編輯商品」彈窗
    const closeEditPopup = () => {
      isEditPopupVisible.value = false;
      imagePreview.value = editingProduct.productPic1; // ✅ 回復為原始圖片
      resetNewProduct();
    };


    const saveEditProduct = async () => {
  if (!editingProduct.ID) {
    alert("🍂 無法儲存，缺少商品 ID！");
    return;
  }

  let updatedImagePath = editingProduct.productPic1; // 預設圖片路徑
  const newStatus = editingProduct.productStatus === "goTop" ? 1 : 0;

  // **1️⃣ 確認是否變更上下架狀態**
  const originalProduct = products.value.find((p) => p.ID === editingProduct.ID);
  if (originalProduct && originalProduct.productStatus !== editingProduct.productStatus) {
    const confirmMessage = newStatus === 1 ? "確定要上架此商品嗎？" : "確定要下架此商品嗎？";
    if (!window.confirm(confirmMessage)) {
      return;
    }
  }

  // **2️⃣ 如果有選擇新圖片，先上傳圖片**
  if (editingProduct.newImageFile) {
    const formData = new FormData();
    formData.append("image", editingProduct.newImageFile);
    formData.append("productID", editingProduct.ID);

    try {
      const response = await fetch(`${base_url}/productUploadImage.php`, {
        method: "POST",
        body: formData,
      });

      const result = await response.json();
      if (result.success) {
        console.log("☘️ 圖片上傳成功，新的圖片路徑:", result.imagePath);
        updatedImagePath = result.imagePath;
      } else {
        alert("🍂 圖片上傳失敗：" + result.error);
        return;
      }
    } catch (error) {
      console.error("🍂 圖片上傳錯誤:", error);
      return;
    }
  }

  // **3️⃣ 統一更新商品資訊**
  try {
    const response = await fetch(`${base_url}/updateProductStatus.php`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        productID: editingProduct.ID,
        productStatus: newStatus,
        productPic1: updatedImagePath,
      }),
    });

    const result = await response.json();
    if (result.success) {
      alert("☘️ 商品更新成功！");

      // **4️⃣ 即時更新前端畫面**
      const index = products.value.findIndex((p) => p.ID === editingProduct.ID);
      if (index !== -1) {
        products.value[index] = {
          ...editingProduct,
          productStatus: newStatus === 1 ? "goTop" : "goOff", // ✅ 確保顯示正確的上下架文字
          productPic1: updatedImagePath,
        };
      }

      // **5️⃣ 確保商品排序**
      products.value = [...products.value].sort((a, b) => {
        if (a.productStatus === "goTop" && b.productStatus === "goOff") return -1;
        if (a.productStatus === "goOff" && b.productStatus === "goTop") return 1;
        return a.ID - b.ID;
      });

      closeEditPopup(); // **關閉彈窗**
    } else {
      alert("🍂 商品更新失敗：" + result.error);
    }
  } catch (error) {
    console.error("🍂 更新錯誤:", error);
  }
};














    // 開啟「新增商品」彈窗
    const openAddPopup = () => {
      console.log("🟢 開啟新增商品彈窗");
      console.log("🟢 初始 newProduct:", newProduct.value);
      isPopupVisible.value = true;
    };

    // 關閉「新增商品」彈窗
    const closePopup = () => {
      // **重置 newProduct，確保下一次打開彈窗時是全新狀態**
      Object.assign(newProduct, {
        productName: "",
        price: 0,
        salePrice: 0,
        inventory: 0,
        productStatus: "goOff", // ✅ 預設回「下架」
        productPic1: null,
      });
      imagePreview.value = null; // ✅ 清除圖片預覽
      isPopupVisible.value = false;
    };

    // 新增商品彈窗儲存按鈕
    const saveProduct = async () => {

    // **驗證輸入**
    if (!newProduct.value.productName || newProduct.value.price <= 0) {
      alert("請填寫完整商品資訊");
      return;
    }

    // **建立 FormData**
    const formData = new FormData();
    formData.append("productName", newProduct.value.productName);
    formData.append("price", newProduct.value.price);
    formData.append("salePrice", newProduct.value.salePrice);
    formData.append("inventory", newProduct.value.inventory);
    formData.append("productStatus", newProduct.value.productStatus === "goTop" ? 1 : 0); // ✅ 轉換為數字
    if (newProduct.value.image) {
      formData.append("image", newProduct.value.image);
    } else {
      console.warn("⚠️ 未選擇圖片！");
    }

     // ✅ **Console 顯示 FormData 內容**
    for (let pair of formData.entries()) {
      console.log("📦 FormData:", pair[0], pair[1]);
    }

    try {
      const response = await fetch(`${base_url}/addProduct.php`, {
        method: "POST",
        body: formData,
      });

      const result = await response.json();
      if (result.success) {
        alert("☘️ 商品新增成功！");

        // **更新商品列表**
        products.value.push({
          ID: result.newID,
          productName: newProduct.value.productName,
          price: newProduct.value.price,
          salePrice: newProduct.value.salePrice,
          saleCount: 0, // 預設為 0，讓畫面立即顯示
          inventory: newProduct.value.inventory,
          productPic1: result.imagePath || null, // 圖片路徑
          productStatus: newProduct.value.productStatus,
        });
        resetNewProduct(); // 清空輸入欄位 & 圖片
        closePopup();
      } else {
        alert("🍂 商品新增失敗：" + result.error);
      }
    } catch (error) {
      console.error("🍂 新增商品錯誤:", error);
      alert("🍂 無法連線到伺服器");
    }
    };

    // 新增商品彈窗 圖片預覽功能
    const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (!file) {
      console.warn("🌏 未選擇圖片");
      return;
    }

    newProduct.value.image = file;

    // 圖片預覽
    const reader = new FileReader();
    reader.onload = () => {
      imagePreview.value = reader.result;
    };
    reader.readAsDataURL(file);

    console.log("🌏 選擇的圖片:", newProduct.value.image);
    };

    // **重置表單**
    const resetNewProduct = () => {
      newProduct.value = {
        productName: "",
        price: 0,
        salePrice: 0,
        inventory: 0,
        productStatus: "goOff",
        image: null,
      };
      imagePreview.value = null;
    };



    // 模擬儲存資料 (可改成實際串接 API)
    // const saveProduct = () => {
    //   // 這裡可放對應的儲存邏輯
    //   alert('已儲存');
    //   isPopupVisible.value = false;
    //   // 如果「編輯」與「新增」要分開控制，也可在這裡依需求決定是否要關閉 edit popup
    //   // isEditPopupVisible.value = false;
    // };



    return {
      paginatedProducts,
      currentPage,
      itemsPerPage,
      totalPages,
      handlePageChange,
      isPopupVisible,
      isEditPopupVisible,
      openAddPopup,
      openEditPopup,
      closePopup,
      closeEditPopup,
      // savePopup,
      products,
      fetchProducts,
      editingProduct,
      imagePreview,
      productID,
      uploadImage, // 編輯彈窗 照片變更
      // updateProductStatus, // 編輯彈窗 商品狀態更新
      newProduct,
      saveProduct,
      saveEditProduct, // 暫時關閉編輯彈窗
      handleImageUpload,
    };
  },
};
</script>

<style lang="scss" scoped>
.SpB_leftBlockPopup_H {
  div{
    &:last-of-type{
      justify-content: left;
    }
  }
}

.text-red {
  color: red;
  font-weight: bold;
}
</style>
