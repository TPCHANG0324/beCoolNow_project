<template>
    <nav class="breadCrumb">
      <ol>
        <li>
        <router-link to="/shop">環保市集</router-link></li>
        &nbsp;&gt;&nbsp;
        <li>{{ priceRange }}</li> 
      </ol>
    </nav>
  </template>
  
  <script>
  export default {
    name: 'BreadcrumbNavigation',
    props: {
      priceRange: {
        type: String,
        required: true
      }
    }
  }
  </script>