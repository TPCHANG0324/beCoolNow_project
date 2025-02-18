<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <h3>地球信件管理</h3>
        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>
          <main class="IcB_table_H">
            <table class="IcB_mainTable_H">
              <thead>
                <tr>
                  <th class="IcB_number_H">編號</th>
                  <th class="IcB_name_H">使用者名稱</th>
                  <th class="IcB_content_H">內容</th>
                  <th class="IcB_time_H">時間</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
  <tr v-for="(letter, index) in letters" :key="letter._id">
    <td class="IcB_number_H">
      {{ (currentPage - 1) * itemsPerPage + index + 1 }}
    </td>
    <td class="IcB_name_H">{{ letter.name }}</td>
    <td class="IcB_content_H">
      {{ letter.message.substring(0, 50) }}...
    </td>
    <td class="IcB_time_H">{{ formatDate(letter.timestamp).split(' ')[0] }}</td>
    <td>
      <button class="IcB_viewBtn_H" @click="viewLetter(letter)">
        查看
      </button>
    </td>
    <td>
      <button class="IcB_deleteBtn_H" @click="confirmDelete(letter._id)">
        <i class="fa-solid fa-trash-can"></i>
      </button>
    </td>
  </tr>
</tbody>
            </table>
          </main>
        </div>
        <!-- 傳入當前頁與總頁數，並監聽分頁切換事件 -->
        <Paginator
          class="paginator_H"
          :current-page="currentPage"
          :total-pages="totalPages"
          @page-change="handlePageChange"
        />
      </div>
    </div>
    <!-- 查看信件彈窗 -->
    <div v-if="selectedLetter !== null" 
     class="view-popup" 
     @click="closeViewPopup">  <!-- 添加點擊事件 -->
  <div class="popup-content" 
       @click.stop>  <!-- 防止點擊內容區域時關閉 -->
    <h3>{{ selectedLetter.name }} 的信件</h3>
    <p>{{ selectedLetter.message }}</p>
    <p>{{ formatDate(selectedLetter.timestamp).split(' ')[0] }}</p>
    <button @click="closeViewPopup">關閉</button>
  </div>
</div>
    <!-- 刪除確認彈窗 -->
    <BackStageConfirmPopup v-if="showDeletePopup" class="AcB_DeletePopup_H">
      <span></span>
      <div>
        <h3>確定將此留言刪除嗎?</h3>
        <div>
          <button @click="cancelDelete">取消</button>
          <button @click="deleteLetter">確定</button>
        </div>
      </div>
    </BackStageConfirmPopup>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

// 元件引入
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import Paginator from '@/components/paginator.vue';

const letters = ref([]);
const totalLetters = ref(0);
const currentPage = ref(1);
const itemsPerPage = ref(10);
const showDeletePopup = ref(false);
const selectedLetterId = ref(null);
const selectedLetter = ref(null);
const loading = ref(false);

// 取得信件列表，依照當前頁碼與每頁筆數撈取
const fetchLetters = async () => {
  if (loading.value) return;
  loading.value = true;
  try {
    const base_url = import.meta.env.VITE_AJAX_URL;
    const response = await axios.get(`${base_url}/admin_letters.php`, {
      params: {
        page: currentPage.value,
        limit: itemsPerPage.value
      }
    });
    if (response.data.success) {
      letters.value = response.data.letters.map(letter => ({
        _id: letter.id,
        name: letter.poster,
        message: letter.mailContents,
        timestamp: letter.postTime
      }));
      totalLetters.value = response.data.total;
    } else {
      throw new Error(response.data.message || '獲取信件失敗');
    }
  } catch (error) {
    console.error('Error fetching letters:', error);
    alert(error.response?.data?.message || '🍂 獲取信件失敗，請稍後再試！');
  } finally {
    loading.value = false;
  }
};

// 查看信件
const viewLetter = (letter) => {
  selectedLetter.value = letter;
};

// 關閉查看彈窗
const closeViewPopup = () => {
  selectedLetter.value = null;
};

// 顯示刪除確認彈窗
const confirmDelete = (letterId) => {
  selectedLetterId.value = letterId;
  showDeletePopup.value = true;
};

// 取消刪除
const cancelDelete = () => {
  showDeletePopup.value = false;
  selectedLetterId.value = null;
};

// 刪除信件
const deleteLetter = async () => {
  if (loading.value) return;
  loading.value = true;
  
  // 先從畫面上移除該筆信件，並更新總數
  const letterIndex = letters.value.findIndex(letter => letter._id === selectedLetterId.value);
  const letterToDelete = letters.value[letterIndex];
  letters.value = letters.value.filter(letter => letter._id !== selectedLetterId.value);
  totalLetters.value--;

  try {
    const base_url = import.meta.env.VITE_AJAX_URL;
    const response = await axios.delete(`${base_url}/admin_letters.php/${selectedLetterId.value}`);
    if (response.data.success) {
      // 如果刪除成功，不需要重新獲取資料，因為已經更新了
      alert('☘️ 刪除成功');
    } else {
      // 刪除失敗則恢復原資料
      letters.value.splice(letterIndex, 0, letterToDelete);
      totalLetters.value++;
      throw new Error(response.data.message || '刪除失敗');
    }
  } catch (error) {
    console.error('Error:', error);
    alert('🍂 刪除失敗，請稍後再試！');
  } finally {
    loading.value = false;
    showDeletePopup.value = false;
    selectedLetterId.value = null;
  }
};

// 分頁處理：當頁碼變更時，更新 currentPage 並重新撈取資料
const handlePageChange = async (page) => {
  // if (loading.value) return;
  currentPage.value = page;
  await fetchLetters();
};

// 格式化時間
const formatDate = (timestamp) => {
  return new Date(timestamp).toLocaleDateString('zh-TW', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit'
  });
};

// 計算總頁數
const totalPages = computed(() => {
  return Math.ceil(totalLetters.value / itemsPerPage.value);
});

onMounted(() => {
  fetchLetters();
});
</script>

<style scoped>
/* 遮罩層 */
.view-popup {
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
  cursor: pointer;
}

.popup-content {
  background-color: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  max-width: 80%;
  width: fit-content;
  min-width: 300px;
  max-height: 80vh;
  overflow-y: auto;
  position: relative;
  cursor: default;
}

.popup-content h3 {
  margin-bottom: 1rem;
  font-size: 1.5rem;
  color: #333;
}

.popup-content p {
  margin-bottom: 1rem;
  line-height: 1.6;
  color: #666;
}

.popup-content p:last-of-type {
  color: #999;
  font-size: 0.9rem;
}

.popup-content button {
  position: absolute;
  top: 1rem;
  right: 1rem;
  padding: 0.5rem 1rem;
  background-color: #e0e0e0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.popup-content button:hover {
  background-color: #d0d0d0;
}

.view-popup::-webkit-scrollbar {
  width: 6px;
}

.view-popup::-webkit-scrollbar-track {
  background: #f1f1f1;
}

.view-popup::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 3px;
}

.view-popup::-webkit-scrollbar-thumb:hover {
  background: #555;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.view-popup {
  animation: fadeIn 0.3s ease-out;
}
</style>
