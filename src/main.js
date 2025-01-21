import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from './App.vue';
import router from './router';

// import '@/assets/main.css';
// import '@/style/index.less';

// 引入组件库全局样式资源
// import 'tdesign-vue-next/es/style/index.css';

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);

//component

app.mount('#app');
