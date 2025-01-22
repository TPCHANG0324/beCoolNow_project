<!-- OrderDetailPopup.vue -->
<template>
    <div v-if="isVisible" class="popup-overlay">
      <div class="popup-content">
        <button class="close-btn" @click="closePopup">&times;</button>
        <h2 class="popup_mb">訂單詳情</h2>
        <div class="order-info">
          <div class="info-row">
            <span class="label">訂單編號：</span>
            <span>{{ order.orderId }}</span>
          </div>
          <div class="info-row">
            <span class="label">訂購日期：</span>
            <span>{{ order.date }}</span>
          </div>
          <div class="info-row">
            <span class="label">商品名稱：</span>
            <span>{{ order.productName }}</span>
          </div>
          <div class="info-row">
            <span class="label">商品金額：</span>
            <span>{{ order.price }} 元</span>
          </div>
          <div class="info-row">
            <span class="label">數量：</span>
            <span>{{ order.quantity }}</span>
          </div>
          <div class="info-row">
            <span class="label">配送狀態：</span>
            <span>{{ order.status }}</span>
          </div>
          <div class="info-row">
            <span class="label">收件地址：</span>
            <span>{{ order.address }}</span>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'OrderDetailPopup',
    props: {
      isVisible: {
        type: Boolean,
        default: false
      },
      order: {
        type: Object,
        default: () => ({})
      }
    },
    methods: {
      closePopup() {
        this.$emit('close');
      }
    }
  }
  </script>
  
  <style scoped>
  .popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .popup-content {
    background-color: #fffff0;
    padding: 2rem;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    position: relative;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  
  .close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    border: none;
    background: none;
    font-size: 24px;
    cursor: pointer;
    padding: 5px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .close-btn:hover {
    background-color: #f0f0f0;
  }
  
  .popup_mb {
    margin-bottom: 1rem;
    color: #333;
    text-align: center;
    font-weight: 800;
    font-size: 1.5rem;
  }
  
  .order-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
  
  .info-row {
    display: flex;
    border-bottom: 1px solid #eee;
    padding-bottom: 0.5rem;
  }
  
  .label {
    font-weight: bold;
    min-width: 100px;
    color: #666;
    font-size: 1rem;
  }
  </style>