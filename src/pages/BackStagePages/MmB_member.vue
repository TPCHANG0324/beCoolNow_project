<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div>
          <h3>會員管理</h3>
          <div class="MmB_searchBar_H">
            <input class="input" type="text" placeholder="搜尋會員編號" />
            <i class="fa-solid fa-magnifying-glass"></i>
          </div>
        </div>
        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>
          <main class="IcB_table_H">
            <table class="MmB_mainTable_H">
              <thead>
                <tr>
                  <th class="MmB_number_H">會員編號</th>
                  <th class="MmB_name_H">姓名</th>
                  <th class="MmB_phone_H">手機</th>
                  <th class="MmB_mail_H">信箱</th>
                  <th class="MmB_pet_H">小寵物</th>
                  <th class="MmB_createDate_H">創建日期</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="MmB_number_H">113122101</td>
                  <td class="MmB_name_H">王小明</td>
                  <td class="MmB_phone_H">0912345678</td>
                  <td class="MmB_mail_H">tibame@gmail.com</td>
                  <td class="MmB_pet_H">氓阿狐</td>
                  <td class="MmB_createDate_H">2025-01-12</td>
                  <!-- 這裡加上 @click 事件 -->
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr>
                <tr>
                  <td class="MmB_number_H">113122102</td>
                  <td class="MmB_name_H">王小明</td>
                  <td class="MmB_phone_H">0912345678</td>
                  <td class="MmB_mail_H">tibame@gmail.com</td>
                  <td class="MmB_pet_H">氓阿狐</td>
                  <td class="MmB_createDate_H">2025-01-12</td>
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr>
                <tr>
                  <td class="MmB_number_H">113122103</td>
                  <td class="MmB_name_H">王小明</td>
                  <td class="MmB_phone_H">0912345678</td>
                  <td class="MmB_mail_H">tibame@gmail.com</td>
                  <td class="MmB_pet_H">氓阿狐</td>
                  <td class="MmB_createDate_H">2025-01-12</td>
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr>
              </tbody>
            </table>
          </main>
        </div>
        <BackStagePaginator></BackStagePaginator>
      </div>
    </div>

    <!-- 用 v-if 控制小彈窗的顯示 -->
     <transition name="fade">
    <BackStageSmallPopup class="MmB_EditView_H" v-if="isEditPopupVisible">
      <span>
        <p>編輯與查看</p>
        <!-- 關閉圖示也加上 @click 事件 -->
        <i class="fa-solid fa-x" @click="closeEditPopup"></i>
      </span>
      <section>
        <article>
          <div>
            <p>會員編號:&nbsp;</p>
            <p>113122101</p>
          </div>
          <div>
            <p>帳號:&nbsp;</p>
            <p>tibame@gmail.com</p>
          </div>
          <div>
            <p>姓名:&nbsp;</p>
            <p>黃小吉</p>
          </div>
          <div>
            <p>地址:&nbsp;</p>
            <p>臺北市中山區南京東路三段219號5樓</p>
          </div>
        </article>

        <article>
          <div>
            <p>性別:&nbsp;</p>
            <p>女</p>
          </div>
          <div>
            <p>手機:&nbsp;</p>
            <p>0912345678</p>
          </div>
          <div>
            <p>帳號狀態:&nbsp;</p>
            <select>
              <option value="normal">正常</option>
              <option value="suspend">停權</option>
            </select>
          </div>
          <div>
            <p>創建時間:&nbsp;</p>
            <p>2025-01-12</p>
          </div>
        </article>
      </section>
      <div>
        <button @click="closeEditPopup">取消</button>
        <button @click="savePopup">儲存</button>
      </div>
    </BackStageSmallPopup>
  </transition>
  </div>
</template>

<script>
import { ref } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageSmallPopup from '@/components/layout/BackStageLayout/BackStageSmallPopup.vue';

export default {
  name: 'MemberManagement',
  components: {
    BackStageHeader,
    BackStageSidebar,
    BackStagePaginator,
    BackStageSmallPopup,
  },
  setup() {
    // 用來控制小彈窗的顯示 / 隱藏
    const isEditPopupVisible = ref(false);

    // 點「編輯與查看」時，打開彈窗
    const openEditPopup = () => {
      isEditPopupVisible.value = true;
    };

    // 點 X 或「取消」時，關閉彈窗
    const closeEditPopup = () => {
      isEditPopupVisible.value = false;
    };

    // 儲存時做一些操作，比如更新會員資料、呼叫 API 等
    const savePopup = () => {
      alert('會員資料已儲存 / 更新');
      // 儲存完後關閉視窗
      isEditPopupVisible.value = false;
    };

    return {
      // 資料
      isEditPopupVisible,
      // 方法
      openEditPopup,
      closeEditPopup,
      savePopup,
    };
  },
};
</script>
