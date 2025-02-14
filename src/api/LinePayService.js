import CryptoJS from 'crypto-js';

class LinePayService {
  constructor() {
    // 確保這個路徑和後端路由匹配
    this.apiBaseUrl = 'http://localhost:3000/api';
  }

  async createPayment(orderData) {
    try {
      const response = await fetch(`${this.apiBaseUrl}/create-payment`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          amount: orderData.amount,
          orderId: orderData.orderId,
          products: orderData.products
        })
      });

      // 先檢查響應狀態
      if (!response.ok) {
        const responseText = await response.text();
        console.error('Server response:', responseText);
        
        // 嘗試解析錯誤信息
        try {
          const errorData = JSON.parse(responseText);
          throw new Error(errorData.message || `HTTP 錯誤 ${response.status}`);
        } catch (e) {
          throw new Error(`服務器返回非 JSON 響應 (狀態碼: ${response.status})`);
        }
      }

      // 嘗試解析 JSON 響應
      const responseText = await response.text();
      console.log('Raw server response:', responseText);
      
      let data;
      try {
        data = JSON.parse(responseText);
      } catch (e) {
        console.error('JSON parsing error:', e);
        throw new Error('服務器返回無效的 JSON 格式');
      }

      // 檢查 LINE Pay API 響應
      if (data.returnCode === '0000') {
        console.log('Payment created successfully:', data);
        
        // 存儲訂單信息
        localStorage.setItem('currentOrder', JSON.stringify({
          orderId: orderData.orderId,
          amount: orderData.amount,
          transactionId: data.info?.transactionId
        }));
        
        return data;
      } else {
        throw new Error(`LINE Pay API 錯誤: ${data.returnMessage || '未知錯誤'}`);
      }
    } catch (error) {
      console.error('Create payment error details:', error);
      throw new Error(`建立付款失敗: ${error.message}`);
    }
  }

  // 添加 signature 生成方法
createSignature(data) {
  const nonce = Date.now().toString();
  const channelSecret = import.meta.env.VITE_LINE_PAY_CHANNEL_SECRET_KEY;
  const message = channelSecret + '/v3/payments/request' + JSON.stringify(data) + nonce;
  
  return CryptoJS.HmacSHA256(message, channelSecret).toString(CryptoJS.enc.Base64);
}
  async confirmPayment(transactionId, amount, orderId) {
    try {
      if (!transactionId || !amount) {
        throw new Error('確認付款資料不完整');
      }

      const response = await fetch(`${this.apiBaseUrl}/confirm`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          transactionId,
          amount,
          orderId,
          currency: 'TWD'
        })
      });

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.message || `HTTP錯誤 ${response.status}`);
      }

      const data = await response.json();

      if (data.returnCode === '0000') {
        // 清除暫存的訂單資訊
        localStorage.removeItem('currentOrder');
        return data;
      } else {
        throw new Error(`確認付款錯誤: ${data.returnMessage}`);
      }
    } catch (error) {
      console.error('Confirm payment error:', error);
      throw new Error(`確認付款失敗: ${error.message}`);
    }
  }

  async getPaymentStatus(orderId) {
    try {
      if (!orderId) {
        throw new Error('訂單編號不能為空');
      }

      const response = await fetch(`${this.apiBaseUrl}/orders/${orderId}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        }
      });

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.message || `HTTP錯誤 ${response.status}`);
      }

      const data = await response.json();
      
      if (data.returnCode === '0000') {
        return data;
      } else {
        throw new Error(`查詢訂單狀態錯誤: ${data.returnMessage}`);
      }
    } catch (error) {
      console.error('Get payment status error:', error);
      throw new Error(`查詢訂單狀態失敗: ${error.message}`);
    }
  }

  // 新增取消付款方法
  async cancelPayment(orderId) {
    try {
      if (!orderId) {
        throw new Error('訂單編號不能為空');
      }

      const response = await fetch(`${this.apiBaseUrl}/cancel/${orderId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        }
      });

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.message || `HTTP錯誤 ${response.status}`);
      }

      const data = await response.json();

      if (data.returnCode === '0000') {
        localStorage.removeItem('currentOrder');
        return data;
      } else {
        throw new Error(`取消付款錯誤: ${data.returnMessage}`);
      }
    } catch (error) {
      console.error('Cancel payment error:', error);
      throw new Error(`取消付款失敗: ${error.message}`);
    }
  }
}

export default LinePayService;