// app.js — perekat DOM. Semua logika perhitungan diambil dari keuangan.js.
import { tambahTransaksi, hitungTotal, hitungSaldo, formatRupiah } from './keuangan.js';

let daftarTransaksi = [];

const form = document.getElementById('form-transaksi');
const tbody = document.getElementById('daftar-transaksi');
const pesanError = document.getElementById('pesan-error');
const elTotalMasuk = document.getElementById('total-masuk');
const elTotalKeluar = document.getElementById('total-keluar');
const elSaldo = document.getElementById('saldo');

function renderTabel() {
  tbody.innerHTML = '';
  for (const t of daftarTransaksi) {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${t.tanggal}</td>
      <td>${t.keterangan}</td>
      <td>${t.jenis === 'masuk' ? 'Masuk' : 'Keluar'}</td>
      <td>${formatRupiah(t.jumlah)}</td>
    `;
    tbody.appendChild(tr);
  }
}

function renderRingkasan() {
  elTotalMasuk.textContent = formatRupiah(hitungTotal(daftarTransaksi, 'masuk'));
  elTotalKeluar.textContent = formatRupiah(hitungTotal(daftarTransaksi, 'keluar'));
  elSaldo.textContent = formatRupiah(hitungSaldo(daftarTransaksi));
}

form.addEventListener('submit', (event) => {
  event.preventDefault();
  pesanError.textContent = '';

  const dataForm = new FormData(form);
  const transaksiBaru = {
    tanggal: dataForm.get('tanggal'),
    keterangan: dataForm.get('keterangan'),
    jenis: dataForm.get('jenis'),
    jumlah: Number(dataForm.get('jumlah')),
  };

  try {
    daftarTransaksi = tambahTransaksi(daftarTransaksi, transaksiBaru);
    renderTabel();
    renderRingkasan();
    form.reset();
  } catch (err) {
    pesanError.textContent = err.message;
  }
});

renderTabel();
renderRingkasan();