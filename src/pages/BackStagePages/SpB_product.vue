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
                <tr>
                  <td class="SpB_number_H">1134444</td>
                  <td>環保吸管</td>
                  <td>50</td>
                  <td>50</td>
                  <td>522</td>
                  <td>上架</td>
                  <!-- 呼叫 openEditPopup -->
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr>
                <tr>
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
                </tr>
              </tbody>
            </table>
          </main>
        </div>
        <BackStagePaginator></BackStagePaginator>
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
              <input class="input" type="text" />
            </div>
            <div>
              <p>原價:&nbsp;</p>
              <input class="input" type="number" min="0" />
            </div>

            <div>
              <p>售價:&nbsp;</p>
              <input class="input" type="number" min="0" />
            </div>
            <div>
              <p>庫存數量:&nbsp;</p>
              <input class="input" type="number" min="0" />
            </div>
          </article>
          <article class="SpB_rightBlockPopup_H">
            <div>
              <p>狀態:&nbsp;</p>
              <select>
                <option value="goTop">上架</option>
                <option value="goOff">下架</option>
              </select>
            </div>
            <figure>
              <label for="UploadPic">商品照:</label>
              <input id="UploadPic" class="UploadPic" type="file" accept="image/*, image/svg+xml" />
              <div class="preview">
                <p>圖片預覽</p>
              </div>
            </figure>
          </article>
        </section>
        <div>
          <button @click="closePopup">取消</button>
          <button @click="savePopup">儲存</button>
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
              <p>1234456</p>
            </div>
            <div>
              <p>原價:&nbsp;</p>
              <p>200</p>
            </div>
            <div>
              <p>庫存數量:&nbsp;</p>
              <p>100</p>
            </div>
            <div>
              <p>商品名稱:&nbsp;</p>
              <p>環保袋</p>
            </div>
            <div>
              <p>售價:&nbsp;</p>
              <p>200</p>
            </div>
          </article>
          <article class="SpB_rightBlockPopup_H">
            <div>
              <p>狀態:&nbsp;</p>
              <select>
                <option value="goTop">上架</option>
                <option value="goOff">下架</option>
              </select>
            </div>
            <figure>
              <label for="UploadPic">商品照:</label>
              <input id="UploadPic" class="UploadPic" type="file" accept="image/*, image/svg+xml" />
              <div class="preview">
                <p>圖片預覽</p>
              </div>
            </figure>
          </article>
        </section>
        <div>
          <button @click="closeEditPopup">取消</button>
          <button @click="savePopup">儲存</button>
        </div>
      </BackStageBigPopup>
    </transition>
  </div>
</template>

<script>
import { ref } from 'vue';
// 建議將 import 的名稱與實際用在 template 裡的名稱對應
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageBigPopup from '@/components/layout/BackStageLayout/BackStageBigPopup.vue';

export default {
  name: 'ProductManagement',
  components: {
    BackStageSidebar,
    BackStagePaginator,
    BackStageHeader,
    BackStageBigPopup,
  },
  setup() {
    // 控制「新增彈窗」是否顯示
    const isPopupVisible = ref(false);
    // 控制「編輯彈窗」是否顯示
    const isEditPopupVisible = ref(false);

    // 開啟「新增商品」彈窗
    const openAddPopup = () => {
      isPopupVisible.value = true;
    };

    // 開啟「編輯商品」彈窗
    const openEditPopup = () => {
      isEditPopupVisible.value = true;
    };

    // 關閉「新增商品」彈窗
    const closePopup = () => {
      isPopupVisible.value = false;
    };

    // 關閉「編輯商品」彈窗
    const closeEditPopup = () => {
      isEditPopupVisible.value = false;
    };

    // 模擬儲存資料 (可改成實際串接 API)
    const savePopup = () => {
      // 這裡可放對應的儲存邏輯
      alert('已儲存');
      isPopupVisible.value = false;
      // 如果「編輯」與「新增」要分開控制，也可在這裡依需求決定是否要關閉 edit popup
      // isEditPopupVisible.value = false;
    };

    return {
      isPopupVisible,
      isEditPopupVisible,
      openAddPopup,
      openEditPopup,
      closePopup,
      closeEditPopup,
      savePopup,
    };
  },
};
</script>
