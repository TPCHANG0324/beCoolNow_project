<template> 
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div>
          <h3>訊息管理</h3>
          <!-- 搜尋區塊 -->
          <div class="MmB_searchBar_H">
            <input id="" class="input" type="text" name="" placeholder="搜尋E-mail" />
            <i class="fa-solid fa-magnifying-glass"></i>
          </div>
        </div>
        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>
          <main class="IcB_table_H">
            <table class="MmB_mainTable_H">
              <thead>
                <tr>
                  <th class="SpB_number_H">編號</th>
                  <th>姓名</th>
                  <th>mail</th>
                  <th>手機</th>
                  <th>送出日期</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <!-- 使用 paginatedContacts 取代原本的 contactList -->
                <tr v-for="(contact, index) in paginatedContacts" :key="contact.ID">
                  <td class="SpB_number_H">
                    {{ index + (currentPage - 1) * itemsPerPage + 1 }}
                  </td>
                  <td>{{ contact.name }}</td>
                  <td>{{ contact['e-mail'] }}</td>
                  <td>{{ contact.cellPhone }}</td>
                  <td>{{ contact.contactDate }}</td>
                  <td><button class="MmB_editBtn_H" @click="openEditPopup(contact)">查看</button></td>
                  <td class="deleteBtn">
                    <button class="IcB_deleteBtn_H" @click="openDeletePopup(contact.ID)">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </main>
        </div>
        <!-- 使用分頁器元件 -->
        <Paginator 
          class="paginator_H"
          :currentPage="currentPage" 
          :totalPages="totalPages" 
          @page-changed="handlePageChange" 
        />
      </div>
    </div>

    <BackStageMessagePopup
      :isVisible="isMessagePopupVisible"
      :messageData="selectedMessage"
      @close="closeEditPopup"
    />
    <transition name="fade">
      <BackStageConfirmPopup class="AuB_messageDelete_H" v-if="isPopupVisible">
        <span></span>
        <div>
          <h3>確定將此訊息刪除嗎?</h3>
          <div>
            <button @click="closePopup">取消</button>
            <button @click="deleteMessage">確定</button>
          </div>
        </div>
      </BackStageConfirmPopup>
    </transition>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import backStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';
// 引入自訂分頁器元件（請確保此元件已存在）
import Paginator from '@/components/paginator.vue';

export default {
  components: {
    BackStageSidebar,
    backStagePaginator,
    BackStageHeader,
    BackStageConfirmPopup,
    Paginator,
  },
  setup() {
    const isPopupVisible = ref(false);
    const contactList = ref([]); // 後端撈取的資料
    const selectedMessageId = ref(null);
    const base_url = import.meta.env.VITE_AJAX_URL;
    const isMessagePopupVisible = ref(false);
    const selectedMessage = ref({});

    // 撈取訊息資料
    const fetchContacts = async () => {
      try {
        const response = await fetch(`${base_url}/AuB_fettchmessage.php`);
        const data = await response.json();
      //   contactList.value = data; // 將 API 回傳的資料存入 contactList
      // } catch (error) {
      //   console.error('撈取資料失敗:', error);
      // }
      // ✅ 按 ID 由小到大排序 (ASC)
        contactList.value = data.sort((a, b) => a.ID - b.ID); 
      } catch (error) {
        console.error("🍂 撈取資料失敗:", error);
      }
    };
    const openEditPopup = (contact) => {
      selectedMessage.value = { ...contact };
      isMessagePopupVisible.value = true;
    };

    const closeEditPopup = () => {
      isMessagePopupVisible.value = false;
      selectedMessage.value = {};
    };

    // 在頁面載入時撈取資料
    onMounted(fetchContacts);

    // 顯示刪除彈窗
    const openDeletePopup = (id) => {
      selectedMessageId.value = id;
      isPopupVisible.value = true;
    };

    // 關閉彈窗
    const closePopup = () => {
      isPopupVisible.value = false;
      selectedMessageId.value = null;
    };

    // 刪除訊息
    const deleteMessage = async () => {
      if (!selectedMessageId.value) return;
      try {
        const response = await fetch(`${base_url}/AuB_deletemessage.php?id=${selectedMessageId.value}`, {
          method: 'DELETE',
        });
        if (response.ok) {
          // 刪除後更新列表
          contactList.value = contactList.value.filter((item) => item.ID !== selectedMessageId.value);
          closePopup();
        } else {
          console.error('刪除失敗，HTTP 狀態碼:', response.status);
        }
      } catch (error) {
        console.error('刪除時發生錯誤:', error);
      }
    };

    // 範例：新增訊息（此方法可依需求調整）
    const submitForm = async () => {
      try {
        const response = await fetch(`${base_url}/AuB_addmessage.php`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            name: "測試用戶",
            email: "test@example.com",
            phone: "0912345678",
            message: "這是一則測試訊息"
          }),
        });

        const result = await response.json();
        if (response.ok) {
          alert('☘️ 訊息已成功送出！');
          fetchContacts(); // **🔄 立即更新後台資料**
        } else {
          alert('🍂 送出失敗: ' + result.error);
        }
      } catch (error) {
        alert('🍂 提交時發生錯誤，請稍後再試');
        console.error('🍂 提交時發生錯誤:', error);
      }
    };

    // -------------------------------
    // 分頁器功能
    // -------------------------------
    const currentPage = ref(1);
    const itemsPerPage = 10;
    const totalPages = computed(() => Math.ceil(contactList.value.length / itemsPerPage));
    const paginatedContacts = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      return contactList.value.slice(start, end);
    });

    const handlePageChange = (newPage) => {
      currentPage.value = newPage;
      window.scrollTo({
        top: 0,
        behavior: 'smooth',
      });
    };
    const updateArticle = () => {
      isPopupVisible.value = false;
    }
    return {
      isPopupVisible,
      contactList,
      selectedMessageId,
      openEditPopup,
      closeEditPopup,
      openDeletePopup,
      closePopup,
      isMessagePopupVisible,
      selectedMessage,
      deleteMessage,
      fetchContacts,
      submitForm,
      updateArticle,
      // 分頁器相關
      currentPage,
      itemsPerPage,
      totalPages,
      paginatedContacts,
      handlePageChange,
    };
  },
};
</script>
