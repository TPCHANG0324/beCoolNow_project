<template>
  <!-- 首頁_主選單 -->
  <header class="Fp_Header_H">選單</header>

  <!-- 首頁_主視覺Banner區塊 -->
  <section class="Fp_Banner_H">
    <header>
      <article>
        <h2>一場悄悄上演的浩劫<br />地球正在發生改變</h2>
        <a href="#" class="btn">立刻行動</a>
      </article>
      <article>
        <h1>全球</h1>
        <h1>暖化</h1>
      </article>
    </header>
  </section>

  <!-- 首頁_災害Banner區塊 -->
  <section class="Fp_disaster_H">
    <article class="Fp_textContent_H">
      <h1>極地融冰</h1>
      <p>極地冰川因全球暖化加速融化，導致海平面上升、生態失衡。北極冰層減少威脅極地動物生存，南極冰架崩解影響全球氣候循環，突顯減碳與環保行動的重要性。</p>
    </article>
  </section>

  <!-- 首頁_什麼是全球暖化 -->
  <section class="Fp_globalWarming_H">
    <figure>
      <img src="../assets/images/Fp08.png" alt="">
    </figure>

    <article>
      <section class="Fp_textContent_H">
        <h2>什麼是全球暖化 ?</h2>
        <span>是地球平均氣溫持續上升的現象，主要因人類活動排放的溫室氣體（如二氧化碳、甲烷）累積於大氣層，導致溫室效應加劇。<br /><br />其影響包括極地冰川融化、海平面上升、極端天氣事件增多、生態系統失衡以及物種滅絕。<br /><br />暖化改變了全球氣候循環，造成乾旱、洪水和颱風等自然災害的頻率與強度上升，威脅人類居住環境和糧食安全。</span>
      </section>
      <section class="Fp_textContent_H">
        <h2>造成的影響</h2>
        <span>海平面上升淹沒沿海地區、生態系統失衡導致物種滅絕、極端天氣頻率增加危害農業與生命安全，此外，氣候變遷還引發糧食短缺、疾病傳播及社會經濟不穩等全球性問題。</span>
      </section>
      <section class="Fp_textContent_H">
        <h2>暖化的證據</h2>
        <span>極地冰川與冰蓋快速融化、海平面上升、全球平均溫度逐年升高、極端氣候事件頻率增加，以及海洋酸化和珊瑚白化等現象，均顯示氣候正快速改變。</span>
      </section>
    </article>
  </section>

  <!-- 首頁_暖化證據_二氧化碳 -->
  <section class="Fp_carbonData_H Fp_disaster_H">
    <div>
      <article class="Fp_textContent_H">
        <h2>二氧化碳 上升</h2>
        <p>大氣中的二氧化碳濃度持續上升，從前工業時期的約280ppm增至目前超過420ppm。燃燒化石燃料、工業活動與森林砍伐是主要原因，這加劇了溫室效應，導致氣候變遷、極端天氣增多及生態系統失衡。</p>
      </article>
      <canvas id="carbonData"></canvas>
    </div>
  </section>

  <!-- 首頁_暖化證據_全球氣溫 -->
  <section class="Fp_tempData_H Fp_disaster_H">
    <div>
      <article class="Fp_textContent_H">
        <h2>全球氣溫 上升</h2>
        <p>自19世紀工業革命以來，全球氣溫持續上升，已增約1.1°C。這主要由於溫室氣體排放增加，尤其是二氧化碳、甲烷等氣體。氣溫上升加劇了極端天氣事件、冰川融化和海平面上升，對生態環境、農業及人類生活造成廣泛影響。</p>
      </article>
      <canvas id="tempData"></canvas>
    </div>
  </section>

  <!-- 首頁_暖化證據_冰層 -->
  <section class="Fp_iceData_H Fp_disaster_H">
    <div>
      <article class="Fp_textContent_H">
        <h2>冰層 減少</h2>
        <p>極地冰層快速融化，尤其在北極和南極地區。北極冰蓋面積逐年減少，南極冰架崩解速度加快。這些變化不僅加速海平面上升，還對當地生態系統和全球氣候循環造成影響，進一步加劇全球暖化的影響。</p>
      </article>
      <canvas id="iceData"></canvas>
    </div>
  </section>

  <!-- 首頁_暖化證據_海平面 -->
  <section class="Fp_seaLevelData_H Fp_disaster_H">
    <div>
      <article class="Fp_textContent_H">
        <h2>海平面 上升</h2>
        <p>冰層融化導致海平面上升，預計到2100年，海平面將上升0.3到1米，對低窪沿海地區和島嶼國家構成嚴重威脅。海平面上升可能引發洪水、土地喪失和生態系統崩潰，影響數百萬人的生活。</p>
      </article>
      <canvas id="seaLevelData"></canvas>
    </div>
  </section>

  <!-- 首頁_頁尾 -->
  <footer class="Fp_Footer_H">頁尾</footer>
</template>

<script>
export default {

}
</script>