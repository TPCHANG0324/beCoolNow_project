<template>
    <!-- 電腦版的側邊新聞欄 -->
    <article v-for="(item, index) in news" :key="index" v-if="isPC">
        <a :href="item.url" target="_blank">
            <img :src="item.urlToImage" alt="" />
            <div class="Fb-news-body-container-X">
                <div class="Fb-news-body-container-time-X">{{ item.publishedAt.split('T')[0] }}</div>
                <div class="Fb-news-body-container-title-X">{{ item.title }}</div>
                <div class="Fb-news-body-container-content-X">{{ item.description }}</div>
            </div>
        </a>
    </article>

    <!-- 手機版的新聞欄 -->
    <article v-for="(item, index) in news" :key="index" v-if="!isPC">
        <a :href="item.url" target="_blank">
            <div class="new-left-X">
                <img :src="item.urlToImage" alt="" />
            </div>
            <div class="new-right-X">
                <span class="new-time-X">新聞&nbsp;‧&nbsp;{{ item.publishedAt.split('T')[0] }}</span>
                <h6 class="new-title-X">{{ item.title }}</h6>
                <p>{{ item.description }}</p>
            </div>
        </a>
    </article>
</template>

<script setup>
const props = defineProps({
    isPC: {
        type: Boolean,
        required: true
    }
});


//今天的日期
const today = ref(new Date())
//取到的新聞陣列
const news = ref([])

//格式化日期
const getDate = (date) => {
    const year = date.getFullYear();
    const month = date.getMonth() < 9 ? '0' + String(date.getMonth() + 1) : String(date.getMonth() + 1)
    const day = date.getDate() < 10 ? '0' + String(date.getDate()) : String(date.getDate())
    return `${year}-${month}-${day}`
}

//請求 NEWS API 的資料
const getNEWS = () => {
    //設定

    const q = `全球%氣候`  //關鍵字
    const apiKey = `c37e23185827432d8fd46365f1de40be`
    const keyWords = ['氣候變遷', '暖化', '綠能', '回收', '汙染', '永續', '能源政策', '環保']  //求到的資料再用關鍵字去篩選
    const regex = new RegExp(keyWords.join('|'))

    //取得 30 天前 ~ 今天的日期  的格式化字串
    const AgoDate = new Date(today.value);
    AgoDate.setDate(today.value.getDate() - 30);
    const from = getDate(AgoDate)
    const to = getDate(today.value)

    const newURL = `https://newsapi.org/v2/everything?q=${q}
  &from=${from}&to=${to}&sortBy=popularity&apiKey=${apiKey}`
    fetch(newURL)
        .then(res => res.json())
        .then(data => {
            if (data.articles && Array.isArray(data.articles)) {
                news.value = [...data.articles];
                news.value.reverse();
                // console.log(news.value)
                news.value = news.value.filter(item => { //篩選關鍵字 && 有圖的
                    return regex.test(item.description) && item.urlToImage;
                });
                // console.log(news.value)
                news.value = news.value.slice(0, 8).reverse();
            } else {
                console.error('data 的 articles 數據不存在:', data);
            }
        })
        .catch(err => {
            console.log('請求錯誤：'+ err)
        })
}

//掛載完畢後串新聞
onMounted(() => {
    getNEWS()

})
</script>

<style lang="scss" scoped></style>