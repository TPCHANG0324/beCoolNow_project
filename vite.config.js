import { defineConfig, loadEnv } from 'vite';
import { resolve } from 'path';
import vue from '@vitejs/plugin-vue';
import Icons from 'unplugin-icons/vite';
import IconsResolver from 'unplugin-icons/resolver';
import AutoImport from 'unplugin-auto-import/vite';
import Components from 'unplugin-vue-components/vite';
import { TDesignResolver } from 'unplugin-vue-components/resolvers';
import path from 'path';

export default ({ mode }) => {
  const { VITE_PORT } = loadEnv(mode, process.cwd());

  return defineConfig({
    base: '/tid103/g1/',

    plugins: [
      vue(),
      AutoImport({
        imports: ['vue', 'vue-router', 'pinia'],
        resolvers: [
          TDesignResolver({
            library: 'vue-next',
          }),
          IconsResolver({
            prefix: 'Icon',
          }),
        ],
        eslintrc: {
          enabled: true,
        },
        dts: true,
      }),
      Components({
        resolvers: [
          TDesignResolver({
            library: 'vue-next',
          }),
          IconsResolver({
            enabledCollections: ['lets-icons'],
          }),
        ],
      }),
      Icons({
        autoInstall: true,
      }),
    ],
    resolve: {
      alias: {
        '@': path.resolve(__dirname, './src'),
      },
    },
    css: {
      preprocessorOptions: {
        less: {
          modifyVars: {
            hack: `true; @import (reference) "${resolve('src/style/variables.less')}";`,
          },
          math: 'strict',
          javascriptEnabled: true,
        },
      },
    },
    optimizeDeps: {
      include: ['mitt', 'dayjs', 'axios', 'pinia', '@vueuse/core'],
      exclude: ['@iconify-icons/lets-icons'],
    },
    server: {
      port: VITE_PORT,
      host: '0.0.0.0',
      open: true,
      cors: true,
      proxy: {
        '/tid103/g1/api': {  // 修改這裡以匹配你的 base 路徑
          target: 'http://localhost:80', // 修改為你的本地 PHP 服務器端口
          changeOrigin: true,
          secure: false,
          // rewrite: (path) => path.replace(/^\/tid103\/g1\/api/, '/api')
        }
      },
      warmup: {
        clientFiles: ['./index.html', './src/{views,components}/*'],
      },
    },

    build: {
      rollupOptions: {
        output: {
          assetFileNames: 'assets/[name].[hash][extname]',
        },
      },
    },
  });
};