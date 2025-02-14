// vite.config.js
import { defineConfig, loadEnv } from "file:///D:/group-project1-new/node_modules/vite/dist/node/index.js";
import { resolve } from "path";
import vue from "file:///D:/group-project1-new/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import Icons from "file:///D:/group-project1-new/node_modules/unplugin-icons/dist/vite.mjs";
import IconsResolver from "file:///D:/group-project1-new/node_modules/unplugin-icons/dist/resolver.mjs";
import AutoImport from "file:///D:/group-project1-new/node_modules/unplugin-auto-import/dist/vite.js";
import Components from "file:///D:/group-project1-new/node_modules/unplugin-vue-components/dist/vite.mjs";
import { TDesignResolver } from "file:///D:/group-project1-new/node_modules/unplugin-vue-components/dist/resolvers.mjs";
import path from "path";
var __vite_injected_original_dirname = "D:\\group-project1-new";
var vite_config_default = ({ mode }) => {
  const { VITE_PORT } = loadEnv(mode, process.cwd());
  return defineConfig({
    //base: VITE_BASE_URL,
    // base: '/beCoolNow_project/',
    // base: '/test_proj/',
    base: "/tid103/g1/",
    plugins: [
      vue(),
      AutoImport({
        imports: ["vue", "vue-router", "pinia"],
        resolvers: [
          TDesignResolver({
            library: "vue-next"
          }),
          IconsResolver({
            prefix: "Icon"
          })
        ],
        eslintrc: {
          enabled: true
        },
        dts: true
      }),
      Components({
        resolvers: [
          TDesignResolver({
            library: "vue-next"
          }),
          IconsResolver({
            enabledCollections: ["lets-icons"]
          })
        ]
      }),
      Icons({
        autoInstall: true
      })
    ],
    resolve: {
      alias: {
        "@": path.resolve(__vite_injected_original_dirname, "./src")
        // '@ckeditor': path.resolve(__dirname, 'node_modules/@ckeditor'),
      }
    },
    css: {
      preprocessorOptions: {
        less: {
          modifyVars: {
            hack: `true; @import (reference) "${resolve("src/style/variables.less")}";`
          },
          math: "strict",
          javascriptEnabled: true
        }
      }
    },
    optimizeDeps: {
      include: ["mitt", "dayjs", "axios", "pinia", "@vueuse/core"],
      // include: ['@ckeditor/ckeditor5-vue'],
      exclude: ["@iconify-icons/lets-icons"]
    },
    server: {
      // 端口号
      port: VITE_PORT,
      // 监听所有地址
      host: "0.0.0.0",
      // 服务启动时是否自动打开浏览器
      open: true,
      // 允许跨域
      cors: true,
      // 自定义代理规则
      proxy: {},
      // 预热文件以提前转换和缓存结果，降低启动期间的初始页面加载时长并防止转换瀑布
      warmup: {
        clientFiles: ["./index.html", "./src/{views,components}/*"]
      }
    },
    build: {
      //   // 设置最终构建的浏览器兼容目标
      //   target: 'es2015',
      //   // 构建后是否生成 source map 文件
      //   sourcemap: false,
      //   //  chunk 大小警告的限制（以 kbs 为单位）
      //   chunkSizeWarningLimit: 2000,
      //   // 启用/禁用 gzip 压缩大小报告
      //   reportCompressedSize: false,
      // 自定义底层的 Rollup 打包配置
      rollupOptions: {
        output: {
          //     // 指定 chunks 的入口文件模式
          //     entryFileNames: 'static/js/[name]-[hash].js',
          //     // 对代码分割中产生的 chunk 自定义命名
          //     chunkFileNames: 'static/js/[name]-[hash].js',
          //     // 自定义构建结果中的静态资源名称
          assetFileNames: "assets/[name].[hash][extname]"
          //     // 压缩 Rollup 产生的额外代码
          //     compact: true,
          //     // 创建自定义的公共 chunk
          //     manualChunks: {
          //       vue: ['vue', 'vue-router', 'pinia'],
          //     },
        }
      }
    }
  });
};
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJEOlxcXFxncm91cC1wcm9qZWN0MS1uZXdcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkQ6XFxcXGdyb3VwLXByb2plY3QxLW5ld1xcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vRDovZ3JvdXAtcHJvamVjdDEtbmV3L3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnLCBsb2FkRW52IH0gZnJvbSAndml0ZSc7XHJcbmltcG9ydCB7IHJlc29sdmUgfSBmcm9tICdwYXRoJztcclxuaW1wb3J0IHZ1ZSBmcm9tICdAdml0ZWpzL3BsdWdpbi12dWUnO1xyXG5pbXBvcnQgSWNvbnMgZnJvbSAndW5wbHVnaW4taWNvbnMvdml0ZSc7XHJcbmltcG9ydCBJY29uc1Jlc29sdmVyIGZyb20gJ3VucGx1Z2luLWljb25zL3Jlc29sdmVyJztcclxuaW1wb3J0IEF1dG9JbXBvcnQgZnJvbSAndW5wbHVnaW4tYXV0by1pbXBvcnQvdml0ZSc7XHJcbmltcG9ydCBDb21wb25lbnRzIGZyb20gJ3VucGx1Z2luLXZ1ZS1jb21wb25lbnRzL3ZpdGUnO1xyXG5pbXBvcnQgeyBURGVzaWduUmVzb2x2ZXIgfSBmcm9tICd1bnBsdWdpbi12dWUtY29tcG9uZW50cy9yZXNvbHZlcnMnO1xyXG5pbXBvcnQgcGF0aCBmcm9tICdwYXRoJztcclxuXHJcbmV4cG9ydCBkZWZhdWx0ICh7IG1vZGUgfSkgPT4ge1xyXG4gIGNvbnN0IHsgVklURV9QT1JUIH0gPSBsb2FkRW52KG1vZGUsIHByb2Nlc3MuY3dkKCkpO1xyXG5cclxuICByZXR1cm4gZGVmaW5lQ29uZmlnKHtcclxuICAgIC8vYmFzZTogVklURV9CQVNFX1VSTCxcclxuICAgIC8vIGJhc2U6ICcvYmVDb29sTm93X3Byb2plY3QvJyxcclxuICAgIC8vIGJhc2U6ICcvdGVzdF9wcm9qLycsXHJcbiAgICBiYXNlOiAnL3RpZDEwMy9nMS8nLFxyXG5cclxuICAgIHBsdWdpbnM6IFtcclxuICAgICAgdnVlKCksXHJcbiAgICAgIEF1dG9JbXBvcnQoe1xyXG4gICAgICAgIGltcG9ydHM6IFsndnVlJywgJ3Z1ZS1yb3V0ZXInLCAncGluaWEnXSxcclxuICAgICAgICByZXNvbHZlcnM6IFtcclxuICAgICAgICAgIFREZXNpZ25SZXNvbHZlcih7XHJcbiAgICAgICAgICAgIGxpYnJhcnk6ICd2dWUtbmV4dCcsXHJcbiAgICAgICAgICB9KSxcclxuICAgICAgICAgIEljb25zUmVzb2x2ZXIoe1xyXG4gICAgICAgICAgICBwcmVmaXg6ICdJY29uJyxcclxuICAgICAgICAgIH0pLFxyXG4gICAgICAgIF0sXHJcbiAgICAgICAgZXNsaW50cmM6IHtcclxuICAgICAgICAgIGVuYWJsZWQ6IHRydWUsXHJcbiAgICAgICAgfSxcclxuICAgICAgICBkdHM6IHRydWUsXHJcbiAgICAgIH0pLFxyXG4gICAgICBDb21wb25lbnRzKHtcclxuICAgICAgICByZXNvbHZlcnM6IFtcclxuICAgICAgICAgIFREZXNpZ25SZXNvbHZlcih7XHJcbiAgICAgICAgICAgIGxpYnJhcnk6ICd2dWUtbmV4dCcsXHJcbiAgICAgICAgICB9KSxcclxuICAgICAgICAgIEljb25zUmVzb2x2ZXIoe1xyXG4gICAgICAgICAgICBlbmFibGVkQ29sbGVjdGlvbnM6IFsnbGV0cy1pY29ucyddLFxyXG4gICAgICAgICAgfSksXHJcbiAgICAgICAgXSxcclxuICAgICAgfSksXHJcbiAgICAgIEljb25zKHtcclxuICAgICAgICBhdXRvSW5zdGFsbDogdHJ1ZSxcclxuICAgICAgfSksXHJcbiAgICBdLFxyXG4gICAgcmVzb2x2ZToge1xyXG4gICAgICBhbGlhczoge1xyXG4gICAgICAgICdAJzogcGF0aC5yZXNvbHZlKF9fZGlybmFtZSwgJy4vc3JjJyksXHJcbiAgICAgICAgLy8gJ0Bja2VkaXRvcic6IHBhdGgucmVzb2x2ZShfX2Rpcm5hbWUsICdub2RlX21vZHVsZXMvQGNrZWRpdG9yJyksXHJcbiAgICAgIH0sXHJcbiAgICB9LFxyXG4gICAgY3NzOiB7XHJcbiAgICAgIHByZXByb2Nlc3Nvck9wdGlvbnM6IHtcclxuICAgICAgICBsZXNzOiB7XHJcbiAgICAgICAgICBtb2RpZnlWYXJzOiB7XHJcbiAgICAgICAgICAgIGhhY2s6IGB0cnVlOyBAaW1wb3J0IChyZWZlcmVuY2UpIFwiJHtyZXNvbHZlKCdzcmMvc3R5bGUvdmFyaWFibGVzLmxlc3MnKX1cIjtgLFxyXG4gICAgICAgICAgfSxcclxuICAgICAgICAgIG1hdGg6ICdzdHJpY3QnLFxyXG4gICAgICAgICAgamF2YXNjcmlwdEVuYWJsZWQ6IHRydWUsXHJcbiAgICAgICAgfSxcclxuICAgICAgfSxcclxuICAgIH0sXHJcbiAgICBvcHRpbWl6ZURlcHM6IHtcclxuICAgICAgaW5jbHVkZTogWydtaXR0JywgJ2RheWpzJywgJ2F4aW9zJywgJ3BpbmlhJywgJ0B2dWV1c2UvY29yZSddLFxyXG4gICAgICAvLyBpbmNsdWRlOiBbJ0Bja2VkaXRvci9ja2VkaXRvcjUtdnVlJ10sXHJcbiAgICAgIGV4Y2x1ZGU6IFsnQGljb25pZnktaWNvbnMvbGV0cy1pY29ucyddLFxyXG4gICAgfSxcclxuICAgIHNlcnZlcjoge1xyXG4gICAgICAvLyBcdTdBRUZcdTUzRTNcdTUzRjdcclxuICAgICAgcG9ydDogVklURV9QT1JULFxyXG4gICAgICAvLyBcdTc2RDFcdTU0MkNcdTYyNDBcdTY3MDlcdTU3MzBcdTU3NDBcclxuICAgICAgaG9zdDogJzAuMC4wLjAnLFxyXG4gICAgICAvLyBcdTY3MERcdTUyQTFcdTU0MkZcdTUyQThcdTY1RjZcdTY2MkZcdTU0MjZcdTgxRUFcdTUyQThcdTYyNTNcdTVGMDBcdTZENEZcdTg5QzhcdTU2NjhcclxuICAgICAgb3BlbjogdHJ1ZSxcclxuICAgICAgLy8gXHU1MTQxXHU4QkI4XHU4REU4XHU1N0RGXHJcbiAgICAgIGNvcnM6IHRydWUsXHJcbiAgICAgIC8vIFx1ODFFQVx1NUI5QVx1NEU0OVx1NEVFM1x1NzQwNlx1ODlDNFx1NTIxOVxyXG4gICAgICBwcm94eToge30sXHJcbiAgICAgIC8vIFx1OTg4NFx1NzBFRFx1NjU4N1x1NEVGNlx1NEVFNVx1NjNEMFx1NTI0RFx1OEY2Q1x1NjM2Mlx1NTQ4Q1x1N0YxM1x1NUI1OFx1N0VEM1x1Njc5Q1x1RkYwQ1x1OTY0RFx1NEY0RVx1NTQyRlx1NTJBOFx1NjcxRlx1OTVGNFx1NzY4NFx1NTIxRFx1NTlDQlx1OTg3NVx1OTc2Mlx1NTJBMFx1OEY3RFx1NjVGNlx1OTU3Rlx1NUU3Nlx1OTYzMlx1NkI2Mlx1OEY2Q1x1NjM2Mlx1NzAxMVx1NUUwM1xyXG4gICAgICB3YXJtdXA6IHtcclxuICAgICAgICBjbGllbnRGaWxlczogWycuL2luZGV4Lmh0bWwnLCAnLi9zcmMve3ZpZXdzLGNvbXBvbmVudHN9LyonXSxcclxuICAgICAgfSxcclxuICAgIH0sXHJcbiAgICBidWlsZDoge1xyXG4gICAgICAvLyAgIC8vIFx1OEJCRVx1N0Y2RVx1NjcwMFx1N0VDOFx1Njc4NFx1NUVGQVx1NzY4NFx1NkQ0Rlx1ODlDOFx1NTY2OFx1NTE3Q1x1NUJCOVx1NzZFRVx1NjgwN1xyXG4gICAgICAvLyAgIHRhcmdldDogJ2VzMjAxNScsXHJcbiAgICAgIC8vICAgLy8gXHU2Nzg0XHU1RUZBXHU1NDBFXHU2NjJGXHU1NDI2XHU3NTFGXHU2MjEwIHNvdXJjZSBtYXAgXHU2NTg3XHU0RUY2XHJcbiAgICAgIC8vICAgc291cmNlbWFwOiBmYWxzZSxcclxuICAgICAgLy8gICAvLyAgY2h1bmsgXHU1OTI3XHU1QzBGXHU4QjY2XHU1NDRBXHU3Njg0XHU5NjUwXHU1MjM2XHVGRjA4XHU0RUU1IGticyBcdTRFM0FcdTUzNTVcdTRGNERcdUZGMDlcclxuICAgICAgLy8gICBjaHVua1NpemVXYXJuaW5nTGltaXQ6IDIwMDAsXHJcbiAgICAgIC8vICAgLy8gXHU1NDJGXHU3NTI4L1x1Nzk4MVx1NzUyOCBnemlwIFx1NTM4Qlx1N0YyOVx1NTkyN1x1NUMwRlx1NjJBNVx1NTQ0QVxyXG4gICAgICAvLyAgIHJlcG9ydENvbXByZXNzZWRTaXplOiBmYWxzZSxcclxuICAgICAgLy8gXHU4MUVBXHU1QjlBXHU0RTQ5XHU1RTk1XHU1QzQyXHU3Njg0IFJvbGx1cCBcdTYyNTNcdTUzMDVcdTkxNERcdTdGNkVcclxuICAgICAgcm9sbHVwT3B0aW9uczoge1xyXG4gICAgICAgIG91dHB1dDoge1xyXG4gICAgICAgICAgLy8gICAgIC8vIFx1NjMwN1x1NUI5QSBjaHVua3MgXHU3Njg0XHU1MTY1XHU1M0UzXHU2NTg3XHU0RUY2XHU2QTIxXHU1RjBGXHJcbiAgICAgICAgICAvLyAgICAgZW50cnlGaWxlTmFtZXM6ICdzdGF0aWMvanMvW25hbWVdLVtoYXNoXS5qcycsXHJcbiAgICAgICAgICAvLyAgICAgLy8gXHU1QkY5XHU0RUUzXHU3ODAxXHU1MjA2XHU1MjcyXHU0RTJEXHU0RUE3XHU3NTFGXHU3Njg0IGNodW5rIFx1ODFFQVx1NUI5QVx1NEU0OVx1NTQ3RFx1NTQwRFxyXG4gICAgICAgICAgLy8gICAgIGNodW5rRmlsZU5hbWVzOiAnc3RhdGljL2pzL1tuYW1lXS1baGFzaF0uanMnLFxyXG4gICAgICAgICAgLy8gICAgIC8vIFx1ODFFQVx1NUI5QVx1NEU0OVx1Njc4NFx1NUVGQVx1N0VEM1x1Njc5Q1x1NEUyRFx1NzY4NFx1OTc1OVx1NjAwMVx1OEQ0NFx1NkU5MFx1NTQwRFx1NzlGMFxyXG4gICAgICAgICAgYXNzZXRGaWxlTmFtZXM6ICdhc3NldHMvW25hbWVdLltoYXNoXVtleHRuYW1lXScsXHJcbiAgICAgICAgICAvLyAgICAgLy8gXHU1MzhCXHU3RjI5IFJvbGx1cCBcdTRFQTdcdTc1MUZcdTc2ODRcdTk4OURcdTU5MTZcdTRFRTNcdTc4MDFcclxuICAgICAgICAgIC8vICAgICBjb21wYWN0OiB0cnVlLFxyXG4gICAgICAgICAgLy8gICAgIC8vIFx1NTIxQlx1NUVGQVx1ODFFQVx1NUI5QVx1NEU0OVx1NzY4NFx1NTE2Q1x1NTE3MSBjaHVua1xyXG4gICAgICAgICAgLy8gICAgIG1hbnVhbENodW5rczoge1xyXG4gICAgICAgICAgLy8gICAgICAgdnVlOiBbJ3Z1ZScsICd2dWUtcm91dGVyJywgJ3BpbmlhJ10sXHJcbiAgICAgICAgICAvLyAgICAgfSxcclxuICAgICAgICB9LFxyXG4gICAgICB9LFxyXG4gICAgfSxcclxuICB9KTtcclxufTtcclxuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUFxUCxTQUFTLGNBQWMsZUFBZTtBQUMzUixTQUFTLGVBQWU7QUFDeEIsT0FBTyxTQUFTO0FBQ2hCLE9BQU8sV0FBVztBQUNsQixPQUFPLG1CQUFtQjtBQUMxQixPQUFPLGdCQUFnQjtBQUN2QixPQUFPLGdCQUFnQjtBQUN2QixTQUFTLHVCQUF1QjtBQUNoQyxPQUFPLFVBQVU7QUFSakIsSUFBTSxtQ0FBbUM7QUFVekMsSUFBTyxzQkFBUSxDQUFDLEVBQUUsS0FBSyxNQUFNO0FBQzNCLFFBQU0sRUFBRSxVQUFVLElBQUksUUFBUSxNQUFNLFFBQVEsSUFBSSxDQUFDO0FBRWpELFNBQU8sYUFBYTtBQUFBO0FBQUE7QUFBQTtBQUFBLElBSWxCLE1BQU07QUFBQSxJQUVOLFNBQVM7QUFBQSxNQUNQLElBQUk7QUFBQSxNQUNKLFdBQVc7QUFBQSxRQUNULFNBQVMsQ0FBQyxPQUFPLGNBQWMsT0FBTztBQUFBLFFBQ3RDLFdBQVc7QUFBQSxVQUNULGdCQUFnQjtBQUFBLFlBQ2QsU0FBUztBQUFBLFVBQ1gsQ0FBQztBQUFBLFVBQ0QsY0FBYztBQUFBLFlBQ1osUUFBUTtBQUFBLFVBQ1YsQ0FBQztBQUFBLFFBQ0g7QUFBQSxRQUNBLFVBQVU7QUFBQSxVQUNSLFNBQVM7QUFBQSxRQUNYO0FBQUEsUUFDQSxLQUFLO0FBQUEsTUFDUCxDQUFDO0FBQUEsTUFDRCxXQUFXO0FBQUEsUUFDVCxXQUFXO0FBQUEsVUFDVCxnQkFBZ0I7QUFBQSxZQUNkLFNBQVM7QUFBQSxVQUNYLENBQUM7QUFBQSxVQUNELGNBQWM7QUFBQSxZQUNaLG9CQUFvQixDQUFDLFlBQVk7QUFBQSxVQUNuQyxDQUFDO0FBQUEsUUFDSDtBQUFBLE1BQ0YsQ0FBQztBQUFBLE1BQ0QsTUFBTTtBQUFBLFFBQ0osYUFBYTtBQUFBLE1BQ2YsQ0FBQztBQUFBLElBQ0g7QUFBQSxJQUNBLFNBQVM7QUFBQSxNQUNQLE9BQU87QUFBQSxRQUNMLEtBQUssS0FBSyxRQUFRLGtDQUFXLE9BQU87QUFBQTtBQUFBLE1BRXRDO0FBQUEsSUFDRjtBQUFBLElBQ0EsS0FBSztBQUFBLE1BQ0gscUJBQXFCO0FBQUEsUUFDbkIsTUFBTTtBQUFBLFVBQ0osWUFBWTtBQUFBLFlBQ1YsTUFBTSw4QkFBOEIsUUFBUSwwQkFBMEIsQ0FBQztBQUFBLFVBQ3pFO0FBQUEsVUFDQSxNQUFNO0FBQUEsVUFDTixtQkFBbUI7QUFBQSxRQUNyQjtBQUFBLE1BQ0Y7QUFBQSxJQUNGO0FBQUEsSUFDQSxjQUFjO0FBQUEsTUFDWixTQUFTLENBQUMsUUFBUSxTQUFTLFNBQVMsU0FBUyxjQUFjO0FBQUE7QUFBQSxNQUUzRCxTQUFTLENBQUMsMkJBQTJCO0FBQUEsSUFDdkM7QUFBQSxJQUNBLFFBQVE7QUFBQTtBQUFBLE1BRU4sTUFBTTtBQUFBO0FBQUEsTUFFTixNQUFNO0FBQUE7QUFBQSxNQUVOLE1BQU07QUFBQTtBQUFBLE1BRU4sTUFBTTtBQUFBO0FBQUEsTUFFTixPQUFPLENBQUM7QUFBQTtBQUFBLE1BRVIsUUFBUTtBQUFBLFFBQ04sYUFBYSxDQUFDLGdCQUFnQiw0QkFBNEI7QUFBQSxNQUM1RDtBQUFBLElBQ0Y7QUFBQSxJQUNBLE9BQU87QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQSxNQVVMLGVBQWU7QUFBQSxRQUNiLFFBQVE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUEsVUFNTixnQkFBZ0I7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQSxRQU9sQjtBQUFBLE1BQ0Y7QUFBQSxJQUNGO0FBQUEsRUFDRixDQUFDO0FBQ0g7IiwKICAibmFtZXMiOiBbXQp9Cg==
