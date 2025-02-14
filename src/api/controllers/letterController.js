// controllers/letterController.js
import Letter from '../models/letter.js';

// 獲取信件列表
export const getLetters = async (req, res) => {
  try {
    const page = parseInt(req.query.page) || 1;
    const limit = parseInt(req.query.limit) || 10;
    const skip = (page - 1) * limit;

    const letters = await Letter.find()
      .sort({ timestamp: -1 })
      .skip(skip)
      .limit(limit);

    const total = await Letter.countDocuments();

    res.status(200).json({
      success: true,
      letters,
      total
    });
  } catch (error) {
    console.error('獲取信件錯誤:', error);
    res.status(500).json({
      success: false,
      message: '獲取信件失敗'
    });
  }
};

// 新增信件
export const createLetter = async (req, res) => {
  try {
    const { name, message, avatar } = req.body;

    const letter = new Letter({
      name,
      message,
      avatar: avatar || '/assets/images/defaultavatar.jpeg',
      timestamp: new Date()
    });

    await letter.save();

    res.status(201).json({
      success: true,
      message: '信件提交成功',
      letter
    });
  } catch (error) {
    console.error('新增信件錯誤:', error);
    res.status(500).json({
      success: false,
      message: '提交失敗'
    });
  }
};

// 刪除信件 (新增這個功能給後台使用)
export const deleteLetter = async (req, res) => {
  try {
    const { id } = req.params;
    await Letter.findByIdAndDelete(id);
    
    res.status(200).json({
      success: true,
      message: '刪除成功'
    });
  } catch (error) {
    console.error('刪除信件錯誤:', error);
    res.status(500).json({
      success: false,
      message: '刪除失敗'
    });
  }
};