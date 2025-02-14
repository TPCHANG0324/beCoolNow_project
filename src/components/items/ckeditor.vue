<template>
  <ckeditor v-model="data" :editor="ClassicEditor" :config="config" />
</template>

<script setup>
import { ref, computed } from 'vue';
import { ClassicEditor, Essentials, Paragraph, Bold, Italic } from 'ckeditor5';
// import { FormatPainter } from 'ckeditor5-premium-features';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import 'ckeditor5/ckeditor5.css';


const data = ref('<p>CSS樣式吃不到!!!!</p>');

const config = computed(() => {
  return {
    licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3MzkwNTkxOTksImp0aSI6IjAzZWExNjRhLWExOTAtNDM0Yy1hMmFmLWZhMzJiYzU1MmZhNiIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6ImMxOTJhYTViIn0.AvkbCnXsU0baau0T4n6STm7Df57bjB2NORmiAjAAv7v82TPz4GH1mkWSfjJiXqbG0ciYxupk8PuGnnoOEofWeA', // Or 'GPL'.
    plugins: [Essentials, Paragraph, Bold, Italic],
    toolbar: ['undo', 'redo', '|', 'bold', 'italic', '|']
  };
});



</script>
