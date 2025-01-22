<template>
  <div class="Fp_homeWrapper_H">
    <!-- 首頁_主選單 -->
    <!-- <header class="Fp_Header_H">選單</header> -->
    <MainHeader></MainHeader>
    <!-- 首頁_主視覺Banner區塊 -->
    <section ref="bannerRef" class="Fp_Banner_H">
      <header>
        <article>
          <h2>一場悄悄上演的浩劫<br />地球正在發生改變</h2>
          <router-link to="/activity" class="btn">立刻行動</router-link>
        </article>
        <article>
          <h1>全球</h1>
          <h1>暖化</h1>
        </article>
      </header>
    </section>

    <!-- 首頁_災害Banner區塊 -->
    <section>
      <article class="Fp_disasterIce_H">
        <article class="Fp_textContent_H">
          <h1>極地融冰</h1>
          <p>
            極地冰川因全球暖化加速融化，導致海平面上升、生態失衡。北極冰層減少威脅極地動物生存，南極冰架崩解影響全球氣候循環，突顯減碳與環保行動的重要性。
          </p>
        </article>
      </article>

      <article class="Fp_disasterFire_H">
        <article class="Fp_textContentRight_H">
          <h1>森林野火</h1>
          <p>
            全球暖化推動森林野火頻率與強度攀升，持續高溫與乾燥氣候讓森林成為火災的燃料庫。野火肆虐，不僅吞噬植被與生態，還釋放大量碳排放，形成惡性循環。
          </p>
        </article>
      </article>

      <article class="Fp_disasterTyphoon_H">
        <article class="Fp_textContent_H">
          <h1>極端風暴</h1>
          <p>
            全球暖化導致極端風暴頻率與強度顯著增加。海洋升溫為風暴提供更多能量，水蒸氣含量上升引發更強降雨，氣候系統不穩定性加劇颶風、暴雨等災害。
          </p>
        </article>
      </article>

      <article class="Fp_disasterRain_H">
        <article class="Fp_textContentRight_H">
          <h1>暴雨洪災</h1>
          <p>
            全球暖化導致暴雨洪災頻率和強度不斷上升。升高的氣溫使大氣含水量增加，極端降雨成為常態，引發洪水肆虐，造成生態破壞與生命財產重大損失。
          </p>
        </article>
      </article>
    </section>

    <!-- 首頁_什麼是全球暖化 -->
    <section class="Fp_globalWarming_H">
      <figure>
        <img src="../assets/images/Fp08.png" alt="" />
      </figure>

      <article>
        <section class="Fp_textContent_H">
          <h2>什麼是全球暖化 ?</h2>
          <span>
            是地球平均氣溫持續上升的現象，主要因人類活動排放的溫室氣體（如二氧化碳、甲烷）累積於大氣層，導致溫室效應加劇。<br /><br />其影響包括極地冰川融化、海平面上升、極端天氣事件增多、生態系統失衡以及物種滅絕。<br /><br />暖化改變了全球氣候循環，造成乾旱、洪水和颱風等自然災害的頻率與強度上升，威脅人類居住環境和糧食安全。
          </span>
        </section>
        <section class="Fp_textContent_H">
          <h2>造成的影響</h2>
          <span>
            海平面上升淹沒沿海地區、生態系統失衡導致物種滅絕、極端天氣頻率增加危害農業與生命安全，此外，氣候變遷還引發糧食短缺、疾病傳播及社會經濟不穩等全球性問題。
          </span>
        </section>
        <section class="Fp_textContent_H">
          <h2>暖化的證據</h2>
          <span>
            極地冰川與冰蓋快速融化、海平面上升、全球平均溫度逐年升高、極端氣候事件頻率增加，以及海洋酸化和珊瑚白化等現象，均顯示氣候正快速改變。
          </span>
        </section>
      </article>
    </section>

    <!-- 首頁_暖化證據_二氧化碳 -->
    <section class="Fp_carbonData_H Fp_disaster_H">
      <div>
        <article class="Fp_textContent_H">
          <h2>二氧化碳 上升</h2>
          <p>
            大氣中的二氧化碳濃度持續上升，從前工業時期的約280ppm增至目前超過420ppm。燃燒化石燃料、工業活動與森林砍伐是主要原因，這加劇了溫室效應，導致氣候變遷、極端天氣增多及生態系統失衡。
          </p>
        </article>
        <img id="carbonData" src="../assets/images/Fp09_CO2.png" alt="CO2 Data" />
        <!-- <canvas id="carbonData"></canvas> -->
      </div>
    </section>

    <!-- 首頁_暖化證據_全球氣溫 -->
    <section class="Fp_tempData_H Fp_disaster_H">
      <div>
        <article class="Fp_textContent_H">
          <h2>全球氣溫 上升</h2>
          <p>
            自19世紀工業革命以來，全球氣溫持續上升，已增約1.1°C。這主要由於溫室氣體排放增加，尤其是二氧化碳、甲烷等氣體。氣溫上升加劇了極端天氣事件、冰川融化和海平面上升，對生態環境、農業及人類生活造成廣泛影響。
          </p>
        </article>
        <img id="tempData" src="../assets/images/Fp09_CO2.png" alt="CO2 Data" />
        <!-- <canvas id="tempData"></canvas> -->
      </div>
    </section>

    <!-- 首頁_暖化證據_冰層 -->
    <section class="Fp_iceData_H Fp_disaster_H">
      <div>
        <article class="Fp_textContent_H">
          <h2>冰層 減少</h2>
          <p>
            極地冰層快速融化，尤其在北極和南極地區。北極冰蓋面積逐年減少，南極冰架崩解速度加快。這些變化不僅加速海平面上升，還對當地生態系統和全球氣候循環造成影響，進一步加劇全球暖化的影響。
          </p>
        </article>
        <img id="iceData" src="../assets/images/Fp09_CO2.png" alt="CO2 Data" />
        <!-- <canvas id="iceData"></canvas> -->
      </div>
    </section>

    <!-- 首頁_暖化證據_海平面 -->
    <section class="Fp_seaLevelData_H Fp_disaster_H">
      <div>
        <article class="Fp_textContent_H">
          <h2>海平面 上升</h2>
          <p>
            冰層融化導致海平面上升，預計到2100年，海平面將上升0.3到1米，對低窪沿海地區和島嶼國家構成嚴重威脅。海平面上升可能引發洪水、土地喪失和生態系統崩潰，影響數百萬人的生活。
          </p>
        </article>
        <img id="seaLevelData" src="../assets/images/Fp09_CO2.png" alt="CO2 Data" />
        <!-- <canvas id="seaLevelData"></canvas> -->
      </div>
    </section>

    <!-- 首頁_頁尾 -->
    <!-- <footer class="Fp_Footer_H">頁尾</footer> -->
    <MainFooter class="Fp_indexFooter_H"></MainFooter>
  </div>
</template>

<script>
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
import { RouterLink } from 'vue-router';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { onMounted, ref } from 'vue';

export default {
  name: 'FpBanner',
  setup() {
    const bannerRef = ref(null); // 用來綁定 <section> 元素

    onMounted(() => {
      gsap.registerPlugin(ScrollTrigger);

      // 設定動畫
      const timeline = gsap.timeline({
        scrollTrigger: {
          trigger: bannerRef.value, // 綁定的元素
          start: 'top top', // 滾動動畫的起始點
          end: 'bottom top', // 滾動動畫的結束點
          scrub: true, // 滾動與動畫同步
          pin: true, // 固定 Banner 區塊
        },
      });

      // 文字逐漸放大並淡出
      timeline.to(
        bannerRef.value.querySelectorAll(' article h1'), // 確保找到正確的目標
        {
          scale: 4,
          autoAlpha: 0,
          duration: 60,
          ease: 'slow',
        },
      );

      // 背景圖放大
      timeline.to(
        bannerRef.value,
        {
          scale: 1.2,
          duration: 60,
          ease: 'slow',
        },
        '<', // 與文字動畫同步
      );
    });

    return {
      bannerRef,
    };
  },
};
</script>
