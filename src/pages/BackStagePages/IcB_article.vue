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
                <!-- 使用 v-for 動態渲染從資料庫取得的文章資料 -->
                <tr v-for="article in articles" :key="article.ID">
                  <td class="IcB_number_H">{{ article.ID }}</td>
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
        <BackStagePaginator></BackStagePaginator>
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
            <input id="UploadPic" class="UploadPic" type="file" accept="image/*, image/svg+xml" @change="handleFileChange" />
            <div class="preview">
              <p>圖片預覽</p>
              <img v-if="newArticle.image" :src="newArticle.image" alt="預覽圖片" />
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
              <input id="IcB_editTopic_H" class="input" type="text" v-model="editArticle.title" />
            </label>
            <label for="IcB_editUrl_H">
              外部鏈結:
              <input id="IcB_editUrl_H" class="input" type="text" v-model="editArticle.url" />
            </label>
            <label for="IcB_editContent_H">
              內容描述:<br />
              <textarea id="IcB_editContent_H" name="IcB_editContent_H" v-model="editArticle.content"></textarea>
            </label>
          </div>
          <figure>
            <label for="UploadPicEdit">圖片:</label>
            <input id="UploadPicEdit" class="UploadPic" type="file" accept="image/*, image/svg+xml" @change="handleEditFileChange" />
            <div class="preview">
              <p>圖片預覽</p>
              <img v-if="editArticle.image" :src="editArticle.image" alt="預覽圖片" />
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
import { ref, onMounted } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageSmallPopup from '@/components/layout/BackStageLayout/BackStageSmallPopup.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';

export default {
  components: {
    BackStageSidebar,
    BackStagePaginator,
    BackStageHeader,
    BackStageSmallPopup,
    BackStageConfirmPopup,
  },
  setup() {
    // -------------------------------
    // 1. 取得文章列表（從後端 API 撈取）
    // -------------------------------
    const articles = ref([]);
    const IcB_fetchArticles = async () => {
      try {
        const response = await fetch('./php/IcB_fetchArticles.php'); 
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
      image: '',
    });
    // 用於編輯文章的表單資料
    const editArticle = ref({
      id: null,
      title: '',
      url: '',
      content: '',
      image: '',
    });

    const openAddPopup = () => {
      newArticle.value = { title: '', url: '', content: '', image: '' };
      isAddPopupVisible.value = true;
    };

    const openEditPopup = (id) => {
      currentArticleId.value = id;
      // 注意：使用資料庫中回傳的欄位名稱 (ID 與 mediaTitle)
      const articleToEdit = articles.value.find(article => article.ID === id);
      if (articleToEdit) {
        editArticle.value = { ...articleToEdit };
        isEditPopupVisible.value = true;
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

      if (isAddPopupVisible.value) {
        apiUrl = 'php/IcB_addArticle.php';
        formData.append('title', newArticle.value.title);
        formData.append('url', newArticle.value.url);
        formData.append('content', newArticle.value.content);
        formData.append('image', newArticle.value.image);
      } else if (isEditPopupVisible.value) {
        apiUrl = 'php/IcB_editArticle.php';
        formData.append('id', editArticle.value.id);
        formData.append('title', editArticle.value.title);
        formData.append('url', editArticle.value.url);
        formData.append('content', editArticle.value.content);
        // formData.append('image', editArticle.value.image);
        formData.append('image' , 'example.png');

      }
      console.log('formData:', formData);

      try {
        const response = await fetch(apiUrl, {
          method: 'POST',
          body: formData,
        });
        const result = await response.json();
        console.log(result.value);
        
        if (result.success) {
          alert('儲存成功');
          // 儲存成功後重新撈取最新資料
          await IcB_fetchArticles();
        } else {
          alert('儲存失敗：' + result.message);
        }
      } catch (error) {
        console.error('儲存文章錯誤：', error);
      }
      closePopup();
    };

    // -------------------------------
    // 4. 刪除文章
    // -------------------------------
    const deleteArticle = async () => {
      try {
        const response = await fetch(`./php/IcB_deleteArticle.php?id=${currentArticleId.value}`);
        const result = await response.json();
        if (result.success) {
          alert('刪除成功');
          await IcB_fetchArticles();
        } else {
          alert('刪除失敗：' + result.message);
        }
      } catch (error) {
        console.error('刪除文章錯誤：', error);
      }
      closePopup();
    };

    // -------------------------------
    // 5. 處理圖片上傳（將圖片轉為 base64 預覽）
    // -------------------------------
    const handleFileChange = (event) => {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          newArticle.value.image = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    };

    const handleEditFileChange = (event) => {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          editArticle.value.image = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    };

    return {
      // 文章列表
      articles,
      // Popup 與表單
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
