import express from 'express';
import mongoose from 'mongoose';
import cors from 'cors';
import dotenv from 'dotenv';
import { createPayment } from './create-payment.js';
import lettersRoutes from './routes/letters.js';
import adminLettersRoutes from './routes/admin/letters.js';

// 載入環境變數
dotenv.config();

const app = express();

// CORS 設定
app.use(cors({
  origin: 'http://localhost:3000',
  credentials: true
}));

// 中間件（移除重複的中間件）
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// MongoDB 連接設定
const connectDB = async () => {
  try {
    const conn = await mongoose.connect(process.env.MONGODB_URI || 'mongodb://localhost:27017/your_database', {
      useNewUrlParser: true,
      useUnifiedTopology: true
    });
    console.log(`MongoDB Connected: ${conn.connection.host}`);
  } catch (error) {
    console.error(`Error: ${error.message}`);
    process.exit(1);
  }
};

connectDB();

// API 路由
app.use('/api/letters', lettersRoutes);
app.use('/api/admin/letters', adminLettersRoutes);

// LINE Pay 相關路由
app.post('/api/create-payment', createPayment);

// 錯誤處理中間件
app.use((err, req, res, next) => {
  console.error('Error:', err);
  
  if (err instanceof mongoose.Error) {
    return res.status(400).json({
      success: false,
      message: '資料庫操作錯誤',
      error: err.message
    });
  }

  if (err.name === 'ValidationError') {
    return res.status(400).json({
      success: false,
      message: '資料驗證錯誤',
      error: err.message
    });
  }

  res.status(err.status || 500).json({
    success: false,
    message: err.message || '伺服器錯誤',
    error: process.env.NODE_ENV === 'development' ? err.stack : undefined
  });
});

// 404 處理
app.use((req, res) => {
  res.status(404).json({
    success: false,
    message: '找不到該路由'
  });
});

// 設定端口
const PORT = process.env.PORT || 3000;

// 啟動服務器
const server = app.listen(PORT, () => {
  console.log(`伺服器運行在 http://localhost:${PORT}`);
  console.log(`LINE Pay 支付端點: http://localhost:${PORT}/api/create-payment`);
});

// 錯誤處理
server.on('error', (error) => {
  if (error.code === 'EADDRINUSE') {
    console.error(`端口 ${PORT} 已被占用`);
  } else {
    console.error('服務器啟動錯誤:', error);
  }
});

export default app;