<template>
  <header class="Ic_header_R">
    <MainHeader></MainHeader>
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
          <img src="@/assets/images/thunder-rainy.png" alt="Thunderstorm Icon" />
        </button>
        <button @click="openPanel('Wave Icon')">
          <img src="@/assets/images/streamline_tidal-wave-solid.png" alt="Wave Icon" />
        </button>
        <button @click="openPanel('Typhoon Icon')">
          <img src="@/assets/images/mingcute_typhoon-fill.png" alt="Typhoon Icon" />
        </button>
        <button @click="openPanel('Tree Icon')">
          <img src="@/assets/images/mynaui_tree-solid.png" alt="Tree Icon" />
        </button>
        <button @click="openPanel('Temperature Icon')">
          <img src="@/assets/images/fa_thermometer-2.png" alt="Temperature Icon" />
        </button>
        <button @click="openPanel('CO2 Icon')">
          <img src="@/assets/images/iwwa_co2.png" alt="CO2 Icon" />
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
    <button class="rotate-button left" @click="rotate(-90)" v-show="!isMobile">◀</button>

    <!-- DONUT -->
    <h2 class="donut-title">該如何緩解全球暖化呢</h2>
    <div class="rotatable-donut" :style="{ transform: !isMobile ? `rotate(${rotation}deg)` : '' }">
      <div
        v-for="(section, index) in sections"
        :key="index"
        :class="['donut-section', `section-${index + 1}`]"
        :style="isMobile ? { clipPath: 'polygon(50% 50%, 100% 0%, 100% 100%)' } : {}"
      >
        <div>
          <h3 class="section-title">{{ section.title }}</h3>
          <p class="section-text">{{ section.text }}</p>
        </div>
      </div>
    </div>

    <!-- 右旋按鈕 -->
    <button class="rotate-button right" @click="rotate(90)" v-show="!isMobile">▶</button>
  </div>
</div>



    <section class="Ic_conference-section_R">
      <h3>臺灣響應的國際會議</h3>
      <!-- Tabs 按鈕 -->
      <div class="Ic_conference-tabs_R">
        <button v-for="(tab, index) in tabs" :key="index" :class="['Ic_tab-button_R', { active: activeTab === tab.id }]"
          @click="setActiveTab(tab.id)">
          {{ tab.title }}
        </button>
      </div>

      <!-- 內文區塊 -->
      <div class="Ic_conference-content_R">
        <div v-for="(tab, index) in tabs" :key="index" :class="['Ic_tab-content', { active: activeTab === tab.id }]">
          <img :src="tab.image" :alt="tab.title" />
          <p>{{ tab.content }}</p>
        </div>
      </div>
    </section>

    <section class="Ic_bottom_R">
      <h3>教育宣導</h3>
      <swiper
    :space-between="1"
    navigation
    class="custom-swiper"
    :modules="modules"
    :breakpoints="swiperBreakpoints"
  >
    <swiper-slide v-for="(slide, index) in slides" :key="index">
      <div v-if="slide.type === 'youtube'" class="slide-video">
        <iframe
          width="100%"
          height="315"
          :src="slide.src"
          title="YouTube Video"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
          @mouseover="disablePointerEvents"
          @mouseout="enablePointerEvents"
        ></iframe>
      </div>
      <div v-else class="slide-image">
        <img :src="slide.src" :alt="slide.title" />
      </div>
    </swiper-slide>
  </swiper>
    </section>

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
            <div class="Ic_game-question_R">
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
</template>

<script>
import MainHeader from "@/components/layout/MainHeader.vue";
import MainFooter from "@/components/layout/MainFooter.vue";
import  { Navigation, Pagination } from "swiper/modules";

import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/swiper-bundle.css";
import { ref } from "vue";

export default {
  name: "MainPage",
  components: {
    MainHeader,
    MainFooter,
    Swiper,
    SwiperSlide,
  },
  setup() {
    // Panel Logic
    const isPanelOpen = ref(false); // 面板開關
    const panelContent = ref({}); // 面板內容
    const panelData = {
      "Thunderstorm Icon": {
        title: "雷雨",
        image: new URL('@/assets/images/annual_wet.jpg', import.meta.url).href,
        description: "地球暖化影響全球降雨模式，根據IPCC報告，全球平均氣溫每上升1°C，大氣中的水汽量將增加約7%，導致極端降雨事件增加。同時，全球乾旱區面積擴大，降雨量減少的地區如地中海和非洲部分地區，年降雨量下降10%以上。相反，熱帶地區因水循環加速，強降雨頻率增加30%。這種降雨分布的不均衡不僅影響糧食安全，還加劇洪水和乾旱等極端天氣的威脅，迫切需要全球共同努力減緩暖化進程。",
      },
      "Wave Icon": {
        title: "海浪",
        image: new URL('@/assets/images/slrtrend_tpx_2022 1.png', import.meta.url).href,
        description: "台灣沿岸測站數據顯示，海平面每年上升約3毫米，顯示全球暖化對沿岸地區的深遠影響。近50年來，海洋表面溫度上升約0.8°C，這種溫度變化不僅導致珊瑚白化現象增加，也改變了海洋生態系統，使得魚群遷徙路徑和生物多樣性面臨挑戰。此外，海岸侵蝕問題日益嚴重，例如雲林及台南地區的海岸線，每年平均退縮達1至2公尺，嚴重威脅沿岸農地、居民與基礎建設的安全。這些數據強調，氣候變遷對海洋與沿岸地區的影響日益加劇，若不積極採取減碳與防護措施，可能造成更大規模的環境與經濟損失。因此，台灣必須加強推廣綠色能源、減少碳排放，並提升沿岸地區的防災能力，確保未來的永續發展。",
      },
      "Typhoon Icon": {
        title: "颱風",
        image: new URL('@/assets/images/typhoon.svg', import.meta.url).href,
        description: "極端天氣現象如颱風、暴雨和熱浪正因地球暖化而加劇。根據數據，全球平均氣溫已上升約1.1°C（相較於工業化前），每增加1°C，空氣可攜帶7%的更多水汽，導致降雨更為極端。此外，2020年全球因熱浪創下49°C以上的高溫記錄，颱風的風速和頻率也有所增加。例如，台灣地區的豪雨量近20年增幅約15%，導致水患風險顯著提高，影響生態與經濟穩定。",
      },
      "Tree Icon": {
        title: "樹木",
        image: new URL('@/assets/images/w_1350 1.png', import.meta.url).href,
        description: "地球暖化對農業造成顯著影響，氣溫上升和極端天氣增加導致作物產量下降。據研究，全球小麥和玉米產量每升高1°C分別減少約6%和7%。此外，降雨模式改變導致乾旱頻率增加，影響水稻等需水量高的作物生長。台灣地區近20年乾旱次數上升25%，對農業灌溉造成壓力。病蟲害因暖化範圍擴大，據估計每年全球農業損失達約77億美元，威脅糧食安全與農業經濟發展。",
      },
      "Temperature Icon": {
        title: "氣溫",
        image: new URL('@/assets/images/_119312978_temp_rises_since_1850_2x640-nc.png 1.png', import.meta.url).href,
        description: "氣溫上升是地球暖化的直接結果，對環境和生態系統造成深遠影響。據聯合國報告，自1880年以來，全球平均氣溫已升高約1.1°C。每升高1°C，北極海冰面積減少約13%，對極地生態構成威脅。此外，熱浪頻率和強度增加，2022年全球熱浪導致歐洲超過2萬人死亡。同時，高溫促使海洋升溫，影響珊瑚礁生態，部分珊瑚礁白化率達50%以上，生物多樣性面臨危機。",
      },
      "CO2 Icon": {
        title: "二氧化碳",
        image: new URL('@/assets/images/cccooo.svg', import.meta.url).href,
        description: "二氧化碳（CO₂）是地球暖化的主要驅動因素，自工業革命以來，大氣中CO₂濃度增加了超過50%，從280 ppm升至2022年的約420 ppm。這導致全球平均氣溫升高約1.1°C。CO₂增加使溫室效應加劇，導致極端天氣、海平面上升以及極地冰層融化。據統計，燃燒化石燃料每年排放約330億噸CO₂，為主要來源。高濃度CO₂還導致海洋酸化，影響海洋生態系統，如珊瑚礁白化和海洋生物多樣性減少。",
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
        title: "減少溫室氣體排放",
        text: "大力推動可再生能源如太陽能、風能，逐步淘汰化石燃料，減少二氧化碳和甲烷的排放，從根本上減緩氣候變化。強化能源政策和產業轉型，以達到全球氣候目標。",
      },
      {
        title: "植樹造林",
        text: "增加全球森林覆蓋率，有助於吸收空氣中的二氧化碳，進行碳封存，減緩氣候變化。此外，森林也能改善水質、減少土壤侵蝕，並促進生物多樣性，是長期的環境修復方案。",
      },
      {
        title: "推動低碳生活方式",
        text: "鼓勵民眾減少私家車使用，選擇公共交通、騎行和步行等低碳方式，推廣減少食物浪費和循環經濟。這些行為有助於降低碳排放，從日常生活中積極應對暖化問題。",
      },
      {
        title: "推廣綠色科技",
        text: "加速開發並應用低碳技術，如碳捕捉與儲存（CCS）、清潔能源技術和電動交通工具。這些科技能夠減少排放，提升能源使用效率，為減緩全球暖化提供技術支援。",
      },
    ]);

    const rotate = (angle) => {
      rotation.value += angle;
    };

    // Tabs 文章
    const activeTab = ref("Ic_cop29_R");
    const tabs = ref([
      {
        id: "Ic_cop29_R",
        title: "COP29氣候會議",
        image: new URL('@/assets/images/Ic03.png', import.meta.url).href,
        content:
          "COP29氣候會議將於2024年11月在阿塞拜疆首都巴庫舉行，匯聚全球領袖、科學家與環保人士，共同應對氣候挑戰。本次會議核心議題包括協助開發中國家應對氣候變化、更新國家自主貢獻（NDC）目標以及打擊漂綠行為。會議還將討論減少溫室氣體排放、推進綠色技術創新與能源轉型的重要策略。作為全球氣候行動的重要平台，COP29致力於促進各國合作，共同實現巴黎協定下的碳中和目標，維護地球的未來環境可持續性。",
      },
      {
        id: "Ic_twcae_R",
        title: "TWCAE 4th臺灣氣候行動高峰論壇",
        image: new URL('@/assets/images/ccccc.png', import.meta.url).href,
        content:
          "TWCAE 4th臺灣氣候行動高峰論壇於近期在台北舉行，吸引了國內外專家、學者及企業代表參與，共同討論台灣在國際氣候政策中的角色。論壇聚焦於「綠色經濟轉型」與「碳中和目標」的實現策略，強調能源轉型的重要性，並探討如何利用創新技術促進減碳效益。會議還分享了企業在減少碳排放和推動永續發展的成功案例，強調各界合作的重要性。論壇旨在提升台灣於全球氣候行動中的影響力，實現2050淨零碳排的目標，共建永續未來。",
      },
      {
        id: "Ic_law_R",
        title: "氣候變遷因應法",
        image: new URL('@/assets/images/law2.png', import.meta.url).href,
        content:
          "氣候變遷因應法是台灣為應對氣候變遷挑戰的重要立法，目標在於實現2050淨零碳排。該法涵蓋碳定價機制、推廣可再生能源、支持低碳技術發展及強化防災能力，並要求各部門提出減碳計畫。此外，法案鼓勵企業參與減碳行動，推動產業轉型，同時提高公眾環保意識。氣候變遷因應法不僅是國家邁向永續發展的基石，也是台灣在全球氣候行動中扮演關鍵角色的展現。。",
      },
    ]);

    const setActiveTab = (tabId) => {
      activeTab.value = tabId;
    };

    // Quiz Game
    const currentScreen = ref("start");
    const questions = ref([
      {
        question: "哪個是全球暖化導致的常見現象?",
        options: ["A.\t冬季降雪量增加", "B.\t海平面上升", "C.\t沙漠地區變得更涼爽"],
        correctIndex: 1,
      },
      {
        question: "哪個行為有助於減少碳排放?",
        options: ["A.\t多吃肉", "B.\t搭乘大眾交通工具", "C.\t開冷氣睡覺"],
        correctIndex: 1,
      },
      {
        question: "COP29 的主要議題之一是什麼?",
        options: ["A.\t協助開發中國應對氣候變化", "B.\t氣候變化對北極熊棲息地的影響", "C.\t太陽能技術的發展和補貼政策"],
        correctIndex: 0,
      },
      {
        question: "TWCAE 4th 台灣氣候行動高峰論壇的主要目的是什麼?",
        options: ["A.\t研究太陽能技術的最新進展", "B.\t討論全球石化能源的未來走向", "C.\t探討台灣如何在國際舞台上推動氣候政策"],
        correctIndex: 2,
      },
      {
        question: "TWCAE 4th 提出的台灣碳中和目標的具體實現時間為何?",
        options: ["A.\t2030年", "B.\t2050年", "C.\t2100年"],
        correctIndex: 1,
      },
      {
        question: "下列哪種能源是可再生能源?",
        options: ["A.\t太陽能", "B.\t石油", "C.\t煤炭"],
        correctIndex: 0,
      },
      {
        question: "哪種溫室氣體的全球暖化潛勢(GWP)最高?",
        options: ["A.\t二氧化碳(CO₂)", "B.\t甲烷(CH₄)", "C.\t氟利昂(CFCs)"],
        correctIndex: 2,
      },

    ]);
    const currentQuestionIndex = ref(0);
    const currentQuestion = ref(questions.value[currentQuestionIndex.value]);
    const score = ref(0);
    const feedback = ref("");
    const letters = ["A", "B", "C"];
    const feedbackclass = ref(""); // 新增變數儲存動畫 class

    const startGame = () => {
      currentScreen.value = "quiz";
      score.value = 0;
      currentQuestionIndex.value = 0;
      currentQuestion.value = questions.value[currentQuestionIndex.value];
    };

    const submitAnswer = (selectedIndex) => {
  feedbackclass.value = ""; // 重置動畫
  
  if (selectedIndex === currentQuestion.value.correctIndex) {
    feedback.value = "答對！";
    feedbackclass.value = "correct-animation";
    score.value++;
  } else {
    feedback.value = "答錯QQ";
    feedbackclass.value = "wrong-animation";
  }

  setTimeout(() => {
    feedback.value = "";
    feedbackclass.value = "";
    if (currentQuestionIndex.value + 1 < questions.value.length) {
      currentQuestionIndex.value++;
      currentQuestion.value = questions.value[currentQuestionIndex.value];
    } else {
      currentScreen.value = "end";
    }
  }, 1000);
};

    const restartGame = () => {
      currentScreen.value = "start";
    };


    // Slideshow
    // Swiper Breakpoints
    const swiperBreakpoints = {
      830: {
        slidesPerView: 3, // 螢幕寬度 >= 830px
        spaceBetween: 10,
      },
      810: {
        slidesPerView: 2, // 螢幕寬度 >= 830px
        spaceBetween: 10,
      },
      0: {
        slidesPerView: 1, // 螢幕寬度 < 820px
        spaceBetween: 10,
      },
    };
    const slides = [
      {
        type: "youtube",
        src: "https://www.youtube.com/embed/gMsXhjsbo_g",
        title: "YouTube Video 1",
      },
      {
        type: "youtube",
        src: "https://www.youtube.com/embed/9u7CDV3j5-Q?si=8Mxht9IotlriVOBk",
        title: "YouTube Video 2",
      },
      {
        type: "youtube",
        src: "https://www.youtube.com/embed/qAu8OhWL8F4",
        title: "YouTube Video 3",
      },
      {
        type: "youtube",
        src: "https://www.youtube.com/embed/3n2qruJngMg?si=PHAZVKC_piBslp7A",
        title: "YouTube Video 3",
      },
      {
        type: "youtube",
        src: "https://www.youtube.com/embed/U1y6PWTA4Fw?si=pFhNJa5zxE32wHHu",
        title: "YouTube Video 3",
      },
    ];

    // 動態管理 iframe 事件
    const disablePointerEvents = (event) => {
      event.target.style.pointerEvents = "none";
    };

    const enablePointerEvents = (event) => {
      event.target.style.pointerEvents = "auto";
    };

    return {
      modules: [Navigation, Pagination],
      slides,
      swiperBreakpoints,
      disablePointerEvents,
      enablePointerEvents,
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
