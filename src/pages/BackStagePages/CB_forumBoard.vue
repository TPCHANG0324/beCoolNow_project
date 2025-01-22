<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <div class="CB_tag_H">
          <h3 class="CB_titleF_H">討論板管理</h3>
          <div class="MmB_searchBar_H">
            <input id="" class="input" type="text" name="" placeholder="搜尋文章" />
            <i class="fa-solid fa-magnifying-glass"></i>
          </div>
        </div>
        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>
          <main class="CB_TableF_H">
            <table class="CB_mainFTable_H">
              <thead>
                <tr>
                  <th class="CB_numberF_H">文章編號</th>
                  <th class="CB_memberIdF_H">會員編號</th>
                  <th class="CB_articleF_H">文章分類</th>
                  <th class="CB_topicF_H">標題</th>
                  <th class="CB_editDateF_H">編輯日期</th>
                  <th class="CB_goTopCheckF_H">是否置頂</th>
                  <th class="CB_goOffF_H">下架</th>
                  <!-- <th><button class="IcB_addBtn_H">新增</button></th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>113122101</td>
                  <td>氣候科學</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>113122102</td>
                  <td>氣候科學</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>113122103</td>
                  <td>氣候科學</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>113122103</td>
                  <td>氣候科學</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>113122103</td>
                  <td>氣候科學</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>113122103</td>
                  <td>氣候科學</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                </tr>
                <tr>
                  <td>7</td>
                  <td>113122103</td>
                  <td>氣候科學</td>
                  <td class="CB_content_H">全球暖化釀嚴重海洋生態災難 科學家憂「大滅絕」再現</td>
                  <td>2025-01-12</td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                </tr>
              </tbody>
            </table>
          </main>
        </div>
        <BackStagePaginator></BackStagePaginator>
      </div>
    </div>

    <!-- 討論板 下架 -->
    <BackStageConfirmPopup class="CB_goOffForum_H">
      <span></span>
      <div>
        <h3>確定將此文章下架嗎?</h3>
        <div>
          <button>取消</button>
          <button>確定</button>
        </div>
      </div>
    </BackStageConfirmPopup>

    <!-- 討論板 置頂 -->
    <BackStageConfirmPopup class="CB_goTopForum_H">
      <span></span>
      <div>
        <h3>確定將此文章置頂嗎?</h3>
        <div>
          <button>取消</button>
          <button>確定</button>
        </div>
      </div>
    </BackStageConfirmPopup>
  </div>
</template>

<script>
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import backStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageConfirmPopup from '@/components/layout/BackStageLayout/BackStageConfirmPopup.vue';
</script>
