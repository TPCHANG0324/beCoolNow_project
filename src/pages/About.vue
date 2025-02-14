<template>
  <div>
    <MainHeader></MainHeader>
    <div class="aboutus_top_R">
      <div class="aboutus_toptitle_R">
        <video class="background-video" autoplay loop muted playsinline>
        <source src="../assets/videos/bcn.mp4" type="video/mp4">
      </video>
        <h1>關於我們</h1>
        <h1>About Us</h1>
      </div>
    </div>
    <div class="wrapper">
      <div class="aboutus_top2_R">
        <h2>我們的理念</h2>
        <p>
          全球暖化是全人類的共同挑戰，對臺灣而言更是迫在眉睫。極端氣候頻發、海平面上升、生態失衡，
          正威脅我們的安全與未來。面對這場氣候危機，臺灣雖然渺小，但我們擁有創新與行動的力量，需要你我一起關注!
        </p>
      </div>
      <div class="aboutus_top3_R">
        <div class="aboutus_top3pic_R">
          <img src="../assets/images/Au02.jpeg" alt="" />
        </div>
        <div class="aboutus_top3word_R">
          <h2>提倡環保理念<br/>宣傳活動</h2>
          <p>
            推動綠能、環保行動、守護環境，從現在開始，每一步都至關重要！ 我們相信，改變的力量來自每一個人，
            從臺灣出發，與全球同行，創造永續的未來。 讓我們攜手行動，為地球的明天發聲！
          </p>
        </div>
      </div>
      <div class="aboutus_middle_R">
        <div class="about_middlecard_R">
          <h3>改變並非一夕之間，拯救唯一的地球家園仍刻不容緩</h3>
          <p>Change doesn't happen overnight, but saving our one and only home—Earth—remains an urgent priority.</p>
          <h3>一人之力固然有限，請您立即伸出援手<br />讓我們集聚人之力，推動共同期盼的改變！</h3>
          <p>
            One person's power may be limited, but your immediate support can make a difference. Let us unite our
            strength to drive the change we all hope for!
          </p>
          <router-link to="/Support" class="btn">支持我們</router-link>
        </div>
      </div>
      <div class="about_bottom_R">
        <h2>聯絡我們</h2>
        <h2>Contact</h2>
        <div class="aboutus_input_R">
          <div class="form-group">
            <p>姓名:</p>
            <input class="input" type="text" v-model="name" @blur="validateName" />
            <span v-if="errors.name" class="error-text_about">{{ errors.name }}</span>
          </div>
          <div class="form-group">
            <p>* Email:</p>
            <input class="input" type="email" v-model="email" @blur="validateEmail" />
            <span v-if="errors.email" class="error-text_about">{{ errors.email }}</span>
          </div>
          <div class="form-group">
            <p>手機:</p>
            <input class="input" type="text" v-model="phone" @blur="validatePhone" />
          <span v-if="errors.phone" class="error-text_about">{{ errors.phone }}</span>
          </div>
          <div class="form-group">
            <p>* 您的建議:</p>
            <textarea class="input" rows="4" v-model="message" @blur="validateMessage"></textarea>
          <span v-if="errors.message" class="error-text_about">{{ errors.message }}</span>
          </div>
        </div>
        <button class="btn" @click="submitForm">送出</button>
      </div>

      <div class="aboutus_lowest_R">
        <h3>響應環保好夥伴</h3>
        <ul class="aboutus_marquee_R">
          <li>
            <div class="icon-text-wrapper">
              <img src="../assets/images/afakelogo1.png" alt="GitHub" style="width: 80px; height: 80px" />
              <span>永續科技公司</span>
            </div>
          </li>
          <li>
            <div class="icon-text-wrapper">
              <img src="../assets/images/afakelogo2.png" alt="GitHub" style="width: 80px; height: 80px" />
              <span>綠能科技</span>
            </div>
          </li>
          <li>
            <div class="icon-text-wrapper">
              <img src="../assets/images/afakelogo3.png" alt="Google" style="width: 80px; height: 80px" />
              <span>綠城建築</span>
            </div>
          </li>
          <li>
            <div class="icon-text-wrapper">
              <img src="../assets/images/afakelogo4.png" alt="Facebook" style="width: 80px; height: 80px" />
              <span>永續農業</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <MainFooter></MainFooter>
  </div>
</template>

<script>
import { RouterLink } from 'vue-router';
import { ref, computed } from 'vue';

export default {
  setup() {
    const name = ref('');
    const email = ref('');
    const phone = ref('');
    const message = ref('');
    const errors = ref({
      name: '',
      email: '',
      phone: '',
      message: '',
    });

    // Email 驗證
    const validateEmail = () => {
      const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if (!email.value) {
        errors.value.email = '請輸入 Email';
      } else if (!emailPattern.test(email.value)) {
        errors.value.email = '請輸入有效的 Email 格式';
      } else {
        errors.value.email = '';
      }
    };

    // 手機驗證（台灣格式）
    const validatePhone = () => {
      const phonePattern = /^09\d{8}$/; // 09 開頭 + 8 位數字
      if (!phone.value) {
        errors.value.phone = '請輸入手機號碼';
      } else if (!phonePattern.test(phone.value)) {
        errors.value.phone = '請輸入有效的台灣手機號碼（09開頭，共10位數）';
      } else {
        errors.value.phone = '';
      }
    };

    // 姓名驗證
    const validateName = () => {
      if (!name.value.trim()) {
        errors.value.name = '請輸入姓名';
      } else {
        errors.value.name = '';
      }
    };

    // 訊息驗證
    const validateMessage = () => {
      if (!message.value.trim()) {
        errors.value.message = '請輸入您的建議';
      } else {
        errors.value.message = '';
      }
    };

    // 表單提交
    const submitForm = () => {
      validateName();
      validateEmail();
      validatePhone();
      validateMessage();

      // 如果有錯誤，阻止提交
      if (errors.value.name || errors.value.email || errors.value.phone || errors.value.message) {
        alert('請填寫完整並修正錯誤後再送出');
        return;
      }

      alert('表單提交成功！');
      // 可加入 API 發送邏輯
    };

    return {
      name,
      email,
      phone,
      message,
      errors,
      validateEmail,
      validatePhone,
      validateName,
      validateMessage,
      submitForm,
    };
  },
};
</script>

<style scoped>
.error-text_about {
  color: red;
  font-size: 14px;
  margin-top: 5px;
  display: block;
}
.btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
</style>
