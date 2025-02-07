<template>
  <div class="popup-wrapper_member">
    <div class="overlay_member" @click="closePopup"></div>
    <div class="popup-container_member">
      <div v-if="currentPopup === 'login'">
        <PopupLogin @switch="showNewMemberPopup" />
      </div>
      <div v-if="currentPopup === 'register'">
        <PopupNewMember @switch="showLoginPopup" />
      </div>
    </div>
  </div>
</template>

<script>
import PopupLogin from './popup.vue';              // 登入組件
import PopupNewMember from './popupnewmember.vue'; // 註冊組件

export default {
  name: 'loginPopupChange',
  components: { PopupLogin, PopupNewMember },
  data() {
    return {
      currentPopup: 'login', // 默認顯示登入彈窗
    };
  },
  methods: {
    showLoginPopup() {
      this.currentPopup = 'login';
    },
    showNewMemberPopup() {
      this.currentPopup = 'register';
    },
    closePopup() {
      this.$emit('close');
    }
  },

};
</script>

<style lang="scss">
.popup-wrapper_member {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.overlay_member {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); // 半透明黑色背景
  z-index: 1000;
}

.popup-container_member {
  position: relative;
  z-index: 1001; // 確保彈窗在遮罩層上方
}
</style>
