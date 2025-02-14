<template>
  <div>
    <MainHeader></MainHeader>
    <header class="Ic_header_R">

       <!-- MP4 影片背景 -->
       <video autoplay muted loop class="Ic_video_bg_R">
        <source src="@/assets/videos/101 taipei new.mp4" type="video/mp4" />
      </video>
      <div class="Ic_wrapper_R">
        <div class="Ic_banner_R">
          <h1 class="Ic_title_R">全球暖化下的臺灣</h1>
          <h1 class="Ic_title2_R">Global warming in Taiwan</h1>
        </div>
      </div>
    </header>

    <div class="Ic_wrapper_R">
      <section class="Ic_icon-section_R">
        <!-- 圖標列表 -->
        <div class="icon-list">
          <button @click="openPanel('Thunderstorm Icon')">
            <font-awesome-icon :icon="['fas', 'cloud-bolt']" class="hover-icon_Info" />
          </button>
          <button @click="openPanel('Wave Icon')">
            <font-awesome-icon :icon="['fas', 'water']" class="hover-icon_Info" />
          </button>
          <button @click="openPanel('Typhoon Icon')">
            <font-awesome-icon :icon="['fas', 'hurricane']" class="hover-icon_Info" />
          </button>
          <button @click="openPanel('Tree Icon')">
            <font-awesome-icon :icon="['fas', 'tree']" class="hover-icon_Info" />
          </button>
          <button @click="openPanel('Temperature Icon')">
            <font-awesome-icon :icon="['fas', 'temperature-arrow-up']" class="hover-icon_Info" />
          </button>
          <button @click="openPanel('CO2 Icon')">
            <font-awesome-icon :icon="['fas', 'head-side-mask']" class="hover-icon_Info" />
          </button>
        </div>

        <!-- 背景遮罩 -->
        <div :class="['overlay', { active: isPanelOpen }]" @click="closePanel"></div>

        <!-- 滑動面板 -->
        <div :class="['slide-panel', { active: isPanelOpen }]">
          <div class="slide-content">
            <button class="close-panel" @click="closePanel">X</button>
            <h3>{{ panelContent.title }}</h3>
            <img v-if="panelContent.image" :src="panelContent.image" alt="Panel Image" />
            <p>{{ panelContent.description }}</p>
          </div>
        </div>
      </section>

      <div class="Ic_ball_R">
        <div class="donut-container">
          <!-- 左旋按鈕 -->
          <button v-show="!isMobile" class="rotate-button left" @click="rotate(-90)">◀</button>

          <!-- DONUT -->
          <h2 class="donut-title">該如何緩解全球暖化呢</h2>
          <div class="rotatable-donut" :style="{ transform: !isMobile ? `rotate(${rotation}deg)` : '' }">
            <div v-for="(section, index) in sections" :key="index" :class="['donut-section', `section-${index + 1}`]"
              :style="isMobile ? { clipPath: 'polygon(50% 50%, 100% 0%, 100% 100%)' } : {}">
              <div>
                <h3 class="section-title">{{ section.title }}</h3>
                <p class="section-text">{{ section.text }}</p>
              </div>
            </div>
          </div>

          <!-- 右旋按鈕 -->
          <button v-show="!isMobile" class="rotate-button right" @click="rotate(90)">▶</button>
        </div>
      </div>
      <!-- 文章管理 -->
      <section class="Ic_conference-section_R">
        <h3>臺灣響應的國際會議</h3>
        <!-- Tabs 按鈕 -->
        <div class="Ic_conference-tabs_R">
          <button v-for="(tab, index) in tabs" :key="tab.id"
            :class="['Ic_tab-button_R', { active: activeTab === tab.id }]" @click="setActiveTab(tab.id)">
            {{ tab.title }}
          </button>
        </div>

        <!-- 內文區塊 -->
        <div class="Ic_conference-content_R">
          <div v-for="(tab, index) in tabs" :key="tab.id" :class="['Ic_tab-content', { active: activeTab === tab.id }]">
            <img :src="tab.image" :alt="tab.title" />
            <p>{{ tab.content }}</p>
          </div>
        </div>
      </section>

      <!-- 教育影片 -->
      <section class="Ic_bottom_R">
        <h3>教育宣導</h3>
        <swiper :space-between="10" navigation pagination class="custom-swiper" :modules="modules"
          :breakpoints="swiperBreakpoints">
          <swiper-slide v-for="(slide, index) in slides" :key="index">
            <div v-if="slide.type === 'youtube'" class="slide-video">
              <iframe width="100%" height="315" :src="slide.src" :title="slide.title" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
            </div>
            <div v-else class="slide-image">
              <img :src="slide.src" :alt="slide.title" />
            </div>
          </swiper-slide>
        </swiper>
      </section>


      <!-- 問答遊戲 -->
      <section class="ic_gamehead_R">
        <h3>暖化問答</h3>
        <!-- 開始畫面 -->
        <div v-if="currentScreen === 'start'" class="start-screen_R">
          <div class="ic_gamebg_R">
            <h3>歡迎來到暖化問答遊戲</h3>
            <button @click="startGame">開始遊戲</button>
          </div>
        </div>

        <!-- 問答畫面 -->
        <div v-if="currentScreen === 'quiz'" class="quiz-screen">
          <div class="Ic_game_R">
            <div class="Ic_game-content_R">
              <div class="Ic_game-question_R" :class="{ 'shake': feedback === '答錯QQ' }">
                <!-- 顯示進度 -->
                <p class="progress_R">第 {{ currentQuestionIndex + 1 }} 題，共 {{ questions.length }} 題</p>
                <h4>{{ currentQuestion.question }}</h4>
                <div class="Ic_game-options_R">
                  <p v-for="(option, index) in currentQuestion.options" :key="index">
                    {{ option }}
                  </p>
                </div>
                <div class="Ic_game-buttons_R">
                  <button v-for="(option, index) in currentQuestion.options" :key="index"
                    :data-correct="index === currentQuestion.correctIndex" @click="submitAnswer(index)">
                    {{ letters[index] }}
                  </button>
                </div>
                <p id="Ic_feedback_R" :class="[feedbackclass]">{{ feedback }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- 結束畫面 -->
        <div v-if="currentScreen === 'end'" class="end-screen_R">
          <div class="gamefinish_R">
            <h3>遊戲結束！</h3>
            <p>您的得分是：{{ score }}/{{ questions.length }}</p>
            <button @click="restartGame">重新開始</button>
          </div>
        </div>
      </section>
    </div>
    <MainFooter></MainFooter>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
import { Navigation, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/swiper-bundle.css';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCloudBolt } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faWater } from '@fortawesome/free-solid-svg-icons';
import { faHurricane } from '@fortawesome/free-solid-svg-icons'; // 匯入 hurricane 圖示
import { faTree } from '@fortawesome/free-solid-svg-icons'; // 匯入 tree 圖示
import { faTemperatureArrowUp } from '@fortawesome/free-solid-svg-icons'; // 匯入圖示
import { faHeadSideMask } from '@fortawesome/free-solid-svg-icons'; // 匯入 head-side-mask 圖示



library.add(faCloudBolt);
library.add(faWater);
library.add(faHurricane);
library.add(faTree);
library.add(faTemperatureArrowUp);
library.add(faHeadSideMask);

export default {
  name: 'MainPage',
  components: {
    MainHeader,
    MainFooter,
    Swiper,
    SwiperSlide,
    FontAwesomeIcon,
  },
  setup() {
    // Panel Logic
    const isPanelOpen = ref(false); // 面板開關
    const panelContent = ref({}); // 面板內容
    const panelData = {
      'Thunderstorm Icon': {
        title: '雷雨',
        image: new URL('@/assets/images/annual_wet.jpg', import.meta.url).href,
        description:
          '地球暖化影響全球降雨模式，根據 IPCC 報告，全球平均氣溫每上升 1°C ，大氣中的水汽量將增加約 7%，導致極端降雨事件增加。同時，全球乾旱區面積擴大，降雨量減少的地區如地中海和非洲部分地區，年降雨量下降 10% 以上。相反，熱帶地區因水循環加速，強降雨頻率增加 30%。這種降雨分布的不均衡不僅影響糧食安全，還加劇洪水和乾旱等極端天氣的威脅，迫切需要全球共同努力減緩暖化進程。',
      },
      'Wave Icon': {
        title: '海浪',
        image: new URL('@/assets/images/slrtrend_tpx_2022 1.png', import.meta.url).href,
        description:
          '台灣沿岸測站數據顯示，海平面每年上升約 3 毫米，顯示全球暖化對沿岸地區的深遠影響。近 50 年來，海洋表面溫度上升約 0.8°C，這種溫度變化不僅導致珊瑚白化現象增加，也改變了海洋生態系統，使得魚群遷徙路徑和生物多樣性面臨挑戰。此外，海岸侵蝕問題日益嚴重，例如雲林及台南地區的海岸線，每年平均退縮達1至2公尺，嚴重威脅沿岸農地、居民與基礎建設的安全。這些數據強調，氣候變遷對海洋與沿岸地區的影響日益加劇，若不積極採取減碳與防護措施，可能造成更大規模的環境與經濟損失。因此，台灣必須加強推廣綠色能源、減少碳排放，並提升沿岸地區的防災能力，確保未來的永續發展。',
      },
      'Typhoon Icon': {
        title: '颱風',
        image: new URL('@/assets/images/typhoon.svg', import.meta.url).href,
        description:
          '極端天氣現象如颱風、暴雨和熱浪正因地球暖化而加劇。根據數據，全球平均氣溫已上升約 1.1°C（相較於工業化前），每增加 1°C，空氣可攜帶7%的更多水汽，導致降雨更為極端。此外，2020 年全球因熱浪創下 49°C 以上的高溫記錄，颱風的風速和頻率也有所增加。例如，台灣地區的豪雨量近 20 年增幅約 15%，導致水患風險顯著提高，影響生態與經濟穩定。',
      },
      'Tree Icon': {
        title: '樹木',
        image: new URL('@/assets/images/w_1350 1.png', import.meta.url).href,
        description:
          '地球暖化對農業造成顯著影響，氣溫上升和極端天氣增加導致作物產量下降。據研究，全球小麥和玉米產量每升高 1°C 分別減少約 6% 和 7%。此外，降雨模式改變導致乾旱頻率增加，影響水稻等需水量高的作物生長。台灣地區近 20 年乾旱次數上升 25%，對農業灌溉造成壓力。病蟲害因暖化範圍擴大，據估計每年全球農業損失達約 77 億美元，威脅糧食安全與農業經濟發展。',
      },
      'Temperature Icon': {
        title: '氣溫',
        image: new URL('@/assets/images/_119312978_temp_rises_since_1850_2x640-nc.png 1.png', import.meta.url).href,
        description:
          '氣溫上升是地球暖化的直接結果，對環境和生態系統造成深遠影響。據聯合國報告，自 1880 年以來，全球平均氣溫已升高約 1.1°C。每升高 1°C，北極海冰面積減少約 13%，對極地生態構成威脅。此外，熱浪頻率和強度增加，2022 年全球熱浪導致歐洲超過 2 萬人死亡。同時，高溫促使海洋升溫，影響珊瑚礁生態，部分珊瑚礁白化率達 50% 以上，生物多樣性面臨危機。',
      },
      'CO2 Icon': {
        title: '二氧化碳',
        image: new URL('@/assets/images/cccooo.svg', import.meta.url).href,
        description:
          '二氧化碳（CO₂）是地球暖化的主要驅動因素，自工業革命以來，大氣中CO₂濃度增加了超過 50%，從 280 ppm 升至 2022 年的約 420 ppm。這導致全球平均氣溫升高約 1.1°C。CO₂ 增加使溫室效應加劇，導致極端天氣、海平面上升以及極地冰層融化。據統計，燃燒化石燃料每年排放約 330 億噸 CO₂，為主要來源。高濃度 CO₂ 還導致海洋酸化，影響海洋生態系統，如珊瑚礁白化和海洋生物多樣性減少。',
      },
    };

    const openPanel = (iconName) => {
      panelContent.value = panelData[iconName] || {};
      isPanelOpen.value = true;
    };

    const closePanel = () => {
      isPanelOpen.value = false;
      panelContent.value = {};
    };

    // donut
    const rotation = ref(0); // 初始旋轉角度
    const sections = ref([
      {
        title: '減少溫室氣體排放',
        text: '大力推動可再生能源如太陽能、風能，逐步淘汰化石燃料，減少二氧化碳和甲烷的排放，從根本上減緩氣候變化。強化能源政策和產業轉型，以達到全球氣候目標。',
      },
      {
        title: '植樹造林',
        text: '增加全球森林覆蓋率，有助於吸收空氣中的二氧化碳，進行碳封存，減緩氣候變化。此外，森林也能改善水質、減少土壤侵蝕，並促進生物多樣性，是長期的環境修復方案。',
      },
      {
        title: '推動低碳生活方式',
        text: '鼓勵民眾減少私家車使用，選擇公共交通、騎行和步行等低碳方式，推廣減少食物浪費和循環經濟。這些行為有助於降低碳排放，從日常生活中積極應對暖化問題。',
      },
      {
        title: '推廣綠色科技',
        text: '加速開發並應用低碳技術，如碳捕捉與儲存（CCS）、清潔能源技術和電動交通工具。這些科技能夠減少排放，提升能源使用效率，為減緩全球暖化提供技術支援。',
      },
    ]);

    const rotate = (angle) => {
      rotation.value += angle;
    };

    // --- 文章管理相關 ---
    // 用來存放從後端撈取的會議文章資料
    const tabs = ref([]);
    // 用來記錄目前活躍的 tab ID
    const activeTab = ref('');
    const base_url = import.meta.env.VITE_AJAX_URL
    // 呼叫後端 API 取得文章管理資料
    const fetchConferenceArticles = async () => {
      try {
        const response = await fetch(`${base_url}/IcB_fetchArticles.php`); // 請根據實際路徑調整
        const data = await response.json();
        // 假設回傳的 data 為陣列，每筆資料至少含有 id, title, image, content
        const transformedData = data.map(item => ({
          id: item.ID,
          title: item.mediaTitle,
          image: item.mediaPic,
          content: item.mediaContents,
        }));
        tabs.value = transformedData;
        if (transformedData.length > 0) {
          activeTab.value = transformedData[0].id;
        }

      } catch (error) {
        console.error('取得會議文章失敗：', error);
      }
    };

    // 設定活躍 tab
    const setActiveTab = (tabId) => {
      activeTab.value = tabId;
    };

    // --- 其他區塊 (例如 Panel、Donut、問答等) 略過，保留原有邏輯 ---

    // 當元件掛載時，呼叫 fetchConferenceArticles
    onMounted(() => {
      fetchConferenceArticles();
    });

    // Quiz Game
    const currentScreen = ref('start');
    const questions = ref([
      {
        question: '哪個是全球暖化導致的常見現象?',
        options: ['A.\t冬季降雪量增加', 'B.\t海平面上升', 'C.\t沙漠地區變得更涼爽'],
        correctIndex: 1,
      },
      {
        question: '哪個行為有助於減少碳排放?',
        options: ['A.\t多吃肉', 'B.\t搭乘大眾交通工具', 'C.\t開冷氣睡覺'],
        correctIndex: 1,
      },
      {
        question: 'COP29 的主要議題之一是什麼?',
        options: ['A.\t協助開發中國家應對氣候變化', 'B.\t氣候變化對北極熊棲息地的影響', 'C.\t太陽能技術的發展和補貼政策'],
        correctIndex: 0,
      },
      {
        question: 'TWCAE 4th 台灣氣候行動高峰論壇的主要目的是什麼?',
        options: [
          'A.\t研究太陽能技術的最新進展',
          'B.\t討論全球石化能源的未來走向',
          'C.\t探討台灣如何在國際舞台上推動氣候政策',
        ],
        correctIndex: 2,
      },
      {
        question: 'TWCAE 4th 提出的台灣碳中和目標的具體實現時間為何?',
        options: ['A.\t2030年', 'B.\t2050年', 'C.\t2100年'],
        correctIndex: 1,
      },
      {
        question: '下列哪種能源是可再生能源?',
        options: ['A.\t太陽能', 'B.\t石油', 'C.\t煤炭'],
        correctIndex: 0,
      },
      {
        question: '哪種溫室氣體的全球暖化潛勢(GWP)最高?',
        options: ['A.\t二氧化碳(CO₂)', 'B.\t甲烷(CH₄)', 'C.\t氟利昂(CFCs)'],
        correctIndex: 2,
      },
    ]);
    const currentQuestionIndex = ref(0);
    const currentQuestion = ref(questions.value[currentQuestionIndex.value]);
    const score = ref(0);
    const feedback = ref('');
    const letters = ['A', 'B', 'C'];
    const feedbackclass = ref(''); // 新增變數儲存動畫 class
    const isShaking = ref(false); // 新增控制晃動的狀態
    const isSubmit = ref(false)

    const startGame = () => {
      currentScreen.value = 'quiz';
      score.value = 0;
      currentQuestionIndex.value = 0;
      currentQuestion.value = questions.value[currentQuestionIndex.value];
    };


    const submitAnswer = (selectedIndex) => {
      if (isSubmit.value === true) return
      isSubmit.value = true
      feedbackclass.value = ''; // 重置動畫
      // isShaking.value = false; // 重置晃動狀態
      console.log(isShaking.value);


      if (selectedIndex === currentQuestion.value.correctIndex) {
        feedback.value = 'YA 答對！';
        feedbackclass.value = 'correct-animation';
        score.value++;
        console.log(isShaking.value);

      } else {
        feedback.value = '答錯 QQ';
        feedbackclass.value = 'wrong-animation';
      // 強制重新觸發晃動動畫
    const questionElement = document.querySelector('.Ic_game-question_R');
    questionElement.classList.remove('shake');
    void questionElement.offsetWidth; // 觸發重排
    questionElement.classList.add('shake');
        
      }

      setTimeout(() => {
        feedback.value = '';
        feedbackclass.value = '';
        isShaking.value = false; // 停止晃動
        console.log(isShaking.value);

        if (currentQuestionIndex.value + 1 < questions.value.length) {
          currentQuestionIndex.value++;
          currentQuestion.value = questions.value[currentQuestionIndex.value];
        } else {
          currentScreen.value = 'end';
        }
        isSubmit.value = false

      }, 1000);
    };

    const restartGame = () => {
      currentScreen.value = 'start';
    };

    // Slideshow
    // Swiper Breakpoints
    const modules = [Navigation, Pagination];
    const slides = ref([]);
    const swiperBreakpoints = {
      830: { slidesPerView: 3, spaceBetween: 10 },
      810: { slidesPerView: 2, spaceBetween: 10 },
      0: { slidesPerView: 1, spaceBetween: 10 },
    };

    // Fetch
    const fetchYoutubeVideos = async (query) => {
      const apiKey = 'AIzaSyCZvTGvYRkTDOAbAeN5FA8QQEybsEQSixk';
      const maxResults = 6;
      const q = `氣候變遷 全球暖化`;
      const url = `https://www.googleapis.com/youtube/v3/search?part=snippet&q=${q}&key=${apiKey}&type=video&safeSearch=strict&video&maxResults=${maxResults}`;
      try {
        const response = await fetch(url);
        const data = await response.json();
        console.log(data)

        // 解析 YouTube 資料
        slides.value = data.items.map((item) => ({
          type: 'youtube',
          src: `https://www.youtube.com/embed/${item.id.videoId}`,
          title: item.snippet.title,
        }));
      } catch (error) {
        console.error('YouTube API 加載失敗:', error);
        slides.value = [
          {
            type: 'error',
            title: '影片加載失敗，請稍後再試',
            src: '',
          },
        ];
      }
    };

    // Mounted Hook
    onMounted(() => {
      fetchYoutubeVideos('教育宣導'); // 初次載入
    });

    return {
      modules: [Navigation, Pagination],
      slides,
      swiperBreakpoints,
      tabs,
      activeTab,
      setActiveTab,
      currentScreen,
      questions,
      currentQuestion,
      currentQuestionIndex,
      score,
      feedback,
      letters,
      startGame,
      submitAnswer,
      restartGame,
      isPanelOpen,
      panelContent,
      openPanel,
      closePanel,
      rotation,
      sections,
      rotate,
    };
  },
};
</script>
