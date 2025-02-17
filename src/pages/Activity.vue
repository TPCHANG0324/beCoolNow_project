<!-- 已經 RWD 820/ 430 完成 -->
<template>
  <div>
    <MainHeader></MainHeader>
    <treeanimation v-if="treePopup !== null"></treeanimation>
    <div class="wrapper">
      <div class="hero-section">
        <video autoplay muted loop playsinline class="banner-video">
          <source src="../assets/videos/leafgrowing.mp4" type="video/mp4">
        </video>
        <div class="hero-text">
          <h1>「綠色行動，從今天開始」</h1>
          <h2>改變，讓奇蹟發生</h2>
        </div>
      </div>
      <h3 class="Ac_h3">21 日減碳環保活動</h3>
      <!-- 卡片容器 -->

      <div class="daily_card" data-expanded="false">
        <!-- 卡片範例 1 -->
        <div
          v-for="(item, key) in cardData.slice(0, cardLimit)"
          :key="key"
          class="AcB_card"
          :class="{ darkGreen_card: key % 2 === 1 }"
        >
          <header>
            <i class="fa-regular fa-circle-check"></i>
            累積<span class="action-count">{{ item.action }}</span
            >次行動
          </header>

          <img :src="item.img" alt="" />

          <h3 class="Ac_h3">{{ item.title }}</h3>
          <article>
            {{ item.desc }}
          </article>
          <button class="btn btn-Ac_done_btn" :class="{ disabled: treePopup === key }" @click="done(key)">
            {{ treePopup === key ? '感謝你的響應！' : '我也完成 +1' }}
          </button>
        </div>
      </div>
    </div>

    <div v-if="cardLimit !== cardData.length" id="learnMoreBtn" class="learn_more">
      <a @click.prevent="expandCards">Learn More</a>
    </div>

    <div v-else class="collapse_section">
      <button id="collapseBtn" class="btnclose" @click.prevent="collapseCards">收合</button>
    </div>
    <hr class="dashed-line" />

    <!-- 信件標題 -->

    <h3 class="Ac_h3"><br />給地球的一封信</h3>

    <!-- 信件展示區 -->

    <div class="letter-container">
      <!-- 信件統計數字 -->
      <!-- 模擬 MacOS 標題列 -->
      <div class="mac-window">
        <div class="mac-buttons">
          <div class="mac-btn red"></div>
          <div class="mac-btn yellow"></div>
          <div class="mac-btn green"></div>
        </div>
      </div>
      <div class="stats-bar">現在總共有 {{ totalLetters }} 封給地球的信</div>

      <!-- 信件卡片結構修改 -->
      <div class="letter scrollable-content">
        <div v-for="(letter, index) in letters" :key="index" class="letter_place1">
          <div class="letter-card">
            <p class="letter-content">
              {{ letter.mailContents }}
            </p>
            <div class="signature-line">
              <div class="spacer"></div>
              <div class="name">- {{ letter.poster }}</div>
            </div>
          </div>
          <img :src="getAvatarPath(letter.avatar)" :alt="letter.poster + '頭像'" class="avatar" />
        </div>
      </div>
    </div>

    <!-- 背景圖片容器 -->
    <div class="background-container">
      <img src="../assets/images/ACd.png" alt="背景圖片" class="background-image" />

      <!-- 信件表單區 -->
      <div class="letter-form-container">
        <form class="letter-form" @submit="handleSubmit">
        <!-- 姓名輸入欄 -->
  <div class="form-group">
    <label for="poster" class="message0">姓名或暱稱：</label>
    <input
      id="poster_Ac"
      v-model="formData.poster"
      type="text"
      placeholder="請輸入您的姓名"
      required
    />
  </div>

  <!-- 信件內容輸入框 -->
  <div class="form-group">
    <label for="mailContents" class="message">信件內容：</label>
    <textarea
      id="mailContents"
      v-model="formData.mailContents"
      placeholder="寫下給地球的一封信吧！"
      required
    ></textarea>
  </div>

  <!-- 驗證碼區塊 -->
  <div class="captcha-group">
    <label for="captcha" class="message1">請輸入驗證碼：</label>
    <input
      id="captcha"
      v-model="formData.captcha"
      type="text"
      required
    />
    <span class="captcha-code">{{ currentCaptcha }}</span>
    <button type="button" class="refresh-captcha" @click="generateCaptcha">換一張</button>
  </div>

          <!-- 送出按鈕 -->
          <button type="submit" class="submit-btn">寫給地球的一封信</button>
        </form>
      </div>
    </div>

    <hr class="dashed-line" />

    <div class="carbon-reduction-card">
      <div class="text-content">
        <h1>今日減碳行動：<br />讓我們一‘碳’究境碳排放的真相</h1>
        <p>
          透過即時的交通資訊與數據化的減碳工具，讓通勤族和環保推動者輕鬆採取更低碳、更高效的生活方式。<br />
          一“碳”究境的友站致力於讓低碳選擇變得便捷且有趣，激發更多人為地球的可持續發展貢獻力量。
        </p>
        <!-- 按鈕部分 -->
  <button class="learn-more-button" @click="goToG2Site">深入了解</button>
      </div>
      <div class="image-content">
    <img
      src="../assets/images/acfinial.png"
      alt="煙囪排放煙霧的圖片"
      @click="goToG2Site"
      style="cursor: pointer;"
    />
  </div>
    </div>
    <member_login class="member_login"></member_login>
    <!-- <loginPopupChange></loginPopupChange> -->
    <MainFooter></MainFooter>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
// import { ref, onMounted } from 'vue';
import axios from 'axios';
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
// import defaultAvatar from '@/assets/images/defaultavatar.jpeg';
// import xiaoming from '@/assets/images/Ac08.jpg';
// import earthMan from '@/assets/images/newAC.png';
import member_login from '../pages/popup.vue';
import popupnewmember from '../pages/popupnewmember.vue';
import treeanimation from '@/components/treeanimation.vue';
import { RouterLink } from 'vue-router';
import loginPopupChange from '@/pages/loginPopupChange.vue';
// import { log } from 'console';
// import Ac02 from '@/assets/images/Ac02.jpg'

// 定義響應式數據
const letters = ref([]);
const totalLetters = ref(0);
const formData = ref({
  poster: '',
  mailContents: '',
  captcha: '',
});

// 添加導航函數
const goToG2Site = () => {
  window.location.href = 'https://tibamef2e.com/tid103/g2/home';
};



// 新增獲取信件列表函數
// const fetchLetters = async () => {
//   try {
//     const response = await axios.get('/api/letters');
//     letters.value = response.data.letters;
//     totalLetters.value = response.data.total;
//   } catch (error) {
//     console.error('Error fetching letters:', error);
//   }
// };
const cardData = ref(
JSON.parse(localStorage.getItem('cardData')) || [
  {
    title: 'Day 1 給地球的一封信',
    desc: '你有沒有什麼話想對地球說呢？無論是祝福、感謝、提醒，或者是另一種真實的聲音，歡迎你用不同的觀點，寫下給地球的一封信。',
    img: new URL('@/assets/images/Ac02.jpg', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 2 現在，花 3 秒鐘和手機一起開啟「專注模式」',
    desc: '開啟手機的「專注模式」，除了可以暫時遠離通知的干擾、沉浸當下，還能減少能源耗損。今天，為自己和手機開啟一段專注時間吧！',
    img: new URL('@/assets/images/Ac03.jpg', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 3 向身邊一棵樹說謝謝',
    desc: '今天抽空走到身邊最近的樹旁，謝謝他吸收二氧化碳、釋放氧氣，也感謝他滋養著以樹為家的植物、動物，豐富了「高空生態系」。',
    img: new URL('@/assets/images/Ac04.jpg', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 4 前往離你最近的公園， 完成一次「無痕」散步',
    desc: '無痕精神，來自無痕山林的概念。前往離你最近的公園，試試看、只留下回憶與足跡，不留下垃圾。',
    img: new URL('@/assets/images/Ac05.jpg', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 5 退訂一份電子報',
    desc: '你「取消訂閱」信箱中超過一個月沒打開的電子報！花 10 秒取消一份天天發送的電子報，每年就能減少 109.5g數位碳排放。',
    img: new URL('@/assets/images/acnew.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 6 打消一個購買念頭',
    desc: '花一分鐘列出最近想買的東西，試著從清單中劃掉一項，決定不買它了！如果不知道要如何刪去，來參考這三個小練習。',
    img: new URL('@/assets/images/Ac07.jpg', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 7 出門前，把餐具、環保杯、購物袋放進包包',
    desc: '養成運動習慣的第一步，是帶運動衣出門；要擁抱更環保、減少廢棄的永續生活，現在把「餐具、環保杯、購物袋」放進包包。',
    img: new URL('@/assets/images/AC_d7.jpg', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 8 和 AI 聊聊 ─ 給「台灣第一個生成式 AI 永續機器人」一個問題',
    desc: '加入「小綠行動中」，並試著輸入一個關於永續的問題。透過生成式 AI永續機器人，隨時隨地，即時獲得永續的解答和靈感。',
    img: new URL('@/assets/images/day08_new.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 9 練習一次：關於洗手的減法',
    desc: '世界衛生組織：「覆蓋雙手表面」的泡沫量已足夠，用太多洗手乳不僅無益、還會耗費更多水。今天試試以平常一半的量來洗手。',
    img: new URL('@/assets/images/AC_Day9.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 10 猜猜看，哪一個是「負碳」國家？',
    desc: '是冰島、不丹，還是紐西蘭？這個國家生產充足的潔淨能源，更以憲法規定國土的森林覆蓋率不低於60%，成為全球少數的負碳國。',
    img: new URL('@/assets/images/AC_day09.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 11 憑直覺比比看，洗髮與保養的「碳排放」高低',
    desc: '每天，我們在洗沐和保養的過程中都會產生碳排放。根據自己的「碳直覺」，比比看洗髮和保養的「碳排放」。',
    img: new URL('@/assets/images/AC_Day11.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 12 下一餐，蔬食',
    desc: '搜尋附近的美味蔬食，下一餐就去吃！美國環境工作小組估算，一餐不吃肉就能減少 760g碳排、約為開車四公里所產生的碳排。',
    img: new URL('@/assets/images/Ac_Day12.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 13 投給你最喜歡的台灣特有種一票',
    desc: '台灣森林覆蓋率超過一半，孕育著豐富的生態和特有種，包括台灣黑熊、台灣山椒魚、紅檜、台灣百合等。',
    img: new URL('@/assets/images/AC_Day13.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 14 找出身邊用最久的物品',
    desc: '花十秒鐘，找出今天身邊陪你最久的物品！也歡迎你拍張照分享你和它的故事，「用久一點」就是為環境做的一件好事。',
    img: new URL('@/assets/images/AC_Day14.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 15 解決碗中最後一粒米',
    desc: '下一餐，把飯菜都吃光！以台灣為例，平均每人每年產生約 22.2 公斤剩食，每餐飯都能以「完食」對地球好一次。',
    img: new URL('@/assets/images/AC_Day15.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 16 自我檢測你的發票雲端等級',
    desc: '以三個分級檢測 (A) 發票都記得存載具 (B) 有載具 App (C) 沒聽過載具，你是哪種？',
    img: new URL('@/assets/images/AC_Day16.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 17 完成一次百分百垃圾分類',
    desc: '買網購、叫外送、喝一瓶罐裝飲料...你會將廢棄物一視同仁嗎？今天嘗試辨識一個可回收的廢棄物，從一般垃圾丟至回收區吧！',
    img: new URL('@/assets/images/AC_Day17.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 18 挑戰：下一餐，少一件垃圾',
    desc: '少一雙免洗筷、少一個塑膠湯匙、或是少一張衛生紙，挑戰讓下一餐少一件垃圾，也許，比想像中還容易！',
    img: new URL('@/assets/images/AC_Day18.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 19 丟掉 3 個冰箱裡不要的東西',
    desc: '維持冰箱最佳表現小訣竅：丟棄那些以為還會拿來吃，但已是陳年食材、醬料。多一些空氣循環，少一些能源消耗與碳排。',
    img: new URL('@/assets/images/AC_Day19.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 20 從衣櫃裡，找出「最熟悉的陌生衣」',
    desc: '找出深埋在衣櫃中那件「最熟悉的陌生衣」，讓你很喜歡卻忘記穿的它，重回日常穿搭！或是，二手與回收，也能賦予它新生命。',
    img: new URL('@/assets/images/AC_DAY20.png', import.meta.url).href,
    action: 1111,
  },
  {
    title: 'Day 21 找到離你最近的「循環杯」',
    desc: '喝飲料、外帶咖啡，不一定要自備環保杯也能降低一次性垃圾？搜尋看看，離你最近的「循環杯」在哪裡？',
    img: new URL('@/assets/images/AC_Day21.png', import.meta.url).href,
    action: 1111,
  },
  ]
);
const currentCaptcha = ref('');
const letterCardWidth = ref(0);
const cardLimit = ref(6);
// const isClicked = ref(false);
const treePopup = ref(null);
const xiaoming = new URL('@/assets/images/Ac08.jpg', import.meta.url).href;
const earthMan = new URL('@/assets/images/newAC.png', import.meta.url).href;
const defaultAvatar = new URL('@/assets/images/defaultavater2.png', import.meta.url).href;

const expandCards = () => {

  cardLimit.value = cardData.value.length;
  // nextTick(() => {
  //   const dailyCard = document.querySelector('.daily_card');
  //   if (dailyCard) {
  //     dailyCard.setAttribute('data-expanded', 'true');
  //   }
  // });
};


const collapseCards = () => {

  cardLimit.value = 6;
  const daily_card_element = document.querySelector('.daily_card');
  daily_card_element.scrollIntoView({
    // top: 0, // 滾動到頂部
    behavior: 'smooth', // 平滑滾動
  });
  // nextTick(() => {
  //   const dailyCard = document.querySelector('.daily_card');
  //   if (dailyCard) {
  //     dailyCard.setAttribute('data-expanded', 'false');
  //   }
  // });
};



// 監聽 letters 變化，保存到 localStorage
watch(
  letters,
  (newLetters) => {
    localStorage.setItem('letters', JSON.stringify(newLetters));
  },
  { deep: true },
);

// 監聽 totalLetters 變化，保存到 localStorage
watch(totalLetters, (newTotal) => {
  localStorage.setItem('totalLetters', newTotal.toString());
});
const done = (key) => {
  let clicked = localStorage.getItem('clicked');
  if(clicked){
    clicked = JSON.parse(clicked);
  }
  if(clicked && clicked['key-'+key]) {
    alert('🌏 一個任務只能打卡一次哦！')
    return
  }

  // 判斷有沒有案過的 STORAGE 有的話就 return
  if(treePopup.value) return
  // isClicked.value = true
  // 遞增 action 計數
  cardData.value[key].action += 1;

  // 儲存到 localStorage
  localStorage.setItem('cardData', JSON.stringify(cardData.value));

  // 設定彈出視窗
  treePopup.value = key;
  // 確定岸好了就設定 localStorage
  if(!clicked){
    clicked = {}
    clicked['key-'+key] = true
    localStorage.setItem('clicked', JSON.stringify(clicked));
  }else{
    clicked['key-'+key] = true
    localStorage.setItem('clicked', JSON.stringify(clicked));
    
  }
  

  setTimeout(() => {
    treePopup.value = null;
  }, 3000);
};

// 監聽 cardData 變化並儲存到 localStorage
watch(cardData, (newCardData) => {
  localStorage.setItem('cardData', JSON.stringify(newCardData));
}, { deep: true });
// 處理頭像路徑的函數
const getAvatarPath = (avatarPath) => {
  try {
    return avatarPath || defaultAvatar;
  } catch (error) {
    return defaultAvatar;
  }
};

// 生成隨機驗證碼
const generateCaptcha = () => {
  const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  let result = '';
  for (let i = 0; i < 4; i++) {
    result += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  currentCaptcha.value = result;
};

// 更新 handleSubmit 函數
// 改進的 handleSubmit 函數
const handleSubmit = async (e) => {
  e.preventDefault();

  // 驗證所有必填欄位
  if (!formData.value.poster.trim()) {
    alert('🌏 請輸入姓名或暱稱');
    return;
  }

  if (!formData.value.mailContents.trim()) {
    alert('🌏 請輸入信件內容');
    return;
  }

  if (!formData.value.captcha) {
    alert('🌏 請輸入驗證碼');
    return;
  }

  // 驗證驗證碼
  if (formData.value.captcha !== currentCaptcha.value) {
    alert('🍂 驗證碼輸入錯誤');
    generateCaptcha(); // 重新生成驗證碼
    formData.value.captcha = ''; // 清空驗證碼輸入
    return;
  }

  try {
    const letterData = {
      poster: formData.value.poster.trim(),
      mailContents: formData.value.mailContents.trim(),
      postTime: new Date().toISOString()
    };

    console.log('準備發送的 letterData:', letterData);

    const base_url = import.meta.env.VITE_AJAX_URL
    const response = await axios.post(`${base_url}/letters.php`, letterData)
    console.log('收到回應內容:', response.data);

    if (response.data?.success) {
      letters.value.unshift({
        ...letterData,
        id: response.data.id || Date.now()
      });

      totalLetters.value++;
      formData.value = { poster: '', mailContents: '', captcha: '' };
      generateCaptcha();
      alert('☘️ 信件已成功提交！');
    } else {
      console.error('後端回傳錯誤內容:', response.data);
      throw new Error('提交失敗：' + (response.data?.message || '未知錯誤'));
    }
  } catch (error) {
    console.log('完整錯誤信息:', {
      errorName: error.name,
      errorMessage: error.message,
      requestURL: error.config?.url,
      requestMethod: error.config?.method,
      requestData: error.config?.data,
      responseStatus: error.response?.status,
      responseData: error.response?.data
    });

    alert('🍂 提交失敗：' + error.message);
  }
};


// 修改 API 配置
const api = axios.create({
  // baseURL: import.meta.env.PROD
  //   ? 'http://localhost/tid103/g1/api'
  //   : '/tid103/g1/api',
  // withCredentials: true,
  headers: {
    'Content-Type': 'application/json',
    'X-Requested-With': 'XMLHttpRequest'
  }
});

// 修改獲取信件列表的函數
// 改進的 fetchLetters 函數
const fetchLetters = async () => {
  try {
    const base_url = import.meta.env.VITE_AJAX_URL;
    const response = await axios.get(`${base_url}/letters.php`);

    if (response.data?.success) {
      letters.value = response.data.letters.map(letter => ({
        poster: letter.poster,
        mailContents: letter.mailContents,
        avatar: defaultAvatar,
        postTime: letter.postTime
      }));

      totalLetters.value = response.data.total;
    }
  } catch (error) {
    console.error('Error fetching letters:', error);
    useDefaultLetters();
  }
};
// 提取默認信件邏輯為獨立函數
const useDefaultLetters = () => {
  letters.value = [
    {
      poster: '瑋宸',
      mailContents: '親愛的地球：\n你好！我是瑋宸，我最喜歡在公園裡跑來跑去，也喜歡去海邊玩沙子。\n媽媽說，我們要愛護你，不能亂丟垃圾，也不能浪費水。地球，我想告訴你，以後我會和同學一起種很多小樹，讓你變得更漂亮。希望等我長大，你還是一個很美麗的大地球！',
      avatar: getAvatarPath(xiaoming),
    },
    {
      poster: '愛你的地球公民',
      mailContents: '親愛的地球：\n謝謝你無私地滋養著我們，給予藍天、白雲、青山與綠水。你的四季輪替，讓我們感受到生命的變化與美好。然而，我們也深知自己的行為正在傷害你。請相信我們仍在努力修補這段關係，從減少塑膠、節能減碳到植樹造林。我們希望未來的你，依然能展現純淨與和平，讓我們的後代也能擁抱你。',
      avatar: getAvatarPath(earthMan),
    }
  ];
  totalLetters.value = letters.value.length;
  localStorage.setItem('letters', JSON.stringify(letters.value));
};

// 組件掛載時初始化
onMounted(async () => {
  try {
    await fetchLetters(); // 從資料庫獲取信件

    if (letters.value.length === 0) {
      // 如果資料庫沒有資料，可以選擇是否要設置默認值
      useDefaultLetters();
    }

    const initializeLetterCardWidth = () => {
      const firstCard = document.querySelector('.letter-card');
      if (firstCard) {
        letterCardWidth.value = firstCard.offsetWidth;
      }
    };

    initializeLetterCardWidth();
    generateCaptcha();
  } catch (error) {
    console.error('Error initializing:', error);
    useDefaultLetters(); // 如果獲取失敗，使用默認信件
  }
});


const initializeNativeJS = () => {
  const treeButtons = document.querySelectorAll('.btn-Ac_done_btn');
  const popup = document.querySelector('.popup');
};



  fetchLetters();
  generateCaptcha();

</script>
