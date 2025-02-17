<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div class="CB_tag_H">
          <h3 class="CB_titleM_H">留言板管理</h3>
          <div class="MmB_searchBar_H">
            <input id="" class="input" type="text" name="" placeholder="搜尋 文章編號 或 留言關鍵字" v-model="searchText" />
            <i class="fa-solid fa-magnifying-glass"></i>
          </div>
        </div>
        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>

          <main class="main">
            <div class="CB_TableM_H">
              <table class="CB_mainMTable_H">
                <thead>
                  <tr>
                    <th class="CB_numberM_H">文章編號</th>
                    <th class="CB_memberIdM_H">會員編號</th>
                    <th class="CB_contentM_H">留言內容</th>
                    <th class="CB_editDateM_H">留言日期</th>
                    <th class="CB_report_H">被檢舉數量</th>
                    <th class="CB_goOffM_H">狀態</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="mes in datas" :key="mes.messageID">
                    <td>{{ mes.articleID }}</td>
                    <td>{{ mes.memberID }}</td>
                    <td class="CB_content_H">{{ mes.content }}</td>
                    <td>{{ mes.messageDate.split(' ')[0] }}</td>
                    <td>{{ mes.reportCount }}</td>
                    <td :style="{ color: mes.messageShelves ? '#545454' : 'rgba(84, 84, 84, 0.5)' }">{{
                      mes.messageShelves ? '上架' : '下架' }}</td>
                    <td><button class="MmB_editBtn_H" @click="openEditPopup(mes)">編輯與查看</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <Paginator :currentPage="currentP" :totalPages="totalItemCount" @page-changed="handlePageChange" />
          </main>
        </div>
        <!-- <BackStagePaginator></BackStagePaginator> -->

      </div>
    </div>

    <!-- 留言板 下架 -->
    <!-- <transition name="fade">
      <BackStageConfirmPopup class="CB_goOffMessage_H" v-if="isPopupVisible">
        <span></span>
        <div>
          <h3>確定將此留言下架嗎?</h3>
          <div>
            <button @click="closePopup">取消</button>
            <button @click="updateArticle">確定</button>
          </div>
        </div>
      </BackStageConfirmPopup>
    </transition> -->

    <!-- 編輯留言的彈窗 -->
    <transition name="fade">
      <BackStageBigPopup class="SpB_editProduct_H" v-if="isEditPopupVisible">
        <span>
          <p>文章留言&nbsp;編輯與查看</p>
          <!-- 這裡也可以加上 @click="closeEditPopup" 讓使用者點 X 就能關閉 -->
          <i class="fa-solid fa-x" @click="closeEditPopup"></i>
        </span>
        <!-- <section>
          <article class="SpB_leftBlockPopup_H">
            <div>
              <p>文章編號:&nbsp;</p>
              <p>{{ currentMes.articleID }}</p>
            </div>
            <div>
              <p>會員編號:&nbsp;</p>
              <p>{{ currentMes.memberID }}</p>
            </div>
            <div>
              <p>留言內容:&nbsp;</p>
              <p>{{ currentMes.content }}</p>
            </div>
            <div>
              <p>留言日期:&nbsp;</p>
              <p>{{ currentMes.messageDate.split(' ')[0] }}</p>
            </div>
            <div>
              <p>被檢舉數量:&nbsp;</p>
              <p>{{ currentMes.reportCount }}</p>
            </div>
          </article>
          <article class="SpB_rightBlockPopup_H">
            <div>
              <p>狀態:&nbsp;</p>
              <select v-model="currentMes.messageShelves">
                <option :value="1">上架</option>
                <option :value="0">下架</option>
              </select>
            </div>
          </article>
        </section> -->
        <section class="arti">

          <div class="inn">
            <p>文章標題： {{ currentMes.articleTitle }}</p>
            <p>文章編號： {{ currentMes.articleID }}</p>
          </div>
          <div class="inn">
            <p>留言日期： {{ currentMes.messageDate.split(' ')[0] }}</p>
            <p>會員編號： {{ currentMes.memberID }}</p>
          </div>
          <div class="inn">
            <p>檢舉數量：{{ currentMes.reportCount }}</p>
            <p>留言狀態:
              <select v-model="currentMes.messageShelves">
                <option :value="1">上架</option>
                <option :value="0">下架</option>
              </select>
            </p>
          </div>
          <div class="inn">
            <p>留言內容： {{ currentMes.content }}</p>
          </div>
          
        </section>
        <div>
          <button @click="closeEditPopup">取消</button>
          <button @click="savePopup">儲存</button>
        </div>
      </BackStageBigPopup>
    </transition>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import BackStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageBigPopup from '@/components/layout/BackStageLayout/BackStageBigPopup.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';
import Paginator from '@/components/paginator.vue';

const base_url = import.meta.env.VITE_AJAX_URL //環境路徑
const isEditPopupVisible = ref(false); // 控制「編輯彈窗」是否顯示
const searchID = ref(''); // 搜尋框的ID
const searchText = ref(''); // 搜尋框的文字

//載入留言資料
const messages = ref([]);
const fetchMess = async () => {
  try {
    const res = await fetch(base_url + '/getMessage.php')
    const data = await res.json()
    if (data.success) {
      messages.value = data.messages;
      messages.value = messages.value.reverse();
      // console.log(messages.value)
    } else {
      console.log(data)
    }
  } catch (err) {
    console.error(err)
  }
}

const currentMes = ref(null); //存儲目前開啟彈窗的內容
// 開啟編輯彈窗
const openEditPopup = (mes) => {
  currentMes.value = JSON.parse(JSON.stringify(mes));
  isEditPopupVisible.value = true;
};

//修改並存儲數據
const savePopup = async () => {
  try {
    const res = await fetch(base_url + `/deleteSelfMessage.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        messageID: currentMes.messageID
      })
    })
    const data = await res.json()
    if (data.success) {
      alert('留言下架成功！');
      isEditPopupVisible.value = false;
      fetchMess()
    } else {
      console.log(data)
    }
  } catch (err) {
    console.error(err)
  }
}

// 關閉編輯彈窗
const closeEditPopup = () => {
  isEditPopupVisible.value = false;
};

//篩選留言
const filterMessages = computed(() => {
  if (!searchText) {
    return messages.value
  }
  return messages.value.filter((item) => {
    return (
      String(item.articleID).includes(searchText.value) ||
      String(item.content).includes(searchText.value)
    )
  })
})

//計算頁數 //一頁十筆留言
const currentP = ref(1); //當前頁碼，預設 1

const totalItemCount = computed(() => {
  return Math.ceil(filterMessages.value.length / 10);
});

//當翻頁的時候，就更新當前的頁碼
const handlePageChange = (newPage) => {
  currentP.value = newPage;
  window.scrollTo({
    top: 0, // 滾動到頂部
    behavior: 'smooth', // 平滑滾動
  });
};

//真正要渲染到頁面的文章資料
const datas = computed(() => {
  const start = (currentP.value - 1) * 10;
  const to = currentP.value * 10;
  return filterMessages.value.slice(start, to);
})


onMounted(() => {
  fetchMess()
})


/* 原本的編輯方式(checkbox) */
// 直接定義響應式狀態  
// const isPopupVisible = ref(false);
// // 方法可以直接定義  
// const openPopup = () => {
//   isPopupVisible.value = true;
// };
// const closePopup = () => {
//   isPopupVisible.value = false;
// };
// const updateArticle = () => {
//   alert('已下架');
//   isPopupVisible.value = false;
// };
// const deleteArticle = () => {
//   alert('已刪除');
// };  
</script>
