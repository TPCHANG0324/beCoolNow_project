<!-- 後臺管理系統 導航按鈕列 -->

<template>
  <aside class="sidebar">
    <RouterLink to="/IcB_article/"><button>島嶼文章管理</button></RouterLink>
    <RouterLink to="/IcB_edu/"><button>教育影片管理</button></RouterLink>
    <RouterLink to="/IcB_q&a/"><button>互動問答管理</button></RouterLink>
    <RouterLink to="/AcB_earthMail/"><button>地球信件管理</button></RouterLink>
    <RouterLink to="/CB_forumBoard/"><button>討論板管理</button></RouterLink>
    <RouterLink to="/CB_messageBoard/"><button>留言板管理</button></RouterLink>
    <RouterLink to="/CtB_cityGame/"><button>遊戲互動管理</button></RouterLink>
    <RouterLink to="/AuB_message/"><button>訊息管理</button></RouterLink>
    <RouterLink to="/SpB_product/"><button>商品庫存管理</button></RouterLink>
    <RouterLink to="/SpB_order/"><button>訂單管理</button></RouterLink>
    <RouterLink to="/MmB_member/"><button>會員管理</button></RouterLink>
  </aside>
</template>

<script>
import { RouterLink } from 'vue-router';

export default {
  name: 'BackStageSidebar',
  components: RouterLink,
};
</script>
