import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from './App.vue';
import router from './router';

// import '@/assets/main.css';
// import '@/style/index.less';

// 引入组件库全局样式资源
// import 'tdesign-vue-next/es/style/index.css';

//留言板套件使用
// import CKEditor from '@ckeditor/ckeditor5-vue';
// import CKEditor from '@ckeditor/ckeditor5-vue';
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic';


const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
// app.use(CKEditor);
// app.use(ClassicEditor);


//component

app.mount('#app');
