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
                <tr v-for="(order, index) in orders" :key="order.ID">
                  <td class="MmB_name_H">{{ order.ID }}</td>
                  <td class="MmB_phone_H">{{ order.member_ID }}</td>
                  <td :class="{ 'text-red': order.payStatus === '未付款' }">{{ order.payStatus }}</td>
                  <td class="MmB_order_H">{{ order.orderStatus }}</td>
                  <td class="MmB_transport_H" :class="{ 'text-red': order.shipStatus === '未出貨' }">{{ order.shipStatus }}</td>
                  <td class="MmB_orderDate_H">{{ order.buyDate.split(' ')[0] }}</td>
                  <!-- 點擊這裡開啟彈窗 -->
                  <td><button class="MmB_editBtn_H" @click="openEditPopup(order.ID)">編輯與查看</button></td>
                </tr>
                <!-- <tr>
                  <td class="MmB_name_H">202401121920</td>
                  <td class="MmB_phone_H">113122102</td>
                  <td>已付款</td>
                  <td class="MmB_order_H">已完成</td>
                  <td class="MmB_transport_H">已出貨</td>
                  <td class="MmB_orderDate_H">2025-01-12</td>
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr> -->
                <!-- <tr>
                  <td class="MmB_name_H">202401122000</td>
                  <td class="MmB_phone_H">113122103</td>
                  <td>已付款</td>
                  <td class="MmB_order_H">已完成</td>
                  <td class="MmB_transport_H">已出貨</td>
                  <td class="MmB_orderDate_H">2025-01-12</td>
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr> -->
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
          <p>{{ selectedOrder.ID }}</p>
        </article>
        <article class="SpB_status_H">
          <div>
            <p>付款狀態:&nbsp;</p>
            <p>{{ selectedOrder.payStatus }}</p>
            <!-- <select id="" name="">
              <option value="">已付款</option>
              <option value="">異常</option>
            </select> -->
          </div>
          <div>
            <p>訂單狀態:&nbsp;</p>
            <select v-model="selectedOrder.orderStatus" id="" name="">
              <option value="待處理">待處理</option>
              <option value="已完成">已完成</option>
            </select>
          </div>
        </article>
        <article class="SpB_buyInfo_H">
          <div>
            <div>
              <p>會員編號:&nbsp;</p>
              <p>{{ selectedOrder.member_ID }}</p>
            </div>
            <div>
              <p>收件人姓名:&nbsp;</p>
              <p>{{ selectedOrder.recipientName }}</p>
            </div>
            <div>
              <p>收件人手機:&nbsp;</p>
              <p>{{ selectedOrder.recipientPhone }}</p>
            </div>
            <div>
              <p>收件人地址:&nbsp;</p>
              <p>{{ selectedOrder.recipientAdress }}</p>
            </div>
            <div>
              <p>運送方式:&nbsp;</p>
              <p>{{ selectedOrder.shipMethod || "自行取貨" }}</p>
            </div>
            <div>
              <p>付款方式:&nbsp;</p>
              <p>{{ selectedOrder.payMethod || "現場付現" }}</p>
            </div>
            <!-- <div>
              <p>門市名稱:&nbsp;</p>
              <p>臺北大安店</p>
            </div> -->
            <div>
              <p>索取發票:&nbsp;</p>
              <p>{{ selectedOrder.invoiceType }}</p>
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
                <th>單價</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(product, index) in selectedOrderDetails" :key="selectedOrderDetails.ID">
                <td>{{ product.productName }}</td>
                <td>{{ product.quantity }}</td>
                <td>{{ product.salePrice }}</td>
              </tr>
              <!-- <tr>
                <td>玻璃吸管</td>
                <td>1</td>
                <td>199</td>
              </tr> -->
            </tbody>
          </table>
        </article>
        <article class="SpB_total_H">
          <div>
            <p>金額小計:&nbsp;</p>
            <p>${{ selectedOrder.subtotal || 0 }}元</p>
          </div>
          <div>
            <p>折扣點數:&nbsp;</p>
            <p>{{ selectedOrder.usePoints ? `-${ (selectedOrder.usePoints / 100).toFixed(0) } 點` : "未使用" }}</p>
          </div>
          <div>
            <p>運費:&nbsp;</p>
            <p>${{ selectedOrder.shippingFee || 0 }}元</p>
          </div>
          <div>
            <p>訂單總金額:&nbsp;</p>
            <p>${{ selectedOrder.total || 0 }}元</p>
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
import { ref, onMounted, computed } from 'vue';
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

    const base_url = import.meta.env.VITE_AJAX_URL;
    const orders = ref([]); // 使用 ref([]) 來確保它是響應式變數
    const orderId = ref();
    const selectedOrder = ref({}); // 選擇的訂單
    const selectedOrderDetails = ref([]); // 訂單商品明細
    const isEditPopupVisible = ref(false);
    const shipMethodText = ref('');
    const payMethodText = ref('');


    watch(selectedOrder, (newVal) => {
      console.log("🔍 監聽到的 selectedOrder:", newVal);
    });
    // **統一的狀態對應表**
    const statusMapping = {
      payStatus: { 0: "未付款", 1: "已付款" },
      shipMethod: { 0: "新竹物流宅配", 1: "台灣離島郵寄" },
      payMethod: { 0: "信用卡 (Visa/Master/JCB)", 1: "Line Pay" },
    };

    // **計算屬性 - 格式化 selectedOrder**
    const formattedSelectedOrder = computed(() => {
      if (!selectedOrder.value) return {};

      return {
        ...selectedOrder.value,
        payStatusText: statusMapping.payStatus[selectedOrder.value.payStatus] || "未知",
        shipMethodText: statusMapping.shipMethod[selectedOrder.value.shipMethod] || "未知",
        payMethodText: statusMapping.payMethod[selectedOrder.value.payMethod] || "未知",
      };
    });

    // **取得所有訂單**
    const fetchOrders = async () => {
      try {
        const response = await fetch(`${base_url}/getOrder.php?all_orders=true`);
        const data = await response.json();


        console.log("📡 API 回應 (應該是字串):", data);

        if (data.success) {
          orders.value = data.orders;
          console.log("📌 所有訂單資料: ", orders.value);
        } else {
          console.error("❌ 取得訂單失敗:", data.message);
        }
      } catch (error) {
        console.error("❌ API 錯誤:", error);
      }
    };

    // **開啟「編輯與查看」的彈窗**
    const openEditPopup = async (orderId) => {
      try {
        console.log("開啟彈窗，訂單 ID:", orderId);
        const response = await fetch(`${base_url}/getOrder.php?id=${orderId}`);
        const data = await response.json();

        if (data.success) {
          // 確保 `selectedOrder` 內的值已經是字串
          selectedOrder.value = {
            ...data.order,
            payMethod: data.order.payMethod === "1" ? "Line Pay" : "信用卡",
            payStatus: data.order.payStatus === "1" ? "已付款" : "未付款",
            orderStatus: data.order.orderStatus === "1" ? "已完成" : "待處理",
            shipMethod: data.order.shipMethod === "1" ? "台灣離島郵寄" : "新竹物流宅配",
            shipStatus: data.order.shipStatus === "1" ? "已出貨" : "未出貨",
          };

          // **在這裡手動轉換 orderStatus**
          selectedOrderDetails.value = data.order_details;
          isEditPopupVisible.value = true;
          console.log("📌 轉換後的 `selectedOrder`: ", selectedOrder.value);
        } else {
          console.error("取得訂單詳情失敗:", data.message);
        }
      } catch (error) {
        console.error("API 錯誤:", error);
      }
    };

    // **關閉彈窗**
    const closeEditPopup = () => {
      isEditPopupVisible.value = false;
      selectedOrder.value = null;
      selectedOrderDetails.value = [];
    };

    // **儲存訂單**
    const saveOrder = async () => {

      const statusMappingReverse = {
        "待處理": 0,
        "已完成": 1,
      };

      const payStatusMappingReverse = {
        "未付款": 0,
        "已付款": 1,
      };

      const payMethodMappingReverse = {
        "信用卡": 0,
        "Line Pay": 1,
      };

      const shipMethodMappingReverse = {
        "新竹物流宅配": 0,
        "台灣離島郵寄": 1,
      };

      const shipStatusMappingReverse = {
        "未出貨": 0,
        "已出貨": 1,
      };
      try {
        alert("訂單資料已儲存！");

        // **轉換 orderStatus 為數字**
        const orderStatusValue = statusMappingReverse[selectedOrder.value.orderStatus] ?? 0;
        const payStatusValue = payStatusMappingReverse[selectedOrder.value.payStatus] ?? 0;
        const payMethodValue = payMethodMappingReverse[selectedOrder.value.payMethod] ?? 0;
        const shipMethodValue = shipMethodMappingReverse[selectedOrder.value.shipMethod] ?? 0;
        const shipStatusValue = shipStatusMappingReverse[selectedOrder.value.shipStatus] ?? 0;


        console.log("📌 送出訂單更新，數據:", {
          orderID: selectedOrder.value.ID,
          orderStatus: orderStatusValue,
          payStatus: payStatusValue,
          payMethod: payMethodValue,
          shipMethod: shipMethodValue,
          shipStatus: shipStatusValue,
          shippingFee: selectedOrder.value.shippingFee,
        });

        const response = await fetch(`${base_url}/updateOrder.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            orderID: selectedOrder.value.ID,
            orderStatus: orderStatusValue,
            payStatus: payStatusValue,  // ✅ 傳送付款狀態
            payMethod: payMethodValue,
            shipMethod: shipMethodValue,
            shipStatus: shipStatusValue,
            shippingFee: selectedOrder.value.shippingFee,
          }),
        });

        const result = await response.json();
        console.log("📥 後端回應:", result); // 🔍 確保 `result` 正確


          if (result.success) {
            alert("✅ 訂單狀態更新成功！");
            isEditPopupVisible.value = false;
            fetchOrders(); // 重新獲取訂單列表
          } else {
            alert(`❌ 訂單更新失敗：${result.message}`);
          }
        } catch (error) {
          console.error("❌ 訂單更新錯誤:", error);
          alert("❌ 伺服器錯誤，請稍後再試！");
        }

    };







    onMounted(fetchOrders); // 在組件加載時執行 fetchOrders()

    return {
      base_url,
      fetchOrders,
      isEditPopupVisible,
      openEditPopup,
      closeEditPopup,
      saveOrder,
      orders,
      orderId,
      selectedOrder,
      selectedOrderDetails,
      statusMapping,
      formattedSelectedOrder,
      shipMethodText,
      payMethodText,
    };
  },
};
</script>


<style scoped>
.text-red {
  color: red;
  font-weight: bold;
}
</style>
