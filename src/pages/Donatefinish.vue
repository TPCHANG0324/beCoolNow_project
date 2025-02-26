<template>
  <MainHeader></MainHeader>
  <div class="fs_wrapper_R">
    <video autoplay muted loop playsinline>
      <source src="../assets/videos/turtle_final.mp4" type="video/mp4">
    </video>
    <div class="fs_overlay_R">
      <h2>感謝您對地球盡一份心力</h2>
      <p>快來創建專屬的環保小寵物吧！</p>
      <button class="btn" @click="goToGamePage">立即創建</button>
    </div>
  </div>
  <MainFooter class="donate_finish_footer"></MainFooter>
</template>
<script setup>
import { ref, computed, watch, nextTick, onMounted, onActivated } from 'vue';
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
import emailjs from '@emailjs/browser';
import { useRouter } from 'vue-router';
const router = useRouter();

const goToGamePage = () => {
  window.location.href = 'https://tibamef2e.com/tid103/g2/game';
};

emailjs.init("5-GBPJlIL-R8kd1sM");

// 寄信：從 linepay_confirm.php 得到的參數
const sendEmail = (userData) => {
  const templateParams = {
    to_name: userData.name,
    site_name: '涼城即時',
    donation_name: userData.name,
    donation_date: new Date(),
    donation_amount: userData.amount,
    to_email: userData.email,
  };
  // console.log(templateParams)
  emailjs.send('service_2p5x0aa', 'template_u2usszo', templateParams)
    .then((response) => {
      console.log('SUCCESS!', response.status, response.text);
    }, (err) => {
      console.log('FAILED...', err);
    });
}

//取得捐款者資料
const getDonateData = async () => {
  const base_url = import.meta.env.VITE_AJAX_URL //環境路徑
  try {
    const res = await fetch(base_url + `/getMailInfo.php`)
    if (!res.ok) {
      throw new Error(`HTTP error! Status: ${res.status}`);
    }
    const data = await res.json()
    if (data.success) {
      sendEmail(data.data);
    } else {
      router.push('/support');
    }
  } catch (err) {
    console.error("Error fetching user data:", err)
    router.push('/support');
  }
}



onMounted(async() => {
  await getDonateData()
})
</script>

<style lang="scss">
.donate_finish_footer {
  .footer {
    margin: 0 !important;
  }

}
</style>