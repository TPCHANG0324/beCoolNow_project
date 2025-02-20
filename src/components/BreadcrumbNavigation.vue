<template>
  <nav class="breadCrumb">
    <ol>
      <li>
        <router-link to="/shop">環保市集</router-link>
      </li>

      <!-- 顯示價格範圍 -->
      <li v-if="priceRange && priceRange !== '全部商品'">
        &nbsp;&gt;&nbsp; {{ priceRange }}
      </li>

      <!-- 顯示商品名稱 -->
      <li v-if="productName">
        &nbsp;&gt;&nbsp; {{ productName }}
      </li>
    </ol>
  </nav>
</template>


  <script>
  import { watch, ref, onMounted } from "vue";

  export default {
  name: "BreadcrumbNavigation",
  props: {
    priceRange: {
      type: String,
      default: "全部商品",
    },
    productName: {
      type: String,
      default: "",
    },
  },
  setup(props) {
    // console.log("📢 [Breadcrumb] 收到價格範圍:", props.priceRange);
    onMounted(() => {
      // console.log("📢 [Breadcrumb] 組件已掛載！");
    });
  }

};
  </script>
