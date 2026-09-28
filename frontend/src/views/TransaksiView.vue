<script setup>
import { computed, onMounted, ref } from 'vue'
import { ambilTransaksi } from '../api/transaksi'
import { formatRupiah, hitungSaldo, hitungTotal } from '../utils/keuangan'

const daftar = ref([])
const memuat = ref(false)
const pesanError = ref('')

const totalMasuk = computed(() => hitungTotal(daftar.value, 'masuk'))
const totalKeluar = computed(() => hitungTotal(daftar.value, 'keluar'))
const saldo = computed(() => hitungSaldo(daftar.value))

async function muat() {
  memuat.value = true
  pesanError.value = ''
  try {
    // Alamat API diambil dari VITE_API_URL, tidak ditulis langsung di kode.
    daftar.value = await ambilTransaksi(import.meta.env.VITE_API_URL)
  } catch (err) {
    daftar.value = []
    pesanError.value = err.message
  } finally {
    memuat.value = false
  }
}

onMounted(muat)
</script>

<template>
  <section>
    <div class="ringkasan">
      <div class="kartu">
        <span class="label">Total Masuk</span>
        <span class="nilai masuk">{{ formatRupiah(totalMasuk) }}</span>
      </div>
      <div class="kartu">
        <span class="label">Total Keluar</span>
        <span class="nilai keluar">{{ formatRupiah(totalKeluar) }}</span>
      </div>
      <div class="kartu">
        <span class="label">Saldo</span>
        <span class="nilai saldo">{{ formatRupiah(saldo) }}</span>
      </div>
    </div>

    <p v-if="memuat">Memuat data dari Laravel...</p>

    <div v-else-if="pesanError" class="galat" role="alert">
      <p>{{ pesanError }}</p>
      <button type="button" @click="muat">Coba lagi</button>
    </div>

    <p v-else-if="daftar.length === 0">Belum ada transaksi.</p>

    <table v-else>
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Keterangan</th>
          <th>Jenis</th>
          <th>Jumlah</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="t in daftar" :key="t.id">
          <td>{{ t.tanggal }}</td>
          <td>{{ t.keterangan }}</td>
          <td>{{ t.jenis === 'masuk' ? 'Masuk' : 'Keluar' }}</td>
          <td>{{ formatRupiah(t.jumlah) }}</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>
