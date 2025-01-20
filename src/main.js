import { createApp } from 'vue';

import App from './App.vue';
import router from './router';
import store from './store';
// import 'owl.carousel/dist/assets/owl.carousel.css';
// import 'owl.carousel/dist/assets/owl.theme.default.css';
// import 'jquery'; // Owl Carousel 依賴 jQuery
// import 'owl.carousel';

// import '@/assets/main.css';
// import '@/style/index.less';

// 引入组件库全局样式资源
// import 'tdesign-vue-next/es/style/index.css';

// import VueChart from 'vue-chart-3';


createApp(App).use(router).use(store).mount('#app');
