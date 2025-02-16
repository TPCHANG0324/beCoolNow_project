<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div class="CB_tag_H">
          <h3 class="CB_titleF_H">討論板管理</h3>
          <div class="MmB_searchBar_H">
            <input id="" class="input" type="text" name="" placeholder="搜尋 文章編號 或 文章標題" v-model="searchText"/>
            <i class="fa-solid fa-magnifying-glass"></i>
          </div>
        </div>

        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>

          <!-- 主要表格：用 v-for 迭代資料庫抓到的資料 -->
          <main class="main">
            <div class="CB_TableF_H">
            <table class="CB_mainFTable_H">
              <thead>
                <tr>
                  <th class="CB_numberF_H">文章編號</th>
                  <th class="CB_memberIdF_H">會員編號</th>
                  <th class="CB_articleF_H">文章分類</th>
                  <th class="CB_topicF_H">文章標題</th>
                  <th class="CB_editDateF_H">發布日期</th>
                  <th class="CB_goTopCheckF_H">狀態</th>
                  <!-- <th class="CB_goTopCheckF_H">是否置頂</th> -->
                  <th class="CB_goOffF_H"></th>
                </tr>
              </thead>
              <tbody>
                <!-- 用 filteredArticles 來動態渲染每一筆資料 -->
                <tr v-for="article in datas" :key="article.ID">
                  <!-- 依照你資料表的欄位，對應顯示 -->
                  <td>{{ article.ID }}</td>
                  <td>{{ article.memberId }}</td>
                  <td>{{ article.category }}</td>
                  <td class="CB_content_H">{{ article.title }}</td>
                  <td>{{ article.time.split(' ')[0] }}</td>
                  <td :style="{ color: article.articleShelves ? '#545454' : 'rgba(84, 84, 84, 0.5)' }">{{ article.articleShelves? '上架':'下架' }}</td>
                  <td><button class="MmB_editBtn_H" @click="openEditPopup(article)">編輯與查看</button></td>
                </tr>
              </tbody>
            </table>
          </div>
          <Paginator :currentPage="currentP" :totalPages="totalItemCount" @page-changed="handlePageChange" />
          </main>
          
        </div>
        
        <!-- <BackStagePaginator></BackStagePaginator> -->
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

    <!-- 編輯文章的彈窗 -->
    <transition name="fade">
      <BackStageBigPopup class="SpB_editProduct_H" v-if="isEditPopupVisible">
        <span>
          <p>文章資訊&nbsp;編輯與查看</p>
          <!-- 這裡也可以加上 @click="closeEditPopup" 讓使用者點 X 就能關閉 -->
          <i class="fa-solid fa-x" @click="closeEditPopup"></i>
        </span>
        <section>
          <article class="SpB_leftBlockPopup_H">
            <div>
              <p>文章編號:&nbsp;</p>
              <p>{{ currentArticle.ID }}</p>
            </div>
            <div>
              <p>文章分類:&nbsp;</p>
              <p>{{ currentArticle.category }}</p>
            </div>
            <div>
              <p>會員編號:&nbsp;</p>
              <p>{{ currentArticle.memberId }}</p>
            </div>
            <div>
              <p>文章標題:&nbsp;</p>
              <p>{{ currentArticle.title }}</p>
            </div>
            <div>
              <p>編輯日期:&nbsp;</p>
              <p>{{ currentArticle.time.split(' ')[0] }}</p>
            </div>
          </article>
          <article class="SpB_rightBlockPopup_H">
            <div>
              <p>狀態:&nbsp;</p>
              <select v-model="currentArticle.articleShelves">
                <option :value="1">上架</option>
                <option :value="0">下架</option>
              </select>
            </div>
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

<script setup>
import { ref, onMounted, computed } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageBigPopup from '@/components/layout/BackStageLayout/BackStageBigPopup.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';
import Paginator from '@/components/paginator.vue';

const base_url = import.meta.env.VITE_AJAX_URL //環境路徑
const isEditPopupVisible = ref(false); // 控制「編輯彈窗」是否顯示
const searchText = ref(''); // 搜尋框的文字

//載入文章資料
const articles = ref([]);
const fetchData = async () => {
  try {
    const res = await fetch(base_url + '/getArticles.php');
    if (!res.ok) { //狀態碼異常的話
      throw new Error('伺服器回應狀態：' + res.status);
    }
    const data = await res.json();
    articles.value = processArticles(data.data);
    // articles.value = articles.value.reverse();
  } catch (error) {
    console.error('取得文章資料失敗:', error);
  }
};

//清除 content 帶有的 html 等等
const cleanContent = (htmlContent) => {
  // 移除所有 Base64 圖片
  const withoutImages = htmlContent.replace(/<img[^>]*>/g, '');
  // 移除所有 HTML 標籤
  const withoutTags = withoutImages.replace(/<[^>]*>/g, '');
  // 移除多餘空白
  return withoutTags.trim().replace(/\s+/g, ' ');
}
const processArticles = (articles) => {
  return articles.map(article => ({
    ...article,
    content: cleanContent(article.content), // 處理 content
  }));
};

const currentArticle = ref(null); //存儲目前開啟彈窗的內容
// 開啟編輯彈窗
const openEditPopup = (article) => {
  currentArticle.value = JSON.parse(JSON.stringify(article)); //改用深拷貝
  isEditPopupVisible.value = true;
};

//修改並存儲數據
const savePopup = async () => {
  try {
    const res = await fetch(base_url + '/deleteArticles.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        ArticleID: currentArticle.value.ID,
        shelfStatus: currentArticle.value.articleShelves
      })
    })
    const data = await res.json()
    if (data.success) {
      alert('修改成功！')
      isEditPopupVisible.value = false;
      fetchData();
    }else{
      alert(data.message)
      console.log(data)
    }

  } catch (err) {
    console.error(err)
  }
}

// 關閉編輯彈窗
const closeEditPopup = () => {
  isEditPopupVisible.value = false;
};

//篩選文章
const filteredArticles = computed(() => {
  if (!searchText.value) {
    return articles.value;
  }
  return articles.value.filter((art) => {
    return (
      String(art.ID).includes(searchText.value) ||
      String(art.title).includes(searchText.value)
    );
  });
});


//計算頁數 //一頁十則文章
const currentP = ref(1); //當前頁碼，預設 1

const totalItemCount = computed(() => {
  return Math.ceil(filteredArticles.value.length / 10);
});

//當翻頁的時候，就更新當前的頁碼
const handlePageChange = (newPage) => {
  currentP.value = newPage;
  window.scrollTo({
    top: 0, // 滾動到頂部
    behavior: 'smooth', // 平滑滾動
  });
};

//真正要渲染到頁面的文章資料
const datas = computed(() => {
  const start = (currentP.value - 1) * 10;
  const to = currentP.value * 10;
  return filteredArticles.value.slice(start, to);
})


onMounted(() => {
  fetchData();
});



// ======================================================
// 4. Popup 顯示 / 關閉 與事件
// ======================================================
const isDeletePopupVisible = ref(false);
const isCheckPopupVisible = ref(false);
const currentArticleId = ref(null);

// 關閉 popup
const closePopup = () => {
  isDeletePopupVisible.value = false;
  isCheckPopupVisible.value = false;
  currentArticleId.value = null;
};

// 更新文章
const updateArticle = async () => {
  alert(`已更新文章ID = ${currentArticleId.value}`);
  closePopup();
};
</script>
