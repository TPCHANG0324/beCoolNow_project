<template>
    <div class="Support_banner_S">
        <!-- <div>
            <img src="../assets/images/Au07.jpg" alt="">
        </div> -->
        <h1>您的支持<br>幫助地球生態扭轉危機！</h1>
    </div>

    <div class="Support_box_S">
        <p>是的！我珍愛地球環境與生態
        <br>我要與自然、社會共生共好，永續發展。</p>

        <div class="donate_choise_S">
            <button class="donate_type_month active">每月捐款</button>
            <button class="donate_type_once">單次捐款</button>
        </div>

        <div class="donate_amount_S">
            <button class="amount">$800<br>新台幣</button>        
            <button class="amount">$1000<br>新台幣</button>
            <button class="amount">$1200<br>新台幣</button>
        </div>

        <div class="custom_amount_S">
            <span>自訂金額</span>
            <input type="text" placeholder="請輸入金額" class="custom_amount_input">
        </div>

        <div class="payment_section_S">

            <div class="payment_content">
                <label>選擇付款方式<span class="marker" title="此欄位不可空白">*</span>
                </label>
                
                <label class="linepay">
                    <input type="radio" class="payment_method" value="Line Pay行動支付" check>
                    <span>Line Pay行動支付</span>
                </label>
                <label class="ecpay">
                    <input type="radio" class="payment_method" value="綠界金流服務(信用卡)" check>
                    <span class="ecpay1">綠界金流服務(信用卡)</span>
                    <br>
                    <span class="ecpay2">(信用卡才能進行定期捐款)</span>
                </label>
            </div>

            <div class="payment_step_S">
                <button class="next_step">下一步</button>
              
            </div>
            
            <div class="">
                    
            </div>

        </div>
        

    </div>
</template>

<script>
    export default {
        
    }
</script>

