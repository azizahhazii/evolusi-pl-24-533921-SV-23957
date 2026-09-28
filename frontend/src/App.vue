<template>
  <header class="topbar">
    <h1>Catatan Keuangan Kos</h1>
    <nav>
      <RouterLink to="/">Transaksi</RouterLink>
      <RouterLink to="/tentang">Tentang</RouterLink>
    </nav>
  </header>
  <main class="konten">
    <RouterView />
  </main>
</template>
