<template>
  <MainHeader />
  <main v-if="isAuthenticated">
    <!-- 撰寫文章，縮寫FbW - 功能 - 代號X -->
    <div class="FbW-X">
      <!-- 發文區 -->
      <form action="" class="FbW-wrapper-X">
        <!-- 標題 -->
        <div class="FbW-title-X">
          <div class="FbW-postTilte">
            <label for="FbW-postTilte-X">
              <span>標題</span>
              <span>請在 40 字內描述你的主題（必填）</span>
            </label>
            <select id="" name="">
              <option value="主題選擇" disabled selected>主題選擇</option>
              <option value="氣候科學">氣候科學</option>
              <option value="生態危機">生態危機</option>
              <option value="綠色生活">綠色生活</option>
              <option value="政策國際">政策國際</option>
            </select>
          </div>
          <input id="FbW-postTilte-X" type="text" placeholder="給文章一個好標題" />
        </div>
        <!-- 內文 -->
        <div class="FbW-content-X">
          <label for="FbW-postContent-X">
            <span>內文</span>
            <span>請勿人身攻擊或辱罵他人（必填）</span>
          </label>
          <div class="FbW-translate-X">
            <a title="粗體 (Ctrl-B)" tabindex="-1" class="fa fa-bold"></a>
            <a title="斜體 (Ctrl-I)" tabindex="-1" class="fa fa-italic"></a>
            <a title="插入連結 (Ctrl-K)" tabindex="-1" class="fa fa-link"></a>
            <a title="插入圖片 (Ctrl-Alt-I)" tabindex="-1" class="fa-regular fa-image"></a>
            <a title="表情符號" tabindex="-1" class="fa-regular fa-face-smile"></a>
          </div>
          <textarea id="FbW-postContent-X" name="" placeholder="開始寫文章囉"></textarea>
        </div>
        
        <!-- 預覽圖 -->
        <div class="FbW-picture-X">
          <div>
            <input id="FbW-picChoose-X" type="checkbox" /> <label for="FbW-picChoose-X">是否選擇文章縮圖</label>
          </div>
          <div class="FbW-picture-slider-X"></div>
        </div>

        <button type="submit">送出文章</button>
      </form>
    </div>

    <!-- 測試留言板套件 -->
    <!-- <div>  
        <ckeditor v-model="data" :editor="editor"></ckeditor>  
    </div>  -->

  </main>
  <MainFooter class="removeMT" />
</template>

<script setup>
import MainFooter from '@/components/layout/MainFooter.vue';
import MainHeader from '@/components/layout/MainHeader.vue';
import { useAuth } from '@/utils/useAuth';

//由這段判斷是否經過登入驗證，並且取得用戶的 email 作為資料的獲取渠道
const { isAuthenticated, userEmail, checkAuth } = useAuth()

onMounted(() => {
  checkAuth()
})
// 測試留言板套件
// const data = ref('<p>这里是 CKEditor 示例内容</p>'); // 初始化内容  
// const editor = ClassicEditor; // 使用 ClassicEditor 

</script>
