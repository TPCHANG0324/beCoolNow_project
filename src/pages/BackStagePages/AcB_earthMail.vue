<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <h3>地球信件管理</h3>
        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>
          <main class="IcB_table_H">
            <table class="IcB_mainTable_H">
              <thead>
                <tr>
                  <th class="IcB_number_H">編號</th>
                  <th class="IcB_name_H">使用者名稱</th>
                  <th class="IcB_content_H">內容</th>
                  <th class="IcB_time_H">時間</th>
                  <th></th>
                  <th></th>
                  <!-- <th><button class="IcB_addBtn_H">新增</button></th> -->
                </tr>
              </thead>
              <tbody >
                <tr>
                  <td class="IcB_number_H">1</td>
                  <td class="IcB_name_H">蟹老闆</td>
                  <td class="IcB_content_H">
                    你好！我是小明，我最喜歡在公園裡跑來跑去，也喜歡去海邊玩沙子。媽媽說，我們要愛護你，不能亂丟垃圾，也不能浪費水。
                  </td>
                  <td class="IcB_time_H">2025-01-11</td>
                  <td><button class="IcB_viewBtn_H" @click="openPopup">查看</button></td>
                  <td>
                    <button class="IcB_deleteBtn_H" @click="DeletePopup">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td class="IcB_number_H">2</td>
                  <td class="IcB_name_H">派大星</td>
                  <td class="IcB_content_H">xxxxxxxx</td>
                  <td class="IcB_time_H">2025-01-11</td>
                  <td><button class="IcB_viewBtn_H" @click="openPopup">查看</button></td>
                  <td>
                    <button class="IcB_deleteBtn_H" @click="DeletePopup">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td class="IcB_number_H">3</td>
                  <td class="IcB_name_H">海綿寶寶</td>
                  <td class="IcB_content_H">xxxxxxxx</td>
                  <td class="IcB_time_H">2025-01-11</td>
                  <td><button class="IcB_viewBtn_H" @click="openPopup">查看</button></td>
                  <td>
                    <button class="IcB_deleteBtn_H" @click="DeletePopup">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </main>
        </div>
        <BackStagePaginator></BackStagePaginator>
      </div>
    </div>

    <!-- 地球信件 刪除 -->
     <transition name="fade">
       <BackStageConfirmPopup class="AcB_DeletePopup_H" v-if="isPopupVisible">
         <span></span>
         <div>
           <h3>確定將此留言刪除嗎?</h3>
           <div>
             <button @click="closePopup">取消</button>
             <button @click="updateArticle">確定</button>
           </div>
         </div>
       </BackStageConfirmPopup>
     </transition>
  </div>
</template>

<script>
import { ref } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import backStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';

export default {
  components:{
    BackStageSidebar,
    backStagePaginator,
    BackStageHeader,
    BackStageConfirmPopup,
  },
    setup() {
      const isPopupVisible = ref(false);

      const openPopup = () => {
        isPopupVisible.value = true;
      };

      const closePopup = () => {
        isPopupVisible.value = false;
      };

      const DeletePopup = () => {
        isPopupVisible.value = true;
      };

       // 模擬刪除或更新操作
    const updateArticle = () => {
      // 這裡可以放真正的刪除或更新 API 呼叫邏輯
      alert('已刪除');
      isPopupVisible.value = false;
    };

      return{
        isPopupVisible,
        openPopup,
        closePopup,
        DeletePopup,
        updateArticle,
      };
  },
};
</script>
