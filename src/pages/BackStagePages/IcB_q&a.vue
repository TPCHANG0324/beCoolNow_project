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
                  <th>
                    <button class="IcB_addBtn_H" @click="openAddPopup">新增</button>
                  </th>
                </tr>
              </thead>
              <tbody>
                <!-- 使用 paginatedQnas 替代原本的 qnas -->
                <tr v-for="(qna, index) in paginatedQnas" :key="qna.ID">
                  <td class="IcB_number_H">
                    {{ index + (currentPage - 1) * itemsPerPage + 1 }}
                  </td>
                  <td class="IcB_title_H">{{ qna.question }}</td>
                  <td>
                    <button class="IcB_editBtn_H" @click="openEditPopup(qna.ID)">編輯</button>
                  </td>
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
        <!-- 分頁器元件 -->
        <Paginator :currentPage="currentPage" :totalPages="totalPages" @page-changed="handlePageChange" />
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
              <textarea id="IcB_question_H" name="IcB_question_H" v-model="newArticle.question"></textarea>
            </label>
          </div>
        </div>
        <div class="IcB_answer_H">
          <section>
            <div>
              <label for="correctA">
                解答
                <input type="radio" id="correctA" class="correct" name="correct" value="A" v-model="newArticle.correctAnswer">
              </label>
            </div>
            <label for="IcB_answerA_H">A選項: 
              <input v-model="newArticle.option1" id="IcB_answerA_H" class="input answer_input" type="text" />
            </label>
          </section>

          <section>
            <div>
              <label for="correctB">
                解答
                <input type="radio" id="correctB" class="correct" name="correct" value="B" v-model="newArticle.correctAnswer">
              </label>
            </div>
            <label for="IcB_answerB_H">B選項: 
              <input v-model="newArticle.option2" id="IcB_answerB_H" class="input answer_input" type="text" />
            </label>
          </section>

          <section>
            <div>
              <label for="correctC">
                解答
                <input type="radio" id="correctC" class="correct" name="correct" value="C" v-model="newArticle.correctAnswer">
              </label>
            </div>
            <label for="IcB_answerC_H">C選項: 
              <input v-model="newArticle.option3" id="IcB_answerC_H" class="input answer_input" type="text" />
            </label>
          </section>
        </div>
        <div>
          <button @click="closePopup">取消</button>
          <button @click="saveArticle">儲存</button>
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
            <label for="IcB_question_H">題目描述:<br />
              <textarea v-model="editQnA.question" id="IcB_question_H" name="IcB_question_H"></textarea>
            </label>
          </div>
        </div>
        <div class="IcB_answer_H">
          <section>
            <div>
              <label for="correctAEdit">
                解答
                <input type="radio" id="correctAEdit" class="correctAEdit" v-model="editQnA.correctAnswer" value="A" name="correctEdit">
              </label>
            </div>
            <label for="IcB_answerAEdit_H">A選項: 
              <input v-model="editQnA.option1" id="IcB_answerAEdit_H" class="input answer_input" type="text" />
            </label>
          </section>

          <section>
            <div>
              <label for="correctBEdit">
                解答
                <input type="radio" id="correctBEdit" class="correct" v-model="editQnA.correctAnswer" value="B" name="correctEdit">
              </label>
            </div>
            <label for="IcB_answerBEdit_H">B選項: 
              <input v-model="editQnA.option2" id="IcB_answerBEdit_H" class="input answer_input" type="text" />
            </label>
          </section>

          <section>
            <div>
              <label for="correctCEdit">
                解答
                <input type="radio" id="correctCEdit" class="correct" v-model="editQnA.correctAnswer" value="C" name="correctEdit">
              </label>
            </div>
            <label for="IcB_answerCEdit_H">C選項: 
              <input v-model="editQnA.option3" id="IcB_answerCEdit_H" class="input answer_input" type="text" />
            </label>
          </section>
        </div>
        <div>
          <button @click="closePopup">取消</button>
          <button @click="saveArticle">儲存</button>
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
import { ref, computed, onMounted } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import backStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageSmallPopup from '@/components/layout/BackStageLayout/BackStageSmallPopup.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';
// 引入分頁器元件
import Paginator from '@/components/paginator.vue';

export default {
  components: {
    BackStageSidebar,
    backStagePaginator,
    BackStageHeader,
    BackStageSmallPopup,
    BackStageConfirmPopup,
    Paginator,
  },
  setup() {
    // -------------------------------
    // 1. 取得問答資料（從後端 API 撈取）
    // -------------------------------
    const qnas = ref([]);

    const IcBqna_fetch = async () => {
      try {
        const base_url = import.meta.env.VITE_AJAX_URL;
        const response = await fetch(base_url + '/IcBqna_fetch.php');
        if (!response.ok) {
          throw new Error(`伺服器回應錯誤：${response.status}`);
        }
        const data = await response.json();
        qnas.value = data; // 取得問答資料
        console.log('取得問答資料成功：', qnas.value);
      } catch (error) {
        console.error('取得問答資料失敗：', error);
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

    // 用於新增問答的表單資料
    const newArticle = ref({
      question: '',
      option1: '',
      option2: '',
      option3: '',
      correctAnswer: 'A',
    });
    // 用於編輯問答的表單資料
    const editQnA = ref({
      id: null,
      question: '',
      option1: '',
      option2: '',
      option3: '',
      correctAnswer: 'A',
    });

    const openAddPopup = () => {
      console.log('openAddPopup triggered');
      newArticle.value = { question: '', option1: '', option2: '', option3: '', correctAnswer: 'A' };
      isAddPopupVisible.value = true;
      console.log('isAddPopupVisible:', isAddPopupVisible.value);
    };

    const openEditPopup = (id) => {
      const qnaToEdit = qnas.value.find(qna => qna.ID == id);
      if (qnaToEdit) {
        // 若無正確答案，預設為 "A"
        if (!qnaToEdit.answer && !qnaToEdit.correctAnswer) {
          qnaToEdit.correctAnswer = "A";
        } else if (qnaToEdit.answer && !qnaToEdit.correctAnswer) {
          qnaToEdit.correctAnswer = qnaToEdit.answer;
        }
        editQnA.value = { ...qnaToEdit };
        isEditPopupVisible.value = true;
      } else {
        console.error("找不到對應的題目, ID:", id);
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
    // 3. 儲存問答（新增或編輯）
    // -------------------------------
    const saveArticle = async () => {
      let apiUrl = '';
      let formData = new FormData();
      const base_url = import.meta.env.VITE_AJAX_URL;

      if (isAddPopupVisible.value) {
        apiUrl = base_url + '/IcBqna_addqna.php';
        formData.append('question', newArticle.value.question || "");
        formData.append('option1', newArticle.value.option1 || "");
        formData.append('option2', newArticle.value.option2 || "");
        formData.append('option3', newArticle.value.option3 || "");
        formData.append('correctAnswer', newArticle.value.correctAnswer || "A");
      } else if (isEditPopupVisible.value) {
        apiUrl = base_url + '/IcBqna_edit.php';
        formData.append('id', editQnA.value.ID || "0");
        formData.append('question', editQnA.value.question || "");
        formData.append('option1', editQnA.value.option1 || "");
        formData.append('option2', editQnA.value.option2 || "");
        formData.append('option3', editQnA.value.option3 || "");
        formData.append('answer', editQnA.value.correctAnswer || "A");
      }
      try {
        const response = await fetch(apiUrl, {
          method: 'POST',
          body: formData,
        });

        const text = await response.text();
        console.log("伺服器回應的原始文字：", text);
        const cleanedText = text.trim();

        // 嘗試解析 JSON
        let result;
        try {
          result = JSON.parse(cleanedText);
          console.log("解析後的 JSON：", result);
        } catch (error) {
          console.error("JSON 解析失敗：", error);
          console.error("原始數據：", cleanedText);
          throw new Error("伺服器返回的數據不是有效的 JSON");
        }

        if (result.success) {
          alert('儲存成功');
          await IcBqna_fetch();
        } else {
          alert('儲存失敗：' + result.message);
        }
      } catch (error) {
        console.error('儲存文章錯誤：', error);
      }
      closePopup();
    };

    // -------------------------------
    // 4. 刪除問答
    // -------------------------------
    const deleteArticle = async () => {
      try {
        const base_url = import.meta.env.VITE_AJAX_URL;
        const response = await fetch(base_url + '/IcBqna_delete.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({ id: currentArticleId.value })
        });
        const result = await response.json();
        if (result.success) {
          alert('刪除成功');
          await IcBqna_fetch();
        } else {
          alert('刪除失敗：' + result.message);
        }
      } catch (error) {
        console.error('刪除問答錯誤：', error);
      }
      closePopup();
    };

    // -------------------------------
    // 5. 分頁器功能
    // -------------------------------
    const currentPage = ref(1);
    const itemsPerPage = 10;
    const totalPages = computed(() => Math.ceil(qnas.value.length / itemsPerPage));

    const paginatedQnas = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      return qnas.value.slice(start, end);
    });

    const handlePageChange = (newPage) => {
      currentPage.value = newPage;
      window.scrollTo({
        top: 0,
        behavior: 'smooth',
      });
    };

    return {
      // 問答列表與分頁
      qnas,
      currentPage,
      itemsPerPage,
      totalPages,
      paginatedQnas,
      handlePageChange,
      // Popup 與表單資料
      isAddPopupVisible,
      isEditPopupVisible,
      isDeletePopupVisible,
      newArticle,
      editQnA,
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
