<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div>
          <h3>會員管理</h3>
          <div class="MmB_searchBar_H">
            <input class="input" type="text" placeholder="搜尋會員編號" />
            <i class="fa-solid fa-magnifying-glass"></i>
          </div>
        </div>
        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>
          <main class="IcB_table_H">
            <table class="MmB_mainTable_H">
              <thead>
                <tr>
                  <th class="MmB_number_H">會員編號</th>
                  <th class="MmB_name_H">姓名</th>
                  <th class="MmB_phone_H">手機</th>
                  <th class="MmB_mail_H">信箱</th>
                  <th class="MmB_pet_H">小寵物</th>
                  <th class="MmB_createDate_H">創建日期</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(member, index) in paginatedMembers" :key="member.id">
                  <!-- <td class="MmB_number_H">113122101</td>
                  <td class="MmB_name_H">王小明</td>
                  <td class="MmB_phone_H">0912345678</td>
                  <td class="MmB_mail_H">tibame@gmail.com</td> -->
                  <td>{{ member.id }}</td>
                  <td>{{ member.account }}</td>
                 
                  <td>{{ member.phoneNumber || "未提供" }}</td>
                  <td>{{ member.email }}</td>
                  <td class="MmB_pet_H">氓阿狐</td>
                  <td>{{ member.createTime }}</td>
                  
                  <!-- <td class="MmB_createDate_H">2025-01-12</td> -->
                  <!-- 這裡加上 @click 事件 -->
                  <td><button class="MmB_editBtn_H" @click="openEditPopup(member)">查看</button></td>
                </tr>

                <!-- <tr>
                  <td class="MmB_number_H">113122102</td>
                  <td class="MmB_name_H">王小明</td>
                  <td class="MmB_phone_H">0912345678</td>
                  <td class="MmB_mail_H">tibame@gmail.com</td>
                  <td class="MmB_pet_H">氓阿狐</td>
                  <td class="MmB_createDate_H">2025-01-12</td>
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr>
                <tr>
                  <td class="MmB_number_H">113122103</td>
                  <td class="MmB_name_H">王小明</td>
                  <td class="MmB_phone_H">0912345678</td>
                  <td class="MmB_mail_H">tibame@gmail.com</td>
                  <td class="MmB_pet_H">氓阿狐</td>
                  <td class="MmB_createDate_H">2025-01-12</td>
                  <td><button class="MmB_editBtn_H" @click="openEditPopup">編輯與查看</button></td>
                </tr> -->
              </tbody>
            </table>
          </main>
        </div>
        <!-- 使用自訂分頁器元件 -->
        <Paginator 
          class="paginator_H"
          :currentPage="currentPage" 
          :totalPages="totalPages" 
          @page-changed="handlePageChange" 
        />
      </div>
    </div>

    <!-- 用 v-if 控制小彈窗的顯示 -->
     <transition name="fade">
    <BackStageSmallPopup class="MmB_EditView_H" v-if="isEditPopupVisible">
      <span class="popup-header">
        <p>編輯與查看</p>
        <!-- 關閉圖示也加上 @click 事件 -->
        <i class="fa-solid fa-x" @click="closeEditPopup"></i>
      </span>
      <!-- <section class="popup-content"> -->
      <div class="popup-content">
        <article class="popup-column">
          <div>
            <p class="label">會員編號:&nbsp;</p>
            <!-- <p>113122101</p> -->
            <p>{{ selectedMember.id || 'N/A' }}</p>
          </div>
          <div>
            <p class="label">帳號:&nbsp;</p>
            <p>{{selectedMember.email || 'N/A' }}</p>
          </div>
          <div>
            <p class="label">姓名:&nbsp;</p>
            <!-- <p>黃小吉</p> -->
             <p>{{ selectedMember.account || 'N/A' }}</p>

          </div>
          <div>
            <p class="label">地址:&nbsp;</p>
            <p>臺北市中山區南京東路三段219號5樓</p>
          </div>
        </article>

        <article class="popup-column">
          <div>
            <!-- <p>性別:&nbsp;</p>
            <p>女</p> -->
            <p class="label">性別:</p>
            <select v-model="selectedMember.gender">
              <option value="male">男</option>
              <option value="female">女</option>
            </select>
          </div>
          <div>
            <p class="label">手機:&nbsp;</p>
            <!-- <p>0912345678</p> -->
            <p>{{ selectedMember.phoneNumber || 'N/A' }}</p>
          </div>
          <div>
            <p class="label">帳號狀態:&nbsp;</p>
            <select v-model="selectedMember.status">
              <option value="1">啟用</option>
              <option value="0">停用</option>
              <option value="2">管理員</option>
              <!-- <option value="suspend">停權</option> -->
            </select>
          </div>
          <div>
            <p class="label">創建時間:&nbsp;</p>
            <!-- <p>2025-01-12</p> -->
            <p>{{ selectedMember.createTime || 'N/A' }}</p>
          </div>
        </article>
        <!-- </section> -->
      </div>
      <div class="popup-footer">
        <button @click="closeEditPopup">取消</button>
        <button @click="savePopup">儲存</button>
      </div>
    </BackStageSmallPopup>
  </transition>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageSmallPopup from '@/components/layout/BackStageLayout/BackStageSmallPopup.vue';
// 引入分頁器元件，請確保此元件已建立
import Paginator from '@/components/paginator.vue';
import { reactive } from "vue";

export default {
  name: 'MemberManagement',
  components: {
    BackStageHeader,
    BackStageSidebar,
    BackStagePaginator, // 若你仍需用到其他的 paginator 樣式
    BackStageSmallPopup,
    Paginator,
  },
  setup() {
    const base_url = import.meta.env.VITE_AJAX_URL; // 確保有設置環境變數
    const members = ref([]);
    // 用來控制小彈窗的顯示 / 隱藏
    const isEditPopupVisible = ref(false);
    
    // 1. 撈取會員資料
    const fetchMembers = async () => {
      try {
        const response = await fetch(`${base_url}/MmB_getmembers.php`);
        members.value = await response.json();
        console.log("後台會員資料:", members.value); // 確認資料
      } catch (error) {
        console.error("撈取會員資料失敗:", error);
      }
    };
    // 點「編輯與查看」時，打開彈窗
    const openEditPopup = (member) => {
      // if (!member) return; // 防呆，確保 `member` 存在
      // selectedMember.value = { ...member }; // 正確存入資料
      Object.assign(selectedMember, member); 
      isEditPopupVisible.value = true;
    };
    // 分頁器狀態
    const currentPage = ref(1);
    const itemsPerPage = 10;
    const totalPages = computed(() => Math.ceil(members.value.length / itemsPerPage));
    const paginatedMembers = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage;
      return members.value.slice(start, start + itemsPerPage);
    });
    const handlePageChange = (newPage) => {
      currentPage.value = newPage;
      window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    const selectedMember = reactive({
      id: "",
      account: "",
      email: "",
      phoneNumber: "",
      status: "",
      createTime: "",
    });
    const closeEditPopup = () => {
      isEditPopupVisible.value = false;
      selectedMember.value = {};
    };


    // 儲存時做一些操作，比如更新會員資料、呼叫 API 等
    // const savePopup = () => {
    //   alert('會員資料已儲存 / 更新');
    //   // 儲存完後關閉視窗
    //   isEditPopupVisible.value = false;
    // };

    // 4️⃣ 更新會員資料 (儲存變更)
    const savePopup = async () => {
      try {
        const response = await fetch(`${base_url}/MmB_updatemember.php`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(selectedMember.value),
        });

        const result = await response.json();
        if (response.ok) {
          alert("會員資料已更新！");
          fetchMembers(); // 重新載入會員列表
          closeEditPopup();
        } else {
          alert("更新失敗：" + result.error);
        }
      } catch (error) {
        console.error("更新會員資料失敗:", error);
      }
    };

    // **在組件載入時撈取會員資料**
    onMounted(fetchMembers);

    return {
      members,  
      currentPage,
      itemsPerPage,
      totalPages,
      paginatedMembers,
      handlePageChange,
      isEditPopupVisible,
      selectedMember,
      openEditPopup,
      closeEditPopup,
      savePopup,
    };
  },
};
</script>

<style lang="css" scoped>

.MmB_EditView_H .popup-content{
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: space-between;
  align-items: flex-start;
  padding: 20px;
}


/* 標題區 */
.popup-header {
  /* display: flex;
  justify-content: space-between;
  align-items: center; */
  font-size: 18px;
  font-weight: bold;
  color: #333;
  border-bottom: 1px solid #ccc;
  padding-bottom: 10px;
}

/* 內容區 */
.popup-content {
  display: flex;
  justify-content: space-between;
  gap: 20px;
  padding: 10px 0;
}

/* 每個欄位區塊 */
.popup-column {
  width: 48%;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
  color: #333;
}

/* 標籤 */
.label {
  font-weight: bold;
  color: #555;
  display: inline-block;
  min-width: 130px;
}

/* 選單 */
select {
  width: 100%;
  padding: 5px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

/* 按鈕區 */
.popup-footer {
  display: flex;
  justify-content: center;
  gap: 10px;
  padding-top: 10px;
}

.popup-footer button {
  padding: 8px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
}

.popup-footer button:first-child {
  background: #ccc;
  color: black;
}

.popup-footer button:last-child {
  background: #5b774a;
  color: white;
}

</style>