<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <h3>互動問答管理</h3>
        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>
          <main class="IcB_table_H">
            <table class="IcB_mainTable_H">
              <thead>
                <tr>
                  <th>編號</th>
                  <th>題目</th>
                  <th></th>
                  <th><button class="IcB_addBtn_H" @click="openAddPopup">新增</button></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(qna, index) in qnas" :key="qna.ID">
                  <td class="IcB_number_H">{{ index + 1 }}</td>
                  <td class="IcB_title_H">{{  qna.question}}?</td>
                  <td><button class="IcB_editBtn_H" @click="openEditPopup(qna.ID)">編輯</button></td>
                  <td>
                    <button class="IcB_deleteBtn_H" @click="openDeletePopup(qna.ID)">
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
    <!-- 互動問答 新增 -->
    <transition name="fade">
      <BackStageSmallPopup class="IcB_addQAndAPopup_H" v-if="isAddPopupVisible">
        <span>
          <p>互動問答&nbsp;新增</p>
          <i class="fa-solid fa-x" @click="closePopup"></i>
        </span>
        <div>
          <div class="IcB_addMain_H">
            <label for="IcB_question_H">題目描述:<br>
              <textarea id="IcB_question_H" name="IcB_question_H" v-model="editQnA.question"></textarea>
            </label>
          </div>
        </div>
        <div class="IcB_answer_H">
          <section>
            <div>
              <label for="correctA">解答<input type="radio" id="correctA" class="correct" name="correct"></label>
            </div>
            <label for="IcB_answerA_H">A選項: <input id="IcB_answerA_H" class="input answer_input" type="text" /></label>
          </section>

          <section>
            <div>
              <label for="correctB">解答<input type="radio" id="correctB" class="correct" name="correct"></label>
            </div>
            <label for="IcB_answerB_H">B選項: <input id="IcB_answerB_H" class="input answer_input" type="text" /></label>
          </section>

          <section>
            <div>
              <label for="correctC">解答<input type="radio" id="correctC" class="correct" name="correct"></label>
            </div>
            <label for="IcB_answerC_H">C選項: <input id="IcB_answerC_H" class="input answer_input" type="text" /></label>
          </section>

        </div>
        <div>
          <button>取消</button>
          <button>儲存</button>
        </div>
      </BackStageSmallPopup>
    </transition>

    <!-- 互動問答 編輯 -->
    <transition name="fade">
      <BackStageSmallPopup class="IcB_editQAndAPopup_H" v-if="isEditPopupVisible">
        <span>
          <p>互動問答&nbsp;編輯</p>
          <i class="fa-solid fa-x" @click="closePopup"></i>
        </span>
        <div>
          <div class="IcB_addMain_H">
            <label for="IcB_question_H">題目描述:<br /><textarea id="IcB_question_H" name="IcB_question_H"></textarea>
            </label>
          </div>
        </div>
        <div class="IcB_answer_H">

          <section>
            <div>
              <label for="correctAEdit">解答<input type="radio" id="correctAEdit" class="correctAEdit"
                  name="correctEdit"></label>
            </div>
            <label for="IcB_answerAEdit_H">A選項: <input id="IcB_answerAEdit_H" class="input answer_input"
                type="text" /></label>
          </section>

          <section>
            <div>
              <label for="correctBEdit">解答<input type="radio" id="correctBEdit" class="correct"
                  name="correctEdit"></label>
            </div>
            <label for="IcB_answerBEdit_H">B選項: <input id="IcB_answerBEdit_H" class="input answer_input"
                type="text" /></label>
          </section>

          <section>
            <div>
              <label for="correctCEdit">解答<input type="radio" id="correctCEdit" class="correct"
                  name="correctEdit"></label>
            </div>
            <label for="IcB_answerCEdit_H">C選項: <input id="IcB_answerCEdit_H" class="input answer_input"
                type="text" /></label>
          </section>
        </div>
        <div>
          <button>取消</button>
          <button>儲存</button>
        </div>
      </BackStageSmallPopup>
    </transition>

    <!-- 互動問答 刪除 -->
    <transition name="fade">
      <BackStageConfirmPopup class="IcB_qAndaDeletePopup_H" v-if="isDeletePopupVisible">
        <span></span>
        <div>
          <h3>確定將此題目刪除嗎?</h3>
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
import { ref } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import backStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageSmallPopup from '@/components/layout/BackStageLayout/BackStageSmallPopup.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';

export default {
  components: {
    BackStageSidebar,
    backStagePaginator,
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
        // 環境路徑變數 , 輔導老師建議用這個方法 (.env.development, .env.production )
        const base_url = import.meta.env.VITE_AJAX_URL
        const response = await fetch(base_url + '/IcBqna_fetch.php'); 
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
      IcBqna_fetch();
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
  console.log('openAddPopup triggered');
  newArticle.value = { title: '', url: '', content: '', image: '' };
  isAddPopupVisible.value = true;
  console.log('isAddPopupVisible:', isAddPopupVisible.value);
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
  const base_url = import.meta.env.VITE_AJAX_URL; // 若有設定環境變數，或直接寫成相對/絕對路徑

  if (isAddPopupVisible.value) {
    apiUrl = base_url + '/IcB_addArticle.php';
    formData.append('title', newArticle.value.title);
    formData.append('url', newArticle.value.url);
    formData.append('content', newArticle.value.content);
    // 如果有選取檔案就送出檔案物件
    if (newArticle.value.imageFile) {
      formData.append('image', newArticle.value.imageFile);
    }
  } else if (isEditPopupVisible.value) {
    apiUrl = base_url + '/IcB_editArticle.php';
    formData.append('id', editArticle.value.id);
    formData.append('title', editArticle.value.title);
    formData.append('url', editArticle.value.url);
    formData.append('content', editArticle.value.content);
    if (editArticle.value.imageFile) {
      formData.append('image', editArticle.value.imageFile);
    } else {
      // 如果沒有更新圖片，則可以傳送原本的圖片路徑
      formData.append('image', editArticle.value.image);
    }
  }

  try {
    const response = await fetch(apiUrl, {
      method: 'POST',
      body: formData,
    });
    const result = await response.json();
    console.log(result);
    
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
        const base_url = import.meta.env.VITE_AJAX_URL
        const response = await fetch(base_url + `/IcB_deleteArticle.php?id=${currentArticleId.value}`);
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
    };
  },
};
</script>