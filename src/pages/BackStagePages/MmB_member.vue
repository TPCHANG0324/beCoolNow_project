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
                <!-- 迭代 paginatedMembers -->
                <tr v-for="(member, index) in paginatedMembers" :key="member.id">
                  <td class="MmB_number_H">{{ member.id }}</td>
                  <td class="MmB_name_H">{{ member.name }}</td>
                  <td class="MmB_phone_H">{{ member.phone }}</td>
                  <td class="MmB_mail_H">{{ member.email }}</td>
                  <td class="MmB_pet_H">{{ member.pet }}</td>
                  <td class="MmB_createDate_H">{{ member.createDate }}</td>
                  <td>
                    <button class="MmB_editBtn_H" @click="openEditPopup(member)">編輯與查看</button>
                  </td>
                </tr>
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

    <!-- 小彈窗 -->
    <transition name="fade">
      <BackStageSmallPopup class="MmB_EditView_H" v-if="isEditPopupVisible">
        <span>
          <p>編輯與查看</p>
          <i class="fa-solid fa-x" @click="closeEditPopup"></i>
        </span>
        <section>
          <article>
            <div>
              <p>會員編號:&nbsp;</p>
              <p>{{ currentMember.id }}</p>
            </div>
            <div>
              <p>帳號:&nbsp;</p>
              <p>{{ currentMember.email }}</p>
            </div>
            <div>
              <p>姓名:&nbsp;</p>
              <p>{{ currentMember.name }}</p>
            </div>
            <div>
              <p>地址:&nbsp;</p>
              <p>{{ currentMember.address }}</p>
            </div>
          </article>
          <article>
            <div>
              <p>性別:&nbsp;</p>
              <p>{{ currentMember.gender }}</p>
            </div>
            <div>
              <p>手機:&nbsp;</p>
              <p>{{ currentMember.phone }}</p>
            </div>
            <div>
              <p>帳號狀態:&nbsp;</p>
              <select v-model="currentMember.status">
                <option value="normal">正常</option>
                <option value="suspend">停權</option>
              </select>
            </div>
            <div>
              <p>創建時間:&nbsp;</p>
              <p>{{ currentMember.createDate }}</p>
            </div>
          </article>
        </section>
        <div>
          <button @click="closeEditPopup">取消</button>
          <button @click="savePopup">儲存</button>
        </div>
      </BackStageSmallPopup>
    </transition>
  </div>
</template>

<script>
import { ref, computed } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageSmallPopup from '@/components/layout/BackStageLayout/BackStageSmallPopup.vue';
// 引入分頁器元件，請確保此元件已建立
import Paginator from '@/components/paginator.vue';

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
    // 假設會員資料，實際上可透過 API 撈取
    const members = ref([
      { id: '113122101', name: '王小明', phone: '0912345678', email: 'tibame@gmail.com', pet: '氓阿狐', createDate: '2025-01-12', address: '臺北市中山區某路', gender: '女', status: 'normal' },
      { id: '113122102', name: '王小明', phone: '0912345678', email: 'tibame@gmail.com', pet: '氓阿狐', createDate: '2025-01-12', address: '臺北市中山區某路', gender: '女', status: 'normal' },
      { id: '113122103', name: '王小明', phone: '0912345678', email: 'tibame@gmail.com', pet: '氓阿狐', createDate: '2025-01-12', address: '臺北市中山區某路', gender: '女', status: 'normal' },
      // 可加入更多會員資料...
    ]);

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

    // 小彈窗控制
    const isEditPopupVisible = ref(false);
    const currentMember = ref({});

    const openEditPopup = (member) => {
      currentMember.value = member;
      isEditPopupVisible.value = true;
    };

    const closeEditPopup = () => {
      isEditPopupVisible.value = false;
    };

    const savePopup = () => {
      alert('會員資料已儲存 / 更新');
      isEditPopupVisible.value = false;
    };

    return {
      members,
      currentPage,
      itemsPerPage,
      totalPages,
      paginatedMembers,
      handlePageChange,
      isEditPopupVisible,
      currentMember,
      openEditPopup,
      closeEditPopup,
      savePopup,
    };
  },
};
</script>
