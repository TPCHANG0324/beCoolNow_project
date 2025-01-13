<template>
  <BackStageHeader></BackStageHeader>
  <div class="backStage_bgc">
    <div class="backStage_wrapper">
      <div>
        <h3>會員管理</h3>
        <!-- <h3>會員管理</h3> -->
        <div class="MmB_searchBar_H">
          <input class="input" type="text" name="" id="" placeholder="搜尋會員編號">
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
      </div>
      <div class="wrapper">
        <BackStageSidebar></BackStageSidebar>
        <main class="IcB_table_H">
          <table class="MmB_mainTable_H">
            <thead>
              <tr>
                <th class="MmB_number_H">會員編號</th>
                <th class="MmB_name_H">姓名</th>
                <th class="MmB_phone_H">手機</th>
                <th class="MmB_mail_H">信箱</th>
                <th class="MmB_pet_H">小寵物</th>
                <th class="MmB_createDate_H">創建日期</th>
                <th></th>
                <!-- <th><button class="IcB_addBtn_H">新增</button></th> -->
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="MmB_number_H">113122101</td>
                <td class="MmB_name_H">王小明</td>
                <td class="MmB_phone_H">0912345678</td>
                <td class="MmB_mail_H">tibame@gmail.com</td>
                <td class="MmB_pet_H">氓阿狐</td>
                <td class="MmB_createDate_H">2025-01-12</td>
                <td><button class="MmB_editBtn_H">編輯與查看</button></td>
                <!-- <td>
                  <button class="IcB_deleteBtn_H">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td> -->
              </tr>
              <tr>
                <td class="MmB_number_H">113122102</td>
                <td class="MmB_name_H">王小明</td>
                <td class="MmB_phone_H">0912345678</td>
                <td class="MmB_mail_H">tibame@gmail.com</td>
                <td class="MmB_pet_H">氓阿狐</td>
                <td class="MmB_createDate_H">2025-01-12</td>
                <td><button class="MmB_editBtn_H">編輯與查看</button></td>
                <!-- <td>
                  <button class="IcB_deleteBtn_H">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td> -->
              </tr>
              <tr>
                <td class="MmB_number_H">113122103</td>
                <td class="MmB_name_H">王小明</td>
                <td class="MmB_phone_H">0912345678</td>
                <td class="MmB_mail_H">tibame@gmail.com</td>
                <td class="MmB_pet_H">氓阿狐</td>
                <td class="MmB_createDate_H">2025-01-12</td>
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