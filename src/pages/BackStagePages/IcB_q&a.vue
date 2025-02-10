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
                <tr>
                  <td class="IcB_number_H">1</td>
                  <td class="IcB_title_H">哪個是全球暖化導致的常見現象?</td>
                  <td><button class="IcB_editBtn_H" @click="openEditPopup">編輯</button></td>
                  <td>
                    <button class="IcB_deleteBtn_H" @click="openDeletePopup">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td class="IcB_number_H">2</td>
                  <td class="IcB_title_H">全球暖化對海洋造成的影響是什麼？</td>
                  <td><button class="IcB_editBtn_H" @click="openEditPopup">編輯</button></td>
                  <td>
                    <button class="IcB_deleteBtn_H" @click="openDeletePopup">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td class="IcB_number_H">3</td>
                  <td class="IcB_title_H">哪個是全球暖化的潛在生態影響？</td>
                  <td><button class="IcB_editBtn_H" @click="openEditPopup">編輯</button></td>
                  <td>
                    <button class="IcB_deleteBtn_H" @click="openDeletePopup">
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
      <BackStageSmallPopup class="IcB_addQAndAPopup_H" v-if="isAddPopupVisible">
        <span>
          <p>互動問答&nbsp;新增</p>
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

    <!-- 互動問答 編輯 -->
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
            <label for="correctAEdit">解答<input type="radio" id="correctAEdit" class="correctAEdit" name="correctEdit"></label>
          </div>
          <label for="IcB_answerAEdit_H">A選項: <input id="IcB_answerAEdit_H" class="input answer_input" type="text" /></label>
        </section>

        <section>
          <div>
            <label for="correctBEdit">解答<input type="radio" id="correctBEdit" class="correct" name="correctEdit"></label>
          </div>
          <label for="IcB_answerBEdit_H">B選項: <input id="IcB_answerBEdit_H" class="input answer_input" type="text" /></label>
        </section>

        <section>
          <div>
            <label for="correctCEdit">解答<input type="radio" id="correctCEdit" class="correct" name="correctEdit"></label>
          </div>
          <label for="IcB_answerCEdit_H">C選項: <input id="IcB_answerCEdit_H" class="input answer_input" type="text" /></label>
        </section>
      </div>
      <div>
        <button>取消</button>
        <button>儲存</button>
      </div>
    </BackStageSmallPopup>

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
    const isAddPopupVisible = ref(false);
    const isEditPopupVisible = ref(false);
    const isDeletePopupVisible = ref(false);

    const currentArticleId = ref(null);

    const openAddPopup = () => {
      isAddPopupVisible.value = true;
    };

    const openEditPopup = (id) => {
      currentArticleId.value = id;
      isEditPopupVisible.value = true;
    };

    const openDeletePopup = (id) => {
      currentArticleId.value = id;
      isDeletePopupVisible.value = true;
    };

    const closePopup = () => {
      isAddPopupVisible.value = false;
      isEditPopupVisible.value = false;
      isDeletePopupVisible.value = false;
    };

    const saveArticle = () => {
      closePopup();
    };

    const deleteArticle = () => {
      closePopup();
    };

    return {
      isAddPopupVisible,
      isEditPopupVisible,
      isDeletePopupVisible,
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
