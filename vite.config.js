import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import legacy from '@vitejs/plugin-legacy'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
  plugins: [
    laravel(['resources/js/app.js']),
    vue({
      template: {
        transformAssetUrls: {
          // The Vue plugin will re-write asset URLs, when referenced
          // in Single File Components, to point to the Laravel web
          // server. Setting this to `null` allows the Laravel plugin
          // to instead re-write asset URLs to point to the Vite
          // server instead.
          base: null,

          // The Vue plugin will parse absolute URLs and treat them
          // as absolute paths to files on disk. Setting this to
          // `false` will leave absolute URLs un-touched so they can
          // reference assets in the public directly as expected.
          includeAbsolute: false,
        },
      },
    }),
    legacy(),
    require('autoprefixer'),
  ],
  resolve: {
    alias: {
      '@@': path.join(__dirname, '/resources'),
      '@': path.join(__dirname, '/resources/js'),
      vue: 'vue/dist/vue.esm-bundler.js',
    },
  },
  test: {
    globals: true,
    environment: 'happy-dom',
  },
  build: {
    // rollupOptions: {
    //   external: ['html2canvas', 'jspdf'],
    // },
  },
})
