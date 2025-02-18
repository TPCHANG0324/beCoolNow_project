<template>
    <div class="donation-confirm">
      <MainHeader />
      <div class="confirm-container">
        <div v-if="loading" class="loading">
          <h2>交易確認中，請稍候...</h2>
          <!-- 可以加入載入動畫 -->
        </div>
        <div v-if="error" class="error">
          <h2>交易發生錯誤</h2>
          <p>{{ errorMessage }}</p>
          <button @click="retryPayment" class="retry-btn">重試付款</button>
        </div>
      </div>
      <MainFooter />
    </div>
  </template>
  
  <script>
  import MainHeader from '@/components/layout/MainHeader.vue'
  import MainFooter from '@/components/layout/MainFooter.vue'
  import LinePayService from '@/api/LinePayService';  // 因為您放在 api 資料夾，所以路徑要調整
  
  export default {
    name: 'DonationConfirm',
    
    components: {
      MainHeader,
      MainFooter
    },
  
    data() {
      return {
        loading: true,
        error: false,
        errorMessage: '',
      }
    },
  
    async mounted() {
      // 從 URL 獲取 LINE Pay 回傳的參數
      const { transactionId, orderId } = this.$route.query
  
      if (!transactionId || !orderId) {
        this.handleError('缺少必要的交易參數')
        return
      }
  
      try {
        // 從資料庫獲取訂單資訊
        const order = await this.getOrderFromDatabase(orderId)
        
        // 確認交易
        const linePayService = new LinePayService()
        const result = await linePayService.confirmPayment(transactionId, order.amount)
  
        if (result.returnCode === '0000') {
          // 更新資料庫中的訂單狀態
          await this.updateOrderStatus(orderId, 'COMPLETED')
          
          // 導向成功頁面
          this.$router.push('/donationfinish')
        } else {
          throw new Error(result.returnMessage)
        }
      } catch (error) {
        this.handleError(error.message)
      }
    },
  
    methods: {
      async getOrderFromDatabase(orderId) {
        try {
          // 實作從資料庫獲取訂單的邏輯
          const response = await this.$axios.get(`/api/orders/${orderId}`)
          return response.data
        } catch (error) {
          throw new Error('無法獲取訂單資訊')
        }
      },
  
      async updateOrderStatus(orderId, status) {
        try {
          // 實作更新訂單狀態的邏輯
          await this.$axios.patch(`/api/orders/${orderId}`, {
            status: status
          })
        } catch (error) {
          throw new Error('更新訂單狀態失敗')
        }
      },
  
      handleError(message) {
        this.loading = false
        this.error = true
        this.errorMessage = message
        console.error('Confirmation failed:', message)
      },
  
      retryPayment() {
        // 返回捐款頁面重新進行付款
        this.$router.push('/support')
      }
    }
  }
  </script>
  
  <style scoped>
  .donation-confirm {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  
  .confirm-container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
  }
  
  .loading, .error {
    text-align: center;
    padding: 2rem;
  }
  
  .error {
    color: #dc3545;
  }
  
  .retry-btn {
    margin-top: 1rem;
    padding: 0.5rem 1rem;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .retry-btn:hover {
    background-color: #0056b3;
  }
  </style>