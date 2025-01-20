<template>
  <div>
    <!-- 單一文章頁面，縮寫Fb - 功能 - 代號X -->
    <main>
      <div class="Fb-X">
        <div class="Fb-wrapper-X">
          <!-- 文章 -->
          <div class="Fb-post-X">
            <!-- 文章分類 -->
            <div class="Fb-post-category-container-X">
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
                <li>生態危機</li>
                <li>政策國際</li>
              </ul>
              <div class="Fb-post-write-X"><a href="#">寫文章</a></div>
            </div>
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
                <strong>環保活動例子 1：外出搭乘綠色載具</strong>
                自駕汽機車所造成廢氣排放，是空氣污染的主要來源之一。您不妨嘗試騎乘單車搭配大眾運輸工具，降低由交通工具製造的廢氣及碳排放。

                <strong>環保活動例子 2：確實做好垃圾分類</strong>
                家中的廢棄物，可以確實依照「一般垃圾」、「資源回收物」、「廚餘」等類別進行分類，不僅能減少垃圾處理場的負荷量，經由回收的資源及廚餘都能再利用，投入產品生產及農業堆肥等領域。

                <strong>環保活動例子 3：自備環保餐具、環保袋</strong>
              </p>
              <img src="https://picsum.photos/600/400.jpg" alt="" />
              <p>自備環保餐具、環保杯、環保袋，在外出用餐、消費時重複利用，是最直接能減少塑膠用品使用量的方式。</p>
              <!-- <div class="Fb-Atricle-quote-X">

                        </div> -->
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
              <article>
                <img src="https://picsum.photos/id/102/300/300" alt="" />
                <div class="Fb-news-body-container-X">
                  <div class="Fb-news-body-container-time-X">2024-12-7</div>
                  <div class="Fb-news-body-container-title-X">
                    循環署公告訂定手機回收規定，透過延伸生產者責任協助民眾回收廢舊手機！
                  </div>
                  <div class="Fb-news-body-container-content-X">
                    環境部資源循環署公告手機回收規定，要求手機製造、輸入及販賣業者負起回收的責任，讓手機能回收後能再循環，期盼業者提出手機租賃或維修等循環服務，公告將於明(2025)年1月1日實施
                  </div>
                </div>
              </article>
              <article>
                <img src="https://picsum.photos/id/103/300/300" alt="" />
                <div class="Fb-news-body-container-X">
                  <div class="Fb-news-body-container-time-X">2024-12-7</div>
                  <div class="Fb-news-body-container-title-X">從源頭減少垃圾：如何做好資源回收</div>
                  <div class="Fb-news-body-container-content-X">
                    解決垃圾問題，首先以減量觀念出發，做到分類回收，最後才是垃圾處理。我們在生活中從減量開始做起，只要稍加用心即可做到。
                  </div>
                </div>
              </article>
              <article>
                <img src="https://picsum.photos/id/104/300/300" alt="" />
                <div class="Fb-news-body-container-X">
                  <div class="Fb-news-body-container-time-X">2024-12-7</div>
                  <div class="Fb-news-body-container-title-X">何謂無痕山林？無痕山林7準則，登山時也友善環境</div>
                  <div class="Fb-news-body-container-content-X">
                    近年戶外活動盛行，如露營、登山和健行等，都是親近大自然的好方法，不過同時也延伸出許多環境汙染問題，而台灣早在15年前，便開始推動「無痕山林運動」，希望民眾在從事山林活動時，減少對大自然的衝擊。
                  </div>
                </div>
              </article>
              <article>
                <img src="https://picsum.photos/id/112/300/300" alt="" />
                <div class="Fb-news-body-container-X">
                  <div class="Fb-news-body-container-time-X">2024-12-7</div>
                  <div class="Fb-news-body-container-title-X">環保飲食不只少吃肉，這樣吃素減碳更有效！</div>
                  <div class="Fb-news-body-container-content-X">
                    邀請您支持綠色和平蔬食專案，加入「出一張嘴，用吃改變世界」活動，也向身旁親友推廣「少肉多蔬」的理念，透過改變飲食習慣，以植物性食材取代肉類，同時照顧自己與地球的健康，減緩氣候變遷，用蔬食拯救您我共同的地球家園。
                  </div>
                </div>
              </article>
              <article>
                <img src="https://picsum.photos/id/106/300/300" alt="" />
                <div class="Fb-news-body-container-X">
                  <div class="Fb-news-body-container-time-X">2024-12-7</div>
                  <div class="Fb-news-body-container-title-X">
                    循環署公告訂定手機回收規定，透過延伸生產者責任協助民眾回收廢舊手機！
                  </div>
                  <div class="Fb-news-body-container-content-X">
                    環境部資源循環署公告手機回收規定，要求手機製造、輸入及販賣業者負起回收的責任，讓手機能回收後能再循環，期盼業者提出手機租賃或維修等循環服務，公告將於明(2025)年1月1日實施
                  </div>
                </div>
              </article>
              <article>
                <img src="https://picsum.photos/id/107/300/300" alt="" />
                <div class="Fb-news-body-container-X">
                  <div class="Fb-news-body-container-time-X">2024-12-7</div>
                  <div class="Fb-news-body-container-title-X">從源頭減少垃圾：如何做好資源回收</div>
                  <div class="Fb-news-body-container-content-X">
                    解決垃圾問題，首先以減量觀念出發，做到分類回收，最後才是垃圾處理。我們在生活中從減量開始做起，只要稍加用心即可做到。
                  </div>
                </div>
              </article>
              <article>
                <img src="https://picsum.photos/id/108/300/300" alt="" />
                <div class="Fb-news-body-container-X">
                  <div class="Fb-news-body-container-time-X">2024-12-7</div>
                  <div class="Fb-news-body-container-title-X">何謂無痕山林？無痕山林7準則，登山時也友善環境</div>
                  <div class="Fb-news-body-container-content-X">
                    近年戶外活動盛行，如露營、登山和健行等，都是親近大自然的好方法，不過同時也延伸出許多環境汙染問題，而台灣早在15年前，便開始推動「無痕山林運動」，希望民眾在從事山林活動時，減少對大自然的衝擊。
                  </div>
                </div>
              </article>
              <article>
                <img src="https://picsum.photos/id/111/300/300" alt="" />
                <div class="Fb-news-body-container-X">
                  <div class="Fb-news-body-container-time-X">2024-12-7</div>
                  <div class="Fb-news-body-container-title-X">環保飲食不只少吃肉，這樣吃素減碳更有效！</div>
                  <div class="Fb-news-body-container-content-X">
                    邀請您支持綠色和平蔬食專案，加入「出一張嘴，用吃改變世界」活動，也向身旁親友推廣「少肉多蔬」的理念，透過改變飲食習慣，以植物性食材取代肉類，同時照顧自己與地球的健康，減緩氣候變遷，用蔬食拯救您我共同的地球家園。
                  </div>
                </div>
              </article>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- RWD 時出現的置底評論區塊 -->
    <div class="Fb-rwd-message-X">
      <!-- 分享 -->
      <div class="Fb-rwd-share-X">
        <i class="bi bi-share"></i>
        <span>分享</span>
      </div>
      <!-- 評論 -->
      <div class="Fb-rwd-comment-X">
        <i class="bi bi-chat"></i>
        <span>評論</span>
      </div>
      <!-- 按讚 -->
      <div class="Fb-rwd-good-X">
        <i class="bi bi-hand-thumbs-up"></i>
        <span>按讚</span>
      </div>
    </div>

    <!-- 點擊評論按鈕才會出現的遮罩+框 -->
    <div class="Fb-comment-cover-X">
      <!-- 這是遮罩 -->
      <div class="m-box">
        <!-- 這是框 -->
        <img src="https://picsum.photos/id/240/200/300" alt="" />
        <div class="inner-box">
          <div class="m-name">尖頭拉瑞</div>
          <textarea id="" name="" placeholder="請輸入您的留言"></textarea>
          <button>送出留言</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped></style>
