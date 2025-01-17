<template>
  <BackStageHeader></BackStageHeader>
  <div class="backStage_bgc">
    <div class="backStage_wrapper">
      <div>
        <h3 class="product_h3">商品庫存管理</h3>
        <!-- <h3>會員管理</h3> -->
        <div class="MmB_searchBar_H">
          <input id="" class="input" type="text" name="" placeholder="搜尋商品" />
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
      </div>
      <div class="wrapper">
        <BackStageSidebar></BackStageSidebar>
        <main class="IcB_table_H">
          <table class="MmB_mainTable_H">
            <thead>
              <tr>
                <th class="SpB_number_H">商品編號</th>
                <th>商品名稱</th>
                <th>原價</th>
                <th>售價</th>
                <th>銷售量</th>
                <th>狀態</th>
                <th><button class="SpB_addBtn_H">新增</button></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="SpB_number_H">1134444</td>
                <td>環保吸管</td>
                <td>50</td>
                <td>50</td>
                <td>522</td>
                <td>上架</td>
                <td><button class="MmB_editBtn_H">編輯與查看</button></td>
                <!-- <td>
                  <button class="IcB_deleteBtn_H">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td> -->
              </tr>
              <tr>
                <td class="SpB_number_H">1134444</td>
                <td>玻璃吸管</td>
                <td>100</td>
                <td>100</td>
                <td>200</td>
                <td>上架</td>
                <td><button class="MmB_editBtn_H">編輯與查看</button></td>
                <!-- <td>
                  <button class="IcB_deleteBtn_H">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td> -->
              </tr>
              <tr>
                <td class="SpB_number_H">1134444</td>
                <td>再生環保袋</td>
                <td>299</td>
                <td>249</td>
                <td>602</td>
                <td>上架</td>
                <td><button class="MmB_editBtn_H">編輯與查看</button></td>
                <!-- <td>
                  <button class="IcB_deleteBtn_H">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td> -->
              </tr>
            </tbody>
          </table>
        </main>
      </div>
      <BackStagePaginator></BackStagePaginator>
    </div>
  </div>

  <BackStageBigPopup class="SpB_addProduct_H">
    <span>
      <p>商品資訊&nbsp;新增</p>
    </span>
    <section>
      <article class="SpB_leftBlockPopup_H">
        <div>
          <p>商品編號:&nbsp;</p>
          <input class="input" type="text" />
        </div>
        <div>
          <p>商品名稱:&nbsp;</p>
          <input class="input" type="text" />
        </div>
        <div>
          <p>原價:&nbsp;</p>
          <input class="input" type="number" min="0" />
        </div>

        <div>
          <p>售價:&nbsp;</p>
          <input class="input" type="number" min="0" />
        </div>
        <div>
          <p>庫存數量:&nbsp;</p>
          <input class="input" type="number" min="0" />
        </div>
      </article>
      <article class="SpB_rightBlockPopup_H">
        <div>
          <p>狀態:&nbsp;</p>
          <select>
            <option value="goTop">上架</option>
            <option value="goOff">下架</option>
          </select>
        </div>
        <figure>
          <label for="UploadPic">商品照:</label>
          <input id="UploadPic" class="UploadPic" type="file" accept="image/*, image/svg+xml" />
          <div class="preview">
            <p>圖片預覽</p>
          </div>
        </figure>
      </article>
    </section>
    <div>
      <button>取消</button>
      <button>儲存</button>
    </div>
  </BackStageBigPopup>
  <BackStageBigPopup class="SpB_editProduct_H">
    <span>
      <p>商品資訊&nbsp;編輯與查看</p>
    </span>
    <section>
      <article class="SpB_leftBlockPopup_H">
        <div>
          <p>商品編號:&nbsp;</p>
          <p>1234456</p>
        </div>
        <div>
          <p>原價:&nbsp;</p>
          <p>200</p>
        </div>
        <div>
          <p>庫存數量:&nbsp;</p>
          <p>100</p>
        </div>
        <div>
          <p>商品名稱:&nbsp;</p>
          <p>環保袋</p>
        </div>
        <div>
          <p>售價:&nbsp;</p>
          <p>200</p>
        </div>
      </article>
      <article class="SpB_rightBlockPopup_H">
        <div>
          <p>狀態:&nbsp;</p>
          <select>
            <option value="goTop">上架</option>
            <option value="goOff">下架</option>
          </select>
        </div>
        <figure>
          <label for="UploadPic">商品照:</label>
          <input id="UploadPic" class="UploadPic" type="file" accept="image/*, image/svg+xml" />
          <div class="preview">
            <p>圖片預覽</p>
          </div>
        </figure>
      </article>
    </section>
    <div>
      <button>取消</button>
      <button>儲存</button>
    </div>
  </BackStageBigPopup>
</template>

<script>
import BackStageSidebar from '@/components/items/BackStageItems/BackStageSidebar.vue';
import backStagePaginator from '@/components/items/BackStageItems/BackStagePaginator.vue';
import BackStageHeader from '@/components/layout/BackStageLayout/BackStageHeader.vue';
import BackStageBigPopup from '@/components/layout/BackStageLayout/BackStageBigPopup.vue';
</script>
