<template>
  <!-- 環保市集 - 全商品瀏覽，縮寫Sp - 功能 - 代號X -->
  <main>
    <div class="Sp-X">
      <!-- 最上方BN -->
      <div class="Sp-banner">
        <h1>環保市集</h1>
      </div>

      <!-- 中間內容 -->
      <div class="Sp-wrapper-S">
        <!-- 左：價格選擇 -->
        <div class="fliter_section_S">
          <ul>
            <li><a href="#">全部商品</a></li>
            <li><a href="#">NT$100~$200</a></li>
            <li><a href="#">NT$200~$300</a></li>
            <li><a href="#">NT$300~$400</a></li>
            <li><a href="#">NT$400~$500</a></li>
            <li><a href="#">NT$500 以上</a></li>
          </ul>
        </div>
        <!-- 右：上篩選 + 下商品列表  -->
        <div class="Sp_container_S">
          <!-- 新舊 + 價格篩選 -->

          <div class="store_title_S">
            <!-- 顯示的類別 -->
            <p class="Sp_spend_category">全部商品</p>
            <div class="select-box">
              <select id="" name="">
                <option value="默認排序" selected>默認排序</option>
                <option value="上架時間：由新至舊">上架時間：由新至舊</option>
                <option value="上架時間：由舊至舊">上架時間：由舊至舊</option>
                <option value="價格：由高至低">價格：由高至低</option>
                <option value="價格：由低至高">價格：由低至高</option>
              </select>
            </div>
          </div>

          <!-- 商品列表 -->
          <div class="Sp-product_S">
            <!-- 商品區 -->
            <ul class="product-grid_S">
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="https://picsum.photos/400/600.jpg" alt="環保吸管1" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保吸管1</a>
                <p>價格：NT$150</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="https://picsum.photos/400/600.jpg" alt="環保吸管1" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保吸管1</a>
                <p>價格：NT$150</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="https://picsum.photos/400/600.jpg" alt="環保吸管1" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保吸管1</a>
                <p>價格：NT$150</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="https://picsum.photos/400/600.jpg" alt="環保吸管1" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保吸管1</a>
                <p>價格：NT$150</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="https://picsum.photos/400/600.jpg" alt="環保吸管1" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保吸管1</a>
                <p>價格：NT$150</p>
              </li>
            </ul>
            <!-- 頁數選擇器 -->
            <div class="Sp-pages-X">
              <ul>
                <li class="Sp-pages-prev"><i class="bi bi-caret-left-fill"></i></li>
                <li class="current"><span>1</span></li>
                <li><span>2</span></li>
                <li><span>3</span></li>
                <li><span>4</span></li>
                <li><span>5</span></li>
                <li class="Sp-pages-next"><i class="bi bi-caret-right-fill"></i></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped></style>
