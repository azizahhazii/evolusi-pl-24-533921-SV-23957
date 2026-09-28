import { fileURLToPath, URL } from 'node:url'
import vue from '@vitejs/plugin-vue'
import { defineConfig } from 'vitest/config'

// BASE_PATH diisi oleh workflow (mis. /nama-repo/) supaya aset dimuat benar
// di GitHub Pages. Di laptop dibiarkan kosong -> '/'.
export default defineConfig({
  base: process.env.BASE_PATH || '/',
  plugins: [vue()],
  resolve: {
    alias: { '@': fileURLToPath(new URL('./src', import.meta.url)) },
  },
  test: {
    environment: 'node',
  },
})
