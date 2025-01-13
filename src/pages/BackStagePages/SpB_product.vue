<template>
  <BackStageHeader></BackStageHeader>
  <div class="backStage_bgc">
    <div class="backStage_wrapper">
      <div>
        <h3 class="product_h3">商品庫存管理</h3>
        <!-- <h3>會員管理</h3> -->
        <div class="MmB_searchBar_H">
          <input class="input" type="text" name="" id="" placeholder="搜尋商品">
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
      </div>
      <div class="wrapper">
        <BackStageSidebar></BackStageSidebar>
        <main class="IcB_table_H">
          <table class="MmB_mainTable_H">
            <thead>
              <tr>
                <th class="SpB_number_H">編號</th>
                <th>姓名</th>
                <th>mail</th>
                <th>手機</th>
                <th>銷售量</th>
                <th>狀態</th>
                <th><button class="SpB_addBtn_H">新增</button></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="SpB_number_H">1134444</td>
                <td>環保吸管</td>
                <td>50</td>
                <td>50</td>
                <td>522</td>
                <td>上架</td>
                <td><button class="MmB_editBtn_H">編輯與查看</button></td>
                <!-- <td>
                  <button class="IcB_deleteBtn_H">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td> -->
              </tr>
              <tr>
                <td class="SpB_number_H">1134444</td>
                <td>玻璃吸管</td>
                <td>100</td>
                <td>100</td>
                <td>200</td>
                <td>上架</td>
                <td><button class="MmB_editBtn_H">編輯與查看</button></td>
                <!-- <td>
                  <button class="IcB_deleteBtn_H">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td> -->
              </tr>
              <tr>
                <td class="SpB_number_H">1134444</td>
                <td>再生環保袋</td>
                <td>299</td>
                <td>249</td>
                <td>602</td>
                <td>上架</td>
                <td><button class="MmB_editBtn_H">編輯與查看</button></td>
                <!-- <td>
                  <button class="IcB_deleteBtn_H">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td> -->
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
