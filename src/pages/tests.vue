<template>
  <div>
    <swiper
      :modules="modules"
      :slides-per-view="1"
      :space-between="50"
      navigation
      :pagination="{ clickable: true }"
      :scrollbar="{ draggable: true }"
      @swiper="onSwiper"
      @slideChange="onSlideChange"
    >
      <swiper-slide><img src="../assets/images/Sp15.jpg" alt="" /></swiper-slide>
      <swiper-slide><img src="../assets/images/Sp16.jpg" alt="" /></swiper-slide>
      <swiper-slide><img src="../assets/images/Sp17.jpg" alt="" /></swiper-slide>
      <swiper-slide><img src="../assets/images/Sp18.jpg" alt="" /></swiper-slide>
      <swiper-slide><img src="../assets/images/Sp19.jpg" alt="" /></swiper-slide>
    </swiper>
  </div>
</template>
<script>
// import Swiper core and required modules
import { Navigation, Pagination, Scrollbar, A11y } from 'swiper/modules';

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';

// Import Swiper styles
export default {
  components: {
    Swiper,
    SwiperSlide,
  },
  setup() {
    const onSwiper = (swiper) => {
      console.log(swiper);
    };
    const onSlideChange = () => {
      console.log('slide change');
    };
    return {
      onSwiper,
      onSlideChange,
      modules: [Navigation, Pagination, Scrollbar, A11y],
    };
  },
};
</script>
<style>
.swiper-slide {
  width: 300px;
  height: 300px;
}
.swiper-slide img {
  width: 100%;
  height: 200px;
}
</style>
