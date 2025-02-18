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
          <div class="Fb-post-article-X" :class="{ active: !RWDnews }" v-if="articles.length !== 0">
            <!-- 置頂區：放廣告或站上的精華文章 -->
            <div class="Fb-post-article-top-X">
              <!-- <div class="Fb-post-article-banner-X"></div> -->
            </div>
            <!-- po 文顯示區 -->
            <section>
              <article v-for="(data, index) in datas" :key="data.ID" @click="goToArticle(data.ID)">
                <div class="Fb-post-article-left-X">
                  <div class="Fb-post-article-left-C-T-X">
                    <span>{{ data.category }}</span>&nbsp;‧&nbsp;<span>{{ data.time.split(' ')[0] }}</span>
                  </div>
                  <h6 class="Fb-post-article-left-title-X">{{ data.title }}</h6>
                  <p v-html="data.content"></p>
                  <div class="Fb-post-react-X">
                    <i class="bi bi-hand-thumbs-up" style="font-style: normal;"><span style="padding: 0 4px;">{{
                        data.handup }}</span></i>
                    <i class="bi bi-chat" style="font-style: normal;"><span style="padding: 0 4px;">{{ data.chat
                        }}</span></i>
                    <i class="bi bi-share"></i>
                  </div>
                </div>
                <div v-if="data.coverImage" class="Fb-post-article-right-X">
                  <img :src="getCoverImage(data.coverImage)" alt="" />
                </div>
              </article>
            </section>

            <!-- 頁數 -->
            <Paginator :currentPage="currentP" :totalPages="totalItemCount" @page-changed="handlePageChange" />
          </div>

          <div v-else style="text-align: center; margin: 100px 0; color: #2E4E3F;">載入文章中，請稍後...</div>

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
import { ref, computed, onMounted, watch } from 'vue';
import { useRouter } from 'vue-router';
import MainFooter from '@/components/layout/MainFooter.vue';
import MainHeader from '@/components/layout/MainHeader.vue';
import Paginator from '@/components/paginator.vue';
import NewsApi from '@/components/newsApi.vue';

const base_url = import.meta.env.VITE_AJAX_URL //環境路徑

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
const fetchArticlesURL = base_url + '/getArticles.php';
const fetchArticles = async () => {
  try {
    const res = await fetch(fetchArticlesURL);
    const data = await res.json();
    if (data.success) {
      articles.value = processArticles(data.data);
      articles.value = articles.value.filter((item) => {
        return item.articleShelves == 1 //上架的才顯示
      })
      // console.log(articles.value)
    } else {
      console.log(data)
    }
  } catch (error) {
    console.error("獲取文章時發生錯誤:", error);
  }
};

const cleanContent = (htmlContent) => {
  // 移除所有 Base64 圖片
  const withoutImages = htmlContent.replace(/<img[^>]*>/g, '');
  // 移除所有 HTML 標籤
  const withoutTags = withoutImages.replace(/<[^>]*>/g, '');
  // 移除多餘空白
  return withoutTags.trim().replace(/\s+/g, ' ');
}

const processArticles = (articles) => {
  return articles.map(article => ({
    ...article,
    content: cleanContent(article.content), // 處理 content
  }));
};


//封面圖
const getCoverImage = (Image) => {
  return Image ? Image : new URL('@/assets/images/defaultavatar.jpeg', import.meta.url).href
}

onMounted(fetchArticles);

</script>
