<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div class="CB_tag_H">
          <h3 class="CB_titleM_H">留言板管理</h3>
          <div class="CB_searchBar_H">
            <div>
              <input id="" class="input" type="text" name="" placeholder="搜尋文章編號" />
              <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div>
              <input id="" class="input" type="text" name="" placeholder="關鍵字" />
              <i class="fa-solid fa-magnifying-glass"></i>
            </div>
          </div>
        </div>
        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>
          <main class="CB_TableM_H">
            <table class="CB_mainMTable_H">
              <thead>
                <tr>
                  <th class="CB_numberM_H">文章編號</th>
                  <th class="CB_memberIdM_H">會員編號</th>
                  <th class="CB_contentM_H">內容</th>
                  <th class="CB_editDateM_H">編輯日期</th>
                  <th class="CB_report_H">被檢舉數量</th>
                  <th class="CB_goOffM_H">下架</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>113122101</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td>0</td>
                  <td><input type="checkbox" @click="deleteArticle"/></td>
                  <th><button class="CB_buttonM_H" @click="openPopup">查看</button></th>
                </tr>
                <tr>
                  <td>2</td>
                  <td>113122101</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td>0</td>
                  <td><input type="checkbox" @click="deleteArticle"/></td>
                  <th><button class="CB_buttonM_H" @click="openPopup">查看</button></th>
                </tr>
                <tr>
                  <td>3</td>
                  <td>113122101</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td>0</td>
                  <td><input type="checkbox" @click="deleteArticle"/></td>
                  <th><button class="CB_buttonM_H" @click="openPopup">查看</button></th>
                </tr>
                <tr>
                  <td>4</td>
                  <td>113122101</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td>0</td>
                  <td><input type="checkbox" @click="deleteArticle"/></td>
                  <th><button class="CB_buttonM_H" @click="openPopup">查看</button></th>
                </tr>
                <tr>
                  <td>5</td>
                  <td>113122101</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td>0</td>
                  <td><input type="checkbox" @click="deleteArticle"/></td>
                  <th><button class="CB_buttonM_H" @click="openPopup">查看</button></th>
                </tr>
                <tr>
                  <td>6</td>
                  <td>113122101</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td>0</td>
                  <td><input type="checkbox" @click="deleteArticle"/></td>
                  <th><button class="CB_buttonM_H" @click="openPopup">查看</button></th>
                </tr>
                <tr>
                  <td>7</td>
                  <td>113122101</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td>0</td>
                  <td><input type="checkbox" @click="deleteArticle"/></td>
                  <th><button class="CB_buttonM_H" @click="openPopup">查看</button></th>
                </tr>
                <tr>
                  <td>8</td>
                  <td>113122101</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td>0</td>
                  <td><input type="checkbox" @click="deleteArticle"/></td>
                  <th><button class="CB_buttonM_H" @click="openPopup">查看</button></th>
                </tr>
                <tr>
                  <td>9</td>
                  <td>113122101</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td>0</td>
                  <td><input type="checkbox" @click="deleteArticle"/></td>
                  <th><button class="CB_buttonM_H" @click="openPopup">查看</button></th>
                </tr>
              </tbody>
            </table>
          </main>
        </div>
        <BackStagePaginator></BackStagePaginator>
      </div>
    </div>

    <!-- 留言板 下架 -->
     <transition name="fade">
       <BackStageConfirmPopup class="CB_goOffMessage_H" v-if="isPopupVisible">
         <span></span>
         <div>
           <h3>確定將此留言下架嗎?</h3>
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
  components: {
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

    const updateArticle = () => {
      alert('已下架');
      isPopupVisible.value = false;
    };

    const deleteArticle = () => {
      alert('已刪除');
    };

    return {
      isPopupVisible,
      openPopup,
      closePopup,
      updateArticle,
      deleteArticle,
    };
  },
};
</script>
