<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div>
          <h3 class="product_h3">商品庫存管理</h3>
          <!-- 搜尋區塊 -->
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
                  <th><button class="SpB_addBtn_H" @click="openAddPopup">新增</button></th>
                </tr>
              </thead>
              <tbody>
                <!-- 迭代 paginatedProducts，僅顯示本頁資料 -->
                <tr v-for="(product, index) in paginatedProducts" :key="product.ID">
                  <!-- 此處可使用 product.ID 或依分頁重新編號 -->
                  <td class="SpB_number_H">{{ product.ID }}</td>
                  <td>{{ product.productName }}</td>
                  <td>{{ product.price }}</td>
                  <td>{{ product.salePrice }}</td>
                  <td>{{ product.saleCount }}</td>
                  <td :class="{'text-red': product.status === 'goOff'}">
                    {{ product.status === "goTop" ? "上架" : "下架" }}
                  </td>
                  <td>
                    <button class="MmB_editBtn_H" @click="openEditPopup(product)">編輯與查看</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </main>
        </div>
        <!-- 使用自訂分頁器元件 -->
        <Paginator 
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
              <select v-model="newProduct.status">
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
              <select v-model="editingProduct.status">
                <option value="goTop">上架</option>
                <option value="goOff">下架</option>
              </select>
            </div>
            <figure>
              <label for="UploadPic">商品照:</label>
              <input @change="uploadImage" id="UploadPic" class="UploadPic" type="file" accept="image/*, image/svg+xml" />
              <div class="preview" style="overflow: hidden;">
                <img :src="imagePreview || `/tid103/g1/images/${editingProduct.productPic1}`" 
                     v-if="imagePreview || editingProduct.productPic1" 
                     style="height: 100%; object-fit: contain;">
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
import { ref, computed, onMounted, reactive } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageBigPopup from '@/components/layout/BackStageLayout/BackStageBigPopup.vue';
// 引入自訂分頁器元件（請確認此元件已存在）
import Paginator from '@/components/paginator.vue';

export default {
  name: 'ProductManagement',
  components: {
    BackStageSidebar,
    BackStagePaginator,
    BackStageHeader,
    BackStageBigPopup,
    Paginator,
  },
  setup() {
    const base_url = import.meta.env.VITE_AJAX_URL;
    const products = ref([]);
    const loading = ref(true);
    const error = ref(null);
    const productID = ref(null);
    const newProduct = ref({
      productName: "",
      price: 0,
      salePrice: 0,
      inventory: 0,
      saleCount: 0,
      status: "goOff", // 預設為下架
      image: null, // 存放圖片檔案
    });
    const imagePreview = ref(null);

    // 取得商品資料
    const fetchProducts = async () => {
      try {
        const response = await fetch(`${base_url}/getAllProducts.php`);
        if (!response.ok) {
          throw new Error("無法取得商品資料");
        }
        let data = await response.json();
        // 確保 status 是數字並轉換為 "goTop" / "goOff"
        data = data.map(product => {
          const numericStatus = Number(product.status);
          return {
            ...product,
            status: numericStatus === 1 ? "goTop" : "goOff",
          };
        });
        // 商品排序：上架排前面，依 ID 由小到大
        products.value = [...data].sort((a, b) => {
          if (a.status === "goTop" && b.status === "goOff") return -1;
          if (a.status === "goOff" && b.status === "goTop") return 1;
          return a.ID - b.ID;
        });
        console.log("✅ 轉換後的商品資料:", products.value);
      } catch (err) {
        error.value = err.message;
      } finally {
        loading.value = false;
      }
    };

    onMounted(fetchProducts);

    // 分頁器功能
    const currentPage = ref(1);
    const itemsPerPage = 10;
    const totalPages = computed(() => Math.ceil(products.value.length / itemsPerPage));
    const paginatedProducts = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage;
      return products.value.slice(start, start + itemsPerPage);
    });
    const handlePageChange = (newPage) => {
      currentPage.value = newPage;
      window.scrollTo({
        top: 0,
        behavior: 'smooth',
      });
    };

    // 新增商品彈窗控制
    const isPopupVisible = ref(false);
    const isEditPopupVisible = ref(false);

    // 開啟「新增商品」彈窗
    const openAddPopup = () => {
      console.log("🟢 開啟新增商品彈窗");
      isPopupVisible.value = true;
    };

    // 關閉「新增商品」彈窗並重置表單
    const closePopup = () => {
      resetNewProduct();
      imagePreview.value = null;
      isPopupVisible.value = false;
    };

    // 新增商品儲存
    const saveProduct = async () => {
      if (!newProduct.value.productName || newProduct.value.price <= 0) {
        alert("請填寫完整商品資訊");
        return;
      }
      const formData = new FormData();
      formData.append("productName", newProduct.value.productName);
      formData.append("price", newProduct.value.price);
      formData.append("salePrice", newProduct.value.salePrice);
      formData.append("inventory", newProduct.value.inventory);
      formData.append("status", newProduct.value.status === "goTop" ? 1 : 0);
      if (newProduct.value.image) {
        formData.append("image", newProduct.value.image);
      } else {
        console.warn("⚠️ 未選擇圖片！");
      }
      // 檢查 FormData 內容（除錯用）
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
          alert("✅ 商品新增成功！");
          products.value.push({
            ID: result.newID,
            productName: newProduct.value.productName,
            price: newProduct.value.price,
            salePrice: newProduct.value.salePrice,
            saleCount: 0,
            inventory: newProduct.value.inventory,
            productPic1: result.imagePath || null,
            status: newProduct.value.status,
          });
          resetNewProduct();
          closePopup();
        } else {
          alert("❌ 商品新增失敗：" + result.error);
        }
      } catch (error) {
        console.error("❌ 新增商品錯誤:", error);
        alert("❌ 無法連線到伺服器");
      }
    };

    // 新增商品圖片預覽功能
    const handleImageUpload = (event) => {
      const file = event.target.files[0];
      if (!file) {
        console.warn("⚠️ 未選擇圖片");
        return;
      }
      newProduct.value.image = file;
      const reader = new FileReader();
      reader.onload = () => {
        imagePreview.value = reader.result;
      };
      reader.readAsDataURL(file);
      console.log("🟢 選擇的圖片:", newProduct.value.image);
    };

    // 重置新增商品表單
    const resetNewProduct = () => {
      newProduct.value = {
        productName: "",
        price: 0,
        salePrice: 0,
        inventory: 0,
        status: "goOff",
        image: null,
      };
      imagePreview.value = null;
    };

    // 編輯彈窗功能
    const editingProduct = reactive({
      ID: null,
      productName: "",
      price: 0,
      salePrice: 0,
      saleCount: 0,
      inventory: 0,
      status: "goTop",
      productPic1: "",
      newImageFile: null,
    });
    const openEditPopup = (product) => {
      console.log("選中的商品 ID:", product.ID);
      Object.assign(editingProduct, product);
      productID.value = product.ID;
      editingProduct.status = product.status;
      imagePreview.value = `/tid103/g1/images/${product.productPic1}`;
      editingProduct.newImageFile = null;
      isEditPopupVisible.value = true;
    };

    const uploadImage = async (event) => {
      const file = event.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreview.value = e.target.result;
      };
      reader.readAsDataURL(file);
      editingProduct.newImageFile = file;
    };

    const closeEditPopup = () => {
      isEditPopupVisible.value = false;
      imagePreview.value = editingProduct.productPic1;
      resetNewProduct();
    };

    const saveEditProduct = async () => {
      if (!editingProduct.ID) {
        alert("❌ 無法儲存，缺少商品 ID！");
        return;
      }
      let updatedImagePath = editingProduct.productPic1;
      const newStatus = editingProduct.status === "goTop" ? 1 : 0;
      const originalProduct = products.value.find((p) => p.ID === editingProduct.ID);
      if (originalProduct && originalProduct.status !== editingProduct.status) {
        const confirmMessage = newStatus === 1 ? "確定要上架此商品嗎？" : "確定要下架此商品嗎？";
        if (!window.confirm(confirmMessage)) {
          return;
        }
      }
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
            console.log("✅ 圖片上傳成功，新的圖片路徑:", result.imagePath);
            updatedImagePath = result.imagePath;
          } else {
            alert("❌ 圖片上傳失敗：" + result.error);
            return;
          }
        } catch (error) {
          console.error("❌ 圖片上傳錯誤:", error);
          return;
        }
      }
      try {
        const response = await fetch(`${base_url}/updateProductStatus.php`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            productID: editingProduct.ID,
            status: newStatus,
            productPic1: updatedImagePath,
          }),
        });
        const result = await response.json();
        if (result.success) {
          alert("✅ 商品更新成功！");
          const index = products.value.findIndex((p) => p.ID === editingProduct.ID);
          if (index !== -1) {
            products.value[index] = {
              ...editingProduct,
              status: newStatus === 1 ? "goTop" : "goOff",
              productPic1: updatedImagePath,
            };
          }
          // 重新排序
          products.value = [...products.value].sort((a, b) => {
            if (a.status === "goTop" && b.status === "goOff") return -1;
            if (a.status === "goOff" && b.status === "goTop") return 1;
            return a.ID - b.ID;
          });
          closeEditPopup();
        } else {
          alert("❌ 商品更新失敗：" + result.error);
        }
      } catch (error) {
        console.error("❌ 更新錯誤:", error);
      }
    };

    return {
      // 商品列表與分頁器相關
      products,
      currentPage,
      itemsPerPage,
      totalPages,
      paginatedProducts,
      handlePageChange,
      // 新增 / 編輯彈窗控制與功能
      isPopupVisible,
      isEditPopupVisible,
      newProduct,
      editingProduct,
      imagePreview,
      openAddPopup,
      closePopup,
      saveProduct,
      openEditPopup,
      closeEditPopup,
      saveEditProduct,
      uploadImage,
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
