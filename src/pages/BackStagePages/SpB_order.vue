<template>
  <BackStageHeader></BackStageHeader>
  <div class="backStage_bgc">
    <div class="backStage_wrapper">
      <div>
        <h3>訂單管理</h3>
        <!-- <h3>會員管理</h3> -->
        <div class="MmB_searchBar_H">
          <input id="" class="input" type="text" name="" placeholder="搜尋訂單" />
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
      </div>
      <div class="wrapper">
        <BackStageSidebar></BackStageSidebar>
        <main class="IcB_table_H">
          <table class="MmB_mainTable_H">
            <thead>
              <tr>
                <th class="MmB_name_H">訂單編號</th>
                <th class="MmB_phone_H">會員編號</th>
                <th>付款狀態</th>
                <th class="MmB_order_H">訂單狀態</th>
                <th class="MmB_transport_H">貨運狀態</th>
                <th class="MmB_orderDate_H">訂購日期</th>
                <th></th>
                <!-- <th><button class="IcB_addBtn_H">新增</button></th> -->
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="MmB_name_H">202401121752</td>
                <td class="MmB_phone_H">113122101</td>
                <td>已付款</td>
                <td class="MmB_order_H">已完成</td>
                <td class="MmB_transport_H">已出貨</td>
                <td class="MmB_orderDate_H">2025-01-12</td>
                <td><button class="MmB_editBtn_H">編輯與查看</button></td>
                <!-- <td>
                  <button class="IcB_deleteBtn_H">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td> -->
              </tr>
              <tr>
                <td class="MmB_name_H">202401121920</td>
                <td class="MmB_phone_H">113122102</td>
                <td>已付款</td>
                <td class="MmB_order_H">已完成</td>
                <td class="MmB_transport_H">已出貨</td>
                <td class="MmB_orderDate_H">2025-01-12</td>
                <td><button class="MmB_editBtn_H">編輯與查看</button></td>
                <!-- <td>
                  <button class="IcB_deleteBtn_H">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td> -->
              </tr>
              <tr>
                <td class="MmB_name_H">202401122000</td>
                <td class="MmB_phone_H">113122103</td>
                <td>已付款</td>
                <td class="MmB_order_H">已完成</td>
                <td class="MmB_transport_H">已出貨</td>
                <td class="MmB_orderDate_H">2025-01-12</td>
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

<style lang="scss" scoped></style>
