import express from 'express';
import { createLetter, getLetters, deleteLetter } from '../controllers/letterController.js';

const router = express.Router();

router.post('/', createLetter);
router.get('/', getLetters);
router.delete('/:id', deleteLetter);  // 新增刪除路由

export default router;