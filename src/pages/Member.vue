<template>
  <div>
    <MainHeader />

    <div class="wrapperpr">
      <h1 class="profile-title">會員資訊</h1>
      <div class="profile_top">
        <div class="profile-container-special_left">
          <div class="profile-header-special">
            <img :src="userAvatar" alt="會員頭像" class="profile-pic-special" />
            <h1 class="profile-greeting-special" v-if="userData && (userData.name || userData.nickname)">
              {{ userData.nickname || userData.name }} 您好！
            </h1>
          </div>
        </div>

        <div class="profile-container-special_right" v-if="userData && userData.name">
          <div class="profile-info-special">
            <div class="profile-field">
              <label for="nickname" class="label_mb">暱稱</label>
              <template v-if="editStates.nickname">
                <input type="text" id="nickname" v-model="tempData.nickname" placeholder="輸入您的暱稱"
                  class="input_2 input_editing" @keyup.enter="saveField('nickname')" />
                <button class="button_mb" @click="saveField('nickname')">儲存</button>
              </template>
              <template v-else>
                <span class="input_2">{{ userData.nickname }}</span>
                <button class="button_mb" @click="editField('nickname')">修改</button>
              </template>
            </div>

            <div class="profile-field">
              <label for="phone" class="label_mb">手機</label>
              <template v-if="!userData.phone || !isPhoneAdded">
                <input type="text" id="phone" v-model="tempData.phone" placeholder="輸入您的手機"
                  class="input_2 input_editing" @keyup.enter="savePhone"
                  :class="{ 'input-error': validationErrors.phone }" :disabled="isPhoneAdded" />
                <button class="button_mb" @click="savePhone">
                  新增
                </button>
                <span v-if="validationErrors.phone" class="error-message">{{ validationErrors.phone }}</span>

              </template>
              <template v-else>
                <span class="input_2">{{ userData.phone }}</span>
                <button class="button_mb" disabled>已新增的手機號碼</button>
              </template>
            </div>

            <div class="profile-field">
              <label for="email" class="label_mb">信箱</label>
              <span class="input_2 email-display">{{ formatEmail(userData.email) }}</span>
              <button class="button_mb" disabled>已新增的信箱</button>
              <!-- <template v-if="editStates.email">
                <input
                  type="email"
                  id="email"
                  v-model="tempData.email"
                  placeholder="輸入您的信箱"
                  class="input_2 input_editing"
                  @keyup.enter="saveField('email')"
                  :class="{ 'input-error': validationErrors.email }"
                />
                <button class="button_mb" @click="saveField('email')">儲存</button>
                <span v-if="validationErrors.email" class="error-message">{{ validationErrors.email }}</span>
              </template>
              <template v-else>
                <span class="input_2 email-display">{{ formatEmail(userData.email) }}</span>
                <button class="button_mb" @click="editField('email')">修改</button>
              </template> -->
            </div>
          </div>
        </div>
      </div>

      <div class="profile_bottom">
        <div class="purchase-record-special">
          <div class="btn2_btn prof">
            <div class="btn2_btn_top">
              <button class="purchase-record-btn12 rec" @click="showSection('purchase')">購買紀錄</button>
              <button class="purchase-record-btn12 rec" @click="showSection('profile')">個人紀錄</button>
              <button class="purchase-record-btn12 rec" @click="showSection('articles')">文章紀錄</button>
            </div>
            <!-- <div class="bt2_btn_bottom">
              <div class="profile-stats-special exp">
                <p>小寵物經驗值: <strong>{{ personalStats.experience }}</strong> | 累積地球幣: <strong>{{ personalStats.points
                    }}</strong></p>
              </div>
            </div> -->
          </div>

          <div class="table-container_mb">
            <table v-if="activeSection === 'purchase'" class="table_mb">
              <thead>
                <tr>
                  <th>日期</th>
                  <th>商品名稱</th>
                  <th>消費金額</th>
                  <th>來源</th>
                  <th>配送狀態</th>
                  <th>訂單詳情</th>
                </tr>
              </thead>
              <tbody v-for="order in purchaseRecords" :key="order.orderId">
                <tr>
                  <td>{{ order.date.split(" ")[0] }}</td>
                  <td>{{ order.productName }}</td>
                  <td>{{ order.price }}</td>
                  <td>{{ productSource }}</td>
                  <td class="delivered-special">{{ order.status == 1 ? "已出貨" : "未出貨" }}</td>
                  <td><button class="order-detail-btn" @click="showOrderDetail(order)">訂單詳情</button></td>
                </tr>
              </tbody>
            </table>

            <table v-if="activeSection === 'profile'" class="personal-record">
              <thead>
                <tr>
                  <th>日期</th>
                  <th>地球幣</th>
                  <th>經驗值</th>
                </tr>
              </thead>
              <tbody v-for="(record, index) in personalRecords" :key="index">
                <tr>
                  <td>{{ record.date }}</td>
                  <td>{{ record.points }}點</td>
                  <td>{{ record.experience }}.EXP</td>
                </tr>
              </tbody>
            </table>

            <table v-if="activeSection === 'articles'" class="table_arti arti">
              <thead>
                <tr>
                  <th>日期</th>
                  <th>文章類別</th>
                  <th>文章名稱</th>
                  <th>上下架狀態</th>
                  <th>修改</th>
                  <th>刪除</th>
                </tr>
              </thead>
              <tbody v-for="item in personalArticles" :key="item.ID" v-if="personalArticles.length != 0">
                <tr>
                  <td>{{ item.time.split(' ')[0] }}</td>
                  <td>{{ item.category }}</td>
                  <td @click="goToArticle(item.ID)" class="goto">{{ item.title }}</td>
                  <td>{{ item.articleShelves === 1 ? '上架' : '下架' }}</td>
                  <td class="del" @click="updateArticle(item.ID)"><i class="bi bi-pencil-square"></i></td>
                  <td class="del" @click="deleteArticle(item.ID)"><i class="bi bi-trash3-fill"></i></td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td colspan="6">
                    <div style="text-align: start; margin-left: 20px;">
                      <p>尚未有文章記錄，歡迎踴躍發表^_^</p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <OrderDetailPopup :is-visible="showOrderPopup" :order="selectedOrder" @close="closeOrderPopup" />

    <MainFooter class="footer_member" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router';
import MainHeader from '@/components/layout/MainHeader.vue'
import MainFooter from '@/components/layout/MainFooter.vue'
import OrderDetailPopup from '@/pages/popUpdetailshop.vue'

const router = useRouter();
const base_url = import.meta.env.VITE_AJAX_URL //環境路徑

// 基本資料相關的 ref
const userData = ref({
  id: '',
  name: '',
  nickname: '',
  phone: '',
  email: '',
})

const userAvatar = ref(new URL('@/assets/images/defaultavater2.png', import.meta.url).href)
const tempData = ref({
  nickname: '',
  phone: '',
  email: ''
})
const editStates = ref({
  nickname: false,
  phone: false,
  email: false
})
const validationErrors = ref({
  phone: '',
  email: ''
})
const productSource = ref('環保市集');



// 訂單和個人記錄相關的 ref
const activeSection = ref('purchase')
const showOrderPopup = ref(false)
const selectedOrder = ref(null)
const isPhoneAdded = ref(false)
const purchaseRecords = ref([])
// const personalRecords = ref([])
const personalArticles = ref([]) //個人文章
// const personalStats = ref({
//   experience: 200,
//   points: 300
// })

// 驗證函數
// 修改現有的驗證函數
const validatePhone = () => {
  if (!tempData.value.phone) {
    validationErrors.value.phone = '請輸入手機號碼'
    return false;
  }
  const phoneRegex = /^09\d{8}$/
  if (!phoneRegex.test(tempData.value.phone)) {
    validationErrors.value.phone = '請輸入正確的手機格式（09開頭共10碼）'
    return false;
  }
  validationErrors.value.phone = ''
  return true;
}

// 新增手機號碼的函數
const savePhone = async () => {
  if (!validatePhone()) return

  // 先跳出確認視窗
  const confirmAdd = confirm('手機號碼一旦新增無法修改，確定新增嗎？')

  if (confirmAdd) {
    try {
      const formData = new FormData()
      const userEmail = localStorage.getItem('userEmail')
      formData.append('phone', tempData.value.phone.trim())
      formData.append('email', userEmail)
      const base_url = import.meta.env.VITE_AJAX_URL
      const res = await fetch(base_url + '/updateUserInfo.php', {
        method: 'POST',
        body: formData,
        // credentials: 'include'
      })

      const data = await res.json()

      if (data.success) {
        userData.value.phone = tempData.value.phone.trim()
        isPhoneAdded.value = true
        localStorage.setItem('userPhone', userData.value.phone)
        alert('手機號碼新增成功！')
      } else {
        alert(data.message || '新增失敗，請稍後再試')
      }
    } catch (err) {
      console.error('錯誤詳情:', err)
      alert('系統錯誤，請稍後再試')
    }
  } else {
    // 用戶按下取消，清空輸入框並返回編輯狀態
    tempData.value.phone = ''
    validationErrors.value.phone = ''
  }
}
// 新增 editField 函式，用來啟動編輯狀態並將原本資料帶入輸入框
const editField = (field) => {
  editStates.value[field] = true
  tempData.value[field] = userData.value[field]
}


// 完整的驗證函數
const validateField = (field) => {
  if (field === 'email') {
    if (!tempData.value.email) {
      validationErrors.value.email = '請輸入電子郵件'
      return false
    }
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (!emailRegex.test(tempData.value.email)) {
      validationErrors.value.email = '請輸入正確的電子郵件格式'
      return false
    }
    validationErrors.value.email = ''
    return true
  }

  if (field === 'phone') {
    return validatePhone()
  }

  // 其他欄位的驗證邏輯（如果需要的話）
  if (field === 'nickname') {
    if (!tempData.value.nickname?.trim()) {
      validationErrors.value.nickname = '請輸入暱稱'
      return false
    }
    validationErrors.value.nickname = ''
    return true
  }

  return true
}

// API 相關函數
const getUserInfo = async () => {
  try {
    const base_url = import.meta.env.VITE_AJAX_URL

    const userEmail = localStorage.getItem('userEmail')


    // const res = await fetch(base_url+'/getUserInfo.php')

    const res = await fetch(base_url + '/getUserInfo.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        userEmail: userEmail,
      })
    });
    const data = await res.json()

    if (data.success) {
      userData.value = {
        ...userData.value,
        ...data.data
      }

      // 只根據 API 返回的數據來判斷
      if (userData.value.phone) {
        isPhoneAdded.value = true
      }

      //  // 同時檢查 API 回傳資料與 localStorage 中的手機號碼
      //  const storedPhone = localStorage.getItem('userPhone')
      // if (userData.value.phone || storedPhone) {
      //   userData.value.phone = userData.value.phone || storedPhone
      //   isPhoneAdded.value = true
      // }

      // // 如果已有手機號碼，設置為已新增狀態
      // if (userData.value.phone) {
      //   isPhoneAdded.value = true
      // }
      userAvatar.value = data.data.avatar || new URL('@/assets/images/defaultavater2.png', import.meta.url).href
    } else {
      console.error('獲取用戶資料失敗')
    }
  } catch (err) {
    console.error(`獲取用戶資料錯誤：${err}`)
    // 如果 API 失敗，使用本地存儲的資料作為備份
    // const storedPhone = localStorage.getItem('userPhone')
    // if (storedPhone) {
    //   userData.value.phone = storedPhone
    //   isPhoneAdded.value = true
    //   }
  }
}


const getPurchaseRecords = async () => {
  try {

    const memberID = localStorage.getItem("member_ID");
    if (!memberID) {
      console.error("❌ 會員 ID 未找到");
      return;
    }

    const base_url = import.meta.env.VITE_AJAX_URL
    // const res = await fetch(`${base_url}/getPurchaseRecords.php`)
    const res = await fetch(`${base_url}/getPurchaseRecords.php?member_ID=${memberID}`);


    if (!res.ok) throw new Error(`HTTP 錯誤！狀態碼: ${res.status}`);

    const data = await res.json();
    console.log("✅ API 回應:", data);

    if (data.success) {
      purchaseRecords.value = data.records;
    } else {
      console.error("❌ 無法獲取購買紀錄:", data.message);
    }
  } catch (error) {
    console.error("❌ API 錯誤:", error);
  }
}
  // } catch (err) {
  //   console.error(`獲取購買記錄錯誤：${err}`)
  //   // 使用範例資料作為備份
  //   purchaseRecords.value = [
  //     {
  //       orderId: "ORD001",
  //       date: "2024/12/25",
  //       productName: "環保吸管",
  //       price: 300,
  //       quantity: 1,
  //       status: "已送達",
  //       address: "台北市大安區復興南路一段390號2樓",
  //       source: "環保市集"
  //     },
      // {
      //   orderId: "ORD002",
      //   date: "2024/12/20",
      //   productName: "可重複使用水壺",
      //   price: 450,
      //   quantity: 1,
      //   status: "已出貨",
      //   address: "新北市板橋區文化路二段",
      //   source: "環保市集"
      // },
      // {
      //   orderId: "ORD003",
      //   date: "2024/12/15",
      //   productName: "竹纖維餐具組",
      //   price: 580,
      //   quantity: 1,
      //   status: "已送達",
      //   address: "台中市西屯區逢甲路",
      //   source: "環保市集"
      // },
      // {
      //   orderId: "ORD004",
      //   date: "2024/12/10",
      //   productName: "有機棉購物袋",
      //   price: 250,
      //   quantity: 2,
      //   status: "處理中",
      //   address: "高雄市鳳山區",
      //   source: "環保市集"
      // },
      // {
      //   orderId: "ORD005",
      //   date: "2024/12/05",
      //   productName: "天然洗髮精",
      //   price: 380,
      //   quantity: 1,
      //   status: "已送達",
      //   address: "台南市東區",
      //   source: "環保市集"
      // },
      // {
      //   orderId: "ORD006",
      //   date: "2024/12/25",
      //   productName: "環保吸管",
      //   price: 300,
      //   quantity: 1,
      //   status: "已送達",
      //   address: "台北市大安區復興南路一段390號2樓",
      //   source: "環保市集"
      // },
      // {
      //   orderId: "ORD007",
      //   date: "2024/12/20",
      //   productName: "可重複使用水壺",
      //   price: 450,
      //   quantity: 1,
      //   status: "已出貨",
      //   address: "新北市板橋區文化路二段",
      //   source: "環保市集"
      // }
//     ]
//   }
// }

// const getPersonalRecords = async () => {
//   try {
//     const res = await fetch(`${base_url}/getPersonalRecords.php`)
//     const data = await res.json()
//     if (data.success) {
//       personalRecords.value = data.data
//     }
//   } catch (err) {
//     console.error(`獲取個人記錄錯誤：${err}`)
//     // 使用範例資料作為備份
//     personalRecords.value = [
//       { date: "2024/12/25", points: 300, experience: 200 },
//       { date: "2024/12/25", points: 300, experience: 200 },
//       { date: "2024/12/25", points: 300, experience: 200 },
//       { date: "2024/12/25", points: 300, experience: 200 },
//       { date: "2024/12/25", points: 300, experience: 200 }

//     ]
//   }
// }

const personalRecords = ref([
      { date: "2024/12/25", points: 300, experience: 200 },
      { date: "2024/12/25", points: 300, experience: 200 },
      { date: "2024/12/25", points: 300, experience: 200 },
      { date: "2024/12/25", points: 300, experience: 200 },
      { date: "2024/12/25", points: 300, experience: 200 }])


//獲取個人文章記錄
const getPersonalArticles = async () => {
  const memberId = userData.value['id'];
  try {
    const res = await fetch(base_url + '/getMemArti.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        memberId
      })
    })
    const data = await res.json()
    personalArticles.value = data.data
  } catch (err) {
    console.log(err)
  }
}

//連結到個人寫的該篇文章
const goToArticle = (ID) => {
  const check = confirm('請問是否要前往該文章？')
  if (!check) {
    return
  }
  router.push(`/social/article/${ID}`);
}

//刪除個人的文章
const deleteArticle = async (ID) => {
  if (!localStorage.getItem('isLoggedIn') && localStorage.getItem('userEmail')) {
    alert('請先登入再進行操作！')
  }
  const check = confirm('請問是否要刪除此篇文章？')
  if (!check) {
    return
  }
  const checkAgain = confirm('刪除文章後將無法還原，請確認是否要繼續進行操作？')
  if (!checkAgain) {
    return
  }
  try {
    const res = await fetch(base_url + '/deleteSelfArticle.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        ArticleID: ID
      })
    })
    const data = await res.json()
    alert(data.message)
    getPersonalArticles()
  } catch (err) {
    console.error(err)
  }
}

//修改個人的文章
const updateArticle = (ID) => {
  const check = confirm('請問是否要修改此篇文章？')
  if (!check) {
    return
  }
  router.push(`/social_write/edit/${ID}`);
}


// API 更新函式（適用於所有欄位）

const updateUserInfo = async (field, value) => {
  try {
    const formData = new FormData()
    const userEmail = localStorage.getItem('userEmail')
    formData.append(field, value)


    formData.append('email', userEmail)

    const base_url = import.meta.env.VITE_AJAX_URL
    const res = await fetch(base_url + '/updateUserInfo.php', {
      method: 'POST',
      body: formData
    })

    const data = await res.json()
    if (data.success) {
      // 更新本地資料
      userData.value[field] = value
      alert('更新成功！')
      return true
    } else {
      alert(data.message || '更新失敗，請稍後再試')
      return false
    }
  } catch (err) {
    console.error(`更新用戶資料錯誤：${err}`)
    alert('系統錯誤，請稍後再試')
    return false
  }
}


// 修改 saveField 函數
const saveField = async (field) => {
  if (!validateField(field)) return

  if (tempData.value[field]?.trim()) {
    const success = await updateUserInfo(field, tempData.value[field].trim())
    if (success) {
      editStates.value[field] = false
      tempData.value[field] = ''
      validationErrors.value[field] = ''
      // 可選：重新獲取使用者資料來同步最新資訊
      // await getUserInfo()
    }
  }
}


const formatEmail = (email) => {
  return email?.replace(/(.{30})/g, '$1\n') || ''
}

const showSection = (section) => {
  activeSection.value = section
}

const showOrderDetail = (order) => {
  selectedOrder.value = order
  showOrderPopup.value = true
}

const closeOrderPopup = () => {
  showOrderPopup.value = false
  selectedOrder.value = null
}

// 生命週期鉤子
onMounted(async () => {
  await getUserInfo()
  if (userData.value.phone) {
    isPhoneAdded.value = true
  }
  await getPurchaseRecords()
  // await getPersonalRecords()
  await getPersonalArticles()
})
</script>
