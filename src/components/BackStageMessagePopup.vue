<template>
    <transition name="fade">
      <div class="popup-overlay" v-if="isVisible">
        <div class="popup-content">
          <button class="close-btn" @click="closePopup">&times;</button>
          <h3>訊息內容</h3>
          <p><strong>姓名：</strong> {{ messageData.name }}</p>
          <p><strong>Email：</strong> {{ messageData["e-mail"] }}</p>
          <p><strong>手機：</strong> {{ messageData.cellPhone }}</p>
          <p><strong>送出日期：</strong> {{ messageData.contactDate }}</p>
          <p><strong>訊息內容：</strong> {{ messageData.contactContents }}</p>
        </div>
      </div>
    </transition>
  </template>
  
  <script>
  export default {
    props: {
      isVisible: Boolean,
      messageData: Object,
    },
    emits: ["close"],
    setup(props, { emit }) {
      const closePopup = () => {
        emit("close");
      };
      return { closePopup };
    },
  };
  </script>
  
  <style scoped>
  .popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .popup-content {
    /* background: white;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    text-align: left;
     */
    width: 600px;
    height: 280px;
    border: 2px solid #5b774a;
    background-color: #e6eccc;
    border-radius: 8px;
    position: relative;
    text-align: left;
    padding: 20px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    /* top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center; */
  }
  
    .popup-content h3 {
        text-align: center;
        font-size: 20px;
        color: #3b5d2f;
        margin-bottom: 15px;
    }
    .popup-content p {
        font-size: 16px;
        color: #333;
        margin-bottom: 8px;
        padding-left: 10px; /* 增加內距 */
        line-height: 1.6;
        }

  .close-btn {
    position: absolute;
    right: 15px;
    top: 15px;
    background: none;
    border: none;
    font-size: 22px;
    cursor: pointer;
    color: #5b774a; /* 深色讓它更明顯 */
    transition: color 0.3s ease-in-out;
  }

  .close-btn:hover {
    background-color: #5b774a;
    color: #fffff0; /* 滑鼠懸停，提升 UX */
    }


  </style>
  