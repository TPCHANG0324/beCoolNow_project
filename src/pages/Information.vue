<template>
  <header class="Ic_header_R">
    <div style="height: 80px; border: 1px solid red">123</div>
    <div class="Ic_wrapper_R">
      <div class="Ic_banner_R">
        <h1 class="Ic_title_R">全球暖化下的臺灣</h1>
        <h1 class="Ic_title2_R">Global warming in Taiwan</h1>
      </div>
    </div>
  </header>

  <div class="Ic_wrapper_R">
    <section class="Ic_icon-section_R">
      <div class="icon-list">
        <button>
          <img src="../assets/images/thunder-rainy.png" alt="Thunderstorm Icon" />
        </button>
        <button>
          <img src="../assets/images/streamline_tidal-wave-solid.png" alt="Wave Icon" />
        </button>
        <button>
          <img src="../assets/images/mingcute_typhoon-fill.png" alt="Typhoon Icon" />
        </button>
        <button>
          <img src="../assets/images/mynaui_tree-solid.png" alt="Tree Icon" />
        </button>
        <button>
          <img src="../assets/images/fa_thermometer-2.png" alt="Temperature Icon" />
        </button>
        <button>
          <img src="../assets/images/iwwa_co2.png" alt="CO2 Icon" />
        </button>
      </div>

      <!-- 滑動內容區域 -->
      <div id="overlay" class="overlay"></div>
      <div id="slidePanel" class="slide-panel">
        <div class="slide-content">
          <button id="closePanel" class="close-panel">X</button>
          <p id="panelText">
            過去影響臺灣颱風提供三種颱風強度的歷年分析： 資料來源：日本氣象廳(JMA) Best
            Track(1977年後才有風速資料)更新日期：依JMA Best
            Track更新速率不定期更新颱風強度分類方式：依中央氣象署(CWA)定義之輕度、中度及強烈颱風風速，將JMA近颱風中心的十分鐘最大平均風速進行分類，強度分級如下：輕颱(
            64knots ＞平均風速 ≧ 35knots )中颱( 100knots ＞平均風速 ≧ 64knots )強颱(平均風速 ≧
            100knots)影響臺灣定義：颱風中心進到距臺灣海岸線300公里範圍內
          </p>
        </div>
      </div>

      <div class="Ic_icon-description_R">
        <p>
          全球暖化對臺灣的影響日益顯著。氣溫上升導致熱浪頻繁，並影響農作物生長與水資源供應。海平面上升威脅臺灣沿海地區，可能引發洪水與土地侵蝕。此外，極端天氣如強烈颱風和乾旱現象增多，造成基礎設施損毀與災後重建壓力。臺灣極需加強減碳措施和提升防災能力，以應對這些挑戰。
        </p>
      </div>
    </section>

    <div class="Ic_ball_R" style="height: 1020px; border: 1px solid blue">
      <!-- 暫定空白 -->
    </div>

    <section class="Ic_conference-section_R">
      <h3>臺灣響應的國際會議</h3>
      <div class="Ic_conference-tabs_R">
        <button class="Ic_tab-button_R active" data-tab="Ic_cop29_R">COP29氣候會議</button>
        <button class="Ic_tab-button_R" data-tab="Ic_twcae_R">TWCAE 4th臺灣氣候行動高峰論壇</button>
        <button class="Ic_tab-button_R" data-tab="Ic_law_R">氣候變遷因應法</button>
      </div>

      <div class="Ic_conference-content_R">
        <div id="Ic_cop29_R" class="Ic_tab-content active">
          <img src="../assets/images/Ic03.png" alt="COP29" />
          <p>
            即聯合國氣候變化綱要公約第29屆締約方大會，於2024年11月11日至22日在亞塞拜然首都巴庫舉行。
            本次會議的主要議題包括： 1. 協助開發中國應對氣候變遷 2. 更新國家自主貢獻 (NDC) 3. 打擊漂綠行為
          </p>
        </div>

        <div id="Ic_twcae_R" class="Ic_tab-content">
          <img src="../assets/images/Ic03.png" alt="TWCAE 4th" />
          <p>
            TWCAE 4th 臺灣氣候行動高峰論壇聚焦於臺灣如何在國際舞台上推動氣候政策，並促進綠色經濟轉型。
            本次論壇將邀請多方專家共同探討未來行動方向。
          </p>
        </div>

        <div id="Ic_law_R" class="Ic_tab-content">
          <img src="../assets/images/Ic03.png" alt="Climate Law" />
          <p>
            氣候變遷因應法為臺灣重要的氣候法律之一，旨在減少溫室氣體排放並提升防災能力。
            該法案包括國家碳中和目標與執行策略。
          </p>
        </div>
      </div>
    </section>

    <section class="Ic_bottom_R">
      <h3>教育宣導</h3>
      <swiper-container init="false" class="my-swiper">
        <!-- Slide 1 -->
        <swiper-slide>
          <div class="slide-content">
            <img src="https://via.placeholder.com/265x294" alt="影片縮圖" />
            <p>COP29 臺灣參與氣候行動</p>
          </div>
        </swiper-slide>

        <!-- Slide 2 -->
        <swiper-slide>
          <div class="slide-content">
            <img src="https://via.placeholder.com/265x294" alt="影片縮圖" />
            <p>北極熊的呼喊</p>
          </div>
        </swiper-slide>

        <!-- Slide 3 -->
        <swiper-slide>
          <div class="slide-content">
            <img src="https://via.placeholder.com/265x294" alt="影片縮圖" />
            <p>二氧化碳對地球暖化的影響</p>
          </div>
        </swiper-slide>
      </swiper-container>
    </section>

    <section>
      <div class="Ic_game_R">
        <h3>暖化問答</h3>
        <div class="Ic_game-content_R">
          <div class="Ic_game-question_R">
            <h4>哪個是全球暖化導致的常見現象?</h4>
            <div class="Ic_game-options_R">
              <p>A. 冬季降雪量增加</p>
              <p>B. 海平面上升</p>
              <p>C. 沙漠地區變得更涼爽</p>
            </div>
            <div class="Ic_game-buttons_R">
              <button data-correct="false">A</button>
              <button data-correct="true">B</button>
              <button data-correct="false">C</button>
            </div>
            <p id="Ic_feedback_R"></p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {};
</script>
