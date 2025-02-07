import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from './App.vue';
import router from './router';
import axios from 'axios';
// import '@/assets/main.css';
// import '@/style/index.less';

// 引入组件库全局样式资源
// import 'tdesign-vue-next/es/style/index.css';

//留言板套件使用
// import CKEditor from '@ckeditor/ckeditor5-vue';  
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic'; 
// import { CKEditor } from '@ckeditor/ckeditor5-vue';

//郵件套件
import emailjs from '@emailjs/browser';

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
// app.use(CKEditor);
// app.component('CKEditor', CKEditor);
app.config.globalProperties.$eventBus = app; // 創建事件總線
app.config.globalProperties.$axios = axios; 
emailjs.init('5-GBPJlIL-R8kd1sM'); //初始化

//component

app.mount('#app');
