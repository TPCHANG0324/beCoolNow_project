import { Router } from 'express';
const router = Router();
import db from '../../db.js';

// 新增信件
router.post('/', async (req, res) => {
  try {
    const { name, message, created_at, user_id } = req.body;
    
    const [result] = await db.execute(
      `INSERT INTO letters (name, message, created_at, user_id) 
       VALUES (?, ?, ?, ?)`,
      [name, message, created_at, user_id]
    );
    
    res.json({ 
      success: true, 
      message: '信件已成功儲存',
      data: result
    });
  } catch (error) {
    console.error('儲存信件時發生錯誤：', error);
    res.status(500).json({ 
      success: false, 
      message: '儲存信件時發生錯誤' 
    });
  }
});

// 獲取所有信件
router.get('/', async (req, res) => {
  try {
    const [letters] = await db.execute(
      `SELECT letters.*, users.nickname 
       FROM letters 
       LEFT JOIN users ON letters.user_id = users.id 
       ORDER BY created_at DESC`
    );
    
    res.json({ 
      success: true, 
      data: letters 
    });
  } catch (error) {
    console.error('獲取信件時發生錯誤：', error);
    res.status(500).json({ 
      success: false, 
      message: '獲取信件時發生錯誤' 
    });
  }
});

export default router;