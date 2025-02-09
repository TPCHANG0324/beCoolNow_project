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
        <i class="bi bi-share"></i>
      </div>
      <p v-html="article.content"></p>
      <!-- <img :src="article.image" alt="" v-if="article.image" /> -->
    </div>

    <!-- 留言區 -->
    <div class="Fb-message-X">
      <div class="Fb-message-select-X">
        <span>全部留言</span>
        <div class="Fb-message-selectBox-X">
          <select id="" name="">
            <option value="最新" selected>最新</option>
            <option value="最舊">最舊</option>
          </select>
        </div>
      </div>
      <!-- 查看更多 -->
      <div class="Fb-message-section-X">
        <div class="Fb-message-section-seeMore-X">
          <i class="bi bi-chat-left-dots"></i>
          <p>查看更多先前的留言</p>
        </div>
      </div>
      <!-- 其他用戶的留言 -->
      <ul class="Fb-ms-other">
        <div class="Fb-message-section-X">
          <img src="https://picsum.photos/id/239/200/300" alt="" />
          <div class="Fb-message-area-X">
            <div class="Fb-message-self-X">
              <span class="Fb-message-self-name-X">骯髒丹</span>
              <span class="Fb-message-self-time-X">2024-12-19&nbsp;&nbsp;&nbsp;17:10</span>
            </div>
            <div class="Fb-message-content-other-X">
              <span>環保行動多樣，從日常小事做起，讓我們一起守護地球！環保行動多樣，從日常小事做起，讓我們一起守護地球！</span>
              <span>檢舉</span>
            </div>
          </div>
        </div>

        <div class="Fb-message-section-X">
          <img src="https://picsum.photos/id/238/200/300" alt="" />
          <div class="Fb-message-area-X">
            <div class="Fb-message-self-X">
              <span class="Fb-message-self-name-X">蟹堡秘方</span>
              <span class="Fb-message-self-time-X">2024-12-19&nbsp;&nbsp;&nbsp;17:10</span>
            </div>
            <div class="Fb-message-content-other-X">
              <span>這篇文章很棒！提醒我們環保從生活中的小事做起，實用具體的建議讓人更容易採取行動！</span>
              <span>檢舉</span>
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
            <textarea id="" name="" :placeholder="isAuthenticated ? '請輸入您的留言' : '請先登入再進行留言'"></textarea>
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
const article = ref(null);
const selfAvatar = ref(null);
const selfName = ref(null);

//由 props 接收文章的 id
const props = defineProps({
  id: {
    type: String,
    required: true
  }
})
//route.params.id
const fetchArticlesURL = `/tid103/g1/php/getArticles.php?id=${props.id}`;
const fetchArticle = async () => {
  try {
    const res = await fetch(fetchArticlesURL);
    const data = await res.json();
    article.value = data[0];

    //更新標題
    if (data[0] && data[0].title) {
      route.meta.title = data[0].title + ' - 涼城即時';
      document.title = data[0].title + ' - 涼城即時';
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
const handup = async () => {
  try {
    const res = await fetch('/tid103/g1/php/updateLikes.php', {
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
  }
}

//自己的留言區：需要大頭貼和暱稱
const getAvatar = async () => {
  try {
    const res = await fetch(`/tid103/g1/php/getUserInfo.php`)
    const data = await res.json()
    if (data.success) {
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

//輸入留言
const sendMessage = () => {

}

onMounted(() => {
  fetchArticle();
  // 從 localStorage 判斷是否已點過讚，如果有紀錄，就設置到目前的狀態
  const likedArticles = JSON.parse(localStorage.getItem('likedArticles') || '{}');
  if (likedArticles[props.id]) {
    handupActive.value = false
  }
  getAvatar();
  checkLogin();
})


</script>
