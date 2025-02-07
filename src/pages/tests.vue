<template>
<<<<<<< HEAD
  <div>
=======

  <figure>
    <!-- 桌機版 (當螢幕 > 430px) -->
    <template v-if="!isMobile">
      <div class="desktop-view">
        <!-- 大圖 -->
        <div class="main-image">
          <img :src="selectedImage" alt="Main Image" />
        </div>
        <!-- 小圖swiper滑動 -->
        <swiper
          ref="thumbnailSwiper"
          v-if="isMounted"
          class="thumbnail-swiper"
          :modules="modules"
          :slides-per-view="4"  
          :space-between="20"
          direction="vertical"  
          :mousewheel="true" 
          :css-mode="false"
          :free-mode="true"
          :autoplay="true"
          @mouseenter="startAutoScroll"
          @mouseleave="stopAutoScroll"
        >
          <swiper-slide
            v-for="(image, index) in images"
            :key="index"
            @click="selectImage(image, index)"
          >
            <img :src="image" alt="Thumbnail" />
          </swiper-slide>
        </swiper>
      </div>
    </template>
   

    <!-- 手機版 Swiper 輪播 (當螢幕 <= 430px) -->
    <!--
>>>>>>> sunny
    <swiper
      v-if="isMounted && isMobile"
      :key="swiperKey"
      :modules="modules"
      :slides-per-view="1"
      :space-between="20"
      navigation
      :pagination="{ clickable: true }"
      :scrollbar="{ draggable: true }"
      :loop="true"
      :autoplay="{ delay: 3000 }"
    >
<<<<<<< HEAD
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
=======
      <swiper-slide v-for="(image, index) in images" :key="index">
        <img :src="image" alt="Swiper Image" />
      </swiper-slide>
    </swiper>
    -->
  </figure>
</template>

<script>
  import { ref, onMounted, onUnmounted } from 'vue';
  import { Navigation, Pagination, Scrollbar, A11y, Mousewheel, Autoplay } from 'swiper/modules';
  import { Swiper, SwiperSlide } from 'swiper/vue';
  import 'swiper/css';
  import 'swiper/css/navigation';
  import 'swiper/css/pagination';
  import 'swiper/css/scrollbar';
 

  export default {
    components: { Swiper, SwiperSlide },
  
    setup() {
    const isMobile = ref(window.innerWidth <= 430);
    const isMounted = ref(false);
    const swiperKey = ref(0);
    const images = [
        "/beCoolNow_project/images/Sp15.jpg",
        "/beCoolNow_project/images/Sp16.jpg",
        "/beCoolNow_project/images/Sp17.jpg",
        "/beCoolNow_project/images/Sp18.jpg",
        "/beCoolNow_project/images/Sp19.jpg",
      // require("@/assets/images/Sp15.jpg"),
      // require("@/assets/images/Sp16.jpg"),
      // require("@/assets/images/Sp17.jpg"),
      // require("@/assets/images/Sp18.jpg"),
    ];
    const selectedImage = ref(images[0]); // 預設顯示第一張圖片

    // 選擇圖片
    const selectImage = (image) => {
      selectedImage.value = image;
    };
    const thumbnailSwiper = ref(null);
     // 控制 Swiper 自動滾動
     const startAutoScroll = () => {
      if (thumbnailSwiper.value?.swiper) {
        thumbnailSwiper.value.swiper.params.autoplay = {
        delay: 1000,
        disableOnInteraction: false
      };
      thumbnailSwiper.value.swiper.autoplay.start();
      }
    };

    const stopAutoScroll = () => {
      if (thumbnailSwiper.value?.swiper) {
        thumbnailSwiper.value.swiper.autoplay.stop();
      }
    };

    // 監聽視窗大小變化
    const updateScreenSize = () => {
      isMobile.value = window.innerWidth <= 430;
      swiperKey.value++; // 重新載入 Swiper
    };

    onMounted(async () => {
      isMounted.value = true;
      isMobile.value = window.innerWidth <= 430;
      await nextTick(); // 確保 DOM 更新後取得 Swiper

      if (thumbnailSwiper.value?.swiper) {
        thumbnailSwiper.value.swiper.autoplay.stop(); // 確保初始狀態是停止的
      }
      updateScreenSize();
      window.addEventListener("resize", updateScreenSize);
    });

    onUnmounted(() => {
      window.removeEventListener("resize", updateScreenSize);
    });

    return {
      isMobile,
      isMounted,
      swiperKey,
      images,
      selectedImage,
      selectImage,
      startAutoScroll,
      stopAutoScroll,
      thumbnailSwiper,
      modules: [Navigation, Pagination, Scrollbar, A11y, Mousewheel, Autoplay],
    };
  },
};
  
</script>

<style scoped>
figure{
  border:1px solid red;
  display: block;
}










/* 桌機版樣式 */
.desktop-view {
  display: flex;
  /* gap: 20px; */
  flex-direction: row-reverse;
  width: 695px;

  border: 2px solid black;
}
div.main-image{
  border: 2px solid green;
}
div.swiper {
  border: 2px solid blue;
}

.main-image img {
  width: 100%;
  max-width: 540px;
  height: 540px;
  padding: 20px;
  object-fit: fill;
  border-radius: 20%;
}

/* Swiper 小圖（垂直模式） */
.thumbnail-swiper {
  height: 540px; /* 限制高度，讓 Swiper 出現滾動 */
  /*width: 120px;  小圖寬度 */
  overflow: hidden;
}

.thumbnail-slide {
  height: calc((540px - 30px) / 4) !important; /* 小圖高度 */
  /* margin-bottom: 10px;  */
}

.thumbnail-swiper .swiper-slide {
  cursor: pointer;
 
}

.thumbnail-swiper .swiper-slide img {
  object-fit: cover;
  width: 100%;
  max-width: 120px;
  height: 120px;
  border: 2px solid transparent;
  cursor: pointer;
  border-radius: 20px;
  transition: border-color 0.3s ease;
  

}

.thumbnail-swiper swiper-slide img:hover {
  border-color: #000;
}

/* .thumbnail-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
  list-style: none;
  padding: 0;
  overflow-y: scroll;
  max-height: 400px;
}

.thumbnail-list li {
  cursor: pointer;
}

.thumbnail-list img {
  width: 100px;
  height: auto;
  border: 2px solid transparent;
  transition: border-color 0.3s ease;
}

.thumbnail-list img:hover {
  border-color: #000;
} */

/* Swiper 樣式 */
swiper {
  width: 100%;
  height: auto;
  margin:auto;
}

swiper-slide img {
  width: 100%;
  height: 316px;
}

:deep(.swiper) {
  margin-left: 0 !important;
  margin-right: 0 !important;
  padding: 0 !important;
>>>>>>> sunny
}
</style>
