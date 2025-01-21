<template>
  <div>
    <BackStageHeader></BackStageHeader>
    <div class="backStage_bgc">
      <div class="backStage_wrapper">
        <h3>遊戲互動管理</h3>
        <!-- <h3>會員管理</h3> -->
        <div class="wrapper">
          <BackStageSidebar></BackStageSidebar>
          <main class="IcB_table_H">
            <h5>城市階段圖:</h5>
            <section>
              <div>
                <figure>
                  <div>
                    <label for="lowStage">低階段:</label>
                    <input id="lowStage" class="cityUpload" type="file" accept="image/*, image/svg+xml" />
                  </div>
                  <div class="preview">
                    <p>圖片預覽</p>
                  </div>
                  <button class="btn">圖片上傳</button>
                </figure>
                <figure>
                  <div>
                    <label for="midStage">中階段:</label>
                    <input id="midStage" class="cityUpload" type="file" accept="image/*, image/svg+xml" />
                  </div>
                  <div class="preview">
                    <p>圖片預覽</p>
                  </div>
                  <button class="btn">圖片上傳</button>
                </figure>
              </div>
              <figure>
                <label for="highStage">高階段:</label>
                <input id="highStage" class="cityUpload" type="file" accept="image/*, image/svg+xml" />
                <div class="preview">
                  <p>圖片預覽</p>
                </div>
                <button class="btn">圖片上傳</button>
              </figure>
            </section>
          </main>
        </div>
        <BackStagePaginator></BackStagePaginator>
      </div>
    </div>
  </div>
</template>

<script>
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import backStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
</script>
