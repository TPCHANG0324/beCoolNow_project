<template>
  <!-- 環保市集 - 購物車，縮寫Sp - 功能 - 代號X -->
  <main>
    <div class="Sp-X">
      <div class="Sp-wrapper-X">
        <!-- 流程顯示 -->
        <div class="Sp-checkout-nav-X">
          <!-- 每一個圓圈 -->
          <div class="Sp-step-X active">
            <span class="Sp-badge-X">
              <div class="Sp-badge-text-X">1</div>
            </span>
            <span>購物車</span>
          </div>

          <div class="Sp-step-X">
            <span class="Sp-badge-X">
              <div class="Sp-badge-text-X">2</div>
            </span>
            <span>填寫資料</span>
          </div>

          <div class="Sp-step-X">
            <span class="Sp-badge-X">
              <div class="Sp-badge-text-X">3</div>
            </span>
            <span>購買完成</span>
          </div>
        </div>
        <!-- 購物車 -->
        <section class="Sp-shopping-cart-X">
          <!-- 表頭 -->
          <div class="Sp-section-header">購物車</div>
          <!-- 項目名稱 + 內容 -->
          <div class="Sp-cart-items-wrapper-X">
            <div class="Sp-table-header-X">
              <div>商品資料</div>
              <div>規格</div>
              <div>單件價格</div>
              <div>數量</div>
              <div>小計</div>
              <div></div>
            </div>
            <div class="Sp-cart-item-X">
              <div class="Sp-cart-item-info-X">
                <a href="#" target="_blank"></a>
                <span>愛護地球環保袋 </span>
              </div>
              <div>不織布</div>
              <div>NT$ 290</div>
              <div>
                <form action="">
                  <div class="Sp-cart-input-group-X">
                    <span><i class="bi bi-dash"></i></span>
                    <input type="number" value="1" step="1" min="0" />
                    <span><i class="bi bi-plus"></i></span>
                  </div>
                </form>
              </div>
              <div>NT$ 2900</div>
              <div><i class="bi bi-trash3-fill"></i></div>
            </div>
          </div>
        </section>
        <!-- 精選商品 -->
        <section class="Sp-shopping-cart-addon-X">
          <!-- 表頭 -->
          <div class="Sp-section-header">精選商品</div>
          <!-- 項目內容 -->
          <div class="Sp-cart-addon-wrapper-X">
            <div class="Sp-cart-addon-item-X">
              <a href="#" target="_blank" class="Sp-cart-addon-item-img">
                <img src="../assets/images/Sp08-2.jpg" alt="" />
              </a>
              <div class="Sp-cart-addon-item-content">
                <div class="Sp-cart-addon-item-info">
                  <p>愛護地球環保杯</p>
                  <span>NT$ 150</span>
                </div>
                <button>加入購物車</button>
              </div>
            </div>
            <div class="Sp-cart-addon-item-X">
              <a href="#" target="_blank" class="Sp-cart-addon-item-img">
                <img src="../assets/images/Sp09-2.jpg" alt="" />
              </a>
              <div class="Sp-cart-addon-item-content">
                <div class="Sp-cart-addon-item-info">
                  <p>愛護地球環保杯2</p>
                  <span>NT$ 180</span>
                </div>
                <button>加入購物車</button>
              </div>
            </div>
            <div class="Sp-cart-addon-item-X">
              <a href="#" target="_blank" class="Sp-cart-addon-item-img">
                <img src="../assets/images/Sp04.jpg" alt="" />
              </a>
              <div class="Sp-cart-addon-item-content">
                <div class="Sp-cart-addon-item-info">
                  <p>設計款 - 愛護地球環保吸管</p>
                  <span>NT$ 80</span>
                </div>
                <button>加入購物車</button>
              </div>
            </div>
            <div class="Sp-cart-addon-item-X">
              <a href="#" target="_blank" class="Sp-cart-addon-item-img">
                <img src="../assets/images/Sp11-2.jpg" alt="" />
              </a>
              <div class="Sp-cart-addon-item-content">
                <div class="Sp-cart-addon-item-info">
                  <p>愛護地球環保筷</p>
                  <span>NT$ 80</span>
                </div>
                <button>加入購物車</button>
              </div>
            </div>
          </div>
        </section>
        <!-- 訂單：選擇付款方式 + 訂單資訊  -->
        <section class="Sp-shopping-info-X">
          <!-- 選擇付款方式 -->
          <section class="Sp-order-form-X">
            <div class="Sp-order-form-header">選擇送貨及付款方式</div>
            <div class="Sp-order-form-body">
              <label for="">送貨方式</label>
              <select id="" name="">
                <option value="新竹物流宅配">新竹物流宅配</option>
              </select>
              <label for="">付款方式</label>
              <select id="" name="">
                <option value="信用卡 (Visa/Master/JCB)">信用卡 (Visa/Master/JCB)</option>
              </select>
            </div>
          </section>
          <!-- 訂單資訊 -->
          <section class="Sp-order-summary-X">
            <div class="Sp-order-summary-header">訂單資訊</div>
            <div class="Sp-order-summary-body">
              <div class="Sp-order-summary-body-subtotal">
                <span>小計：</span>
                <span>NT$ 2900</span>
              </div>
              <div class="Sp-order-summary-body-delivery">
                <span>運費：</span>
                <span>NT$ 100</span>
              </div>
              <div class="Sp-order-summary-body-points">
                <span>目前可用點數：</span>
                <span>250</span>
              </div>
              <div class="Sp-order-summary-body-coupon">
                <label for="">本次使用點數：</label>
                <form action="">
                  <span><i class="bi bi-dash"></i></span>
                  <input type="number" value="100" step="100" min="0" />
                  <span><i class="bi bi-plus"></i></span>
                </form>
              </div>
              <div class="Sp-order-summary-body-discount">
                <span>折抵金額：</span>
                <span>- NT$ 1</span>
              </div>
              <hr />
              <div class="Sp-order-summary-body-amount">
                <span>合計：</span>
                <span>NT$ 2999</span>
              </div>
              <a href="#" class="Sp-checkout-Btn">前往結帳</a>
            </div>
          </section>
        </section>
        <!-- 出貨提醒 -->
        <section class="Sp-shopping-reminder-X">
          <div class="Sp-shopping-reminder-header">出貨提醒</div>
          <div class="Sp-shopping-reminder-body">
            感謝您支持我們的環保商品！以下是您的訂單與出貨注意事項： 📦 出貨時間：
            涼城即時環保市集皆為客製化生產，製作期需2-3週。
            訂單成立後，我們將立即安排生產。若提前完成品檢，我們會儘速出貨。
            若您選購了其他現貨商品，建議您與預購商品分開結帳，以便現貨能提前寄出。 📬 取貨注意事項：
            若您選擇便利商店取貨，請確保「收件人姓名」與身分證一致，以免影響取件流程。 🔍 尺寸與材質說明：
            杯子容量：350ml / 500ml / 750ml 材質：100%再生寶特瓶纖維 (rPET) + 天然纖維 耐熱程度：80°C（請避免直接加熱）
            ❗ 特殊說明： 再生環保馬克杯為特殊客製化商品，非商品瑕疵，恕不接受退換貨。
            若您有尺寸或其他需求疑慮，請於下單前確認商品規格。 如需重新訂製，需再等待2-3週生產期。 💳 付款方式：
            本店支援 LINE Pay 結帳，歡迎使用！ 如有任何問題，歡迎隨時與我們聯繫！🌱
            選擇再生材質，與我們一起為地球減少負擔。
          </div>
          =======
          <div class="Sp-shopping-reminder-body">
            <p>感謝您支持我們的環保商品！以下是您的訂單與出貨注意事項：</p>
            <p>📦 出貨時間：</p>
            <p>涼城即時環保市集皆為客製化生產，製作期需2-3週。</p>
            <p>訂單成立後，我們將立即安排生產。若提前完成品檢，我們會儘速出貨。</p>
            <p>若您選購了其他現貨商品，建議您與預購商品分開結帳，以便現貨能提前寄出。</p>
            <p>📬 取貨注意事項：</p>
            <p>若您選擇便利商店取貨，請確保「收件人姓名」與身分證一致，以免影響取件流程。</p>
            <p>🔍 尺寸與材質說明：</p>
            <p>杯子容量：350ml / 500ml / 750ml</p>
            <p>材質：100%再生寶特瓶纖維 (rPET) + 天然纖維</p>
            <p>耐熱程度：80°C（請避免直接加熱）</p>
            <p>❗ 特殊說明：</p>
            <p>再生環保馬克杯為特殊客製化商品，非商品瑕疵，恕不接受退換貨。</p>
            <p>若您有尺寸或其他需求疑慮，請於下單前確認商品規格。</p>
            <p>如需重新訂製，需再等待2-3週生產期。</p>
            <p>💳 付款方式：</p>
            <p>本店支援 LINE Pay 結帳，歡迎使用！</p>
            <p>如有任何問題，歡迎隨時與我們聯繫！🌱 選擇再生材質，與我們一起為地球減少負擔。</p>
          </div>
          >>>>>>> 29482163883a380007f9bac66b999d10b5922e9d
        </section>
      </div>
    </div>
  </main>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped></style>
