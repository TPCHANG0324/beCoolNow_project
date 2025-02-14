<template>
  <MainHeader></MainHeader>
  <div class="fs_wrapper_R">
    <video autoplay muted loop playsinline>
      <source src="../assets/videos/turtle_final.mp4" type="video/mp4">
    </video>
    <div class="Sp-checkout-nav-X">
        <!-- 每一個圓圈 -->
        <div class="Sp-step-X">
            <span class="Sp-badge-X">
                <div class="Sp-badge-text-X">1</div>
            </span>
            <span>購物車</span>
        </div>

        <div class="Sp-step-X active">
            <span class="Sp-badge-X">
                <div class="Sp-badge-text-X">2</div>
            </span>
            <span>填寫資料</span>
        </div>

        <div class="Sp-step-X">
            <span class="Sp-badge-X">
                <div class="Sp-badge-text-X">3</div>
            </span>
            <span>購買完成</span>
        </div>
    </div>
    <div class="fs_overlay_R">
      <h2>感謝您對地球盡一份心力</h2>
      <p>快來創建專屬的環保小寵物吧！</p>
      <button class="btn">立即創建</button>
    </div>
  </div>
  <MainFooter></MainFooter>
</template>

<script>
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
</script>
