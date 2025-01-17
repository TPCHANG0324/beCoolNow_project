<template>
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
                <th><button class="IcB_addBtn_H">新增</button></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="IcB_number_H">1</td>
                <td class="IcB_title_H">COP29氣候會議</td>
                <td><button class="IcB_editBtn_H">編輯</button></td>
                <td>
                  <button class="IcB_deleteBtn_H">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td class="IcB_number_H">2</td>
                <td class="IcB_title_H">TWCAE 4th臺灣氣候行動高峰論壇</td>
                <td><button class="IcB_editBtn_H">編輯</button></td>
                <td>
                  <button class="IcB_deleteBtn_H">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td class="IcB_number_H">3</td>
                <td class="IcB_title_H">氣候變遷因應法</td>
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

  <!-- 島嶼文章 新增 -->
  <BackStageSmallPopup class="IcB_addPopup_H">
    <span>
      <p>島嶼危機文章&nbsp;新增</p>
    </span>
    <div>
      <div class="IcB_addMain_H">
        <label for="IcB_addTopic_H">文章標題: <input id="IcB_addTopic_H" class="input" type="text" /></label>
        <label for="IcB_addUrl_H">外部鏈結: <input id="IcB_addUrl_H" class="input" type="text" /></label>
        <label for="IcB_addContent_H"
          >內容描述:<br /><textarea id="IcB_addContent_H" name="IcB_addContent_H"></textarea>
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
    <div>
      <button>取消</button>
      <button>儲存</button>
    </div>
  </BackStageSmallPopup>

  <!-- 島嶼文章 編輯 -->
  <BackStageSmallPopup class="IcB_editPopup_H">
    <span>
      <p>島嶼危機文章&nbsp;編輯</p>
    </span>
    <div>
      <div class="IcB_addMain_H">
        <label for="IcB_addTopic_H">文章標題: <input id="IcB_addTopic_H" class="input" type="text" /></label>
        <label for="IcB_addUrl_H">外部鏈結: <input id="IcB_addUrl_H" class="input" type="text" /></label>
        <label for="IcB_addContent_H"
          >內容描述:<br /><textarea id="IcB_addContent_H" name="IcB_addContent_H"></textarea>
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
    <div>
      <button>取消</button>
      <button>儲存</button>
    </div>
  </BackStageSmallPopup>

  <!-- 島嶼文章 刪除 -->
  <BackStageConfirmPopup class="IcB_articleDeletePopup_H">
    <span></span>
    <div>
      <h3>確定將此文章刪除嗎?</h3>
      <div>
        <button>取消</button>
        <button>確定</button>
      </div>
    </div>
  </BackStageConfirmPopup>
</template>

<script>
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import backStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageSmallPopup from '@/components/layout/BackStageLayout/BackStageSmallPopup.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';
</script>
