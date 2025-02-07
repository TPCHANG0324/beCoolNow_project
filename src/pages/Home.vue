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
          <RouterLink to="/activity" class="btn">立刻行動</RouterLink>
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
        <article class="Fp_textContent_H leftBlock">
          <h1>極地融冰</h1>
          <p>
            極地冰川因全球暖化加速融化，導致海水面上升、生態失衡。北極冰層減少威脅極地動物生存，南極冰架崩解影響全球氣候循環，突顯減碳與環保行動的重要性。
          </p>
        </article>
      </article>

      <article class="Fp_disasterFire_H">
        <article class="Fp_textContentRight_H rightBlock">
          <h1>森林野火</h1>
          <p>
            全球暖化推動森林野火頻率與強度攀升，持續高溫與乾燥氣候讓森林成為火災的燃料庫。野火肆虐，不僅吞噬植被與生態，還釋放大量碳排放，形成惡性循環。
          </p>
        </article>
      </article>

      <article class="Fp_disasterTyphoon_H">
        <article class="Fp_textContent_H leftBlock">
          <h1>極端風暴</h1>
          <p>
            全球暖化導致極端風暴頻率與強度顯著增加。海洋升溫為風暴提供更多能量，水蒸氣含量上升引發更強降雨，氣候系統不穩定性加劇颶風、暴雨等災害。
          </p>
        </article>
      </article>

      <article class="Fp_disasterRain_H">
        <article class="Fp_textContentRight_H rightBlock">
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
        <div class="earth_animation"></div>
        <!-- <img src="../assets/images/Fp08.png" alt="" /> -->
      </figure>

      <article>
        <section class="Fp_textContent_H">
          <h2>什麼是全球暖化 ?</h2>
          <span>
            是地球平均溫度持續上升的現象，主要因人類活動排放的溫室氣體（如二氧化碳、甲烷）累積於大氣層，導致溫室效應加劇。<br /><br />其影響包括極地冰川融化、海水面上升、極端天氣事件增多、生態系統失衡以及物種滅絕。<br /><br />暖化改變了全球氣候循環，造成乾旱、洪水和颱風等自然災害的頻率與強度上升，威脅人類居住環境和糧食安全。
          </span>
        </section>
        <section class="Fp_textContent_H">
          <h2>造成的影響</h2>
          <span>
            海水面上升淹沒沿海地區、生態系統失衡導致物種滅絕、極端天氣頻率增加危害農業與生命安全，此外，氣候變遷還引發糧食短缺、疾病傳播及社會經濟不穩等全球性問題。
          </span>
        </section>
        <section class="Fp_textContent_H">
          <h2>暖化的證據</h2>
          <span>
            極地冰川與冰蓋快速融化、海水面上升、全球平均溫度逐年升高、極端氣候事件頻率增加，以及海洋酸化和珊瑚白化等現象，均顯示氣候正快速改變。
          </span>
        </section>
      </article>
    </section>

    <!-- 首頁_暖化證據_二氧化碳 -->
    <section class="Fp_carbonData_H ">
      <div>
        <article class="Fp_textContent_H">
          <h2>二氧化碳 上升</h2>
          <p>
            大氣中的二氧化碳濃度持續上升，從前工業時期的約280ppm增至目前超過420ppm。燃燒化石燃料、工業活動與森林砍伐是主要原因，這加劇了溫室效應，導致氣候變遷、極端天氣增多及生態系統失衡。
          </p>
        </article>
        <CO2Chart id="carbonData"></CO2Chart>
        <!-- <img id="carbonData" src="../assets/images/Fp09_CO2.png" alt="CO2 Data" /> -->
        <!-- <canvas id="carbonData"></canvas> -->
      </div>
    </section>

    <!-- 首頁_暖化證據_全球溫度 -->
    <section class="Fp_tempData_H ">
      <div>
        <article class="Fp_textContent_H">
          <h2>全球溫度 上升</h2>
          <p>
            自19世紀工業革命以來，全球溫度持續上升，已增約1.1°C。這主要由於溫室氣體排放增加，尤其是二氧化碳、甲烷等氣體。溫度上升加劇了極端天氣事件、冰川融化和海水面上升，對生態環境、農業及人類生活造成廣泛影響。
          </p>
        </article>
        <TempChart id="tempData"></TempChart>
        <!-- <img id="tempData" src="../assets/images/Fp10_GlobalTemp.png" alt="CO2 Data" /> -->
        <!-- <canvas id="tempData"></canvas> -->
      </div>
    </section>

    <!-- 首頁_暖化證據_冰層 -->
    <section class="Fp_iceData_H ">
      <div>
        <article class="Fp_textContent_H">
          <h2>冰層 減少</h2>
          <p>
            極地冰層快速融化，尤其在北極和南極地區。北極冰蓋面積逐年減少，南極冰架崩解速度加快。這些變化不僅加速海水面上升，還對當地生態系統和全球氣候循環造成影響，進一步加劇全球暖化的影響。
          </p>
        </article>
        <IceChart id="iceData"></IceChart>
        <!-- <img id="iceData" src="../assets/images/Fp11_LandIceAntarctica.png" alt="CO2 Data" /> -->
        <!-- <canvas id="iceData"></canvas> -->
      </div>
    </section>

    <!-- 首頁_暖化證據_海水面 -->
    <section class="Fp_seaLevelData_H ">
      <div>
        <article class="Fp_textContent_H">
          <h2>海水面 上升</h2>
          <p>
            冰層融化導致海水面上升，預計到2100年，海水面將上升0.3到1米，對低窪沿海地區和島嶼國家構成嚴重威脅。海水面上升可能引發洪水、土地喪失和生態系統崩潰，影響數百萬人的生活。
          </p>
        </article>
        <SeaChart id="seaLevelData"></SeaChart>
        <!-- <img id="seaLevelData" src="../assets/images/Fp12_SeaLevel.png" alt="CO2 Data" /> -->
        <!-- <canvas id="seaLevelData"></canvas> -->
      </div>
    </section>
    <!-- 首頁_頁尾 -->
    <!-- <footer class="Fp_Footer_H">頁尾</footer> -->
    <MainFooter class="Fp_indexFooter_H"></MainFooter>
  </div>
</template>

<script>
import MainFooter from '@/components/layout/MainFooter.vue';
import { RouterLink } from 'vue-router';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { onMounted, onUnmounted, ref } from 'vue';
// import { faL } from '@fortawesome/free-solid-svg-icons';
import CO2Chart from '@/components/items/CO2Chart.vue';
import TempChart from '@/components/items/TempChart.vue';
import IceChart from '@/components/items/IceChart.vue';
import SeaChart from '@/components/items/SeaChart.vue';

export default {
  name: 'FpBanner',
  name: "ScrollEffect",
  // name: "EarthAnimation",
  name: "EarthScrollAnimation",
  name: "GlobalWarmingSection",
  setup() {
    gsap.registerPlugin(ScrollTrigger);
    const bannerRef = ref(null); // 用來綁定 <section> 元素

    const sections = ref([]); // 用來綁定災害區塊


    const totalFrames = 24; // ✅ 雪碧圖的總幀數
    const frameWidth = ref(480); // ✅ 預設幀寬度（桌機）
    const currentFrame = ref(0);

    // 📌 **根據螢幕大小更新 frameWidth**
    const updateFrameWidth = () => {
      const screenWidth = window.innerWidth;
      if (screenWidth <= 430) {
        frameWidth.value = 250; // ✅ **手機**
      } else if (screenWidth <= 820) {
        frameWidth.value = 330; // ✅ **平板**
      } else if (screenWidth <= 1024){
        frameWidth.value = 350; // ✅
      } else {
        frameWidth.value = 480; // ✅ **桌機**
      }
    };

    // 📌 更新動畫幀
    const updateFrame = (direction) => {
      const step = 1;
      if (direction > 0) {
        currentFrame.value = (currentFrame.value + step) % totalFrames;
      } else if (direction < 0) {
        currentFrame.value = (currentFrame.value - step + totalFrames) % totalFrames;
      }

      // ✅ 計算新 `backgroundPositionX`
      const newPosition = -currentFrame.value * frameWidth.value;
      gsap.set(".earth_animation", {
        backgroundPosition: `${newPosition}px 0px`,
      });
    };


    // const updateFrame = (direction) => {
    //   const step = 1; // 定義每次滾動的步幅（可以是 1、2、3 等，數字越大速度越快）

    //   // 根據滾動方向更新幀數
    //   if (direction > 0) {
    //     // 向下滾動，前進一幀
    //     currentFrame.value = (currentFrame.value + step) % totalFrames;
    //   } else if (direction < 0) {
    //     // 向上滾動，後退一幀
    //     currentFrame.value =
    //       (currentFrame.value - step + totalFrames) % totalFrames;
    //   }

    //   // 計算新的背景位置
    //   const newPosition = -currentFrame.value * frameWidth;

    //   // 更新背景位置
    //   gsap.set(".earth_animation", {
    //     backgroundPosition: `${newPosition}px 0px`,
    //   });


    // };

    // const initScrollTrigger = () => {
    //   // 創建 ScrollTrigger
    //   ScrollTrigger.create({
    //     trigger: ".Fp_globalWarming_H", // 設置觸發目標
    //     start: "top bottom", // 當地球容器頂部進入視窗底部時觸發
    //     end: "bottom top", // 當地球容器底部離開視窗頂部時結束
    //     scrub: true, // 滾動時即時觸發
    //     markers: true, // 顯示調試標記
    //     onUpdate: (self) => {
    //       const velocity = Math.abs(self.getVelocity()); // 滾動速度
    //       const speedFactor = Math.min(velocity / 1200, 12); // 動態速度因子，限制最大速度（例如 5 倍速度）

    //       // 更新幀數
    //       const step = Math.round(speedFactor); // 基於速度的步幅
    //       updateFrame(self.direction > 0 ? step : -step);
    //     },
    //   });
    // };

    // const initEarthAnimation = () => {
//       const earthElement = document.querySelector(".earth_animation");

//       // 定義 GSAP 動畫
//       const timeline = gsap.timeline({
//         repeat: -1, // 無限循環
//         paused: true, // 初始暫停
//       });

//       timeline.to(earthElement, {
//         backgroundPosition: "-11520px 0", // 雪碧圖最後一幀
//         ease: "steps(24)", // 每次移動一幀
//         duration: 1, // 完整動畫時間
//       });

//       timeline.pause();
//       console.log("時間線初始化後狀態：", timeline.paused()); // 應打印 true


//       setTimeout(() => {
//        ScrollTrigger.create({
    //     trigger: ".Fp_globalWarming_H",
    //     start: "top bottom",
    //     end: "bottom top",
    //     onEnter: () => {
    //       console.log("onEnter 觸發");
    //       timeline.play();
    //     },
    //     onLeave: () => {
    //       console.log("onLeave 觸發");
    //       timeline.pause();
    //     },
    //     onEnterBack: () => {
    //       console.log("onEnterBack 觸發，恢復動畫");
    //       timeline.play(); // 滾動回到區塊時恢復動畫
    //     },
    //     onLeaveBack: () => {
    //       console.log("onLeaveBack 觸發，暫停動畫");
    //       timeline.pause(); // 滾動離開區塊時暫停動畫
    //     },
    //     markers: true,
    //   });
//      }, 100); // 延遲 100ms


//    };

    const toggleBackgroundAndTextColor = () => {
    const globalWarmingSection = document.querySelector(".Fp_globalWarming_H");
    const textContainers = globalWarmingSection.querySelectorAll(".Fp_textContent_H");

    // 創建 什麼是全球暖化進場 ScrollTrigger
    ScrollTrigger.create({
      trigger: globalWarmingSection,
      start: "top center", // 當區塊的頂部到達視窗中心時觸發
      end: "bottom center", // 當區塊的底部到達視窗中心時結束

      onEnter: () => {
        console.log("進入區塊");

        const enterTimeline = gsap.timeline({
          defaults: {
          duration: 1, // 設置默認動畫時長
          ease: "sine.inOut", // 平滑過渡效果
          },
        });

        // 同步背景和文字顏色變化
        enterTimeline.to(["body", globalWarmingSection],  {
          background: "radial-gradient(circle, #003040, #006c84, #2e1e6e, #00040f)"}, 0); // body 背景變黑
        // enterTimeline.to(globalWarmingSection,  {
        //   background: "radial-gradient(circle, #003040, #006c84, #2e1e6e, #00040f)"}, 0); // 區塊背景變黑
        enterTimeline.to(textContainers, { color: "#fffff0"}, 0); // 文字變為白色


      },
      onLeave: () => {
        console.log("離開區塊");

        // 使用單獨的時間線處理離場動畫
        const leaveTimeline = gsap.timeline({
          defaults: {
          duration: 1, // 設置默認動畫時長
          ease: "sine.inOut", // 平滑過渡效果
          },
        });

        // 同步背景和文字顏色恢復
        leaveTimeline.to(["body", globalWarmingSection], { background: "radial-gradient(circle, #e6eccc, #e6eccc, #e6eccc)"}, 0); // body 背景變白
        // leaveTimeline.to(globalWarmingSection, { background: "radial-gradient(circle, #e6eccc, #e6eccc, #e6eccc)"}, 0); // 區塊背景變白
        leaveTimeline.to(textContainers, { color: "#545454" }, 0); // 文字恢復黑色


      },
      onEnterBack: () => {
        console.log("重新進入區塊");

        // 返回進場時重新使用單獨的時間線
        const enterBackTimeline = gsap.timeline({
          defaults: {
          duration: 1, // 設置默認動畫時長
          ease: "sine.inOut", // 平滑過渡效果
          },
        });
        // 返回時再度變黑
        enterBackTimeline.to(["body", globalWarmingSection], { background: "radial-gradient(circle, #003040, #006c84, #2e1e6e, #00040f)" }, 0);
        // enterBackTimeline.to(globalWarmingSection, { background: "radial-gradient(circle, #003040, #006c84, #2e1e6e, #00040f)" }, 0);
        enterBackTimeline.to(textContainers, { color: "#fffff0" }, 0); // 文字變為白色


      },
      onLeaveBack: () => {
        console.log("再次離開區塊");

        // 返回離場時重新使用單獨的時間線
        const leaveBackTimeline = gsap.timeline({
          defaults: {
          duration: 1, // 設置默認動畫時長
          ease: "sine.inOut", // 平滑過渡效果
          },
        });
        // 再次返回白色
        leaveBackTimeline.to(["body", globalWarmingSection], { background: "radial-gradient(circle, #e6eccc, #e6eccc, #e6eccc)" }, 0);
        // leaveBackTimeline.to(globalWarmingSection, { background: "radial-gradient(circle, #e6eccc, #e6eccc, #e6eccc)" }, 0);
        leaveBackTimeline.to(textContainers, { color: "#545454" }, 0); // 文字恢復黑色
        // gsap.utils.toArray(".Fp_textContent_H").forEach((textBlock) => {

        // gsap.from(textBlock, {
        // scrollTrigger: {
        //   trigger: textBlock,
        //   start: "top 80%",
        //   end: "top 20%",
        //   toggleActions: "play none none reverse",
        // },
        //   scale: 0.95,        // 進場時稍微縮小，增加視覺細節
        //   filter: "blur(4px)", // 文字初始模糊，進場時清晰
        //   opacity: 0,
        //   y: 60,
        //   duration: 1,
        //   ease: "sine.inOut",
        //   });
        // });


      },

    });



    gsap.utils.toArray(".Fp_globalWarming_H .Fp_textContent_H").forEach((textBlock) => {

    gsap.from(textBlock, {
    scrollTrigger: {
      trigger: textBlock,
      start: "top 80%",
      end: "top bottom",
      toggleActions: "play none none reverse",
    },
      scale: 0.95,        // 進場時稍微縮小，增加視覺細節
      filter: "blur(4px)", // 文字初始模糊，進場時清晰
      opacity: 0,
      y: 60,
      duration: .6,
      ease: "sine.inOut",
      });
    });


  };


    onMounted(async() => {
      await nextTick();


      // 主視覺Banner 設定動畫
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


      // 綁定災害區塊
      sections.value = document.querySelectorAll(
        ".Fp_disasterIce_H, .Fp_disasterFire_H, .Fp_disasterTyphoon_H, .Fp_disasterRain_H"
      );

      sections.value.forEach((section, index) => {
      const isEven = index % 2 === 0; // 奇偶數決定刷淡方向


      // 是偶數的話, 漸層從右往左, 否則從左往右
      const initialGradient = isEven
      ? "linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0))" // 偶數：初始從左刷淡
      : "linear-gradient(to left, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0))" // 奇數：初始從右刷淡

      const finalGradient = isEven
      ? "linear-gradient(to right, rgba(0, 0, 0, .6), rgba(0, 0, 0, 0))" // 偶數：結束從左刷淡
      : "linear-gradient(to left, rgba(0, 0, 0, .6), rgba(0, 0, 0, 0))"; // 奇數：結束從右刷淡

      section.style.setProperty("--mask-gradient", initialGradient);

      // GSAP 動畫
        gsap.timeline({
        scrollTrigger: {
          trigger: section,
          start: "top top",
          end: "bottom top",
          scrub: true,
          pin: true,
          markers: false,
        },
      })
      .to(section, {
      backgroundPosition: "0% 30%", // 讓背景在滾動過程中移動
      duration: 1,
      })
      .fromTo(
      section,
      {
        filter: "blur(1.5px)",
        "--mask-gradient": initialGradient, // 初始值
        opacity: .9,
      },
      {
        backgroundPosition: "0% 60%",
        filter: "blur(0px)",
        "--mask-gradient": finalGradient, // 結束值
        duration: 1,
        ease: "sine.inOut",
        opacity: 1,
      },
      )
      // 新增文字進場效果
      .fromTo(
        section.querySelector("h1"),
        {
          y: 200, // 垂直方向偏移量
          opacity: 0, // 初始透明度
          scale: 1, // 初始縮放
        },
        {
          y: 0, // 移回原位置
          opacity: 1, // 完全顯現
          scale: 1, // 恢復正常大小
          duration: 2,
          ease: "sine.inout", // 平滑過渡效果
        },
        0 // 與其他動畫同步
      )
      .fromTo(
        section.querySelector("p"),
        {
          y: 200, // 垂直方向偏移量
          opacity: 0, // 初始透明度
          scale: 1, // 初始縮放
        },
        {
          y: 0, // 移回原位置
          opacity: 1, // 完全顯現
          scale: 1, // 恢復正常大小
          duration: 1,
          ease: "sine.inout", // 平滑過渡效果
        },
        0 // 與其他動畫同步
      )
      });


      // initEarthAnimation();
        // // 強制再次暫停時間線，防止意外啟動
        // timeline.pause();
        // console.log("onMounted 強制暫停時間線");


      // initScrollTrigger();

      toggleBackgroundAndTextColor();


      // 📌 選取4個 `section`
      const sectionData = gsap.utils.toArray([
        ".Fp_carbonData_H",
        ".Fp_tempData_H",
        ".Fp_iceData_H",
        ".Fp_seaLevelData_H"
      ]);

      sectionData.forEach((section) => {

      // ✅ `section` 背景照片灰階變化
      gsap.fromTo(section,
        { filter:'grayscale(100%)' },
        {
          filter:'grayscale(0%)',
          duration: 1.2,
          ease: "sine.inOut",
          scrollTrigger: {
            trigger: section,
            start: "top 50%",
            end: "top 10%",
            toggleActions: "play none none reverse",
          }
        }
      );


      });

      const sectionText = gsap.utils.toArray([
        ".Fp_carbonData_H article",
        ".Fp_tempData_H article",
        ".Fp_iceData_H article",
        ".Fp_seaLevelData_H article"
      ]);

      sectionText.forEach(textBlock => {
        gsap.fromTo(textBlock,
        {
          opacity: 0,               // **初始透明**
          scale: 0.98,              // **稍微縮小**
          y: 20,                    // **從下方滑入**
          filter: "drop-shadow(0px 0px 0px rgba(0,0,0,0))" // **無陰影**
        },
        {
          opacity: 1,               // **完全顯現**
          scale: 1.0,               // **回到正常大小**
          y: 0,                     // **回到原本位置**
          filter: "drop-shadow(4px 4px 10px rgba(0,0,0,.4))", // **文字陰影**
          duration: .8,            // **動畫時長**
          ease: "sine.inOut",
          scrollTrigger: {
          trigger: textBlock,
          start: "top 85%",        // **當文字區塊接近視口頂部 85% 觸發**
          end: "bottom 20%",         // **緩慢進場**
          toggleActions: "play none none reverse",
          }
        }
        )


      })




      // 📌 選取所有數據圖表
      const charts = gsap.utils.toArray([
        "#carbonData",  // 二氧化碳數據圖
        "#tempData",    // 全球溫度數據圖
        "#iceData",     // 冰層變化數據圖
        "#seaLevelData" // 海平面變化數據圖
      ]);

      charts.forEach((chart, index) => {
      const isOdd = index % 2 === 1; // 判斷是否為奇數
      const maskDirection = isOdd ? "inset(100% 100% 0% 0%)" : "inset(100% 0% 0% 100%)"; // 奇數從右到左，偶數從左到右

      gsap.fromTo(chart,
      {
        opacity: 1, // 確保圖表本身不透明
        clipPath: maskDirection, // 初始遮罩範圍
        // scale: 0.9, // 初始縮小，增加彈跳感
        yPercent: 15, // **浮動視差感**
        rotate: gsap.utils.random(-4, 4), // **隨機旋轉 -10° ~ 10°**
      },
      {
        clipPath: "inset(0% 0% 0% 0%)", // 遮罩完全展開，顯露出圖表
        duration: .8,
        ease: "sine.inOut",
        // scale: 1, // 回到正常大小
        yPercent: 0, // **回歸原始位置**
        rotate: 0, // **旋轉回正**
        scrollTrigger: {
          trigger: chart,
          start: "top 85%",  // 當圖表進入視口 75% 時觸發
          end: "bottom 20%",    // 滾動到 0 位置時動畫完成
          toggleActions: "play none none reverse", // 滾動回去時動畫反向播放
          endTrigger: chart, // ✅ 確保動畫的影響範圍準確
        }
      }
      );



      });

      updateFrameWidth(); // ✅ **初始設定**
      window.addEventListener("resize", updateFrameWidth); // ✅ **監聽 RWD 變更**

      // 📌 **滾動觸發動畫**
      ScrollTrigger.create({
        trigger: ".Fp_globalWarming_H", // 設置觸發目標
        start: "top bottom", // 當地球容器頂部進入視窗底部時觸發
        end: "bottom top", // 當地球容器底部離開視窗頂部時結束
        scrub: true, // 滾動時即時觸發
        markers: false, // 顯示調試標記
        onUpdate: (self) => {
          const velocity = Math.abs(self.getVelocity()); // 滾動速度
          const speedFactor = Math.min(velocity / 500, 100); // 動態速度因子，限制最大速度（例如 5 倍速度）

          // 更新幀數
          const step = Math.round(speedFactor); // 基於速度的步幅
          updateFrame(self.direction > 0 ? step : -step);
        },
      });


      // ✅ **初始設置背景大小**
      gsap.set(".earth_animation", {
        backgroundSize: `${totalFrames * frameWidth.value}px auto`,
      });
    });

    // 📌 **監聽 RWD 變更，確保動畫正常**
    watch(frameWidth, (newWidth) => {
      gsap.set(".earth_animation", {
        backgroundSize: `${totalFrames * newWidth}px auto`,
      });

      updateFrame(0);

    });


    onUnmounted(() => {
      console.log("🚀 清除 GSAP & ScrollTrigger");

      gsap.globalTimeline.clear(); // ✅ 清除所有 GSAP 動畫
      ScrollTrigger.killAll(); // ✅ 清除所有 ScrollTrigger
      // ScrollTrigger.refresh(); // ✅ 重新整理 ScrollTrigger 避免錯誤

      // ✅ **手動重置 `body` 和 `.Fp_globalWarming_H` 的背景顏色**
      document.body.style.background = "radial-gradient(circle, #e6eccc, #e6eccc, #e6eccc)";
      const warmingSection = document.querySelector(".Fp_globalWarming_H");
      if (warmingSection) {
        warmingSection.style.background = "radial-gradient(circle, #e6eccc, #e6eccc, #e6eccc)";
      }

    });

    return {
      bannerRef,
      sections,
      // initEarthAnimation,
      frameWidth,
    };
  },


};
</script>

