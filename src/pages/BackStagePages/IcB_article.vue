<!-- 後臺 島嶼文章管理系統 -->

<template>
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
</template>

<script>
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import backStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';

</script>
