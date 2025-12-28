<?php 
session_start();
include "koneksi.php";

if (!isset($_SESSION['level'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Semusim Coffee Menu</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap');

* { box-sizing: border-box; }

 body {
  margin: 0;
  font-family: 'Poppins', sans-serif;
  background-image: url('bgkopi.jpg');  /* ganti dengan nama file fotomu */
  background-size: cover;                   /* supaya foto memenuhi layar */
  background-position: center;              /* posisikan di tengah */
  background-repeat: no-repeat;             /* jangan diulang */
  background-attachment: fixed;             /* biar efeknya seperti “menempel” saat scroll */
 ;
}


/* ---------- HALAMAN PEMBUKA (LEMbaran FLIP) ---------- */
.intro {
  position: fixed;
  inset: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 20;
  pointer-events: auto;
  /* sedikit gelap di belakang lembaran */
  background: linear-gradient(180deg, rgba(0, 0, 0, 0.25), rgba(0,0,0,0.35));
}

/* wadah 3D untuk lembaran */
.sheet-wrap {
  perspective: 2000px;
  width: 70%;
  max-width: 700px;
  height: 50vh;
  max-height: 420px;
  display: flex;
  justify-content: center;
  align-items: center;
}


.sheet {
  width: 100%;
  height: 100%;
  border-radius: 14px;
  transform-style: preserve-3d;
  transition: transform 0.9s cubic-bezier(.2,.9,.2,1);
  box-shadow: 0 20px 40px rgba(0,0,0,0.45);
  cursor: pointer;
  position: relative;
}

/* kelas untuk membalik lembaran */
.sheet.flip {
  transform: rotateY(-180deg);
}

/* sisi depan & belakang */
.sheet .side {
  position: absolute;
  inset: 0;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  backface-visibility: hidden;
  border-radius: 14px;
  padding: 24px;
}

/* depan */
.sheet .front {
  background: linear-gradient(135deg, #ffe6b3, #ffcc80);
  color: #2b1608;
}

/* belakang (akan terlihat saat dibalik) */
.sheet .back {
  background: linear-gradient(135deg, #f7e1d0, #d9b07a);
  transform: rotateY(180deg);
  color: #2b1608;
}

/* teks besar, tebal */
.sheet h1 {
  margin: 0;
  font-size: 2.6rem;
  text-align: center;
  line-height: 1.05;
  font-weight: 800;
  letter-spacing: -0.5px;
}

/* subtitle */
.sheet p.subtitle {
  margin-top: 8px;
  font-size: 1rem;
  font-weight: 600;
  opacity: 0.9;
}

/* tombol kecil di pojok bawah lembaran */
.sheet .controls {
  position: absolute;
  right: 14px;
  bottom: 12px;
  display: flex;
  gap: 8px;
}

/* tombol gaya */
.control-btn {
  background: #ffffff;
  border: none;
  padding: 8px 12px;
  border-radius: 999px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}
.control-btn:active { transform: translateY(1px); }

/* hint klik */
.hint {
  position: absolute;
  left: 20px;
  bottom: 12px;
  font-size: 0.85rem;
  opacity: 0.9;
  background: rgba(255,255,255,0.85);
  padding: 6px 10px;
  border-radius: 999px;
  font-weight: 600;
}

/* ---------- KONTAINER BUKU (MENU) ---------- */
.book {
  position: relative;
  width: 80%;
  max-width: 1000px;
  height: 85vh;
  margin: 7vh auto;
  perspective: 2000px;
  pointer-events: auto;
}

/* halaman buku (sebelumnya) */
.page {
  width: 50%;
  height: 100%;
  background: #e3b05a;
  position: absolute;
  top: 0;
  transition: transform 1s ease-in-out;
  transform-origin: left;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  border-radius: 10px;
  overflow: hidden;
}

.page img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 10px;
}

.left-page {
  left: 0;
  background: #b26508;
}

.right-page {
  left: 50%;
  background: #523c04;
  transform-origin: left;
}


.menu-section {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.menu-section h2 {
    position: sticky;
    top: 0;
    background: white;
    padding: 10px 0;
    z-index: 10;
}

.menu-section {
    overflow-y: auto;
}

.menu-item {
  background: #dab775;  
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  margin: 10px auto;
  padding: 10px;
  width: 70%;
  transition: transform 0.3s ease;
}

.menu-item:hover {
  transform: scale(1.05);
}

.menu-item h3 {
  margin: 10px 0 5px;
  color: #5a3e36;
}

.menu-item p {
  color: #6b4e43;
}

.btn {
  background: linear-gradient(90deg, #f9f9f9, #ffffff);
  border: none;
  border-radius: 25px;
  padding: 8px 20px;
  cursor: pointer;
  font-weight: 600;
  color: #4c2c23;
}

.btn:hover {
  background: linear-gradient(90deg, #896105, #956b0a);
}

/* ---------- NAV BUTTON ---------- */
.nav-buttons {
  text-align: center;
  position: relative;
  top: 88vh;
}

.nav-buttons button {
  margin: 0 10px;
  padding: 10px 20px;
  border: none;
  border-radius: 20px;
  background: #ffffff;
  cursor: pointer;
  font-weight: 600;
  color: #5a3e36;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.nav-buttons button:hover {
  background: #010000;
}

footer {
  text-align: center;
  padding: 10px;
  font-size: 0.9rem;
  color: #5a3e36;
}

/* ---------- EFEK FLIP PADA HALAMAN BUKU ---------- */

/* ---------- TOMBOL MUSIK ---------- */
#music-btn {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: #fff;
  border: 2px solid #ffd1dc;
  border-radius: 50%;
  padding: 10px 14px;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  font-size: 18px;
}
#music-btn:hover {
  background: #ffd9e3;
}

/* ---------- KERANJANG (POPUP) ---------- */
/* ikon/box kecil di pojok kanan atas */
#cartBox {
  position: fixed;
  top: 20px;
  right: 20px;
  background: rgba(255,255,255,0.95);
  padding: 10px 14px;
  border-radius: 12px;
  font-weight: 700;
  box-shadow: 0 6px 20px rgba(0,0,0,0.25);
  z-index: 1005; /* di atas intro(20) dan sheet */
  cursor: pointer;
  display: flex;
  gap: 8px;
  align-items: center;
}

/* modal overlay */
#cartModal {
  display: none; /* default tersembunyi */
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: center;
  z-index: 1010; /* sangat atas */
}

/* konten modal */
.cart-panel {
  background: #fff;
  width: 92%;
  max-width: 420px;
  border-radius: 14px;
  padding: 18px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.35);
  max-height: 80vh;
  overflow: auto;
}

/* bar atas modal */
.cart-panel .head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
}

.cart-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 10px 0;
  padding: 8px;
  border-radius: 8px;
  background: #f7f7f7;
}

.cart-item .name { font-weight: 600; color: #333; }
.cart-item .price { color: #6b4e43; font-weight: 700; }

/* tombol kecil di item */
.qty-controls {
  display: flex;
  gap: 6px;
  align-items: center;
}

.small-btn {
  border: none;
  background: #ddd;
  padding: 6px 8px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 700;
}

/* total & aksi */
.cart-footer {
  margin-top: 12px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.total-row {
  display: flex;
  justify-content: space-between;
  font-weight: 800;
  font-size: 1.05rem;
  padding-top: 8px;
  border-top: 1px dashed #ddd;
}

/* tombol checkout & clear */
.checkout-btn {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 10px;
  background: #333;
  color: white;
  font-weight: 700;
  cursor: pointer;
}

.clear-btn {
  width: 100%;
  padding: 8px;
  border: none;
  border-radius: 10px;
  background: #eee;
  color: #333;
  cursor: pointer;
}

/* responsive kecil */
@media (max-width: 640px) {
  .sheet-wrap { width: 90%; height: 46vh; }
  .sheet h1 { font-size: 1.8rem; }
}
</style>
</head>
<body>

  <!-- Halaman Pembuka: lembaran dua sisi yang bisa dibolak-balik -->
  <div class="intro" id="intro">
    <div class="sheet-wrap" title="Klik lembaran untuk membolak-balik">
      <div class="sheet" id="sheet">
        <!-- Sisi Depan -->
        <div class="side front" id="frontSide">
          <h1><strong>Coffee shop ☕</strong></h1>
          <p class="subtitle">Nikmati suasana, seduh cerita.</p>
          <div class="hint">Klik untuk balik • Geser untuk masuk</div>
          <div class="controls">
            <button class="control-btn" id="enterBtn">Masuk</button>
          </div>
        </div>

        <!-- Sisi Belakang -->
        <div class="side back" id="backSide">
          <h1><strong>Coffee shop</strong></h1>
          <p class="subtitle">Menu spesial & suasana hangat.</p>
          <div style="margin-top:12px; font-weight:600;">Klik lagi untuk balik atau tekan "Masuk".</div>
          <div class="controls">
            <button class="control-btn" id="closeBtn">Tutup</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Buku Menu (tetap ada di belakang) -->
  <div class="book" id="book">
    <!-- Halaman 1 -->
    <div class="page left-page" id="page1">
      <div class="menu-section">
        <h2>☕ Coffee & Drinks</h2>

        <div class="menu-item">
          <img src="foto1.jpg" alt="Hot Espresso">
          <h3>Hot Espresso</h3>
          <p>Rp 20.000</p>
          <button class="btn">Pesan Sekarang</button>
        </div>

        <div class="menu-item">
          <img src="foto2.jpg" alt="Iced Coffee">
          <h3>Iced Coffee</h3>
          <p>Rp 22.000</p>
          <button class="btn">Pesan Sekarang</button>
        </div>
         
        <div class="menu-item">
          <img src="foto5.jpg" alt="cappucino">
          <h3>Cappucino</h3>
          <p>Rp 15.000</p>
          <button class="btn">Pesan Sekarang</button>
        </div>
      </div>
    </div>

    <!-- Halaman 2 -->
    <div class="page right-page" id="page2">
      <div class="menu-section">
        <h2>🍟 Snack & Food</h2>

        <div class="menu-item">
          <img src="foto3.jpg" alt="French Fries">
          <h3>French Fries</h3>
          <p>Rp 18.000</p>
          <button class="btn">Pesan Sekarang</button>
        </div>

        <div class="menu-item">
          <img src="foto4.jpg" alt="Cireng Sambal Kecap">
          <h3>Cireng Sambal Kecap</h3>
          <p>Rp 15.000</p>
          <button class="btn">Pesan Sekarang</button>
        </div>

        <div class="menu-item">
          <img src="foto6.jpg" alt="Donat">
          <h3>Donat</h3>
          <p>Rp 10.000</p>
          <button class="btn">Pesan Sekarang</button>
        </div>

      </div>
    </div>
  </div>


  <!-- KERANJANG ICON (POJOK) -->
  <div id="cartBox" title="Lihat Keranjang">
    🛒 <span id="cartCount">0</span>
  </div>

  <!-- POPUP KERANJANG -->
  <div id="cartModal" aria-hidden="true">
    <div class="cart-panel" role="dialog" aria-modal="true" aria-labelledby="cartTitle">
      <div class="head">
        <h3 id="cartTitle">Keranjang</h3>
        <button id="closeCart" class="control-btn" title="Tutup">✕</button>
      </div>

      <div id="cartList">
        <!-- daftar item akan masuk di sini -->
      </div>

      <div class="cart-footer">
        <div class="total-row">
          <span>Total</span>
          <span>Rp <span id="cartTotal">0</span></span>
        </div>

        <button class="checkout-btn" id="checkoutBtn">Checkout</button>
        <button class="clear-btn" id="clearCartBtn">Kosongkan Keranjang</button>
      </div>
    </div>
  </div>

  <button id="music-btn" onclick="toggleMusic()">🎵</button>

  <footer>
    © 2025 Semusim Coffee | Design by Kamu 🌸
  </footer>

  <!-- Suara & Musik -->
  <audio id="flipSound" src=""></audio>
  <audio id="bgMusic" src="Sempurna - Andra And The Backbone (instrumental guitar cover) by Albayments.mp3" loop></audio>

<script>
/* kontrol lembaran pembuka */
const sheet = document.getElementById('sheet');
const intro = document.getElementById('intro');
const enterBtn = document.getElementById('enterBtn');
const closeBtn = document.getElementById('closeBtn');
const flipSound = document.getElementById("flipSound");
let sheetFlipped = false;

/* klik pada lembaran membolak-balik */
sheet.addEventListener('click', (e) => {
  // jika klik pada tombol jangan triggrer flip
  if (e.target.closest('.control-btn')) return;
  sheetFlipped = !sheetFlipped;
  if (sheetFlipped) {
    sheet.classList.add('flip');
  } else {
    sheet.classList.remove('flip');
  }
  // mainkan suara flip (jika tersedia)
  try { flipSound.currentTime = 0; flipSound.play(); } catch(e){ /* ignore */ }
});

/* tombol "Masuk" menutup overlay intro dan menampilkan menu */
enterBtn.addEventListener('click', (e) => {
  // hentikan event bubbling supaya tidak memicu flip ganda
  e.stopPropagation();
  // mainkan suara
  try { flipSound.currentTime = 0; flipSound.play(); } catch(e){}
  // sembunyikan intro
  intro.style.transition = 'opacity 0.6s ease, visibility 0.6s';
  intro.style.opacity = 0;
  // setelah anim selesai sembunyikan display agar klik menu bekerja normal
  setTimeout(() => {
    intro.style.display = 'none';
  }, 620);
});

/* tombol "Tutup" (dari sisi belakang) membawa kembali ke sisi depan */
closeBtn.addEventListener('click', (e) => {
  e.stopPropagation();
  sheetFlipped = false;
  sheet.classList.remove('flip');
  try { flipSound.currentTime = 0; flipSound.play(); } catch(e){}
});

/* Memungkinkan gesture 'swipe down' atau tombol Esc untuk menutup (opsional) */
document.addEventListener('keydown', (ev) => {
  if (ev.key === 'Escape') {
    // close intro jika masih terlihat
    if (intro && intro.style.display !== 'none') {
      intro.style.opacity = 0;
      setTimeout(()=> intro.style.display = 'none', 360);
    }
    // close cart modal jika terbuka
    if (document.getElementById('cartModal').style.display === 'flex') {
      closeCartModal();
    }
  }
});

/* ---------- musik & flip halaman buku ---------- */
let flipped = false;
let musicPlaying = false;
const bgMusic = document.getElementById("bgMusic");
const musicBtn = document.getElementById("music-btn");

function flipToPage(page) {
  const page1 = document.getElementById('page1');
  if (page === 2 && !flipped) {
    page1.classList.add('flip');
    try { flipSound.currentTime = 0; flipSound.play(); } catch(e){}
    flipped = true;
  } else if (page === 1 && flipped) {
    page1.classList.remove('flip');
    try { flipSound.currentTime = 0; flipSound.play(); } catch(e){}
    flipped = false;
  }
}

function toggleMusic() {
  if (!musicPlaying) {
    bgMusic.play();
    musicBtn.textContent = "⏸";
    musicPlaying = true;
  } else {
    bgMusic.pause();
    musicBtn.textContent = "🎵";
    musicPlaying = false;
  }
}

/* ========== KERANJANG (LOGIKA) ========== */
/* Struktur keranjang: array item { name, price, qty } */
let cart = [];

/* helper: parse harga dari string "Rp 20.000" -> number 20000 */
function parsePrice(text) {
  if (!text) return 0;
  // ambil angka saja
  const num = text.replace(/[^0-9]/g, '');
  return parseInt(num || '0', 10);
}

/* update tampilan counter kecil */
function updateCartCounter() {
  const count = cart.reduce((s, it) => s + it.qty, 0);
  document.getElementById('cartCount').textContent = count;
}

/* update isi popup */
function renderCartList() {
  const list = document.getElementById('cartList');
  list.innerHTML = '';
  let total = 0;
  if (cart.length === 0) {
    list.innerHTML = '<p style="opacity:.8">Keranjang kosong.</p>';
  } else {
    cart.forEach((it, index) => {
      total += it.price * it.qty;
      const div = document.createElement('div');
      div.className = 'cart-item';
      div.innerHTML = `
        <div>
          <div class="name">${it.name}</div>
          <div style="font-size:0.85rem;color:#777">Rp ${formatPrice(it.price)}</div>
        </div>
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px">
          <div class="qty-controls">
            <button class="small-btn" data-action="dec" data-index="${index}">−</button>
            <div style="padding:0 8px">${it.qty}</div>
            <button class="small-btn" data-action="inc" data-index="${index}">＋</button>
          </div>
          <button class="small-btn" data-action="remove" data-index="${index}" style="background:#ffdede">Hapus</button>
        </div>
      `;
      list.appendChild(div);
    });
  }
  document.getElementById('cartTotal').textContent = formatPrice(total);
  updateCartCounter();
  attachCartItemButtons(); // ikat event pada tombol inc/dec/hapus
}

/* format number -> "20.000" */
function formatPrice(n) {
  return String(n).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

/* tambahkan item ke keranjang (jika sudah ada, tambah qty) */
function addToCart(itemName, itemPrice) {
  const idx = cart.findIndex(i => i.name === itemName && i.price === itemPrice);
  if (idx > -1) {
    cart[idx].qty += 1;
  } else {
    cart.push({ name: itemName, price: itemPrice, qty: 1 });
  }
  // quick visual feedback: mainkan sound flip jika ada
  try { flipSound.currentTime = 0; flipSound.play(); } catch(e){}
  renderCartList();
}

/* attach pada semua tombol "Pesan Sekarang" */
document.querySelectorAll('.menu-item .btn').forEach(btn => {
  btn.addEventListener('click', function(e) {
    // ambil elemen menu parent
    const box = this.closest('.menu-item');
    const name = box.querySelector('h3') ? box.querySelector('h3').textContent.trim() : 'Item';
    const priceText = box.querySelector('p') ? box.querySelector('p').textContent : 'Rp 0';
    const price = parsePrice(priceText);
    addToCart(name, price);
  });
});

/* buka modal keranjang */
document.getElementById('cartBox').addEventListener('click', () => {
  openCartModal();
});

/* fungsi buka / tutup modal */
function openCartModal() {
  const modal = document.getElementById('cartModal');
  modal.style.display = 'flex';
  document.getElementById('cartModal').setAttribute('aria-hidden', 'false');
  renderCartList();
}
function closeCartModal() {
  const modal = document.getElementById('cartModal');
  modal.style.display = 'none';
  document.getElementById('cartModal').setAttribute('aria-hidden', 'true');
}

/* tombol tutup modal */
document.getElementById('closeCart').addEventListener('click', closeCartModal);

/* clear cart */
document.getElementById('clearCartBtn').addEventListener('click', () => {
  if (!confirm('Kosongkan keranjang?')) return;
  cart = [];
  renderCartList();
});

/* checkout (saat ini hanya alert) */
document.getElementById('checkoutBtn').addEventListener('click', () => {
  if (cart.length === 0) {
    alert('Keranjang kosong.');
    return;
  }
  // contoh: tampilkan ringkasan lalu kosongkan keranjang
  let pesan = 'Checkout:\n';
  cart.forEach(it => pesan += `${it.name} x${it.qty} — Rp ${formatPrice(it.price * it.qty)}\n`);
  pesan += '\nTotal: Rp ' + formatPrice(cart.reduce((s,i)=> s + i.price*i.qty, 0));
  alert(pesan)
  // setelah checkout, kosongkan
  cart = [];
  renderCartList();
  closeCartModal();
});

/* pasang handler tombol inc/dec/remove pada item */
function attachCartItemButtons() {
  const buttons = document.querySelectorAll('[data-action]');
  buttons.forEach(btn => {
    btn.onclick = function() {
      const action = this.getAttribute('data-action');
      const idx = parseInt(this.getAttribute('data-index'), 10);
      if (isNaN(idx)) return;
      if (action === 'inc') {
        cart[idx].qty += 1;
      } else if (action === 'dec') {
        cart[idx].qty = Math.max(1, cart[idx].qty - 1);
      } else if (action === 'remove') {
        cart.splice(idx, 1);
      }
      renderCartList();
    };
  });
}

/* close modal jika klik di luar panel */
document.getElementById('cartModal').addEventListener('click', (e) => {
  if (e.target === document.getElementById('cartModal')) closeCartModal();
});

/* inisialisasi render awal */
renderCartList();
</script>
</body>
</html>
