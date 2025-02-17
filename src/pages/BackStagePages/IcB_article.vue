<template>
  <div>
    <!-- 後臺 島嶼文章管理系統 -->
    <BackStageHeader></BackStageHeader>

    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <h3>島嶼文章管理</h3>
        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>
          <main class="IcB_table_H">
            <table class="IcB_mainTable_H">
              <thead>
                <tr>
                  <th>編號</th>
                  <th>文章標題</th>
                  <th></th>
                  <th>
                    <button class="IcB_addBtn_H" @click="openAddPopup">新增</button>
                  </th>
                </tr>
              </thead>
              <tbody>
                <!-- 使用 paginatedArticles 替代原本的 articles -->
                <tr v-for="(article, index) in paginatedArticles" :key="article.ID">
                  <td class="IcB_number_H">
                    {{ index + (currentPage - 1) * itemsPerPage + 1 }}
                  </td>
                  <td class="IcB_title_H">{{ article.mediaTitle }}</td>
                  <td>
                    <button class="IcB_editBtn_H" @click="openEditPopup(article.ID)">編輯</button>
                  </td>
                  <td>
                    <button class="IcB_deleteBtn_H" @click="openDeletePopup(article.ID)">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </main>
        </div>
        <!-- 使用自訂分頁器元件 -->
        <div class="paginator-wrapper">
          <!-- <Paginator :currentPage="currentPage" :totalPages="totalPages" @page-changed="handlePageChange" /> -->
        </div>
      </div>
    </div>

    <!-- 島嶼文章 新增 -->
    <transition name="fade">
      <BackStageSmallPopup class="IcB_addPopup_H" v-if="isAddPopupVisible" @close="closePopup">
        <span>
          <p>島嶼危機文章&nbsp;新增</p>
          <i class="fa-solid fa-x" @click="closePopup"></i>
        </span>
        <div>
          <div class="IcB_addMain_H">
            <label for="IcB_addTopic_H">
              文章標題:
              <input id="IcB_addTopic_H" class="input" type="text" v-model="newArticle.title" />
            </label>
            <label for="IcB_addUrl_H">
              外部鏈結:
              <input id="IcB_addUrl_H" class="input" type="text" v-model="newArticle.url" />
            </label>
            <label for="IcB_addContent_H">
              內容描述:<br />
              <textarea id="IcB_addContent_H" name="IcB_addContent_H" v-model="newArticle.content"></textarea>
            </label>
          </div>
          <figure>
            <label for="UploadPic">圖片:</label>
            <input id="UploadPic" class="UploadPic" type="file" accept="image/*, image/svg+xml"
              @change="handleFileChange" />
            <div class="preview">
              <img v-if="newArticle.mediaPic" :src="newArticle.mediaPic" alt="預覽圖片" />
              <!-- <p>圖片預覽</p> -->
            </div>
          </figure>
        </div>
        <div>
          <button @click="closePopup">取消</button>
          <button @click="saveArticle">儲存</button>
        </div>
      </BackStageSmallPopup>
    </transition>

    <!-- 島嶼文章 編輯 -->
    <transition name="fade">
      <BackStageSmallPopup class="IcB_editPopup_H" v-if="isEditPopupVisible" @close="closePopup">
        <span>
          <p>島嶼危機文章&nbsp;編輯</p>
          <i class="fa-solid fa-x" @click="closePopup"></i>
        </span>
        <div>
          <div class="IcB_addMain_H">
            <label for="IcB_editTopic_H">
              文章標題:
              <input id="IcB_editTopic_H" class="input" type="text" v-model="editArticle.mediaTitle" />
            </label>
            <label for="IcB_editUrl_H">
              外部鏈結:
              <input id="IcB_editUrl_H" class="input" type="text" v-model="editArticle.mediaURL" />
            </label>
            <label for="IcB_editContent_H">
              內容描述:<br />
              <textarea id="IcB_editContent_H" name="IcB_editContent_H" v-model="editArticle.mediaContents"></textarea>
            </label>
          </div>
          <figure>
            <label for="UploadPicEdit">圖片:</label>
            <input id="UploadPicEdit" class="UploadPic" type="file" accept="image/*, image/svg+xml"
              @change="handleEditFileChange" />
            <div class="preview">
              <p>圖片預覽</p>
              <img v-if="editArticle.mediaPic" :src="'/tid103/g1/php/'+editArticle.mediaPic" alt="預覽圖片" />
            </div>
          </figure>
        </div>
        <div>
          <button @click="closePopup">取消</button>
          <button @click="saveArticle">儲存</button>
        </div>
      </BackStageSmallPopup>
    </transition>

    <!-- 島嶼文章 刪除 -->
    <transition name="fade">
      <BackStageConfirmPopup class="IcB_articleDeletePopup_H" v-if="isDeletePopupVisible" @close="closePopup">
        <span></span>
        <div>
          <h3>確定將此文章刪除嗎?</h3>
          <div>
            <button @click="closePopup">取消</button>
            <button @click="deleteArticle">確定</button>
          </div>
        </div>
      </BackStageConfirmPopup>
    </transition>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageSmallPopup from '@/components/layout/BackStageLayout/BackStageSmallPopup.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';
// 引入自訂分頁器元件
import Paginator from '@/components/paginator.vue';

export default {
  components: {
    BackStageSidebar,
    BackStagePaginator,
    BackStageHeader,
    BackStageSmallPopup,
    BackStageConfirmPopup,
    Paginator,
  },
  setup() {
    // -------------------------------
    // 1. 取得文章列表（從後端 API 撈取）
    // -------------------------------
    const articles = ref([]);
    const IcB_fetchArticles = async () => {
      try {
        const base_url = import.meta.env.VITE_AJAX_URL;
        const response = await fetch(base_url + '/IcB_fetchArticles.php');
        if (!response.ok) {
          throw new Error(`伺服器回應錯誤：${response.status}`);
        }
        const data = await response.json();
        articles.value = data;
        console.log('取得文章資料成功：', articles.value);
      } catch (error) {
        console.error('取得文章資料失敗：', error);
      }
    };

    onMounted(() => {
      IcB_fetchArticles();
    });

    // -------------------------------
    // 2. Popup 顯示狀態與表單資料
    // -------------------------------
    const isAddPopupVisible = ref(false);
    const isEditPopupVisible = ref(false);
    const isDeletePopupVisible = ref(false);
    const currentArticleId = ref(null);

    // 用於新增文章的表單資料
    const newArticle = ref({
      title: '',
      url: '',
      content: '',
      mediaPic: '',
      imageFile:'',
    });
    // 用於編輯文章的表單資料
    const editArticle = ref({
      id: null,
      title: '',
      url: '',
      content: '',
      mediaPic: '',
      imageFile:'',
    });

    const openAddPopup = () => {
      console.log('openAddPopup triggered');

      newArticle.value = { title: '', url: '', content: '', mediaPic: '', imageFile: '' };
      isAddPopupVisible.value = true;
      console.log('isAddPopupVisible:', isAddPopupVisible.value);
    };

    const openEditPopup = (id) => {
      currentArticleId.value = id;
      const articleToEdit = articles.value.find(article => article.ID === id);
      if (articleToEdit) {
        console.log('編輯的文章資料：', articleToEdit);
        editArticle.value = { ...articleToEdit };
        isEditPopupVisible.value = true;
      } else {
        console.error('找不到要編輯的文章');
      }
    };
    const openDeletePopup = (id) => {
      currentArticleId.value = id;
      isDeletePopupVisible.value = true;
    };

    const closePopup = () => {
      isAddPopupVisible.value = false;
      isEditPopupVisible.value = false;
      isDeletePopupVisible.value = false;
      currentArticleId.value = null;
    };

    // -------------------------------
    // 3. 儲存文章（新增或編輯）
    // -------------------------------
    const saveArticle = async () => {
      let apiUrl = '';
      let formData = new FormData();
      const base_url = import.meta.env.VITE_AJAX_URL;

      if (isAddPopupVisible.value) {
        apiUrl = base_url + '/IcB_addArticle.php';
        formData.append('id', newArticle.value.ID);
        formData.append('title', newArticle.value.title);
        formData.append('url', newArticle.value.url);
        formData.append('content', newArticle.value.content);
        if (newArticle.value.imageFile) {
          formData.append('image', newArticle.value.imageFile);
        }
      } else if (isEditPopupVisible.value) {
        apiUrl = base_url + '/IcB_editArticle.php';
        formData.append('id', editArticle.value.ID);
        formData.append('title', editArticle.value.mediaTitle);
        formData.append('url', editArticle.value.mediaURL);
        formData.append('content', editArticle.value.mediaContents);
        if (editArticle.value.imageFile) {
          formData.append('image', editArticle.value.imageFile);
        } else {
          formData.append('image', editArticle.value.imageFile);
        }
      }

      // 除錯用：印出所有送出的資料
      for (let [key, value] of formData.entries()) {
        console.log(key, value);
      }

      try {
        const response = await fetch(apiUrl, {
          method: 'POST',
          body: formData,
        });
        const result = await response.json();
        if (result.success) {
          alert('☘️ 儲存成功');
          await IcB_fetchArticles();
        } else {
          alert('🍂 儲存失敗：' + result.message);
        }
      } catch (error) {
        console.error('🍂 儲存文章錯誤：', error);
      }
      closePopup();
    };

    // -------------------------------
    // 4. 刪除文章
    // -------------------------------
    const deleteArticle = async () => {
      try {
        const base_url = import.meta.env.VITE_AJAX_URL;
        const response = await fetch(base_url + `/IcB_deleteArticle.php?id=${currentArticleId.value}`);
        const result = await response.json();
        if (result.success) {
          alert('☘️ 刪除成功');
          await IcB_fetchArticles();
        } else {
          alert('🍂 刪除失敗：' + result.message);
        }
      } catch (error) {
        console.error('🍂 刪除文章錯誤：', error);
      }
      closePopup();
    };

    // -------------------------------
    // 5. 處理圖片上傳
    // -------------------------------
    const handleFileChange = (event) => {
      const file = event.target.files[0];
      if (file) {
        newArticle.value.imageFile = file;
        newArticle.value.mediaPic = URL.createObjectURL(file);
        console.log('圖片預覽 URL:', newArticle.value.mediaPic); // 除錯用
      }
    };

    const handleEditFileChange = (event) => {
      const file = event.target.files[0];
      if (file) {
        editArticle.value.imageFile = file;
        editArticle.value.mediaPic = URL.createObjectURL(file);
        console.log('編輯圖片預覽 URL:', editArticle.value.mediaPic); // 除錯用
      }
    };

    // -------------------------------
    // 6. 分頁器功能
    // -------------------------------
    const currentPage = ref(1);
    const itemsPerPage = 10;
    const totalPages = computed(() => Math.ceil(articles.value.length / itemsPerPage));
    const paginatedArticles = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      return articles.value.slice(start, end);
    });

    const handlePageChange = (newPage) => {
      currentPage.value = newPage;
      window.scrollTo({
        top: 0,
        behavior: 'smooth',
      });
    };

    return {
      // 文章列表與分頁
      articles,
      currentPage,
      itemsPerPage,
      totalPages,
      paginatedArticles,
      handlePageChange,
      // Popup 與表單資料
      isAddPopupVisible,
      isEditPopupVisible,
      isDeletePopupVisible,
      newArticle,
      editArticle,
      openAddPopup,
      openEditPopup,
      openDeletePopup,
      closePopup,
      saveArticle,
      deleteArticle,
      handleFileChange,
      handleEditFileChange,
    };
  },
};
</script>
