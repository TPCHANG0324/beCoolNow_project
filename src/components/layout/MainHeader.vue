<template>
  <!-- 前臺 主要Header -->
  <header class="layout_header">
    <div class="header-wrapper">
      <div class="logo">
        <a href="#">
          <img src="../../assets/images/headerlogo.png" alt="logo" />
        </a>
      </div>
      <nav class="nav-large">
        <ul>
          <li><a href="#">島嶼危機</a></li>
          <li><a href="#">永續行動</a></li>
          <li><a href="#">社群中心</a></li>
          <li><a href="#">綠境方城市</a></li>
          <li><a href="#">關於我們</a></li>
          <li><a href="#">好站連結</a></li>
        </ul>
        <ul>
          <li>
            <a href="#"><i class="bi bi-handbag"></i></a>
          </li>
          <li>
            <a href="#"><i class="bi bi-person-circle"></i></a>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <header class="mobile_header">
    <div class="logo">
      <a href="#">
        <img src="../../assets/images/headerlogo.png" alt="logo" />
      </a>
    </div>
    <div>
      <ul>
        <li>
          <a href="#"><i class="bi bi-handbag"></i></a>
        </li>
        <li>
          <a href="#"><i class="bi bi-person-circle"></i></a>
        </li>
      </ul>
      <svg class="ham hamRotate ham8" viewBox="0 0 100 100" width="80" onclick="this.classList.toggle('active')">
        <path
          class="line top"
          d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"
        />
        <path class="line middle" d="m 30,50 h 40" />
        <path
          class="line bottom"
          d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"
        />
      </svg>
    </div>
  </header>

  <nav class="mobile_nav">
    <ul>
      <li><a href="#">島嶼危機</a></li>
      <li><a href="#">永續行動</a></li>
      <li><a href="#">社群中心</a></li>
      <li><a href="#">綠境方城市</a></li>
      <li><a href="#">關於我們</a></li>
      <li><a href="#">好站連結</a></li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: 'MainHeader',
};
</script>
