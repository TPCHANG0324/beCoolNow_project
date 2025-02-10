<template>
  <main>
    <MainHeader />
    <!-- 社群中心，縮寫Fb - 功能 - 代號X -->
    <div class="Fb-X">
      <div class="Fb-wrapper-X">
        <!-- 文章 -->
        <!--   -->
        <div class="Fb-post-X" v-show="!$route.params.id">
          <!-- 文章分類 -->
          <div class="Fb-post-category-container-X">
            <ul class="Fb-post-category-X">
              <div class="Fb-post-category-box">
                <select id="" v-model="activeItem" name="" :class="{ active: !RWDnews }" @change="changeCategory">
                  <option v-for="(item, index) in category" :key="index" :value="index">{{ item }}</option>
                </select>
              </div>
              <p :class="{ active: RWDnews }" @click="clickNews">熱門新聞</p>
              <li v-for="(item, index) in category" :key="index" :class="{ active: activeItem === index }"
                @click="clickCategory(index)">
                {{ item }}
              </li>
            </ul>
            <div class="Fb-post-write-X">
              <RouterLink to="/social_write">寫文章</RouterLink>
            </div>
          </div>

          <!-- :articles="articles" -->
          <!-- <router-view :key="$route.path" :activeItem="activeItem" :datas="datas"   @category-changed="changeCategory" /> -->

          <!-- 文章區 -->
          <div class="Fb-post-article-X" :class="{ active: !RWDnews }">
            <!-- 置頂區：放廣告或站上的精華文章 -->
            <div class="Fb-post-article-top-X">
              <!-- <div class="Fb-post-article-banner-X"></div> -->
            </div>
            <!-- po 文顯示區 -->
            <section>
              <article v-for="(data, index) in datas" :key="index" @click="goToArticle(data.ID)">
                <div class="Fb-post-article-left-X">
                  <div class="Fb-post-article-left-C-T-X">
                    <span>{{ data.category }}</span>&nbsp;‧&nbsp;<span>{{ data.time.split(' ')[0] }}</span>
                  </div>
                  <h6 class="Fb-post-article-left-title-X">{{ data.title }}</h6>
                  <p v-html="data.content"></p>
                  <div class="Fb-post-react-X">
                    <i class="bi bi-hand-thumbs-up" style="font-style: normal;"><span style="padding: 0 4px;">{{ data.handup }}</span></i>
                    <i class="bi bi-chat" style="font-style: normal;"><span style="padding: 0 4px;">{{ data.chat }}</span></i>
                    <i class="bi bi-share"></i>
                  </div>
                </div>
                <div v-if="data.coverImage" class="Fb-post-article-right-X">
                  <img :src="getCoverImage(data.coverImage)" alt="" />
                </div>
              </article>
            </section>

            <!-- 頁數 -->
            <!-- 使用:key="activeItem" 強制讓頁數顯示再跑一次 -->
            <Paginator :currentPage="currentP" :totalPages="totalItemCount" @page-changed="handlePageChange" />
          </div>

          <!-- RWD 的時候才會出現的新聞區 -->
          <div class="Fb-news-article-X" :class="{ active: RWDnews }">
            <NewsApi :isPC="false" />
          </div>
        </div>

        <!-- 單一文章部分 -->
        <router-view v-show="$route.params.id"></router-view>



        <!-- 新聞 -->
        <!-- v-show="!$route.params.id" -->
        <div class="Fb-news-X">
          <div class="Fb-news-header-X">熱門新聞</div>
          <!-- 新聞的主要內容 -->
          <div class="Fb-news-body-X">
            <NewsApi :isPC="true" />
          </div>
        </div>
      </div>
    </div>
    <MainFooter />
  </main>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import MainFooter from '@/components/layout/MainFooter.vue';
import MainHeader from '@/components/layout/MainHeader.vue';
import Paginator from '@/components/paginator.vue';
import NewsApi from '@/components/newsApi.vue';

//文章的類別
const category = ref(['全部文章', '氣候科學', '生態危機', '綠色生活', '政策國際']);
//控制 li 的 active
const activeItem = ref(0);
//控制 select & p 的 active
const RWDnews = ref(false);

//點擊 li 的時候
const clickCategory = (index) => {
  activeItem.value = index;
  RWDnews.value = false;
};

//當 select 改變的時候
const changeCategory = () => {
  RWDnews.value = false;
};

//點擊 p 的時候
const clickNews = () => {
  RWDnews.value = true;
};

//計算頁數 //一頁五則文章
const currentP = ref(1); //當前頁碼，預設 1

const totalItemCount = computed(() => {
  return Math.ceil(filterArticles.value.length / 5);
});


// 監聽 activeItem 的變化：只要類別改變，頁數就回到第一頁
watch(activeItem, (newValue) => {
  currentP.value = 1;
});

//當翻頁的時候，就更新當前的頁碼
const handlePageChange = (newPage) => {
  currentP.value = newPage;
  window.scrollTo({
    top: 0, // 滾動到頂部
    behavior: 'smooth', // 平滑滾動
  });
};

//類別的篩選
const filterArticles = computed(() => {
  return articles.value.filter((item) => {
    if (activeItem.value === 0) {
      return articles.value;
    } else {
      return item.category === category.value[activeItem.value];
    }
  });
});

//真正要渲染到頁面的文章資料
const datas = computed(() => {
  const start = (currentP.value - 1) * 5;
  const to = currentP.value * 5;
  return filterArticles.value.slice(start, to);
})

const router = useRouter();

const goToArticle = (ID) => {
  router.push(`/social/article/${ID}`);
  // router.push('/social_article');
}

//--------------------------------------------------

//文章資料從 getArticles.php 求取
const articles = ref([])
const fetchArticlesURL = '/tid103/g1/php/getArticles.php';
const fetchArticles = async () => {
  try {
    const res = await fetch(fetchArticlesURL);
    const data = await res.json();
    articles.value = data;
  } catch (error) {
    console.error("獲取文章時發生錯誤:", error);
  }
};

//封面圖(要再修改)
const getCoverImage = (Image) => {
  return Image ? new URL(Image, import.meta.url).href : new URL('@/assets/images/defaultavatar.jpeg', import.meta.url).href
}

onMounted(fetchArticles);



//假設這是資料庫中所有文章的資料
// const articles = ref([
//   {
//     category: '氣
// 科學',
//     time: '2024-12-25',
//     title: '日本異常高溫 預估2024年均溫將續創統計史新高',
//     content:
//       '（中央社東京25日綜合外電報導）日本氣象廳今天公布天氣總結指出，日本今年1月到11月的平均氣溫較1991年到2020年平均氣溫升高攝氏1.64度，比2023年的升高1.29度還多，預料將連續兩年創統計史新高紀錄。',
//     handup: 100,
//     chat: 100,
//     image: new URL('@/assets/images/Fb10.jpg', import.meta.url).href
//   },
//   {
//     category: '政策國際',
//     time: '2024-12-25',
//     title: '調查：助低收者因應極端氣候 8成6支持政府釋資源',
//     content:
//       '台大風險中心舉辦「2024台灣公正轉型調查發布」記者會，針對淨零排放、氣候變遷雙主軸，對全國18歲以上民眾，在17日到25日使用室內電話、行動電話2種電話訪問調查，有效樣本1102份，以95%信賴度估計，抽樣誤差在正、負2.95個百分點之內。',
//     handup: 100,
//     chat: 100,
//     image: '',
//   },
//   {
//     category: '生態危機',
//     time: '2024-12-25',
//     title: '北極氣候暖化 耶誕老人故鄉不下雪引擔憂',
//     content:
//       '（中央社芬蘭羅文尼米26日綜合外電報導）隨著耶誕節的腳步日漸接近，耶誕老人的工作進入緊鑼密鼓的忙碌階段。但是氣候暖化導致他位在北極圈的老家下雪量不足，就連耶誕老人都十分擔心。',
//     handup: 100,
//     chat: 100,
//     image: new URL('@/assets/images/Fb11.jpg', import.meta.url).href
//   },
//   {
//     category: '政策國際',
//     time: '2024-12-25',
//     title: 'COP29終於達成氣候融資協議 峰會重點一次看',
//     content:
//       '（中央社巴庫24日綜合外電報導）亞塞拜然首都巴庫舉行的聯合國氣候變化綱要公約第29次締約方會議（COP29）歷經2週的緊張協商，最終在期限過後2天達成氣候融資協議。路透社整理本次峰會的重點如下：',
//     handup: 100,
//     chat: 100,
//     image: new URL('@/assets/images/Fb04.jpg', import.meta.url).href
//   },
//   {
//     category: '生態危機',
//     time: '2024-12-25',
//     title: '太平洋高壓西進擴大 台灣面臨極端高溫及乾旱',
//     content:
//       '（中央社記者張雄風台北28日電）氣象署今天表示，統計過去70年，太平洋高壓系統逐漸西進擴大，近10年甚至已經涵蓋到中國華南沿岸，足見全球暖化的影響；台灣未來將面臨更為頻繁的極端高溫，及乾旱事件所帶來的氣候風險。',
//     handup: 100,
//     chat: 100,
//     image: new URL('@/assets/images/Fb14.jpg', import.meta.url).href
//   },
//   {
//     category: '綠色生活',
//     time: '2024-12-25',
//     title: '《綠色生活行動指南》：適合每個人的日常生活環保起手式',
//     content:
//       '根據統計，全球每年浪費掉的食物約為 13 億公噸，是生產量的 3 分之 1，而每噸廚餘經過掩埋處理，會產生約 221.35 公斤二氧化碳、14.7 公斤甲烷，總計每年為了處理廚餘，就製造高達 44 億噸的溫室氣體。',
//     handup: 100,
//     chat: 100,
//     image: '',
//   },
//   {
//     category: '氣候科學',
//     time: '2024-12-25',
//     title: '日本異常高溫 預估2024年均溫將續創統計史新高',
//     content:
//       '（中央社東京25日綜合外電報導）日本氣象廳今天公布天氣總結指出，日本今年1月到11月的平均氣溫較1991年到2020年平均氣溫升高攝氏1.64度，比2023年的升高1.29度還多，預料將連續兩年創統計史新高紀錄。',
//     handup: 100,
//     chat: 100,
//     image: new URL('@/assets/images/Fb10.jpg', import.meta.url).href
//   },
//   {
//     category: '政策國際',
//     time: '2024-12-25',
//     title: '調查：助低收者因應極端氣候 8成6支持政府釋資源',
//     content:
//       '台大風險中心舉辦「2024台灣公正轉型調查發布」記者會，針對淨零排放、氣候變遷雙主軸，對全國18歲以上民眾，在17日到25日使用室內電話、行動電話2種電話訪問調查，有效樣本1102份，以95%信賴度估計，抽樣誤差在正、負2.95個百分點之內。',
//     handup: 100,
//     chat: 100,
//     image: '',
//   },
//   {
//     category: '生態危機',
//     time: '2024-12-25',
//     title: '北極氣候暖化 耶誕老人故鄉不下雪引擔憂',
//     content:
//       '（中央社芬蘭羅文尼米26日綜合外電報導）隨著耶誕節的腳步日漸接近，耶誕老人的工作進入緊鑼密鼓的忙碌階段。但是氣候暖化導致他位在北極圈的老家下雪量不足，就連耶誕老人都十分擔心。',
//     handup: 100,
//     chat: 100,
//     image: new URL('@/assets/images/Fb11.jpg', import.meta.url).href
//   },
//   {
//     category: '政策國際',
//     time: '2024-12-25',
//     title: 'COP29終於達成氣候融資協議 峰會重點一次看',
//     content:
//       '（中央社巴庫24日綜合外電報導）亞塞拜然首都巴庫舉行的聯合國氣候變化綱要公約第29次締約方會議（COP29）歷經2週的緊張協商，最終在期限過後2天達成氣候融資協議。路透社整理本次峰會的重點如下：',
//     handup: 100,
//     chat: 100,
//     image: new URL('@/assets/images/Fb04.jpg', import.meta.url).href
//   },
//   {
//     category: '生態危機',
//     time: '2024-12-25',
//     title: '太平洋高壓西進擴大 台灣面臨極端高溫及乾旱',
//     content:
//       '（中央社記者張雄風台北28日電）氣象署今天表示，統計過去70年，太平洋高壓系統逐漸西進擴大，近10年甚至已經涵蓋到中國華南沿岸，足見全球暖化的影響；台灣未來將面臨更為頻繁的極端高溫，及乾旱事件所帶來的氣候風險。',
//     handup: 100,
//     chat: 100,
//     image: new URL('@/assets/images/Fb14.jpg', import.meta.url).href
//   },
//   {
//     category: '綠色生活',
//     time: '2024-12-25',
//     title: '《綠色生活行動指南》：適合每個人的日常生活環保起手式',
//     content:
//       '根據統計，全球每年浪費掉的食物約為 13 億公噸，是生產量的 3 分之 1，而每噸廚餘經過掩埋處理，會產生約 221.35 公斤二氧化碳、14.7 公斤甲烷，總計每年為了處理廚餘，就製造高達 44 億噸的溫室氣體。',
//     handup: 100,
//     chat: 100,
//     image: '',
//   },
// ])


</script>
