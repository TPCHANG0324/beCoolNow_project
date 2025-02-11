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
                  <td class="IcB_time_H">{{ formatDate(letter.timestamp) }}</td>
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
        <!-- 傳入當前頁、總頁數，並監聽分頁切換事件 -->
        <BackStagePaginator
          :current-page="currentPage"
          :total-pages="totalPages"
          @page-change="handlePageChange"
        />
      </div>
    </div>

    <!-- 查看信件彈窗 -->
    <div v-if="showViewPopup" class="view-popup">
      <div class="popup-content">
        <h3>{{ selectedLetter.name }} 的信件</h3>
        <p>{{ selectedLetter.message }}</p>
        <p>{{ formatDate(selectedLetter.timestamp) }}</p>
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

// 元件匯入
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';

const letters = ref([]);
const totalLetters = ref(0);
const currentPage = ref(1);
const itemsPerPage = ref(10);
const showDeletePopup = ref(false);
const selectedLetterId = ref(null);
const showViewPopup = ref(false);
const selectedLetter = ref(null);
const loading = ref(false);

// 取得信件列表（後台 API 路徑 /api/admin/letters 需與後端對應）
const fetchLetters = async () => {
  loading.value = true;
  try {
    const response = await axios.get('/api/admin/letters', {
      params: {
        page: currentPage.value,
        limit: itemsPerPage.value
      },
      headers: {
        'Content-Type': 'application/json'
        // 如需認證，可加入 'Authorization': `Bearer ${token}`
      }
    });

    if (response.data.success) {
      letters.value = response.data.letters;
      totalLetters.value = response.data.total;
    } else {
      throw new Error(response.data.message || '獲取信件失敗');
    }
  } catch (error) {
    console.error('Error fetching letters:', error);
    alert(error.response?.data?.message || '獲取信件失敗，請稍後再試！');
  } finally {
    loading.value = false;
  }
};

// 查看信件
const viewLetter = (letter) => {
  selectedLetter.value = letter;
  showViewPopup.value = true;
};

// 關閉查看彈窗
const closeViewPopup = () => {
  showViewPopup.value = false;
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

// 刪除信件（後台 API DELETE /api/admin/letters/:id）
// 更新刪除信件函數
const deleteLetter = async () => {
  loading.value = true;
  try {
    const response = await api.delete(`/api/admin/letters/${selectedLetterId.value}`);
    if (response.data.success) {
      await fetchLetters();
      alert('刪除成功');
    } else {
      throw new Error(response.data.message || '刪除失敗');
    }
  } catch (error) {
    console.error('Error:', error);
    alert('刪除失敗，請稍後再試！');
  } finally {
    loading.value = false;
    showDeletePopup.value = false;
    selectedLetterId.value = null;
  }
};

// 分頁處理
const handlePageChange = async (page) => {
  loading.value = true;
  try {
    currentPage.value = page;
    await fetchLetters();
  } catch (error) {
    console.error('Error:', error);
  } finally {
    loading.value = false;
  }
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