<!-- 已經 RWD 820/ 430 完成 -->

<template>
      <div class="bcn-donation-container">
        <div class="bcn-top-place">
        <div class="bcn-donation-header">
            <p>您選擇了 <strong>每月捐款 新臺幣 1000元</strong></p>
           
        </div>
        <!-- <button class="bcn-btn-secondary">重新選擇捐款</button> -->
    </div>
    
    <div class="bcn-donation-form2">
       
        <form action="#" method="post">
            <div class="bcn-form-title">
                <h2>付款資料</h2>
            </div>
            <div class="inside_form2">
                
            <!-- <label for="email" class="bcn-label">* 電子郵件地址</label> -->
            <input type="email" id="email" name="email" placeholder="卡號" required class="bcn-input-text">
            
            <!-- <label for="name" class="bcn-label">* 捐款人姓名</label> -->
            <input type="text" id="name" name="name" placeholder="持卡人姓名"  required class="bcn-input-text">
            
            <!-- <label for="phone" class="bcn-label">電話號碼</label> -->
            <input type="text"  name="date" placeholder="有效期限 (MM/DD)" required class="bcn-input-text" >
                <!-- <option value="TW+886">TW +886</option> -->
             <!-- <label for="name" class="bcn-label">* 捐款人姓名</label> -->
             <input type="text" id="id_code" name="id_code" placeholder="安全碼"  required class="bcn-input-text">
            
            <!-- ✅ 修正 checkbox 與文字的排列
            <div class="bcn-checkbox-container">
                <input type="checkbox" id="agree" name="agree">
                <label for="agree">我已詳細閱讀並同意隱私權政策</label>
            </div> -->
            
           
        </div>
        <button type="submit" class="bcn-btn-primary">立即以 信用卡 捐款</button>
        </form>
    </div>
    <a href="./pay1/" class="bc-prev-step-button">
        <span class="bc-prev-step-icon">❮</span>
        <span class="bc-prev-step-text">上一步</span>
    </a>
</div>
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>

</style>