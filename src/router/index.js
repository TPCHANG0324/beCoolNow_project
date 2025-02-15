// import { name } from 'dayjs/locale/zh-cn';
import { createRouter, createWebHistory } from 'vue-router';
import eventBus from '@/utils/eventBus';
import { useAuth } from '@/utils/useAuth';
// import Shop_product from '@/pages/Shop_product.vue';


// path → component
const routes = [
  {
    path: '/',
    component: () => import('@/pages/Home.vue'),
    meta: {
      title: '首頁',
      // requiredLogin: false
    },
  },
  {
    path: '/information/',
    component: () => import('@/pages/Information.vue'),
    meta: {
      title: '島嶼危機',
      // requiredLogin: false
    },
  },

  {
    path: '/donatefinish/',
    component: () => import('@/pages/Donatefinish.vue'),
    meta: {
      title: '感謝捐款',
      // requiredLogin: false
    },
  },
  {
    path: '/activity/',
    component: () => import('@/pages/Activity.vue'),
    meta: {
      title: '永續行動',
      // requiredLogin: false
    },
  },
  {
    path: '/social',
    name: 'social',
    component: () => import('@/pages/social.vue'),
    meta: {
      title: '社群中心',
      // requiredLogin: true
    },
    children: [
      {
        path: 'article/:id',
        name: 'article-detail',
        component: () => import('@/pages/Social_article.vue'),
        meta: {
          // title: '文章詳情',
          title: null,
          dynamicTitle: true
        },
        props: true
      }
    ]
  },
  {
    path: '/About/',
    component: () => import('@/pages/About.vue'),
    meta: {
      title: '關於我們',
    },
  },
  {
    path: '/shop_checkout/',
    component: () => import('@/pages/Shop_checkout.vue'),
    meta: {
      title: '市集結帳',
      // requiredLogin: true
    },
  },
  {
    path: '/shop_finish/',
    component: () => import('@/pages/Shop_finish.vue'),
    meta: {
      title: '市集結束',
    },
  },
  {
    path: '/social_write/',
    component: () => import('@/pages/Social_write.vue'),
    meta: {
      title: '寫文章',
      // requiredLogin: true
    },
  },
  {
    path:'/social_write/edit/:id',
    name: 'article-edit',
    component: () => import('@/pages/Social_edit.vue'),
    meta:{
      title:'修改文章',
    }
  },
  {
    path: '/popup/',
    component: () => import('@/pages/popup.vue'),
    meta: {
      title: '前台彈窗',
      // requiredLogin: true
    },
  },
  {
    path: '/city/',
    component: () => import('@/pages/City.vue'),
    meta: {
      title: '綠境方城市',
      // requiredLogin: true,
    },
  },
  {
    path: '/popupnewmember/',
    component: () => import('@/pages/popupnewmember.vue'),
    meta: {
      title: '前台彈窗新會員註冊',
      // requiredLogin: true
    },
  },
  {
    path: '/support/',
    component: () => import('@/pages/Support.vue'),
    meta: {
      title: '支持我們',
      // requiredLogin: true
    },
  },
  {
    path: '/pay1/',
    component: () => import('@/pages/pay1.vue'),
    meta: {
      title: '捐款頁面1',
      // requiredLogin: true
    },
  },

  {
    path: '/donation/confirm',
    name: 'DonationConfirm',
    component: () => import('@/pages/DonationConfirm.vue')
  },
  {
    path: '/pay2/',
    component: () => import('@/pages/pay2.vue'),
    meta: {
      title: '捐款頁面2',
      // requiredLogin: true
    },
  },
  {
    path: '/shop/',
    component: () => import('@/pages/Shop.vue'),
    meta: {
      title: '環保市集',
      // requiredLogin: true
    },
  },
  {
    path: '/shop/:id',
    name:'single-shop',
    component: () => import('@/pages/Shop_product.vue'),
    meta: {
      title: '環保市集_商品頁',
      // requiredLogin: true
    },
  },
  {
    path: '/shop_cart/',
    component: () => import('@/pages/Shop_cart.vue'),
    meta: {
      title: '環保市集_購物車',
      // requiredLogin: true
    },
  },
  {
    path: '/member/',
    component: () => import('@/pages/Member.vue'),
    meta: {
      title: '會員中心',
      requiredLogin: true
    },
  },
  {
    path: '/test/',
    component: () => import('@/pages/test.vue'),
    meta: {
      title: '測試動畫',
      // requiredLogin: true
    },
  },
  {
    path: '/tests/',
    component: () => import('@/pages/tests.vue'),
    meta: {
      title: '測試動畫',
      // requiredLogin: true
    },
  },
  {
    path: '/loginPage/',
    component: () => import('@/pages/loginPage.vue'),
    meta: {
      title: '前後台登入',
      // requiredLogin: true
    },
  },
  {
    path: '/loginPagePC/',
    component: () => import('@/pages/loginPagePC.vue'),
    meta: {
      title: '前後台登入',
      // requiredLogin: true
    },
  },
  {
    path: '/loginPopupChange/',
    component: () => import('@/pages/loginPopupChange.vue'),
    meta: {
      title: '登入彈窗切換',
      // requiredLogin: true
    },
  },
  {
    path: '/BackStagePages',
    children: [
      { path: '', component: () => import('@/pages/BackStagePages/IcB_article.vue'), meta:{title:'島嶼文章管理'} },
      { path: 'IcB_edu', component: () => import('@/pages/BackStagePages/IcB_edu.vue'), meta:{title:'教育影片管理'} },
      { path: 'IcB_q&a', component: () => import('@/pages/BackStagePages/IcB_q&a.vue'), meta:{title:'互動問答管理'} },
      { path: 'AcB_earthMail', component: () => import('@/pages/BackStagePages/AcB_earthMail.vue'), meta:{title:'地球信件管理'} },
      { path: 'CB_forumBoard', component: () => import('@/pages/BackStagePages/CB_forumBoard.vue'), meta:{title:'討論板管理'} },
      { path: 'CB_messageBoard', component: () => import('@/pages/BackStagePages/CB_messageBoard.vue'), meta:{title:'留言板管理'} },
      { path: 'CtB_cityGame', component: () => import('@/pages/BackStagePages/CtB_cityGame.vue'), meta:{title:'遊戲互動管理'} },
      { path: 'AuB_message', component: () => import('@/pages/BackStagePages/AuB_message.vue'), meta:{title:'訊息管理'} },
      { path: 'SpB_product', component: () => import('@/pages/BackStagePages/SpB_product.vue'), meta:{title:'商品庫存管理'} },
      { path: 'SpB_order', component: () => import('@/pages/BackStagePages/SpB_order.vue'), meta:{title:'訂單管理'} },
      { path: 'MmB_member', component: () => import('@/pages/BackStagePages/MmB_member.vue'), meta:{title:'會員管理'} },
    ],
  },

  //----------------------------- 彈窗畫面
  {
    path: '/BackStageSmallPopup/',
    component: () => import('@/components/layout/BackStageLayout/BackStageSmallPopup.vue'),
    meta: {
      title: '後臺-確認彈窗',
      // requiredLogin: true
    },
  },
  // {
  //   path: '/MainHeader/',
  //   component: () => import('@/components/layout/MainHeader.vue'),
  //   meta: {
  //     title: 'Header',
  //     // requiredLogin: true
  //   },
  // },
  {
    path: '/ckeditor/',
    component: () => import('@/components/items/ckeditor.vue'),
    meta: {
      title: 'ckeditor',
      // requiredLogin: true
    },
  },
  {
    path: '/loading/',
    component: () => import('@/components/items/loading.vue'),
    meta: {
      title: 'loading',
      // requiredLogin: true
    },
  },
];

// 建立 router
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL), // vite 設定檔中的 base: /tid103/g1/
  routes: routes,
  // history: createWebHashHistory(),
  // routes: routes,
  scrollBehavior(to, from, savedPosition) {
    // return desired position
    return { top: 0 };
  },
});

router.beforeEach(async (to, from, next) => {
  // 記得加第三個參數 next
  //console.log(to);   // 連到目前的網址的物件資料
  //console.log(from); // 從哪個網址連過來的物件資料

  const { checkAuth } = useAuth(); //檢查登入
  if (to.matched.some(record => record.meta.requiredLogin)) {

    try {
      const isAuthenticated = await checkAuth();
      if (!isAuthenticated) {
        const askLogin = confirm('此頁面需要先登入再進行操作，請問是否繼續？');
        if(askLogin){
          localStorage.setItem('redirectPath', to.fullPath); //存儲原本要去的頁面
          eventBus.emit('show-login-popup'); //跳出登入彈窗
        }
        next(false)
      } else {
        next()
      }
    } catch (err) {
      console.error('檢查登入狀態失敗:', err);
      next(false);
    }
  } else {
    document.title = to.meta.title;
    next();
  }

});

router.afterEach((to, from) => {
  //設置社群中心 - 文章詳情 頁面的 title
  if (to.meta.title && !to.meta.dynamicTitle) {
    document.title = to.meta.title
  }
})
// 匯出 router
export default router;
