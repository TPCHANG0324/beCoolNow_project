import express from 'express';
import mongoose from 'mongoose';
import cors from 'cors';
import dotenv from 'dotenv';

// 載入環境變數
dotenv.config();

const app = express();

// CORS 設定
app.use(cors({
  origin: process.env.FRONTEND_URL || 'http://localhost:5173', // 前端網址
  credentials: true,
  methods: ['GET', 'POST', 'DELETE', 'UPDATE', 'PUT', 'PATCH'],
  allowedHeaders: ['Content-Type', 'Authorization']
}));

// 中間件
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

// 路由
import lettersRoutes from './routes/letters.js';
import adminLettersRoutes from './routes/admin/letters.js';

// API 路由
app.use('/api/letters', lettersRoutes);
app.use('/api/admin/letters', adminLettersRoutes);

// 錯誤處理中間件
app.use((err, req, res, next) => {
  console.error('Error:', err);
  
  // 區分不同類型的錯誤
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

  // 預設錯誤回應
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

const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
  console.log(`伺服器運行在 port ${PORT}`);
});

// 優雅關閉程序
process.on('SIGTERM', () => {
  console.log('SIGTERM 收到信號，準備關閉');
  mongoose.connection.close();
  process.exit(0);
});

export default app;