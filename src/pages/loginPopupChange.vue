<template>
    <div class="popup-container">
      <!-- 判斷當前顯示的彈窗 -->
      <div v-if="currentPopup === 'login'">
        <MemberLogin @switch="showNewMemberPopup()" />
      </div>
      <div v-if="currentPopup === 'register'">
        <PopupNewMember @switch="showLoginPopup()" />
      </div>
    </div>
  </template>
  
  <script>
  import MemberLogin from './popupnewmember.vue'
  import PopupNewMember from './popup.vue'
  
  export default {
    name: 'loginPopupChange',
    components: { MemberLogin, PopupNewMember },
    data() {
      return {
        currentPopup: 'register', // 默認顯示登入彈窗
      }
    },
    methods: {
      showNewMemberPopup() {
        // console.log('SSSS');
        
        this.currentPopup = 'register'
      },

      /**
       * 顯示登入彈窗
       */
      showLoginPopup() {
        // console.log('SSSSSS');

        this.currentPopup = 'login'
      },
    }
  }
  </script>

<style>
  .popup-container{
    display: none;
  }
</style>