import express from 'express';
import { deleteLetter } from '../../controllers/letterController.js'; // 或如果檔案名稱是 letterControllers.js，請調整路徑
const router = express.Router();

router.delete('/:id', deleteLetter);

export default router;
