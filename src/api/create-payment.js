import axios from 'axios';
import crypto from 'crypto';
import dotenv from 'dotenv';

dotenv.config();

export async function createPayment(req, res) {
    try {
      console.log('收到支付請求:', req.body); // 添加請求日誌
  
      const { amount, orderId, products } = req.body;
  
      // 驗證必要參數
      if (!amount || !orderId || !products) {
        return res.status(400).json({
          returnCode: 'ERROR',
          returnMessage: '缺少必要參數'
        });
      }

    // LINE Pay API 設定
    const channelId = process.env.LINE_PAY_CHANNEL_ID;
    const channelSecretKey = process.env.LINE_PAY_CHANNEL_SECRET_KEY;
    const baseUrl = process.env.LINE_PAY_API_URL;
    const confirmUrl = process.env.LINE_PAY_CONFIRM_URL;
    const cancelUrl = process.env.LINE_PAY_CANCEL_URL;

    // 準備請求資料
    if (!channelId || !channelSecretKey || !baseUrl || !confirmUrl || !cancelUrl) {
        console.error('缺少必要的環境變數配置');
        return res.status(500).json({
          returnCode: 'ERROR',
          returnMessage: '服務器配置錯誤'
        });
      }
  
      const requestUrl = '/v3/payments/request';
      const requestBody = {
        amount,
        currency: 'TWD',
        orderId,
        packages: [{
          id: orderId,
          amount,
          products
        }],
        redirectUrls: {
          confirmUrl,
          cancelUrl
        }
      };

    // 產生 nonce 和 signature
    const nonce = Date.now().toString();
    const message = channelSecretKey + requestUrl + JSON.stringify(requestBody) + nonce;
    const signature = crypto
      .createHmac('sha256', channelSecretKey)
      .update(message)
      .digest('base64');

      console.log('正在發送請求到 LINE Pay...'); // 添加請求日誌

    // 發送請求到 LINE Pay API
    const response = await axios({
      method: 'POST',
      url: `${baseUrl}${requestUrl}`,
      headers: {
        'Content-Type': 'application/json',
        'X-LINE-ChannelId': channelId,
        'X-LINE-Authorization-Nonce': nonce,
        'X-LINE-Authorization': signature
      },
      data: requestBody
    });

    console.log('LINE Pay 回應:', response.data); // 添加響應日誌

    // 回傳結果給前端
    res.json(response.data);

  } catch (error) {
    console.error('LINE Pay create payment error:', error.response?.data || error);

    // 更詳細的錯誤處理
    const errorResponse = {
        returnCode: 'ERROR',
        returnMessage: '支付處理失敗',
        details: error.response?.data || error.message
      };
      res.status(error.response?.status || 500).json(errorResponse);
    }
}