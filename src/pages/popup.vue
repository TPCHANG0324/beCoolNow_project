<!-- 已經 RWD 820/ 430 完成 -->

<template>
 <div class="member-login-container">
        <div class="member-login-card">
            <img src="../assets/images/logo_color1.svg" alt="涼城即時 Be Cool Now" class="member-login-logo">
            <h1 class="member-login-title">會員登入</h1>
            
            <form class="member-login-form">
                <div class="member-login-input-group">
                    <label for="account">帳號</label>
                    <input type="text" id="account" placeholder="請輸入帳號">
                </div>

                <div class="member-login-input-group">
                    <label for="password">密碼</label>
                    <input type="password" id="password" placeholder="須包含英文字母與大小寫">
                </div>

                <button type="submit" class="member-login-submit-btn">登入</button>

                <div class="member-login-links">
                    <a href="#" class="member-login-register">新會員註冊</a>
                    <a href="#" class="member-login-forgot">忘記密碼?</a>
                </div>
            </form>
        </div>
    </div>

</template>


<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>

</style>