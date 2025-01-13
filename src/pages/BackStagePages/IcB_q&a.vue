<template>
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
</template>

<script>
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import backStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
</script>
