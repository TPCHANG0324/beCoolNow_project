import { createRouter, createWebHistory } from 'vue-router';

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
    path: '/information',
    component: () => import('@/pages/Information.vue'),
    meta: {
      title: '島嶼危機',
      // requiredLogin: false
    },
  },
  {
    path: '/activity',
    component: () => import('@/pages/Activity.vue'),
    meta: {
      title: '永續行動',
      // requiredLogin: false
    },
  },
  {
    path: '/social',
    component: () => import('@/pages/social.vue'),
    meta: {
      title: '社群中心',
      // requiredLogin: true
    },
  },
  {
    path: '/social_article',
    component: () => import('@/pages/Social_article.vue'),
    meta: {
      title: '社群中心_文章',
      // requiredLogin: true
    },
  },
  {
    path: '/About',
    component: () => import('@/pages/About.vue'),
    meta: {
      title: '關於我們',
    },
  },
  {
    path: '/loginPage/',
    component: () => import('@/pages/loginPage.vue'),
    meta: {
      title: '社群中心',
      // requiredLogin: true
    },
  },
  {
    path: '/shop_checkout',
    component: () => import('@/pages/Shop_checkout.vue'),
    meta: {
      title: '市集結帳',
      // requiredLogin: true
    },
  },
  {
    path: '/shop_finish',
    component: () => import('@/pages/Shop_finish.vue'),
    meta: {
      title: '市集結束',
    },
  },
  {
    path: '/social_write',
    component: () => import('@/pages/Social_write.vue'),
    meta: {
      title: '寫文章',
      // requiredLogin: true
    },
  },
  {
    path: '/social_news',
    component: () => import('@/pages/Social_news.vue'),
    meta: {
      title: '新聞',
    },
  },
  {
    path: '/popup',
    component: () => import('@/pages/popup.vue'),
    meta: {
      title: '前台彈窗',
      // requiredLogin: true
    },
  },
  // {
  //   path: '/Ct/', component: () => import('@/pages/Ct.vue'),
  //   meta: {
  //     title: '綠境方城市',
  //     requiredLogin: true
  //   }
  // },
  {
    path: '/pay1/',
    component: () => import('@/pages/pay1.vue'),
    meta: {
      title: '捐款頁面1',
      // requiredLogin: true
    },
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
    path: '/shop',
    component: () => import('@/pages/Shop.vue'),
    meta: {
      title: '環保市集',
      // requiredLogin: true
    },
  },
  {
    path: '/shop_product/',
    component: () => import('@/pages/Shop_product.vue'),
    meta: {
      title: '環保市集_商品頁',
      // requiredLogin: true
    },
  },
  {
    path: '/shop_cart',
    component: () => import('@/pages/Shop_cart.vue'),
    meta: {
      title: '環保市集_購物車',
      // requiredLogin: true
    },
  },
  {
    path: '/member',
    component: () => import('@/pages/Member.vue'),
    meta: {
      title: '會員中心',
      // requiredLogin: true
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
    path: '/IcB_article/',
    component: () => import('@/pages/BackStagePages/IcB_article.vue'),
    meta: {
      title: '島嶼文章管理',
      // requiredLogin: true
    },
  },
  {
    path: '/IcB_edu/',
    component: () => import('@/pages/BackStagePages/IcB_edu.vue'),
    meta: {
      title: '教育影片管理',
      // requiredLogin: true
    },
  },
  {
    path: '/IcB_q&a/',
    component: () => import('@/pages/BackStagePages/IcB_q&a.vue'),
    meta: {
      title: '互動問答管理',
      // requiredLogin: true
    },
  },
  {
    path: '/AcB_earthMail/',
    component: () => import('@/pages/BackStagePages/AcB_earthMail.vue'),
    meta: {
      title: '地球信件管理',
      // requiredLogin: true
    },
  },
  {
    path: '/CB_forumBoard/',
    component: () => import('@/pages/BackStagePages/CB_forumBoard.vue'),
    meta: {
      title: '討論板管理',
      // requiredLogin: true
    },
  },
  {
    path: '/CB_messageBoard/',
    component: () => import('@/pages/BackStagePages/CB_messageBoard.vue'),
    meta: {
      title: '留言板管理',
      // requiredLogin: true
    },
  },
  {
    path: '/CtB_cityGame/',
    component: () => import('@/pages/BackStagePages/CtB_cityGame.vue'),
    meta: {
      title: '遊戲互動管理',
      // requiredLogin: true
    },
  },
  {
    path: '/AuB_message/',
    component: () => import('@/pages/BackStagePages/AuB_message.vue'),
    meta: {
      title: '訊息管理',
      // requiredLogin: true
    },
  },
  {
    path: '/SpB_product/',
    component: () => import('@/pages/BackStagePages/SpB_product.vue'),
    meta: {
      title: '商品庫存管理',
      // requiredLogin: true
    },
  },
  {
    path: '/SpB_order/',
    component: () => import('@/pages/BackStagePages/SpB_order.vue'),
    meta: {
      title: '訂單管理',
      // requiredLogin: true
    },
  },
  {
    path: '/MmB_member/',
    component: () => import('@/pages/BackStagePages/MmB_member.vue'),
    meta: {
      title: '會員管理',
      // requiredLogin: true
    },
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
  {
    path: '/Support/',
    component: () => import('@/pages/Support.vue'),
    meta: {
      title: '支持我們',
      // requiredLogin: true
    },
  },
];

// 建立 router
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL), // vite 設定檔中的 base: /tid103/g1/
  routes: routes,
});

router.beforeEach(async (to, from, next) => {
  // 記得加第三個參數 next
  //console.log(to);   // 連到目前的網址的物件資料
  //console.log(from); // 從哪個網址連過來的物件資料

  if (to.meta.requiredLogin) {
    // ======= 以下要取得使用者目前的登入狀態，會是 bool == //
    // 取得是否已登入，可能是從 localStorage 抓資料或從後端判斷。
    // let isAuthenticated = true;
    const res = await fetch('https://notes.webmix.cc/login_test/login.php');
    const data = await res.json();

    console.log(data);

    const isAuthenticated = data.login_status;
    // ============================================== //

    if (isAuthenticated) {
      document.title = to.meta.title;
      next();
    } else {
      // 未登入，就直接導回到首頁或其它頁面。
      next('/');
    }
  } else {
    document.title = to.meta.title;
    next();
  }
});
// 匯出 router
export default router;
