import { createRouter, createWebHashHistory } from 'vue-router'
import TransaksiView from '../views/TransaksiView.vue'
import TentangView from '../views/TentangView.vue'

// Hash history (/#/tentang): reload halaman kedua tetap aman di hosting statis
// seperti GitHub Pages, tanpa perlu aturan try_files / rewrite di server.
const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'transaksi', component: TransaksiView },
    { path: '/tentang', name: 'tentang', component: TentangView },
  ],
})

export default router
