<template>
  <MainHeader />
  <!-- 單一文章頁面，縮寫Fb - 功能 - 代號X -->
  <main>
    <div class="Fb-X">
      <div class="Fb-wrapper-X">
        <!-- 文章 -->
        <div class="Fb-post-X">
          <!-- 文章分類 -->
          <!-- <div class="Fb-post-category-container-X">
            <ul class="Fb-post-category-X">
              <div class="Fb-post-category-box">
                <select id="" name="" class="active">
                  <option value="全部文章">全部文章</option>
                  <option value="氣候科學">氣候科學</option>
                  <option value="生態危機">生態危機</option>
                  <option value="生態危機">生態危機</option>
                  <option value="政策國際">政策國際</option>
                </select>
              </div>
              <p class="">熱門新聞</p>
              <li class="active">全部文章</li>
              <li>氣候科學</li>
              <li>生態危機</li>
              <li>綠色生活</li>
              <li>政策國際</li>
            </ul>
            <div class="Fb-post-write-X"><a href="#">寫文章</a></div>
          </div> -->

          <!-- 單一文章區 -->
          <div class="Fb-Atricle-X">
            <div class="Fb-Atricle-title-X">10 個愛護地球的舉動，讓你親身響應環保理念！</div>
            <div class="Fb-Atricle-info-X">
              <img src="https://picsum.photos/id/237/200/300" alt="" />
              <div class="Atricle-name-time-X">
                <span>派大星教授加博士先生</span>
                <span>2024-12-19&nbsp;&nbsp;17:00</span>
              </div>
              <i class="bi bi-hand-thumbs-up">100</i>
              <!-- <i class="bi bi-hand-thumbs-up-fill">100</i> -->
              <i class="bi bi-share"></i>
            </div>
            <p>
              環保觀念深植國人心中，為了我們愛護的自然資源與地球環境，除了做好資源回收外，還有哪些可以採取的環保行動呢？本篇整理了
              10 個日常生活中常見的環保例子，讓大家可以透過這些案例，學習如何更加善待我們的地球。<br />
              <strong>環保活動例子 1：外出搭乘綠色載具</strong><br />
              自駕汽機車所造成廢氣排放，是空氣污染的主要來源之一。您不妨嘗試騎乘單車搭配大眾運輸工具，降低由交通工具製造的廢氣及碳排放。
              <br />
              <strong>環保活動例子 2：確實做好垃圾分類</strong><br />
              家中的廢棄物，可以確實依照「一般垃圾」、「資源回收物」、「廚餘」等類別進行分類，不僅能減少垃圾處理場的負荷量，經由回收的資源及廚餘都能再利用，投入產品生產及農業堆肥等領域。
              <br />
              <strong>環保活動例子 3：自備環保餐具、環保袋</strong><br />
            </p>
            <img src="https://picsum.photos/600/400.jpg" alt="" />
            <p>自備環保餐具、環保杯、環保袋，在外出用餐、消費時重複利用，是最直接能減少塑膠用品使用量的方式。</p>
            <!-- <div class="Fb-Atricle-quote-X"></div> -->
          </div>
          <!-- 留言區 -->
          <div class="Fb-message-X">
            <div class="Fb-message-select-X">
              <span>全部留言</span>
              <div class="Fb-message-selectBox-X">
                <select id="" name="">
                  <option value="最新" selected>最新</option>
                  <option value="最舊">最舊</option>
                </select>
              </div>
            </div>
            <!-- 查看更多 -->
            <div class="Fb-message-section-X">
              <div class="Fb-message-section-seeMore-X">
                <i class="bi bi-chat-left-dots"></i>
                <p>查看更多先前的留言</p>
              </div>
            </div>
            <!-- 其他用戶的留言 -->
            <ul class="Fb-ms-other">
              <div class="Fb-message-section-X">
                <img src="https://picsum.photos/id/239/200/300" alt="" />
                <div class="Fb-message-area-X">
                  <div class="Fb-message-self-X">
                    <span class="Fb-message-self-name-X">骯髒丹</span>
                    <span class="Fb-message-self-time-X">2024-12-19&nbsp;&nbsp;&nbsp;17:10</span>
                  </div>
                  <div class="Fb-message-content-other-X">
                    <span
                      >環保行動多樣，從日常小事做起，讓我們一起守護地球！環保行動多樣，從日常小事做起，讓我們一起守護地球！</span
                    >
                    <span>檢舉</span>
                  </div>
                </div>
              </div>

              <div class="Fb-message-section-X">
                <img src="https://picsum.photos/id/238/200/300" alt="" />
                <div class="Fb-message-area-X">
                  <div class="Fb-message-self-X">
                    <span class="Fb-message-self-name-X">蟹堡秘方</span>
                    <span class="Fb-message-self-time-X">2024-12-19&nbsp;&nbsp;&nbsp;17:10</span>
                  </div>
                  <div class="Fb-message-content-other-X">
                    <span>這篇文章很棒！提醒我們環保從生活中的小事做起，實用具體的建議讓人更容易採取行動！</span>
                    <span>檢舉</span>
                  </div>
                </div>
              </div>
            </ul>
            <!-- 自己的留言區 -->
            <div class="Fb-message-section-X self">
              <img src="https://picsum.photos/id/240/200/300" alt="" />
              <div class="Fb-message-area-X">
                <div class="Fb-message-self-X">尖頭拉瑞</div>
                <div class="Fb-message-content-X">
                  <textarea id="" name="" placeholder="請輸入您的留言"></textarea>
                </div>
                <button>送出留言</button>
              </div>
            </div>
          </div>

          
        </div>

        <!-- 新聞 -->
        <div class="Fb-news-X">
          <div class="Fb-news-header-X">熱門新聞</div>
          <!-- 新聞的主要內容 -->
          <div class="Fb-news-body-X">
            <NewsApi :isPC="true" />
          </div>
        </div>
      </div>
    </div>
  </main>

  <MainFooter class="removeMT" />
</template>

<script setup>
import MainFooter from '@/components/layout/MainFooter.vue';
import MainHeader from '@/components/layout/MainHeader.vue';
import NewsApi from '@/components/newsApi.vue';
</script>

<style lang="scss" scoped></style>
