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
                  <th><button class="IcB_addBtn_H">新增</button></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="IcB_number_H">1</td>
                  <td class="IcB_title_H">哪個是全球暖化導致的常見現象?</td>
                  <td><button class="IcB_editBtn_H">編輯</button></td>
                  <td>
                    <button class="IcB_deleteBtn_H">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td class="IcB_number_H">2</td>
                  <td class="IcB_title_H">全球暖化對海洋造成的影響是什麼？</td>
                  <td><button class="IcB_editBtn_H">編輯</button></td>
                  <td>
                    <button class="IcB_deleteBtn_H">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td class="IcB_number_H">3</td>
                  <td class="IcB_title_H">哪個是全球暖化的潛在生態影響？</td>
                  <td><button class="IcB_editBtn_H">編輯</button></td>
                  <td>
                    <button class="IcB_deleteBtn_H">
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
    <BackStageSmallPopup class="IcB_addQAndAPopup_H">
      <span>
        <p>互動問答&nbsp;新增</p>
        <i class="fa-solid fa-x"></i>
      </span>
      <div>
        <div class="IcB_addMain_H">
          <label for="IcB_question_H"
            >題目描述:<br /><textarea id="IcB_question_H" name="IcB_question_H"></textarea>
          </label>
        </div>
        <figure>
          <label for="UploadPic">圖片:</label>
          <input id="UploadPic" class="UploadPic" type="file" accept="image/*, image/svg+xml" />
          <div class="preview">
            <p>圖片預覽</p>
          </div>
        </figure>
      </div>
      <div class="IcB_answer_H">
        <label for="IcB_answerA_H">A選項: <input id="IcB_answerA_H" class="input" type="text" /></label>
        <label for="IcB_answerB_H">B選項: <input id="IcB_answerB_H" class="input" type="text" /></label>
        <label for="IcB_answerC_H">C選項: <input id="IcB_answerC_H" class="input" type="text" /></label>
      </div>
      <div>
        <button>取消</button>
        <button>儲存</button>
      </div>
    </BackStageSmallPopup>

    <!-- 互動問答 編輯 -->
    <BackStageSmallPopup class="IcB_editQAndAPopup_H">
      <span>
        <p>互動問答&nbsp;編輯</p>
        <i class="fa-solid fa-x" @click="closePopup"></i>
      </span>
      <div>
        <div class="IcB_addMain_H">
          <label for="IcB_question_H"
            >題目描述:<br /><textarea id="IcB_question_H" name="IcB_question_H"></textarea>
          </label>
        </div>
        <figure>
          <label for="UploadPic">圖片:</label>
          <input id="UploadPic" class="UploadPic" type="file" accept="image/*, image/svg+xml" />
          <div class="preview">
            <p>圖片預覽</p>
          </div>
        </figure>
      </div>
      <div class="IcB_answer_H">
        <label for="IcB_answerA_H">A選項: <input id="IcB_answerA_H" class="input" type="text" /></label>
        <label for="IcB_answerB_H">B選項: <input id="IcB_answerB_H" class="input" type="text" /></label>
        <label for="IcB_answerC_H">C選項: <input id="IcB_answerC_H" class="input" type="text" /></label>
      </div>
      <div>
        <button>取消</button>
        <button>儲存</button>
      </div>
    </BackStageSmallPopup>

    <!-- 互動問答 刪除 -->
    <BackStageConfirmPopup class="IcB_qAndaDeletePopup_H">
      <span></span>
      <div>
        <h3>確定將此題目刪除嗎?</h3>
        <div>
          <button>取消</button>
          <button>確定</button>
        </div>
      </div>
    </BackStageConfirmPopup>
  </div>
</template>

<script>
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import backStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageSmallPopup from '@/components/layout/BackStageLayout/BackStageSmallPopup.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';
</script>
