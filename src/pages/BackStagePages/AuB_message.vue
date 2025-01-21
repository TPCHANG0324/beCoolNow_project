<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div>
          <h3>訊息管理</h3>
          <!-- <h3>會員管理</h3> -->
          <div class="MmB_searchBar_H">
            <input id="" class="input" type="text" name="" placeholder="搜尋E-mail" />
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
                  <th>送出日期</th>
                  <th></th>
                  <th></th>
                  <!-- <th><button class="SpB_addBtn_H">新增</button></th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="SpB_number_H">1</td>
                  <td>王小明</td>
                  <td>abc@gmail.com</td>
                  <td>0912345678</td>
                  <td>2025-01-12</td>
                  <td><button class="MmB_editBtn_H">查看</button></td>
                  <td class="deleteBtn">
                    <button class="IcB_deleteBtn_H">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td class="SpB_number_H">2</td>
                  <td>王小明</td>
                  <td>abc@gmail.com</td>
                  <td>0912345678</td>
                  <td>2025-01-12</td>
                  <td><button class="MmB_editBtn_H">查看</button></td>
                  <td>
                    <button class="IcB_deleteBtn_H">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td class="SpB_number_H">3</td>
                  <td>王小明</td>
                  <td>abc@gmail.com</td>
                  <td>0912345678</td>
                  <td>2025-01-12</td>
                  <td><button class="MmB_editBtn_H">查看</button></td>
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
    <BackStageConfirmPopup class="AuB_messageDelete_H">
      <span></span>
      <div>
        <h3>確定將此訊息刪除嗎?</h3>
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
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';
</script>
