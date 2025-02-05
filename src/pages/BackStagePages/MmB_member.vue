<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div>
          <h3>會員管理</h3>
          <!-- <h3>會員管理</h3> -->
          <div class="MmB_searchBar_H">
            <input id="" class="input" type="text" name="" placeholder="搜尋會員編號" />
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
    <BackStageSmallPopup class="MmB_EditView_H">
      <span>
        <p>編輯與查看</p>
        <i class="fa-solid fa-x"></i>
      </span>
      <section>
        <article>
          <div>
            <p>會員編號:&nbsp;</p>
            <p>113122101</p>
          </div>
          <div>
            <p>帳號:&nbsp;</p>
            <p>tibame@gmail.com</p>
          </div>
          <div>
            <p>姓名:&nbsp;</p>
            <p>黃小吉</p>
          </div>
          <div>
            <p>地址:&nbsp;</p>
            <p>臺北市中山區南京東路三段219號5樓</p>
          </div>
        </article>

        <article>
          <div>
            <p>性別:&nbsp;</p>
            <p>女</p>
          </div>
          <div>
            <p>手機:&nbsp;</p>
            <p>0912345678</p>
          </div>
          <div>
            <p>帳號狀態:&nbsp;</p>
            <select id="" name="">
              <option value="normal">正常</option>
              <option value="suspend">停權</option>
            </select>
          </div>
          <div>
            <p>創建時間:&nbsp;</p>
            <p>2025-01-12</p>
          </div>
        </article>
      </section>
      <div>
        <button>取消</button>
        <button>儲存</button>
      </div>
    </BackStageSmallPopup>
  </div>
</template>

<script>
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import backStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageSmallPopup from '@/components/layout/BackStageLayout/BackStageSmallPopup.vue';
</script>
