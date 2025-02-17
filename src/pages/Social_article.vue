<template>
  <!-- 文章 -->
  <div class="Fb-post-X">
    <!-- 單一文章區 -->
    <div class="Fb-Atricle-X" v-if="article">
      <div class="Fb-Atricle-title-X">{{ article.title }}</div>
      <div class="Fb-Atricle-info-X">
        <img :src="getAvatarSource()" alt="" />
        <div class="Atricle-name-time-X">
          <span style="font-weight: bold;">{{ article.account }}</span>
          <span style="font-size: 12px;">{{ article.time.split(' ')[0] }}&nbsp;&nbsp;{{ article.time.split(' ')[1]
            }}</span>
        </div>
        <i class="bi" :class="handupActive ? 'bi-hand-thumbs-up' : 'bi-hand-thumbs-up-fill'" @click="handup"><span>{{
          article.handup }}</span></i>
        <i class="bi bi-share" @click="shareArticle"></i>
      </div>
      <p v-html="article.content"></p>
      <!-- <img :src="article.image" alt="" v-if="article.image" /> -->
    </div>

    <!-- 留言區 -->
    <div class="Fb-message-X">
      <div class="Fb-message-select-X">
        <span>全部留言</span>
        <div class="Fb-message-selectBox-X">
          <select id="" name="" v-model="messageSort">
            <option value="舊到新" selected>舊到新</option>
            <option value="新到舊">新到舊</option>
          </select>
        </div>
      </div>
      <!-- 查看更多 -->
      <div class="Fb-message-section-X cur" v-if="messages.length > 3" @click="toggleMessages">
        <div class="Fb-message-section-seeMore-X">
          <i class="bi bi-chat-left-dots"></i>
          <p>{{ isShowAll ? '收起留言' : '查看完整留言' }}</p>
        </div>
      </div>
      <!-- 其他用戶的留言 -->
      <ul class="Fb-ms-other">
        <div class="Fb-message-section-X" v-for="message in displayMessages" :key="message.messageID">
          <img :src="otherAvatarSource(message.avatar)" alt="" />
          <div class="Fb-message-area-X">
            <div class="Fb-message-self-X">
              <span class="Fb-message-self-name-X">{{ message.nickname }}</span>
              <span class="Fb-message-self-time-X">{{ message.messageDate.split(' ')[0] }}&nbsp;&nbsp;&nbsp;{{
                message.messageDate.split(' ')[1].slice(0, -3) }}</span>
            </div>
            <div class="Fb-message-content-other-X">
              <span>{{ message.content }}</span>
              <span :style="{ color: message.memberID !== selfId ? '#DA0606' : '#d0ad44' }"
                @click="message.memberID !== selfId ? report(message.messageID) : deleteSelf(message.messageID)">
                {{ message.memberID !== selfId ? '檢舉' : '刪除' }}
              </span>
              <!-- <span @click="report(message.messageID)" v-show="message.memberID !== selfId"
                style="color: #DA0606;">檢舉</span>
              <span @click="deleteSelf(message.messageID)" v-show="message.memberID == selfId"
                style="color: #d0ad44;">刪除</span> -->
            </div>
          </div>
        </div>
      </ul>
      <!-- 自己的留言區 -->
      <div class="Fb-message-section-X self">
        <img :src="selfAvatar" alt="" />
        <div class="Fb-message-area-X">
          <div class="Fb-message-self-X">{{ selfName }}</div>
          <div class="Fb-message-content-X">
            <textarea id="" name="" :placeholder="isAuthenticated ? '請輸入您的留言' : '請先登入再進行留言'"
              v-model="message"></textarea>
          </div>
          <button @click="sendMessage">送出留言</button>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useAuth } from '@/utils/useAuth';

const route = useRoute();
const article = ref(null); //文章
const message = ref(null); //自己的留言
const selfAvatar = ref(null); //自己留言區的大頭貼
const selfName = ref(null); //自己留言區的暱稱
const selfId = ref(null); //自己的 id
const messages = ref([]); //別人的留言
const isShowAll = ref(false); //是否顯示全部的留言
const base_url = import.meta.env.VITE_AJAX_URL //環境路徑

//由 props 接收文章的 id
const props = defineProps({
  id: {
    type: String,
    required: true
  }
})
//route.params.id
const fetchArticlesURL = base_url + `/getArticles.php?id=${props.id}`;
const fetchArticle = async () => {
  try {
    const res = await fetch(fetchArticlesURL);
    const data = await res.json();
    article.value = data.data[0];

    //更新標題
    if (data.data[0] && data.data[0].title) {
      route.meta.title = data.data[0].title + ' - 涼城即時';
      document.title = data.data[0].title + ' - 涼城即時';
    }
  } catch (error) {
    console.error("獲取文章時發生錯誤:", error);
  }
};

//發文者是否使用預設大頭貼判斷
const getAvatarSource = () => {
  return article.imagePath ? imagePath : new URL('@/assets/images/defaultavatar.jpeg', import.meta.url).href
}

//點讚：預設所有人都可以點讚
const handupActive = ref(true);
const isLoading = ref(false); //執行狀態
const handup = async () => {
  if(isLoading.value) return
  try {
    isLoading.value = true
    const res = await fetch(base_url + '/updateLikes.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        articleId: props.id,
        action: handupActive.value ? 'like' : 'unlike'
      })
    });

    const data = await res.json();

    if (data.success) {
      handupActive.value = !handupActive.value;
      article.value.handup = data.newLikeCount;

      // 更新 localStorage
      const likedArticles = JSON.parse(localStorage.getItem('likedArticles') || '{}');
      if (!handupActive.value) { // 點讚後
        likedArticles[props.id] = true;
      } else { // 取消讚後
        delete likedArticles[props.id];
      }
      localStorage.setItem('likedArticles', JSON.stringify(likedArticles));

    } else {
      console.error('更新讚數失敗:', data.message);
    }
  } catch (error) {
    console.error('點讚操作失敗:', error);
  }finally{
    isLoading.value = false //重置狀態
  }
}

//自己的留言區：需要大頭貼和暱稱
const getAvatar = async () => {
  const userEmail = localStorage.getItem('userEmail')
  try {
    const res = await fetch(base_url + `/getMemberInfo.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        userEmail
      })
    })
    const data = await res.json()
    if (data.success) {
      selfId.value = data.data.id
      selfAvatar.value = data.data.avatar || new URL('@/assets/images/defaultavatar.jpeg', import.meta.url).href
      selfName.value = data.data.nickname
    } else {
      selfAvatar.value = `https://picsum.photos/id/240/200/300`
      selfName.value = `訪客`
    }
  } catch (err) {
    console.error(`取得個人資料失敗：${err}`)
  }
}

//獲取是否登入狀態
const { checkAuth, isAuthenticated } = useAuth()
const checkLogin = async () => {
  await checkAuth();
}

//獲取該文章的留言
const getMessage = async () => {
  try {
    const res = await fetch(base_url + `/getMessage.php?id=${props.id}`)
    const data = await res.json()
    if (data.success) {
      messages.value = data.messages
      messages.value = messages.value.filter((item) => {
        return item.messageShelves == 1; //上架的才顯示
      })
    } else {
      console.log(data.message)
    }
  } catch (err) {
    console.error(`獲取留言失敗：${err}`)
  }
}

//留言的排序
const messageSort = ref("舊到新"); //預設排序是 舊到新
watch(messageSort, (newValue) => {
  messages.value = messages.value.reverse();
})

//查看完整留言
const displayMessages = computed(() => {
  if (messages.value.length <= 3) {
    return messages.value;
  }
  return isShowAll.value ? messages.value : messages.value.slice(-3);
});

const toggleMessages = () => {
  isShowAll.value = !isShowAll.value;
};

//檢舉留言：要登入才能檢舉，已經檢舉過紀錄在 localstorage，就不能再檢舉了
const report = async (messageID) => {
  if (!checkLogin) {
    alert('🌏 請先登入！')
    return
  }
  const check = confirm('🌏 是否要檢舉該則留言？');
  if (!check) {
    return
  }
  const records = JSON.parse(localStorage.getItem('reportMessage')) || [];
  if (records.includes(messageID)) {
    alert('🌏 你已檢舉過該則留言！')
    return
  }
  try {
    const res = await fetch(base_url + `/reportMessages.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        messageID
      })
    });
    const data = await res.json();
    if (data.success) {
      alert(data.message)
      records.push(messageID)
      localStorage.setItem('reportMessage', JSON.stringify(records));
    } else {
      alert(data.message)
    }
  } catch (err) {
    console.error(`${err}`)
  }
}

//下架自己的留言
const deleteSelf = async (messageID) => {
  const check = confirm('🌏 是否要刪除該則留言？');
  if (!check) {
    return
  }
  try {
    const res = await fetch(base_url + `/deleteSelfMessage.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        messageID,
        forumBoardId: props.id
      })
    })
    const data = await res.json()
    if (data.success) {
      getMessage();
      alert(data.message);
    }
  } catch (err) {
    console.error(`${err}`);
  }
}


//留言者是否使用預設大頭貼判斷
const otherAvatarSource = (avatar) => {
  return avatar ? avatar : new URL('@/assets/images/defaultavatar.jpeg', import.meta.url).href
}

//輸入留言
const sendMessage = async () => {
  const userEmail = localStorage.getItem('userEmail')
  if (!checkLogin) {
    alert('🌏 請先登入！')
    return
  }
  if (message.value) {
    try {
      const res = await fetch(base_url + `/sendMessage.php`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          id: selfId.value,
          contents: message.value,
          forumBoardId: props.id,
          userEmail
        })
      })
      const data = await res.json()
      if (data.success) { //會再判斷一次是否已經登入
        getMessage();
        alert(data.message)
        message.value = ''
      } else {
        alert('🌏 請先登入再進行操作！')
      }
    } catch (err) {
      console.error(`登入驗證失敗：${err}`)
    }
  } else {
    alert('🌏 不能輸入空留言！')
  }
}

//分享文章
const shareArticle = async () => {
  try {
    // 使用 Clipboard API 複製目前頁面的 URL，需要在 HTTPS 執行
    await navigator.clipboard.writeText(window.location.href);
    alert('🌏 連結已複製');
  } catch (error) {
    console.error('複製連結失敗：', error);
    alert('🍂 無法複製連結');
  }
};

onMounted(() => {
  fetchArticle();
  getMessage();
  // 從 localStorage 判斷是否已點過讚，如果有紀錄，就設置到目前的狀態
  const likedArticles = JSON.parse(localStorage.getItem('likedArticles') || '{}');
  if (likedArticles[props.id]) {
    handupActive.value = false
  }
  getAvatar();
  checkLogin();
})


</script>
