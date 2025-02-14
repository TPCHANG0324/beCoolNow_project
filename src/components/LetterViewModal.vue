<template>
    <div v-if="isOpen" 
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         @click="handleBackdropClick">
      <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4 relative">
        <!-- 關閉按鈕 -->
        <button 
          @click="onClose"
          class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-colors"
          aria-label="關閉彈窗">
          <svg 
            class="w-6 h-6" 
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24">
            <path 
              stroke-linecap="round" 
              stroke-linejoin="round" 
              stroke-width="2" 
              d="M6 18L18 6M6 6l12 12" 
            />
          </svg>
        </button>
  
        <!-- 內容區域 -->
        <div class="mt-2">
          <h3 class="text-xl font-semibold mb-4">
            {{ letter?.name }} 的信件
          </h3>
          <div class="space-y-4">
            <p class="text-gray-600 whitespace-pre-wrap">
              {{ letter?.message }}
            </p>
            <p class="text-sm text-gray-500">
              發布時間：{{ letter?.timestamp ? formatDate(letter.timestamp) : '' }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({
    isOpen: {
      type: Boolean,
      required: true
    },
    letter: {
      type: Object,
      required: true
    },
    onClose: {
      type: Function,
      required: true
    }
  });
  
  // 處理背景點擊事件
  const handleBackdropClick = (e) => {
    // 確保只有點擊背景時才關閉，避免點擊內容區域時關閉
    if (e.target === e.currentTarget) {
      onClose();
    }
  };
  
  // 格式化日期
  const formatDate = (timestamp) => {
    return new Date(timestamp).toLocaleDateString('zh-TW', {
      year: 'numeric',
      month: '2-digit',
      day: '2-digit',
      hour: '2-digit',
      minute: '2-digit'
    });
  };
  </script>
  
  <style scoped>
  .fixed {
    position: fixed;
  }
  
  .inset-0 {
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
  }
  
  .bg-black {
    background-color: rgba(0, 0, 0, 0.5);
  }
  
  .z-50 {
    z-index: 50;
  }
  
  .bg-white {
    background-color: white;
  }
  
  .rounded-lg {
    border-radius: 0.5rem;
  }
  
  .p-6 {
    padding: 1.5rem;
  }
  
  .max-w-2xl {
    max-width: 42rem;
  }
  
  .relative {
    position: relative;
  }
  
  .absolute {
    position: absolute;
  }
  
  .top-4 {
    top: 1rem;
  }
  
  .right-4 {
    right: 1rem;
  }
  
  .mt-2 {
    margin-top: 0.5rem;
  }
  
  .mb-4 {
    margin-bottom: 1rem;
  }
  
  .text-xl {
    font-size: 1.25rem;
  }
  
  .font-semibold {
    font-weight: 600;
  }
  
  .text-gray-600 {
    color: #4B5563;
  }
  
  .text-gray-500 {
    color: #6B7280;
  }
  
  .whitespace-pre-wrap {
    white-space: pre-wrap;
  }
  
  .text-sm {
    font-size: 0.875rem;
  }
  
  .space-y-4 > * + * {
    margin-top: 1rem;
  }
  
  .w-6 {
    width: 1.5rem;
  }
  
  .h-6 {
    height: 1.5rem;
  }
  </style>