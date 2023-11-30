import {fileURLToPath, URL} from 'node:url'

import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'

const port = 5173;
const origin = `${process.env.DDEV_PRIMARY_URL}:${port}`;

export default defineConfig({
  base: './',
  build: {
    cssCodeSplit: false,
    outDir: '../../Resources/Public/dist/',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      external: ['@typo3/backend/notification.js', '@typo3/backend/modal.js'],
      output: {
        entryFileNames: "index.js",
        assetFileNames: (assetInfo) => {
          if (assetInfo.name !== undefined && assetInfo.name.endsWith('.css')) {
            return 'index.css';
          }
          // Standard-Dateinamen für andere Assets
          return 'assets/[name]-[hash][extname]';
        },
      }
    }
  },
  // Adjust Vites dev server for DDEV
  // https://vitejs.dev/config/server-options.html
  server: {
    // respond to all network requests:
    host: '0.0.0.0',
    port: port,
    strictPort: true,
    // Defines the origin of the generated asset URLs during development
    origin: origin
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
