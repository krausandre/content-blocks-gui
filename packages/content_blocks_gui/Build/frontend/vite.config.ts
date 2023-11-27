import {fileURLToPath, URL} from 'node:url'

import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'

// https://vitejs.dev/config/
export default defineConfig({
  base: './',
  build: {
    outDir: '../../Resources/Public/dist/',
    emptyOutDir: true,
    rollupOptions: {
      output: {
        entryFileNames: "index.js",
      }
    }
  },
  plugins: [
    vue(),
    //vueJsx(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  }
})