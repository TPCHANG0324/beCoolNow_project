<!-- 前臺 主要Footer -->

<template>
  <footer class="layout_footer">
    <div class="footer">
      <div class="footer-wrapper">
        <router-link to="/Home" class="logo-a"><img src="../../assets/images/logo_color2.svg" alt="" /></router-link>
        <ul>
          <li>
            <router-link to="/information">島嶼危機</router-link>
            <!-- <a href="#">臺灣的響應</a>
            <a href="#">教育推廣</a>
            <a href="#">機智問答</a> -->
          </li>
          <li>
            <router-link to="/activity">永續行動</router-link>
            <!-- <a href="#">給地球的一封信</a>
            <a href="#">今日減碳行動</a> -->
          </li>
          <li><router-link to="/social">社群中心</router-link></li>
          <li><router-link to="/city">綠境方程式</router-link></li>
          <li>
            <router-link to="/About">關於我們</router-link>
            <!-- <a href="#">聯絡我們</a> -->
          </li>
          <li><a href="#">好站連結</a></li>
          <li><router-link to="/shop">環保市集</router-link></li>
          <li><router-link to="/member">會員中心</router-link></li>
        </ul>
      </div>
    </div>
    <div class="copyright">
      <div class="copyright-wrapper">
        <p>&copy;本網站為緯育TibaMe【第94期】前端工程師專業技術養成班學員作品,僅供學習、展示之用途。</p>
        <ul>
          <li>
            <a href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="-2 -2 24 24">
                <g fill="currentColor">
                  <path
                    d="M8.695 6.937v1.377H7.687v1.683h1.008V15h2.072V9.997h1.39s.131-.807.194-1.69h-1.576v-1.15c0-.173.226-.404.45-.404h1.128V5h-1.535C8.644 5 8.695 6.685 8.695 6.937"
                  />
                  <path
                    d="M10 18a8 8 0 1 0 0-16a8 8 0 0 0 0 16m0 2C4.477 20 0 15.523 0 10S4.477 0 10 0s10 4.477 10 10s-4.477 10-10 10"
                  />
                </g>
              </svg>
            </a>
          </li>
          <li>
            <a href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="-2 -2 24 24">
                <g fill="currentColor">
                  <path
                    d="M10 18a8 8 0 1 0 0-16a8 8 0 0 0 0 16m0 2C4.477 20 0 15.523 0 10S4.477 0 10 0s10 4.477 10 10s-4.477 10-10 10"
                  />
                  <path
                    d="M15 6.947c-.368.16-.763.27-1.178.318c.424-.25.748-.646.902-1.117a4.2 4.2 0 0 1-1.304.49A2.06 2.06 0 0 0 11.923 6c-1.133 0-2.051.905-2.051 2.02q0 .237.053.46a5.85 5.85 0 0 1-4.228-2.11a2 2 0 0 0-.278 1.015c0 .7.363 1.32.913 1.681a2.1 2.1 0 0 1-.93-.253v.025a2.03 2.03 0 0 0 1.646 1.98a2.1 2.1 0 0 1-.927.034a2.05 2.05 0 0 0 1.916 1.403a4.16 4.16 0 0 1-2.548.864q-.248 0-.489-.028A5.86 5.86 0 0 0 8.144 14c3.774 0 5.837-3.078 5.837-5.748l-.007-.262A4.1 4.1 0 0 0 15 6.947"
                  />
                </g>
              </svg>
            </a>
          </li>
          <li>
            <a href="#"
              ><svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                <path fill="#545454" d="M13.61 12.243a1.6 1.6 0 1 1-1.56-1.63a1.62 1.62 0 0 1 1.56 1.63" />
                <path
                  fill="#545454"
                  d="M14.763 7.233H9.338a2.024 2.024 0 0 0-2.024 2.024v5.547a2.024 2.024 0 0 0 2.024 2.024h5.425a2.024 2.024 0 0 0 2.024-2.024V9.267a2.026 2.026 0 0 0-2.024-2.034m-2.713 7.723a2.703 2.703 0 1 1 2.642-2.703a2.67 2.67 0 0 1-2.642 2.703m2.936-5.405a.496.496 0 0 1-.496-.506a.506.506 0 1 1 1.012 0a.496.496 0 0 1-.557.506z"
                />
                <path
                  fill="#545454"
                  d="M12.05 2a10 10 0 1 0-.1 20a10 10 0 0 0 .1-20m6.073 12.702a3.39 3.39 0 0 1-3.41 3.411H9.389a3.39 3.39 0 0 1-3.411-3.41V9.378a3.39 3.39 0 0 1 3.41-3.411h5.325a3.39 3.39 0 0 1 3.41 3.41z"
                /></svg
            ></a>
          </li>
        </ul>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'MainFooter',
};
</script>
