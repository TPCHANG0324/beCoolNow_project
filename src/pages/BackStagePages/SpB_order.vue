<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div>
          <h3>訂單管理</h3>
          <div class="MmB_searchBar_H">
            <input class="input" type="text" placeholder="搜尋訂單" />
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
                <!-- 使用 paginatedOrders 迭代訂單資料 -->
                <tr v-for="(order, index) in paginatedOrders" :key="order.orderNumber">
                  <td class="MmB_name_H">{{ order.orderNumber }}</td>
                  <td class="MmB_phone_H">{{ order.memberId }}</td>
                  <td>{{ order.paymentStatus }}</td>
                  <td class="MmB_order_H">{{ order.orderStatus }}</td>
                  <td class="MmB_transport_H">{{ order.shippingStatus }}</td>
                  <td class="MmB_orderDate_H">{{ order.orderDate }}</td>
                  <td>
                    <button class="MmB_editBtn_H" @click="openEditPopup(order)">編輯與查看</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </main>
        </div>
        <!-- 分頁器元件，傳入 currentPage 與 totalPages -->
        <Paginator 
          class="paginator_H"
          :currentPage="currentPage" 
          :totalPages="totalPages" 
          @page-changed="handlePageChange" 
        />
      </div>
    </div>

    <!-- 訂單編輯與查看彈窗 -->
    <transition name="fade">
      <BackStageBigPopup class="SpB_editViewOrder_H" v-if="isEditPopupVisible">
        <span>
          <p>訂單資訊&nbsp;編輯與查看</p>
          <i class="fa-solid fa-x" @click="closeEditPopup"></i>
        </span>
        <div class="SpB_scrollDiv_H">
          <article class="SpB_orderNum_H">
            <p>訂單編號:&nbsp;</p>
            <p>{{ currentOrder.orderNumber }}</p>
          </article>
          <article class="SpB_status_H">
            <div>
              <p>付款狀態:&nbsp;</p>
              <p>{{ currentOrder.paymentStatus }}</p>
            </div>
            <div>
              <p>訂單狀態:&nbsp;</p>
              <select v-model="currentOrder.orderStatus">
                <option value="已完成">已完成</option>
                <option value="待處理">待處理</option>
                <option value="取消">取消</option>
              </select>
            </div>
          </article>
          <article class="SpB_buyInfo_H">
            <div>
              <p>會員編號:&nbsp;</p>
              <p>{{ currentOrder.memberId }}</p>
            </div>
            <div>
              <p>收件人姓名:&nbsp;</p>
              <p>{{ currentOrder.recipientName }}</p>
            </div>
            <div>
              <p>收件人手機:&nbsp;</p>
              <p>{{ currentOrder.recipientPhone }}</p>
            </div>
            <div>
              <p>收件人地址:&nbsp;</p>
              <p>{{ currentOrder.address }}</p>
            </div>
            <div>
              <p>運送方式:&nbsp;</p>
              <p>{{ currentOrder.shippingMethod }}</p>
            </div>
            <div>
              <p>付款方式:&nbsp;</p>
              <p>{{ currentOrder.paymentMethod }}</p>
            </div>
            <div>
              <p>門市名稱:&nbsp;</p>
              <p>{{ currentOrder.storeName }}</p>
            </div>
            <div>
              <p>索取發票:&nbsp;</p>
              <p>{{ currentOrder.invoice }}</p>
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
                <tr v-for="(item, idx) in currentOrder.items" :key="idx">
                  <td>{{ item.name }}</td>
                  <td>{{ item.quantity }}</td>
                  <td>{{ item.amount }}</td>
                </tr>
              </tbody>
            </table>
          </article>
          <article class="SpB_total_H">
            <div>
              <p>商品金額:&nbsp;</p>
              <p>{{ currentOrder.totalAmount }}</p>
            </div>
            <div>
              <p>折扣點數:&nbsp;</p>
              <p>{{ currentOrder.discount }}</p>
            </div>
            <div>
              <p>運費:&nbsp;</p>
              <p>{{ currentOrder.shippingFee }}</p>
            </div>
            <div>
              <p>訂單總金額:&nbsp;</p>
              <p>{{ currentOrder.finalAmount }}</p>
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
import { ref, computed } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageBigPopup from '@/components/layout/BackStageLayout/BackStageBigPopup.vue';
// 引入自訂分頁器元件（請確認此元件存在）
import Paginator from '@/components/paginator.vue';

export default {
  name: 'OrderManagement',
  components: {
    BackStageHeader,
    BackStageSidebar,
    BackStagePaginator,
    BackStageBigPopup,
    Paginator,
  },
  setup() {
    // 假設這邊有訂單資料，實際上可透過 API 撈取
    const orders = ref([
      {
        orderNumber: '202401121752',
        memberId: '113122101',
        paymentStatus: '已付款',
        orderStatus: '已完成',
        shippingStatus: '已出貨',
        orderDate: '2025-01-12',
        recipientName: '張三',
        recipientPhone: '0912345678',
        address: '臺北市信義區某路',
        shippingMethod: '宅配',
        paymentMethod: '線上付款',
        storeName: '臺北大安店',
        invoice: '會員載具',
        items: [
          { name: '商品A', quantity: 2, amount: 400 },
          { name: '商品B', quantity: 1, amount: 199 },
        ],
        totalAmount: '$570元',
        discount: 'NA',
        shippingFee: '$45',
        finalAmount: '$650元',
      },
      {
        orderNumber: '202401121920',
        memberId: '113122102',
        paymentStatus: '已付款',
        orderStatus: '已完成',
        shippingStatus: '已出貨',
        orderDate: '2025-01-12',
        recipientName: '李四',
        recipientPhone: '0923456789',
        address: '臺北市中正區某路',
        shippingMethod: '宅配',
        paymentMethod: '線上付款',
        storeName: '臺北大安店',
        invoice: '會員載具',
        items: [
          { name: '商品C', quantity: 1, amount: 300 },
          { name: '商品D', quantity: 3, amount: 150 },
        ],
        totalAmount: '$750元',
        discount: 'NA',
        shippingFee: '$60',
        finalAmount: '$810元',
      },
      {
        orderNumber: '202401122000',
        memberId: '113122103',
        paymentStatus: '已付款',
        orderStatus: '已完成',
        shippingStatus: '已出貨',
        orderDate: '2025-01-12',
        recipientName: '王五',
        recipientPhone: '0934567890',
        address: '臺北市大安區某路',
        shippingMethod: '宅配',
        paymentMethod: '線上付款',
        storeName: '臺北大安店',
        invoice: '會員載具',
        items: [
          { name: '商品E', quantity: 2, amount: 500 },
          { name: '商品F', quantity: 1, amount: 299 },
        ],
        totalAmount: '$1299元',
        discount: 'NA',
        shippingFee: '$50',
        finalAmount: '$1349元',
      },
      // 可增加更多訂單資料...
    ]);

    // 分頁器狀態與計算屬性
    const currentPage = ref(1);
    const itemsPerPage = 10;
    const totalPages = computed(() => Math.ceil(orders.value.length / itemsPerPage));
    const paginatedOrders = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage;
      return orders.value.slice(start, start + itemsPerPage);
    });
    const handlePageChange = (newPage) => {
      currentPage.value = newPage;
      window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // 編輯彈窗控制
    const isEditPopupVisible = ref(false);
    const currentOrder = ref({}); // 當前編輯的訂單

    const openEditPopup = (order) => {
      currentOrder.value = order;
      isEditPopupVisible.value = true;
    };

    const closeEditPopup = () => {
      isEditPopupVisible.value = false;
    };

    const saveOrder = () => {
      alert('訂單資料已儲存！');
      isEditPopupVisible.value = false;
    };

    return {
      orders,
      currentPage,
      itemsPerPage,
      totalPages,
      paginatedOrders,
      handlePageChange,
      isEditPopupVisible,
      currentOrder,
      openEditPopup,
      closeEditPopup,
      saveOrder,
    };
  },
};
</script>
