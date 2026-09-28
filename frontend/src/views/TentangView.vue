<script setup>
const apiUrl = import.meta.env.VITE_API_URL || '(belum diatur)'
</script>

<template>
  <section>
    <h2>Tentang aplikasi</h2>
    <p>
      Frontend Vue 3 untuk aplikasi Catatan Keuangan Kos. Data transaksi
      diambil dari backend Laravel lewat endpoint JSON <code>GET /api/transaksi</code>.
    </p>
    <p>Alamat API saat build: <code>{{ apiUrl }}</code></p>
    <p>
      Semua yang masuk hasil build bisa dibaca pengguna, jadi aplikasi ini
      tidak menyimpan rahasia apa pun.
    </p>
  </section>
</template>
