<template>

  <!-- v-if="isLoading" -->
  <!-- <div  class="loading-container">
    <div class="loading-spinner"></div>
    <div>正在載入畫面…</div>
  </div> -->
  <!-- v-else-if="isAuthenticated" -->
  <main>
    <MainHeader />
    <!-- 撰寫文章，縮寫FbW - 功能 - 代號X -->
    <div class="FbW-X">
      <!-- 發文區 -->
      <form action="" class="FbW-wrapper-X" @submit.prevent="handleSubmit">
        <!-- 標題 -->
        <div class="FbW-title-X">
          <div class="FbW-postTilte">
            <label for="FbW-postTilte-X">
              <span class="fir">標題</span>
              <span class="las">輸入 5 至 40 字（必填）</span>
            </label>
            <select id="" name="" v-model="theme">
              <option value="主題選擇" disabled selected>主題選擇</option>
              <option value="氣候科學">氣候科學</option>
              <option value="生態危機">生態危機</option>
              <option value="綠色生活">綠色生活</option>
              <option value="政策國際">政策國際</option>
            </select>
          </div>
          <input id="FbW-postTilte-X" type="text" placeholder="給文章一個好標題" v-model="title" />
        </div>
        <!-- 內文 -->
        <div class="FbW-content-X">
          <label for="FbW-postContent-X">
            <span>內文</span>
            <span>至少輸入 50 字，請遵守發文禮儀（必填）</span>
          </label>



          <!-- <div class="FbW-translate-X">
            <select name="" id="">
              <option value="段落">段落</option>
              <option value="標題1">標題1</option>
              <option value="標題2">標題2</option>
              <option value="標題3">標題3</option>
            </select>
            <span title="粗體 (Ctrl-B)" tabindex="-1" class="fa fa-bold"></span>
            <span title="斜體 (Ctrl-I)" tabindex="-1" class="fa fa-italic"></span>
            <span title="插入連結 (Ctrl-K)" tabindex="-1" class="fa fa-link"></span>
            <span title="插入圖片 (Ctrl-Alt-I)" tabindex="-1" class="fa-regular fa-image"></span>
          </div>
          <textarea id="FbW-postContent-X" name="" placeholder="開始寫文章囉"></textarea> -->
        </div>
        <ckeditor v-model="editorData" :editor="ClassicEditor" :config="config" />

        <!-- 預覽圖 -->
        <div class="FbW-picture-X" v-if="slides.length !== 0">
          <div>
            <input id="FbW-picChoose-X" type="checkbox" v-model="hasThumbnail" /> <label
              for="FbW-picChoose-X">是否選擇文章縮圖</label>
          </div>
          <!-- <div class="FbW-picture-slider-X"></div> -->
          <swiper navigation class="custom-swiper" :modules="modules" @swiper="onSwiper" @slideChange="onSlideChange">
            <swiper-slide v-for="(slide, index) in slides" :key="index">
              <div class="FbW-picture-slider-X">
                <img :src="slide.img" alt="">
              </div>
            </swiper-slide>
          </swiper>
        </div>

        <button type="submit" :disabled="isUploading"> {{ isUploading ? '發布中...' : '送出文章' }}</button>
      </form>


    </div>
    <MainFooter class="removeMT" />
  </main>

</template>

<script setup>
import { ref, computed, watch } from 'vue';
import MainFooter from '@/components/layout/MainFooter.vue';
import MainHeader from '@/components/layout/MainHeader.vue';
import { useAuth } from '@/utils/useAuth';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import 'ckeditor5/ckeditor5.css';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/swiper-bundle.css';
import { Navigation, Pagination } from 'swiper/modules';
import { useRouter } from 'vue-router';
const router = useRouter();

//由這段判斷是否經過登入驗證
const { checkAuth, isLoading } = useAuth()

const title = ref(''); //標題
const theme = ref('主題選擇');
const hasThumbnail = ref(false); //是否選擇封面圖片
const editorData = ref(''); //編輯器
const email = localStorage.getItem('userEmail') //使用者的 email

//主題的索引對照
const themeMapping = {
  "氣候科學": 1,
  "生態危機": 2,
  "綠色生活": 3,
  "政策國際": 4
};

//ckeditor 的設定
const config = computed(() => {
  return {
    extraPlugins: [MyCustomUploadAdapterPlugin],
    licenseKey: 'GPL',
    toolbar: [
      'heading', '|',
      'bold', 'italic', 'link', 'blockQuote', 'imageUpload',
      '|', 'undo', 'redo'
    ],
    heading: {
      options: [
        { model: 'paragraph', title: '段落', class: 'ck-heading_paragraph' },
        { model: 'heading1', view: 'h1', title: '標題1', class: 'ck-heading_heading1' },
        { model: 'heading2', view: 'h2', title: '標題2', class: 'ck-heading_heading2' },
        { model: 'heading3', view: 'h3', title: '標題3', class: 'ck-heading_heading3' }
      ]
    },
    image: {
      toolbar: ['imageTextAlternative',],
    },
    readOnly: false,
    link: {
      defaultProtocol: 'https://',
      decorators: {
        openInNewTab: {
          mode: 'manual',
          label: '在新分頁開啟',
          attributes: {
            target: '_blank',
          }
        }
      }
    },
  };
});

/* ----- 圖片預覽 + 更新到 swiper ---- */
const editorImages = ref(new Set());

watch(() => editorData.value, (newContent) => {
  // 創建臨時 DOM 元素來解析內容
  const tempDiv = document.createElement('div');
  tempDiv.innerHTML = newContent;

  // 獲取所有圖片的 src
  const currentImages = new Set(
    Array.from(tempDiv.getElementsByTagName('img'))
      .map(img => img.src)
  );

  // 找出被刪除的圖片
  const deletedImages = Array.from(editorImages.value)
    .filter(src => !currentImages.has(src));

  // 如果有圖片被刪除
  if (deletedImages.length > 0) {
    deletedImages.forEach(deletedSrc => {
      // 從 slides 中移除對應的圖片
      const index = slides.value.findIndex(slide => slide.img === deletedSrc);
      if (index !== -1) {
        slides.value.splice(index, 1);
      }
      // 從追踪集合中移除
      editorImages.value.delete(deletedSrc);
    });

    // 如果沒有圖片了，取消勾選縮圖選項
    if (slides.value.length === 0) {
      hasThumbnail.value = false;
    }
  }

  // 更新追踪的圖片集合
  editorImages.value = currentImages;
}, { deep: true });

class MyUploadAdapter {
  constructor(loader) {
    this.loader = loader;
  }

  upload() {
    return this.loader.file.then(file => new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => {
        const imageUrl = reader.result;

        // 將圖片添加到 slides 陣列中
        slides.value.push({
          id: Date.now(),
          img: imageUrl
        });

        // 將圖片URL添加到追踪集合中
        editorImages.value.add(imageUrl);

        // 自動勾選使用縮圖
        hasThumbnail.value = true;

        // 如果有 swiper 實例，更新到最新上傳的圖片
        if (swiperInstance) {
          swiperInstance.slideTo(slides.value.length - 1);
        }

        resolve({ default: imageUrl });
      };
      reader.onerror = error => reject(error);
    }));
  }

  abort() {
    // 如果上傳被中止，可以在這裡處理
  }
}

// 初始化上傳適配器
function MyCustomUploadAdapterPlugin(editor) {
  editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
    return new MyUploadAdapter(loader);
  };
}

/* --------- */

//內容字數檢查
const cleanContent = (htmlContent) => {
  // 移除所有 Base64 圖片
  const withoutImages = htmlContent.replace(/<img[^>]*>/g, '[圖片]');
  // 移除所有 HTML 標籤
  const withoutTags = withoutImages.replace(/<[^>]*>/g, '');
  // 移除多餘空白
  return withoutTags.trim().replace(/\s+/g, ' ');
}

//送出文章的狀態
const isUploading = ref(false);

//送出文章
const handleSubmit = async () => {
  const isLoggin = checkAuth()
  if(!isLoggin){
    alert('請先登入！')
  }
  //檢查標題
  if (title.value.length < 5 || title.value.length > 40) {
    alert('標題必須在 5 至 40 字之間')
    return
  }

  //檢查文章類別
  if (theme.value === '主題選擇') {
    alert('請選擇文章主題');
    return;
  }

  // 獲取編輯器內容
  let content = editorData.value;
  content = content.replace(/<p>&nbsp;<\/p>\s*(<p>&nbsp;<\/p>)*/g, '<br>');
  content = content.replace(/\s*style="[^"]*"/g, ''); //處理圖片自帶的 style 屬性
  const cleanedContent = cleanContent(content);

  //檢查文章字數
  if (cleanedContent.length < 50) {
    alert('內文至少需要50字');
    return;
  }

  // 準備文章數據
  const articleData = {
    title: title.value,
    content: content,
    theme: themeMapping[theme.value],
    hasThumbnail: hasThumbnail.value,
    thumbnailUrl: hasThumbnail.value && slides.value.length > 0 ? slides.value[getCurrentSlide()].img : null,
    userEmail: email
  };

  try {
    isUploading.value = true;
    // 發送文章數據到後端
    const base_url = import.meta.env.VITE_AJAX_URL
    const res = await fetch(base_url + '/uploadArticles.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      credentials: 'include',
      body: JSON.stringify(articleData)
    });

    const data = await res.json();

    if (!data.success) {
      throw new Error(data.message);
    } else {
      alert(data.message);
      const readArticle = confirm('是否查看發布的文章？');
      if (readArticle) {
        router.push(`/social/article/${data.articleId}`);
      } else {
        title.value = '';
        theme.value = '主題選擇';
        editorData.value = '';
        hasThumbnail.value = false;
      }
    }
  } catch (error) {
    console.error('Error:', error);
    alert('發生錯誤：' + error.message);
  } finally {
    isUploading.value = false;
  }

};


//圖片的 swiper
const modules = [Navigation, Pagination];
const slides = ref([]);
// const swiperBreakpoints = {
//   830: { slidesPerView: 3, spaceBetween: 10 },
//   810: { slidesPerView: 2, spaceBetween: 10 },
//   0: { slidesPerView: 1, spaceBetween: 10 },
// };

let swiperInstance = null;

const onSwiper = (swiper) => {
  swiperInstance = swiper;
};

//獲取目前顯示的圖片索引
const getCurrentSlide = () => {
  if (swiperInstance) {
    return swiperInstance.activeIndex;
  }
};

//滑動的時候觸發 
// const onSlideChange = () => {
//   const currentIndex = getCurrentSlide();
// };

onMounted(async () => {
  try {
    await checkAuth()
  } finally {
    isLoading.value = false
  }
})

</script>

<style scoped>
.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
}

.loading-spinner {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
  margin-bottom: 1rem;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}

/* 整個編輯器 */
::v-deep .ck.ck-reset.ck-editor {
    border: 2px solid #5b774a !important;
    border-radius: 5px;
    background-color: #fffff0 !important;
}

/* 工具列 */
::v-deep .ck.ck-toolbar {
    background-color: #fffff0 !important;
}

/* 編輯區域 */
::v-deep .ck-editor__editable {
    background-color: #fffff0 !important;
    min-height: 200px !important;
}



</style>
