<template>
  <main>
    <MainHeader></MainHeader>
    <!-- 環保市集 - 全商品瀏覽，縮寫Sp - 功能 - 代號X -->
    <div class="Sp-X">
      <!-- 最上方BN -->
      <div class="Sp-banner">
  <video autoplay muted loop playsinline>
    <source src="@/assets/videos/recycle_shop.mp4" type="video/mp4">
  </video>
        <h1>環保市集
          <br /> Eco-Friendly Shop
        </h1>
        
      </div>

      <!-- 中間內容 -->
      <div class="Sp-wrapper-S">
        <!-- 左：價格選擇 -->
        <div class="fliter_section_S">
          <ul>
            <li><a href="#">NT$100~$199</a></li>
            <li><a href="#">NT$200~$299</a></li>
            <li><a href="#">NT$300~$399</a></li>
            <li><a href="#">NT$400~$499</a></li>
            <li><a href="#">NT$500 以上</a></li>
          </ul>
        </div>

        <!-- 右：上篩選 + 下商品列表  -->
        <div class="Sp_container_S">
          <!-- 新舊 + 價格篩選 -->
          <div class="store_title_S">
            <!-- 顯示的類別 -->
            <p class="Sp_spend_category">全部商品</p>

            <div class="select-box fliter_section820_S">
              <select id="" name="">
                <option value="全部商品" selected>全部商品</option>
                <option value="NT$100~$200">NT$100~$200</option>
                <option value="NT$200~$300">NT$200~$300</option>
                <option value="NT$300~$400">NT$300~$400</option>
                <option value="NT$400~$500">NT$400~$500</option>
                <option value="NT$500 以上">NT$500 以上</option>
              </select>
            </div>

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
                  <RouterLink to="/shop_product">
                    <img src="@/assets/images/Sp02.jpg" alt="環保吸管1" class="product-img" />
                  </RouterLink>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保吸管1</a>
                <p>價格：NT$150</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="@/assets/images/Sp03.jpg" alt="環保吸管2" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保吸管2</a>
                <p>價格：NT$160</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="@/assets/images/Sp04.jpg" alt="環保吸管3" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保吸管3</a>
                <p>價格：NT$200</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="@/assets/images/Sp05.jpg" alt="環保袋子1" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保袋子1</a>
                <p>價格：NT$250</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="@/assets/images/Sp06.jpg" alt="環保袋子2" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保袋子2</a>
                <p>價格：NT$500</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="@/assets/images/Sp07.jpg" alt="環保袋子3" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保袋子3</a>
                <p>價格：NT$395</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="@/assets/images/Sp08.jpg" alt="環保杯子1" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保杯子1</a>
                <p>價格：NT$310</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="@/assets/images/Sp09.jpg" alt="環保杯子2" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保杯子2</a>
                <p>價格：NT$200</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="@/assets/images/Sp10.jpg" alt="環保杯子3" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保杯子3</a>
                <p>價格：NT$450</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="@/assets/images/Sp11.jpg" alt="環保筷子1" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保筷子1</a>
                <p>價格：NT$280</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="@/assets/images/Sp12.jpg" alt="環保筷子2" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保筷子2</a>
                <p>價格：NT$200</p>
              </li>
              <li class="product-card_S">
                <div class="product-box_S">
                  <a href="#">
                    <img src="@/assets/images/Sp13.jpg" alt="環保筷子3" class="product-img" />
                  </a>
                  <p class="shop-add-to-cart-X">加入購物車</p>
                </div>
                <a href="#" class="product-card-name-X">環保筷子3</a>
                <p>價格：NT$320</p>
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
    <!-- 商品區 -->
    <!-- <ul class="product-grid_S">
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
          </ul> -->
    <!-- 頁數選擇器 -->
    <!-- <div class="Sp-pages-X">
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
        </div>-->
    <!-- </div> -->
    <MainFooter></MainFooter>
  </main>
</template>

<script setup>
import MainHeader from '@/components/layout/MainHeader.vue';
import MainFooter from '@/components/layout/MainFooter.vue';
</script>
