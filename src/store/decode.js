// messageStore.js
import { defineStore } from 'pinia';

// 解碼 HTML 實體的函數
function decodeHtml(html) {
  var txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
}

export const useMessageStore = defineStore('message', {
  state: () => ({
    messages: [], // 儲存留言的陣列
  }),

  getters: {
    // 取得解碼後的留言，可以指定要解碼的欄位
    decodedMessages: (state) => (fieldToDecode) => {
      return state.messages.map(message => {
        if (message[fieldToDecode]) {
          return {
            ...message,
            [fieldToDecode]: decodeHtml(message[fieldToDecode]), // 解碼指定的欄位
          };
        } else {
          return message; // 如果欄位不存在，則返回原始訊息
        }
      });
    },
  },

  actions: {
    // 設定留言的 action
    setMessages(messages) {
      this.messages = messages;
    },
    // 其他 actions (例如新增留言)
  },
});