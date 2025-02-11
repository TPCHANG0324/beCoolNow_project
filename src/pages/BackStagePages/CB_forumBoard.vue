<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div class="CB_tag_H">
          <h3 class="CB_titleF_H">討論板管理</h3>
          <div class="MmB_searchBar_H">
            <input
              id=""
              class="input"
              type="text"
              name=""
              placeholder="搜尋文章"
              v-model="searchText"
              @input="filterArticles"
            />
            <i class="fa-solid fa-magnifying-glass"></i>
          </div>
        </div>

        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>

          <!-- 主要表格：用 v-for 迭代資料庫抓到的資料 -->
          <main class="CB_TableF_H">
            <table class="CB_mainFTable_H">
              <thead>
                <tr>
                  <th class="CB_numberF_H">文章編號</th>
                  <th class="CB_memberIdF_H">會員編號</th>
                  <th class="CB_articleF_H">文章分類</th>
                  <th class="CB_topicF_H">標題</th>
                  <th class="CB_editDateF_H">編輯日期</th>
                  <th class="CB_goTopCheckF_H">是否置頂</th>
                  <th class="CB_goOffF_H">下架</th>
                </tr>
              </thead>
              <tbody>
                <!-- 用 filteredArticles 來動態渲染每一筆資料 -->
                <tr v-for="article in filteredArticles" :key="article.id">
                  <!-- 依照你資料表的欄位，對應顯示 -->
                  <td>{{ article.id }}</td>
                  <td>{{ article.member_id }}</td>
                  <td>{{ article.category }}</td>
                  <td class="CB_content_H">{{ article.topic }}</td>
                  <td>{{ article.edit_date }}</td>

                  <!-- 置頂 & 下架的勾選狀態也可以綁定到資料 -->
                  <td>
                    <input
                      type="checkbox"
                      :checked="article.is_top"
                      @click="goTopCheck(article.id)"
                    />
                  </td>
                  <td>
                    <input
                      type="checkbox"
                      :checked="article.is_deleted"
                      @click="deleteCheck(article.id)"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
          </main>
        </div>
        
        <BackStagePaginator></BackStagePaginator>
      </div>
    </div>

    <!-- 討論板 下架 -->
    <transition name="fade">
      <BackStageConfirmPopup class="CB_goOffForum_H" v-if="isDeletePopupVisible">
        <span></span>
        <div>
          <h3>確定將此文章下架嗎?</h3>
          <div>
            <button @click="closePopup">取消</button>
            <button @click="updateArticle">確定</button>
          </div>
        </div>
      </BackStageConfirmPopup>
    </transition>

    <!-- 討論板 置頂 -->
    <transition name="fade">
      <BackStageConfirmPopup class="CB_goTopForum_H" v-if="isCheckPopupVisible">
        <span></span>
        <div>
          <h3>確定將此文章置頂嗎?</h3>
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
import { ref, onMounted, computed } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';

export default {
  components: {
    BackStageSidebar,
    BackStagePaginator,
    BackStageHeader,
    BackStageConfirmPopup,
  },
  setup() {
    // ======================================================
    // 1. 文章資料 (從後端撈取)
    // ======================================================
    const articles = ref([]);   // 用來存放後端回傳的所有文章
    const searchText = ref(''); // 搜尋框的文字

    // ======================================================
    // 2. 建立 fetchData 函式，載入資料庫資料
    //    注意 fetchArticles.php 路徑，要與實際檔案位置對應
    // ======================================================
    const fetchData = async () => {
      try {
        const response = await fetch('fetchArticles.php');
        if (!response.ok) {
          throw new Error('伺服器回應狀態：' + response.status);
        }
        // 後端回傳 JSON：[{ id, member_id, category, ... }, ...]
        const data = await response.json();
        articles.value = data;
      } catch (error) {
        console.error('取得文章資料失敗:', error);
      }
    };

    // 元件掛載(onMounted)時呼叫 fetchData
    onMounted(() => {
      fetchData();
    });

    // ======================================================
    // 3. 搜尋 / 過濾邏輯 (可選)
    // ======================================================
    // 這裡示範最簡單的寫法：輸入 id / topic 就能搜尋
    const filteredArticles = computed(() => {
      if (!searchText.value) {
        return articles.value;
      }
      return articles.value.filter((art) => {
        // 依需求比對哪些欄位
        return (
          String(art.id).includes(searchText.value) ||
          String(art.topic).includes(searchText.value)
        );
      });
    });

    // 若要當用戶輸入時即重新過濾
    const filterArticles = () => {
      // 其實不需要任何動作，已經用 computed 自動運算
    };

    // ======================================================
    // 4. Popup 顯示 / 關閉 與事件
    // ======================================================
    const isDeletePopupVisible = ref(false);
    const isCheckPopupVisible = ref(false);
    
    // 目前要操作的文章 (例如 置頂 or 下架) 的 ID
    const currentArticleId = ref(null);

    // 置頂勾選
    const goTopCheck = (id) => {
      currentArticleId.value = id;
      isCheckPopupVisible.value = true;
    };

    // 下架勾選
    const deleteCheck = (id) => {
      currentArticleId.value = id;
      isDeletePopupVisible.value = true;
    };

    // 關閉 popup
    const closePopup = () => {
      isDeletePopupVisible.value = false;
      isCheckPopupVisible.value = false;
      currentArticleId.value = null;
    };

    // 更新文章 (示範：置頂 or 下架)
    const updateArticle = async () => {
      // TODO: 這裡你可以根據 currentArticleId.value，
      //       發送 AJAX 請求給後端，更新資料庫中該筆文章的欄位
      // 例如：updateArticles.php?type=top&id=xxx
      //       updateArticles.php?type=delete&id=xxx

      // 目前只示範前端 alert
      alert(`已更新文章ID = ${currentArticleId.value}`);
      closePopup();
    };

    return {
      articles,
      searchText,
      filterArticles,
      filteredArticles,

      isDeletePopupVisible,
      isCheckPopupVisible,
      goTopCheck,
      deleteCheck,
      closePopup,
      updateArticle,
    };
  },
};
</script>
