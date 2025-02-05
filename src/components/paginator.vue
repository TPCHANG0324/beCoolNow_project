<template>
    <!-- 頁數 -->
    <div class="Sp-pages-X">
        <ul>
            <li class="Sp-pages-prev" @click="prevPage" v-if="currentPage > 1">
                <i class="bi bi-caret-left-fill"></i>
            </li>
            <li v-for="page in totalPages" :key="page" :class="{ current: page === currentPage }" @click="goToPage(page)">
                <span>{{ page }}</span>
            </li>
            <li class="Sp-pages-next" @click="nextPage" v-if="currentPage < totalPages">
                <i class="bi bi-caret-right-fill"></i>
            </li>
        </ul>
    </div>
</template>

<script setup>
// import { ref, watch } from 'vue';
// import { ref, watch, defineProps, defineEmits } from 'vue'
const emit = defineEmits(['page-changed']);

const props = defineProps({
    totalPages: { //總共幾頁
        type: Number,
        required: true
    },
    currentPage: { //目前的頁數
        type: Number,
        required: true
    }
});


//一開始的頁數
// const currentPage = ref(1);
// const currentPage = ref(props.currentPage)

//切換到指定頁
const goToPage = (page) => {
    // if (page !== currentPage.value) {
    //     currentPage.value = page;
    //     //當頁面發生變化的時候，把頁數的資料當作參數傳遞到父組件
    //     emit('page-changed', currentPage.value);
    // }
    if (page !== props.currentPage) {
        emit('page-changed', page);
    }
};



//上一頁
const prevPage = () => {
    if(props.currentPage > 1){
        goToPage(props.currentPage - 1);
    }
};

//下一頁
const nextPage = () => {
    if(props.currentPage < props.totalPages){
        goToPage(props.currentPage + 1);
    }
};
</script>

