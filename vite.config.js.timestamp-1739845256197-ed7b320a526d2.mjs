// vite.config.js
import { defineConfig, loadEnv } from "file:///C:/xampp/htdocs/beCoolNow_project/node_modules/vite/dist/node/index.js";
import { resolve } from "path";
import vue from "file:///C:/xampp/htdocs/beCoolNow_project/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import Icons from "file:///C:/xampp/htdocs/beCoolNow_project/node_modules/unplugin-icons/dist/vite.mjs";
import IconsResolver from "file:///C:/xampp/htdocs/beCoolNow_project/node_modules/unplugin-icons/dist/resolver.mjs";
import AutoImport from "file:///C:/xampp/htdocs/beCoolNow_project/node_modules/unplugin-auto-import/dist/vite.js";
import Components from "file:///C:/xampp/htdocs/beCoolNow_project/node_modules/unplugin-vue-components/dist/vite.mjs";
import { TDesignResolver } from "file:///C:/xampp/htdocs/beCoolNow_project/node_modules/unplugin-vue-components/dist/resolvers.mjs";
import path from "path";
var __vite_injected_original_dirname = "C:\\xampp\\htdocs\\beCoolNow_project";
var vite_config_default = ({ mode }) => {
  const { VITE_PORT } = loadEnv(mode, process.cwd());
  return defineConfig({
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
      exclude: ["@iconify-icons/lets-icons"]
    },
    server: {
      port: VITE_PORT,
      host: "0.0.0.0",
      open: true,
      cors: true,
      proxy: {
        "/tid103/g1/api": {
          // 修改這裡以匹配你的 base 路徑
          target: "http://localhost:80",
          // 修改為你的本地 PHP 服務器端口
          changeOrigin: true,
          secure: false
          // rewrite: (path) => path.replace(/^\/tid103\/g1\/api/, '/api')
        }
      },
      warmup: {
        clientFiles: ["./index.html", "./src/{views,components}/*"]
      },
      optimizeDeps: {
        exclude: ["ecpay_aio_nodejs"]
      }
    },
    build: {
      rollupOptions: {
        output: {
          assetFileNames: "assets/[name].[hash][extname]"
        }
      }
    }
  });
};
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFx4YW1wcFxcXFxodGRvY3NcXFxcYmVDb29sTm93X3Byb2plY3RcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXHhhbXBwXFxcXGh0ZG9jc1xcXFxiZUNvb2xOb3dfcHJvamVjdFxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzoveGFtcHAvaHRkb2NzL2JlQ29vbE5vd19wcm9qZWN0L3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnLCBsb2FkRW52IH0gZnJvbSAndml0ZSc7XHJcbmltcG9ydCB7IHJlc29sdmUgfSBmcm9tICdwYXRoJztcclxuaW1wb3J0IHZ1ZSBmcm9tICdAdml0ZWpzL3BsdWdpbi12dWUnO1xyXG5pbXBvcnQgSWNvbnMgZnJvbSAndW5wbHVnaW4taWNvbnMvdml0ZSc7XHJcbmltcG9ydCBJY29uc1Jlc29sdmVyIGZyb20gJ3VucGx1Z2luLWljb25zL3Jlc29sdmVyJztcclxuaW1wb3J0IEF1dG9JbXBvcnQgZnJvbSAndW5wbHVnaW4tYXV0by1pbXBvcnQvdml0ZSc7XHJcbmltcG9ydCBDb21wb25lbnRzIGZyb20gJ3VucGx1Z2luLXZ1ZS1jb21wb25lbnRzL3ZpdGUnO1xyXG5pbXBvcnQgeyBURGVzaWduUmVzb2x2ZXIgfSBmcm9tICd1bnBsdWdpbi12dWUtY29tcG9uZW50cy9yZXNvbHZlcnMnO1xyXG5pbXBvcnQgcGF0aCBmcm9tICdwYXRoJztcclxuXHJcbmV4cG9ydCBkZWZhdWx0ICh7IG1vZGUgfSkgPT4ge1xyXG4gIGNvbnN0IHsgVklURV9QT1JUIH0gPSBsb2FkRW52KG1vZGUsIHByb2Nlc3MuY3dkKCkpO1xyXG5cclxuICByZXR1cm4gZGVmaW5lQ29uZmlnKHtcclxuICAgIGJhc2U6ICcvdGlkMTAzL2cxLycsXHJcblxyXG4gICAgcGx1Z2luczogW1xyXG4gICAgICB2dWUoKSxcclxuICAgICAgQXV0b0ltcG9ydCh7XHJcbiAgICAgICAgaW1wb3J0czogWyd2dWUnLCAndnVlLXJvdXRlcicsICdwaW5pYSddLFxyXG4gICAgICAgIHJlc29sdmVyczogW1xyXG4gICAgICAgICAgVERlc2lnblJlc29sdmVyKHtcclxuICAgICAgICAgICAgbGlicmFyeTogJ3Z1ZS1uZXh0JyxcclxuICAgICAgICAgIH0pLFxyXG4gICAgICAgICAgSWNvbnNSZXNvbHZlcih7XHJcbiAgICAgICAgICAgIHByZWZpeDogJ0ljb24nLFxyXG4gICAgICAgICAgfSksXHJcbiAgICAgICAgXSxcclxuICAgICAgICBlc2xpbnRyYzoge1xyXG4gICAgICAgICAgZW5hYmxlZDogdHJ1ZSxcclxuICAgICAgICB9LFxyXG4gICAgICAgIGR0czogdHJ1ZSxcclxuICAgICAgfSksXHJcbiAgICAgIENvbXBvbmVudHMoe1xyXG4gICAgICAgIHJlc29sdmVyczogW1xyXG4gICAgICAgICAgVERlc2lnblJlc29sdmVyKHtcclxuICAgICAgICAgICAgbGlicmFyeTogJ3Z1ZS1uZXh0JyxcclxuICAgICAgICAgIH0pLFxyXG4gICAgICAgICAgSWNvbnNSZXNvbHZlcih7XHJcbiAgICAgICAgICAgIGVuYWJsZWRDb2xsZWN0aW9uczogWydsZXRzLWljb25zJ10sXHJcbiAgICAgICAgICB9KSxcclxuICAgICAgICBdLFxyXG4gICAgICB9KSxcclxuICAgICAgSWNvbnMoe1xyXG4gICAgICAgIGF1dG9JbnN0YWxsOiB0cnVlLFxyXG4gICAgICB9KSxcclxuICAgIF0sXHJcbiAgICByZXNvbHZlOiB7XHJcbiAgICAgIGFsaWFzOiB7XHJcbiAgICAgICAgJ0AnOiBwYXRoLnJlc29sdmUoX19kaXJuYW1lLCAnLi9zcmMnKSxcclxuICAgICAgfSxcclxuICAgIH0sXHJcbiAgICBjc3M6IHtcclxuICAgICAgcHJlcHJvY2Vzc29yT3B0aW9uczoge1xyXG4gICAgICAgIGxlc3M6IHtcclxuICAgICAgICAgIG1vZGlmeVZhcnM6IHtcclxuICAgICAgICAgICAgaGFjazogYHRydWU7IEBpbXBvcnQgKHJlZmVyZW5jZSkgXCIke3Jlc29sdmUoJ3NyYy9zdHlsZS92YXJpYWJsZXMubGVzcycpfVwiO2AsXHJcbiAgICAgICAgICB9LFxyXG4gICAgICAgICAgbWF0aDogJ3N0cmljdCcsXHJcbiAgICAgICAgICBqYXZhc2NyaXB0RW5hYmxlZDogdHJ1ZSxcclxuICAgICAgICB9LFxyXG4gICAgICB9LFxyXG4gICAgfSxcclxuICAgIG9wdGltaXplRGVwczoge1xyXG4gICAgICBpbmNsdWRlOiBbJ21pdHQnLCAnZGF5anMnLCAnYXhpb3MnLCAncGluaWEnLCAnQHZ1ZXVzZS9jb3JlJ10sXHJcbiAgICAgIGV4Y2x1ZGU6IFsnQGljb25pZnktaWNvbnMvbGV0cy1pY29ucyddLFxyXG4gICAgfSxcclxuICAgIHNlcnZlcjoge1xyXG4gICAgICBwb3J0OiBWSVRFX1BPUlQsXHJcbiAgICAgIGhvc3Q6ICcwLjAuMC4wJyxcclxuICAgICAgb3BlbjogdHJ1ZSxcclxuICAgICAgY29yczogdHJ1ZSxcclxuICAgICAgcHJveHk6IHtcclxuICAgICAgICAnL3RpZDEwMy9nMS9hcGknOiB7ICAvLyBcdTRGRUVcdTY1MzlcdTkwMTlcdTg4RTFcdTRFRTVcdTUzMzlcdTkxNERcdTRGNjBcdTc2ODQgYmFzZSBcdThERUZcdTVGOTFcclxuICAgICAgICAgIHRhcmdldDogJ2h0dHA6Ly9sb2NhbGhvc3Q6ODAnLCAvLyBcdTRGRUVcdTY1MzlcdTcwQkFcdTRGNjBcdTc2ODRcdTY3MkNcdTU3MzAgUEhQIFx1NjcwRFx1NTJEOVx1NTY2OFx1N0FFRlx1NTNFM1xyXG4gICAgICAgICAgY2hhbmdlT3JpZ2luOiB0cnVlLFxyXG4gICAgICAgICAgc2VjdXJlOiBmYWxzZSxcclxuICAgICAgICAgIC8vIHJld3JpdGU6IChwYXRoKSA9PiBwYXRoLnJlcGxhY2UoL15cXC90aWQxMDNcXC9nMVxcL2FwaS8sICcvYXBpJylcclxuICAgICAgICB9XHJcbiAgICAgIH0sXHJcbiAgICAgIHdhcm11cDoge1xyXG4gICAgICAgIGNsaWVudEZpbGVzOiBbJy4vaW5kZXguaHRtbCcsICcuL3NyYy97dmlld3MsY29tcG9uZW50c30vKiddLFxyXG4gICAgICB9LFxyXG4gICAgICBvcHRpbWl6ZURlcHM6IHtcclxuICAgICAgICBleGNsdWRlOiBbJ2VjcGF5X2Fpb19ub2RlanMnXVxyXG4gICAgICB9XHJcbiAgICB9LFxyXG5cclxuICAgIGJ1aWxkOiB7XHJcbiAgICAgIHJvbGx1cE9wdGlvbnM6IHtcclxuICAgICAgICBvdXRwdXQ6IHtcclxuICAgICAgICAgIGFzc2V0RmlsZU5hbWVzOiAnYXNzZXRzL1tuYW1lXS5baGFzaF1bZXh0bmFtZV0nLFxyXG4gICAgICAgIH0sXHJcbiAgICAgIH0sXHJcbiAgICB9LFxyXG4gIH0pO1xyXG59OyJdLAogICJtYXBwaW5ncyI6ICI7QUFBNlIsU0FBUyxjQUFjLGVBQWU7QUFDblUsU0FBUyxlQUFlO0FBQ3hCLE9BQU8sU0FBUztBQUNoQixPQUFPLFdBQVc7QUFDbEIsT0FBTyxtQkFBbUI7QUFDMUIsT0FBTyxnQkFBZ0I7QUFDdkIsT0FBTyxnQkFBZ0I7QUFDdkIsU0FBUyx1QkFBdUI7QUFDaEMsT0FBTyxVQUFVO0FBUmpCLElBQU0sbUNBQW1DO0FBVXpDLElBQU8sc0JBQVEsQ0FBQyxFQUFFLEtBQUssTUFBTTtBQUMzQixRQUFNLEVBQUUsVUFBVSxJQUFJLFFBQVEsTUFBTSxRQUFRLElBQUksQ0FBQztBQUVqRCxTQUFPLGFBQWE7QUFBQSxJQUNsQixNQUFNO0FBQUEsSUFFTixTQUFTO0FBQUEsTUFDUCxJQUFJO0FBQUEsTUFDSixXQUFXO0FBQUEsUUFDVCxTQUFTLENBQUMsT0FBTyxjQUFjLE9BQU87QUFBQSxRQUN0QyxXQUFXO0FBQUEsVUFDVCxnQkFBZ0I7QUFBQSxZQUNkLFNBQVM7QUFBQSxVQUNYLENBQUM7QUFBQSxVQUNELGNBQWM7QUFBQSxZQUNaLFFBQVE7QUFBQSxVQUNWLENBQUM7QUFBQSxRQUNIO0FBQUEsUUFDQSxVQUFVO0FBQUEsVUFDUixTQUFTO0FBQUEsUUFDWDtBQUFBLFFBQ0EsS0FBSztBQUFBLE1BQ1AsQ0FBQztBQUFBLE1BQ0QsV0FBVztBQUFBLFFBQ1QsV0FBVztBQUFBLFVBQ1QsZ0JBQWdCO0FBQUEsWUFDZCxTQUFTO0FBQUEsVUFDWCxDQUFDO0FBQUEsVUFDRCxjQUFjO0FBQUEsWUFDWixvQkFBb0IsQ0FBQyxZQUFZO0FBQUEsVUFDbkMsQ0FBQztBQUFBLFFBQ0g7QUFBQSxNQUNGLENBQUM7QUFBQSxNQUNELE1BQU07QUFBQSxRQUNKLGFBQWE7QUFBQSxNQUNmLENBQUM7QUFBQSxJQUNIO0FBQUEsSUFDQSxTQUFTO0FBQUEsTUFDUCxPQUFPO0FBQUEsUUFDTCxLQUFLLEtBQUssUUFBUSxrQ0FBVyxPQUFPO0FBQUEsTUFDdEM7QUFBQSxJQUNGO0FBQUEsSUFDQSxLQUFLO0FBQUEsTUFDSCxxQkFBcUI7QUFBQSxRQUNuQixNQUFNO0FBQUEsVUFDSixZQUFZO0FBQUEsWUFDVixNQUFNLDhCQUE4QixRQUFRLDBCQUEwQixDQUFDO0FBQUEsVUFDekU7QUFBQSxVQUNBLE1BQU07QUFBQSxVQUNOLG1CQUFtQjtBQUFBLFFBQ3JCO0FBQUEsTUFDRjtBQUFBLElBQ0Y7QUFBQSxJQUNBLGNBQWM7QUFBQSxNQUNaLFNBQVMsQ0FBQyxRQUFRLFNBQVMsU0FBUyxTQUFTLGNBQWM7QUFBQSxNQUMzRCxTQUFTLENBQUMsMkJBQTJCO0FBQUEsSUFDdkM7QUFBQSxJQUNBLFFBQVE7QUFBQSxNQUNOLE1BQU07QUFBQSxNQUNOLE1BQU07QUFBQSxNQUNOLE1BQU07QUFBQSxNQUNOLE1BQU07QUFBQSxNQUNOLE9BQU87QUFBQSxRQUNMLGtCQUFrQjtBQUFBO0FBQUEsVUFDaEIsUUFBUTtBQUFBO0FBQUEsVUFDUixjQUFjO0FBQUEsVUFDZCxRQUFRO0FBQUE7QUFBQSxRQUVWO0FBQUEsTUFDRjtBQUFBLE1BQ0EsUUFBUTtBQUFBLFFBQ04sYUFBYSxDQUFDLGdCQUFnQiw0QkFBNEI7QUFBQSxNQUM1RDtBQUFBLE1BQ0EsY0FBYztBQUFBLFFBQ1osU0FBUyxDQUFDLGtCQUFrQjtBQUFBLE1BQzlCO0FBQUEsSUFDRjtBQUFBLElBRUEsT0FBTztBQUFBLE1BQ0wsZUFBZTtBQUFBLFFBQ2IsUUFBUTtBQUFBLFVBQ04sZ0JBQWdCO0FBQUEsUUFDbEI7QUFBQSxNQUNGO0FBQUEsSUFDRjtBQUFBLEVBQ0YsQ0FBQztBQUNIOyIsCiAgIm5hbWVzIjogW10KfQo=
