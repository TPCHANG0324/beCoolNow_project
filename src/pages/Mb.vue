<template>

    <div class="wrapperpr">
        <h1 class="profile-title">
            會員資訊
        </h1>
        <div class="profile_top">
            <div class="profile-container-special_left">
                <div class="profile-header-special">
                    <img src="../assets/images/mbhead.png" alt="會員頭像" class="profile-pic-special">
                    <h1 class="profile-greeting-special">大中天 您好！</h1>
                </div>
            </div>


            <div class="profile-container-special_right">
                <div class="profile-info-special">
                    <div class="profile-field">
                        <label for="name" class="label_mb">姓名</label>
                        <input type="text" id="name" placeholder="輸入您的姓名" class="input_2">
                        <button class="button_mb">修改</button>
                    </div>

                    <div class="profile-field">
                        <label for="password" class="label_mb">密碼</label>
                        <input type="password" id="password" placeholder="輸入您的密碼" class="input_2">
                        <button class="button_mb">修改</button>
                    </div>

                    <div class="profile-field">
                        <label for="phone" class="label_mb">手機</label>
                        <input type="text" id="phone" placeholder="輸入您的手機" class="input_2">
                        <button class="button_mb">修改</button>
                    </div>

                    <div class="profile-field">
                        <label for="email" class="label_mb">信箱</label>
                        <input type="text" id="email" placeholder="輸入您的信箱" class="input_2">
                        <button class="button_mb">修改</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile_bottom">
            <div class="profile-stats-special">
                <p>小寵物經驗值: <strong>200</strong> | 累積地球幣: <strong>300</strong></p>
            </div>

            <div class="purchase-record-special">
                <div class="btn2_btn">
                    <button class="purchase-record-btn11">購買紀錄</button> <button class="purchase-record-btn12">
                        個人紀錄</button>
                </div>
                <table class="table_mb">
                    <thead>
                        <tr>
                            <th>日期</th>
                            <th>商品名稱</th>
                            <th>消費金額</th>
                            <th>來源</th>
                            <th>配送狀態</th>
                            <th>訂單詳情</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2023/12/25</td>
                            <td>環保吸管</td>
                            <td>300</td>
                            <td>環保市集</td>
                            <td class="delivered-special">已送達</td>
                            <td><button class="order-detail-btn">訂單詳情</button></td>
                        </tr>
                        <tr>
                            <td>2023/12/25</td>
                            <td>環保吸管</td>
                            <td>300</td>
                            <td>環保市集</td>
                            <td class="delivered-special">已送達</td>
                            <td><button class="order-detail-btn">訂單詳情</button></td>
                        </tr>
                        <tr>
                            <td>2023/12/25</td>
                            <td>環保吸管</td>
                            <td>300</td>
                            <td>環保市集</td>
                            <td class="delivered-special">已送達</td>
                            <td><button class="order-detail-btn">訂單詳情</button></td>
                        </tr>
                        <tr>
                            <td>2023/12/25</td>
                            <td>環保吸管</td>
                            <td>300</td>
                            <td>環保市集</td>
                            <td class="delivered-special">已送達</td>
                            <td><button class="order-detail-btn">訂單詳情</button></td>
                        </tr>
                        <tr>
                            <td>2023/12/25</td>
                            <td>環保吸管</td>
                            <td>300</td>
                            <td>環保市集</td>
                            <td class="delivered-special">已送達</td>
                            <td><button class="order-detail-btn">訂單詳情</button></td>
                        </tr>
                        <tr>
                            <td>2023/12/25</td>
                            <td>環保吸管</td>
                            <td>300</td>
                            <td>環保市集</td>
                            <td class="delivered-special">已送達</td>
                            <td><button class="order-detail-btn">訂單詳情</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped></style>