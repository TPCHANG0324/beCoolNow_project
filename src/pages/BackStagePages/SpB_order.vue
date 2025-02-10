<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div>
          <h3>訂單管理</h3>
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
                  <!-- 點擊這裡開啟彈窗 -->
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr>
                <tr>
                  <td class="MmB_name_H">202401121920</td>
                  <td class="MmB_phone_H">113122102</td>
                  <td>已付款</td>
                  <td class="MmB_order_H">已完成</td>
                  <td class="MmB_transport_H">已出貨</td>
                  <td class="MmB_orderDate_H">2025-01-12</td>
                  <!-- 點擊這裡開啟彈窗 -->
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr>
                <tr>
                  <td class="MmB_name_H">202401122000</td>
                  <td class="MmB_phone_H">113122103</td>
                  <td>已付款</td>
                  <td class="MmB_order_H">已完成</td>
                  <td class="MmB_transport_H">已出貨</td>
                  <td class="MmB_orderDate_H">2025-01-12</td>
                  <!-- 點擊這裡開啟彈窗 -->
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr>
              </tbody>
            </table>
          </main>
        </div>
        <BackStagePaginator></BackStagePaginator>
      </div>
    </div>

    <!-- 用 v-if 控制彈窗顯示與否 -->
     <transition name="fade">
    <BackStageBigPopup class="SpB_editViewOrder_H" v-if="isEditPopupVisible">
      <span>
        <p>訂單資訊&nbsp;編輯與查看</p>
        <!-- 右上角的 X 按鈕關閉 -->
        <i class="fa-solid fa-x" @click="closeEditPopup"></i>
      </span>
      <div class="SpB_scrollDiv_H">
        <article class="SpB_orderNum_H">
          <p>訂單編號:&nbsp;</p>
          <p>123456</p>
        </article>
        <article class="SpB_status_H">
          <div>
            <p>付款狀態:&nbsp;</p>
            <select id="" name="">
              <option value="">已付款</option>
              <option value="">異常</option>
            </select>
          </div>
          <div>
            <p>訂單狀態:&nbsp;</p>
            <select id="" name="">
              <option value="">已出貨</option>
              <option value="">未出貨</option>
            </select>
          </div>
        </article>
        <article class="SpB_buyInfo_H">
          <div>
            <div>
              <p>會員編號:&nbsp;</p>
              <p>113122102</p>
            </div>
            <div>
              <p>收件人姓名:&nbsp;</p>
              <p>黃小吉</p>
            </div>
            <div>
              <p>收件人手機:&nbsp;</p>
              <p>0912345678</p>
            </div>
            <div>
              <p>收件人地址:&nbsp;</p>
              <p>臺北市大安區復興南路二段273號</p>
            </div>
            <div>
              <p>運送方式:&nbsp;</p>
              <p>宅配</p>
            </div>
            <div>
              <p>付款方式:&nbsp;</p>
              <p>線上付款</p>
            </div>
            <div>
              <p>門市名稱:&nbsp;</p>
              <p>臺北大安店</p>
            </div>
            <div>
              <p>索取發票:&nbsp;</p>
              <p>會員載具</p>
            </div>
          </div>
        </article>
        <article class="SpB_orderTable_H">
          <h6>訂單商品明細</h6>
          <table>
            <thead>
              <tr>
                <th>名稱</th>
                <th>數量</th>
                <th>金額</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>環保袋</td>
                <td>2</td>
                <td>400</td>
              </tr>
              <tr>
                <td>玻璃吸管</td>
                <td>1</td>
                <td>199</td>
              </tr>
            </tbody>
          </table>
        </article>
        <article class="SpB_total_H">
          <div>
            <p>商品金額:&nbsp;</p>
            <p>$570元</p>
          </div>
          <div>
            <p>折扣點數:&nbsp;</p>
            <p>NA</p>
          </div>
          <div>
            <p>運費:&nbsp;</p>
            <p>$45</p>
          </div>
          <div>
            <p>訂單總金額:&nbsp;</p>
            <p>$650元</p>
          </div>
        </article>
      </div>
      <div>
        <button @click="closeEditPopup">取消</button>
        <button @click="saveOrder">儲存</button>
      </div>
    </BackStageBigPopup>
  </transition>
  </div>
</template>

<script>
import { ref } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageBigPopup from '@/components/layout/BackStageLayout/BackStageBigPopup.vue';

export default {
  name: 'OrderManagement',
  components: {
    BackStageHeader,
    BackStageSidebar,
    BackStagePaginator,
    BackStageBigPopup,
  },
  setup() {
    // 1. 用來控制「編輯與查看」的彈窗是否顯示
    const isEditPopupVisible = ref(false);

    // 2. 點擊「編輯與查看」按鈕時，打開彈窗
    const openEditPopup = () => {
      isEditPopupVisible.value = true;
    };

    // 3. 點擊 X 或取消按鈕時，關閉彈窗
    const closeEditPopup = () => {
      isEditPopupVisible.value = false;
    };

    // 4. 點擊「儲存」按鈕時，可以做相應的訂單更新或 API 呼叫
    const saveOrder = () => {
      // 這裡放你想要做的操作，比如調用 API 等
      alert('訂單資料已儲存！');
      // 完成後關閉視窗
      isEditPopupVisible.value = false;
    };

    return {
      isEditPopupVisible,
      openEditPopup,
      closeEditPopup,
      saveOrder,
    };
  },
};
</script>
