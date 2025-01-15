<template>
  <div class="bcn-donation-container1">
    <div class="bcn-top-place1">
      <div class="bcn-donation-header1">
        <p>您選擇了 <strong>每月捐款 新臺幣 1000元</strong></p>
      </div>
      <div class="bcn-donation-button11">
        <button class="donation-button11">重新選擇捐款</button>
      </div>
    </div>
    <div class="bcn-form-title_1">
      <h2>捐款人資料填寫</h2>
    </div>
    <div class="bcn-donation-form_1">
      <form action="#" method="post">
        <div class="inside_form_1">
          <label for="email" class="bcn-label1">* 電子郵件地址</label>
          <input id="email" type="email" name="email" required class="bcn-input-text_1" />

          <label for="name" class="bcn-label1">* 捐款人姓名</label>
          <input id="name" type="text" name="name" required class="bcn-input-text_1" />

          <label for="phone" class="bcn-label1">電話號碼</label>
          <input id="phone" type="text" name="phone" placeholder="TW+886" class="bcn-input-text_1" />
          <!-- <option value="TW+886">TW +886</option> -->
          <!-- </select> -->

          <!-- ✅ 修正 checkbox 與文字的排列 -->
          <div class="bcn-checkbox-container_1">
            <input id="agree" type="checkbox" name="agree" />
            <label for="agree" class="agree1">我已詳細閱讀並同意
              <!-- ✅ 添加 href 以及 target="_blank" 讓連結能夠導外並開新分頁 -->
              <a href="#" class="privite" target="_blank" rel="noopener noreferrer">隱私權政策</a>
            </label>
          </div>

          <button type="submit" class="bcn-btn-primary_1">下一步 信用卡填寫</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped></style>
