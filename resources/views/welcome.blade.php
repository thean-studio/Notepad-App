<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notepad — Tulis Ide, Simpan Momen</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --cream: #FAF7F2;
      --ink: #1C1A16;
      --amber: #D97706;
      --amber-light: #FDE68A;
      --sage: #4A7C59;
      --sage-light: #D1FAE5;
      --muted: #78716C;
    }
    body {
      font-family: 'DM Sans', sans-serif;
      background-color: var(--cream);
      color: var(--ink);
    }
    h1, h2, h3 {
      font-family: 'Lora', serif;
    }
    .gradient-text {
      background: linear-gradient(135deg, #D97706, #059669);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .paper-card {
      background: #fff;
      border: 1px solid #E7E5E4;
      box-shadow: 4px 4px 0px #E7E5E4;
    }
    .paper-card:hover {
      box-shadow: 6px 6px 0px #D6D3D1;
      transform: translate(-1px, -1px);
      transition: all 0.15s ease;
    }
    .btn-primary {
      background: var(--ink);
      color: var(--cream);
      border: 2px solid var(--ink);
      font-family: 'DM Sans', sans-serif;
      font-weight: 500;
      transition: all 0.15s ease;
    }
    .btn-primary:hover {
      background: var(--amber);
      border-color: var(--amber);
      transform: translate(-2px, -2px);
      box-shadow: 4px 4px 0px var(--ink);
    }
    .btn-outline {
      background: transparent;
      color: var(--ink);
      border: 2px solid var(--ink);
      font-family: 'DM Sans', sans-serif;
      font-weight: 500;
      transition: all 0.15s ease;
    }
    .btn-outline:hover {
      background: var(--cream);
      transform: translate(-2px, -2px);
      box-shadow: 4px 4px 0px var(--ink);
    }
    .ruled-line {
      background: repeating-linear-gradient(
        transparent,
        transparent 27px,
        #E7E5E4 27px,
        #E7E5E4 28px
      );
    }
    .feature-icon {
      width: 48px;
      height: 48px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
    }
    .nav-link {
      color: var(--muted);
      font-size: 15px;
      transition: color 0.1s;
    }
    .nav-link:hover { color: var(--ink); }
    .hero-note {
      background: #FFFBF5;
      border: 1px solid #E7E5E4;
      border-radius: 4px;
      padding: 28px 32px;
      position: relative;
    }
    .hero-note::before {
      content: '';
      position: absolute;
      left: 60px;
      top: 0; bottom: 0;
      width: 1px;
      background: #FCA5A5;
      opacity: 0.5;
    }
    .tag {
      display: inline-block;
      background: var(--amber-light);
      color: #92400E;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 0.05em;
      padding: 4px 12px;
      border-radius: 999px;
    }
    .step-num {
      width: 36px;
      height: 36px;
      background: var(--ink);
      color: var(--cream);
      font-family: 'Lora', serif;
      font-size: 16px;
      display: flex; align-items: center; justify-content: center;
      border-radius: 50%;
      flex-shrink: 0;
    }
    .testimonial-card {
      background: white;
      border: 1px solid #E7E5E4;
      border-radius: 8px;
      padding: 24px;
    }
    .stars { color: #D97706; }
    .footer-link {
      color: var(--muted);
      font-size: 14px;
      transition: color 0.1s;
    }
    .footer-link:hover { color: var(--ink); }
    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(-2deg); }
      50% { transform: translateY(-8px) rotate(-2deg); }
    }
    @keyframes float2 {
      0%, 100% { transform: translateY(0px) rotate(1.5deg); }
      50% { transform: translateY(-6px) rotate(1.5deg); }
    }
    .float-1 { animation: float 4s ease-in-out infinite; }
    .float-2 { animation: float2 5s ease-in-out infinite 0.8s; }
    .float-3 { animation: float 3.5s ease-in-out infinite 1.5s; }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="sticky top-0 z-50 bg-[#FAF7F2] border-b border-stone-200">
  <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <div class="w-8 h-8 bg-amber-600 rounded flex items-center justify-center">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
          <rect x="2" y="1" width="11" height="14" rx="1" fill="white" opacity="0.9"/>
          <line x1="4" y1="5" x2="11" y2="5" stroke="#D97706" stroke-width="1.2"/>
          <line x1="4" y1="8" x2="11" y2="8" stroke="#D97706" stroke-width="1.2"/>
          <line x1="4" y1="11" x2="8" y2="11" stroke="#D97706" stroke-width="1.2"/>
        </svg>
      </div>
      <span class="text-lg font-semibold" style="font-family:'Lora',serif;">Notepad</span>
    </div>
    <div class="hidden md:flex items-center gap-8">
      <a href="#fitur" class="nav-link">Fitur</a>
      <a href="#cara-kerja" class="nav-link">Cara Kerja</a>
      <a href="#testimoni" class="nav-link">Testimoni</a>
      <a href="#harga" class="nav-link">Harga</a>
    </div>
    <div class="flex items-center gap-3">
      <a href="#login" class="btn-outline px-5 py-2 text-sm rounded-none cursor-pointer">Masuk</a>
      <a href="#register" class="btn-primary px-5 py-2 text-sm rounded-none cursor-pointer">Daftar Gratis</a>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="max-w-6xl mx-auto px-6 pt-20 pb-24">
  <div class="flex flex-col lg:flex-row items-center gap-16">
    <div class="flex-1">
      <span class="tag">✦ Gratis Selamanya untuk Penggunaan Dasar</span>
      <h1 class="text-5xl lg:text-6xl leading-tight mt-6 mb-6">
        Tulis Bebas,<br/>
        <span class="gradient-text italic">Simpan Selamanya.</span>
      </h1>
      <p class="text-stone-500 text-lg leading-relaxed mb-10 max-w-lg">
        Notepad adalah ruang tulis yang tenang — bebas gangguan, cepat diakses, dan selalu siap saat ide datang tiba-tiba. Dari coretan sederhana hingga catatan panjang.
      </p>
      <div class="flex flex-col sm:flex-row gap-4">
        <a href="#register" class="btn-primary px-8 py-3.5 text-base rounded-none text-center">
          Mulai Menulis Sekarang →
        </a>
        <a href="#cara-kerja" class="btn-outline px-8 py-3.5 text-base rounded-none text-center">
          Lihat Cara Kerjanya
        </a>
      </div>
      <p class="text-stone-400 text-sm mt-5">Tidak perlu kartu kredit · Daftar dalam 30 detik</p>
    </div>

    <!-- Floating notes illustration -->
    <div class="flex-1 relative h-80 lg:h-96 w-full hidden md:block">
      <!-- Note 1 -->
      <div class="absolute top-4 left-8 w-52 float-1" style="transform: rotate(-2deg);">
        <div class="hero-note ruled-line shadow-md">
          <p class="text-xs text-stone-400 mb-2 font-mono">📌 Ide Hari Ini</p>
          <p class="text-sm text-stone-700 leading-relaxed">Buat aplikasi yang bisa merekam suara dan ubah jadi teks otomatis...</p>
          <p class="text-xs text-stone-300 mt-3 text-right">11:42 AM</p>
        </div>
      </div>
      <!-- Note 2 -->
      <div class="absolute top-16 right-4 w-56 float-2" style="transform: rotate(1.5deg);">
        <div class="hero-note ruled-line shadow-md">
          <p class="text-xs text-stone-400 mb-2 font-mono">📚 Daftar Baca</p>
          <p class="text-sm text-stone-700 leading-relaxed">
            ✓ Atomic Habits<br/>
            ✓ Deep Work<br/>
            — The Creative Act<br/>
            — Four Thousand Weeks
          </p>
        </div>
      </div>
      <!-- Note 3 -->
      <div class="absolute bottom-4 left-24 w-48 float-3" style="transform: rotate(-1deg);">
        <div class="hero-note shadow-md">
          <p class="text-xs text-stone-400 mb-2 font-mono">💡 Kutipan</p>
          <p class="text-sm text-stone-600 italic leading-relaxed">"Menulis adalah cara terbaik untuk berpikir jernih."</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- STATS BAR -->
<div class="bg-stone-900 py-10">
  <div class="max-w-4xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
    <div>
      <div class="text-3xl font-bold text-amber-400" style="font-family:'Lora',serif;">50K+</div>
      <div class="text-stone-400 text-sm mt-1">Pengguna Aktif</div>
    </div>
    <div>
      <div class="text-3xl font-bold text-amber-400" style="font-family:'Lora',serif;">2M+</div>
      <div class="text-stone-400 text-sm mt-1">Catatan Dibuat</div>
    </div>
    <div>
      <div class="text-3xl font-bold text-amber-400" style="font-family:'Lora',serif;">99.9%</div>
      <div class="text-stone-400 text-sm mt-1">Uptime</div>
    </div>
    <div>
      <div class="text-3xl font-bold text-amber-400" style="font-family:'Lora',serif;">4.9★</div>
      <div class="text-stone-400 text-sm mt-1">Rating Pengguna</div>
    </div>
  </div>
</div>

<!-- FEATURES -->
<section id="fitur" class="max-w-6xl mx-auto px-6 py-24">
  <div class="text-center mb-16">
    <span class="tag">Fitur Unggulan</span>
    <h2 class="text-4xl mt-4">Semua yang Kamu Butuhkan</h2>
    <p class="text-stone-500 mt-3 text-lg">Simpel tapi lengkap. Tidak kurang, tidak berlebihan.</p>
  </div>
  <div class="grid md:grid-cols-3 gap-6">
    <div class="paper-card p-8 cursor-default">
      <div class="feature-icon bg-amber-50 mb-5">✍️</div>
      <h3 class="text-xl mb-3">Editor Bersih</h3>
      <p class="text-stone-500 leading-relaxed">Antarmuka minimalis yang tidak mengalihkan perhatian. Fokus sepenuhnya pada tulisanmu.</p>
    </div>
    <div class="paper-card p-8 cursor-default">
      <div class="feature-icon bg-green-50 mb-5">🔍</div>
      <h3 class="text-xl mb-3">Cari Instan</h3>
      <p class="text-stone-500 leading-relaxed">Temukan catatan apapun dalam hitungan detik dengan pencarian teks penuh yang cepat dan akurat.</p>
    </div>
    <div class="paper-card p-8 cursor-default">
      <div class="feature-icon bg-blue-50 mb-5">☁️</div>
      <h3 class="text-xl mb-3">Sinkronisasi Otomatis</h3>
      <p class="text-stone-500 leading-relaxed">Catatanmu tersinkronisasi di semua perangkat secara real-time. HP, tablet, atau laptop.</p>
    </div>
    <div class="paper-card p-8 cursor-default">
      <div class="feature-icon bg-purple-50 mb-5">🏷️</div>
      <h3 class="text-xl mb-3">Folder & Tag</h3>
      <p class="text-stone-500 leading-relaxed">Kelola catatan dengan folder dan tag yang fleksibel. Sistem organisasi yang terasa natural.</p>
    </div>
    <div class="paper-card p-8 cursor-default">
      <div class="feature-icon bg-red-50 mb-5">🔒</div>
      <h3 class="text-xl mb-3">Enkripsi End-to-End</h3>
      <p class="text-stone-500 leading-relaxed">Catatan pribadimu hanya bisa dibaca olehmu. Privasi bukan fitur tambahan, tapi standar kami.</p>
    </div>
    <div class="paper-card p-8 cursor-default">
      <div class="feature-icon bg-yellow-50 mb-5">📤</div>
      <h3 class="text-xl mb-3">Ekspor Mudah</h3>
      <p class="text-stone-500 leading-relaxed">Ekspor ke PDF, Markdown, atau plain text kapanpun. Datamu selalu milikmu, bukan kami.</p>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section id="cara-kerja" class="bg-stone-900 text-stone-100 py-24">
  <div class="max-w-4xl mx-auto px-6">
    <div class="text-center mb-16">
      <h2 class="text-4xl text-white">Mulai dalam 3 Langkah</h2>
      <p class="text-stone-400 mt-3 text-lg">Tidak ada kurva belajar. Langsung bisa dipakai.</p>
    </div>
    <div class="flex flex-col gap-10">
      <div class="flex items-start gap-6">
        <div class="step-num bg-amber-500">1</div>
        <div>
          <h3 class="text-xl font-semibold text-white mb-2" style="font-family:'DM Sans',sans-serif;">Daftar Akun Gratis</h3>
          <p class="text-stone-400 leading-relaxed">Masukkan email dan password. Selesai. Tidak ada formulir panjang atau verifikasi ribet. Dalam 30 detik kamu sudah siap.</p>
        </div>
      </div>
      <div class="w-px h-6 bg-stone-700 ml-4"></div>
      <div class="flex items-start gap-6">
        <div class="step-num bg-amber-500">2</div>
        <div>
          <h3 class="text-xl font-semibold text-white mb-2" style="font-family:'DM Sans',sans-serif;">Buat Catatan Pertamamu</h3>
          <p class="text-stone-400 leading-relaxed">Klik tombol +, dan mulailah menulis. Tersimpan otomatis setiap perubahan. Tidak perlu tekan Ctrl+S.</p>
        </div>
      </div>
      <div class="w-px h-6 bg-stone-700 ml-4"></div>
      <div class="flex items-start gap-6">
        <div class="step-num bg-amber-500">3</div>
        <div>
          <h3 class="text-xl font-semibold text-white mb-2" style="font-family:'DM Sans',sans-serif;">Akses dari Mana Saja</h3>
          <p class="text-stone-400 leading-relaxed">Login dari HP atau laptop lain — semua catatanmu sudah di sana, tersinkronisasi sempurna.</p>
        </div>
      </div>
    </div>
    <div class="text-center mt-16">
      <a href="#register" class="btn-primary px-10 py-4 text-base rounded-none inline-block">Coba Sekarang — Gratis →</a>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section id="testimoni" class="max-w-6xl mx-auto px-6 py-24">
  <div class="text-center mb-16">
    <span class="tag">Kata Mereka</span>
    <h2 class="text-4xl mt-4">Dipercaya Ribuan Penulis</h2>
  </div>
  <div class="grid md:grid-cols-3 gap-6">
    <div class="testimonial-card">
      <div class="stars text-lg mb-3">★★★★★</div>
      <p class="text-stone-600 leading-relaxed mb-5">"Akhirnya ketemu aplikasi catatan yang nggak bikin kepala pusing. Simpel tapi semua ada. Udah 6 bulan setia pakai Notepad."</p>
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-800 font-semibold text-sm">RD</div>
        <div>
          <p class="font-medium text-stone-800 text-sm">Rizky Damara</p>
          <p class="text-stone-400 text-xs">Penulis Lepas, Yogyakarta</p>
        </div>
      </div>
    </div>
    <div class="testimonial-card border-2 border-amber-400">
      <div class="stars text-lg mb-3">★★★★★</div>
      <p class="text-stone-600 leading-relaxed mb-5">"Saya pakai untuk mencatat meeting dan ide produk. Fitur sinkronisasi-nya mulus banget. Tidak pernah kehilangan satu catatan pun."</p>
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-800 font-semibold text-sm">AP</div>
        <div>
          <p class="font-medium text-stone-800 text-sm">Anisa Putri</p>
          <p class="text-stone-400 text-xs">Product Manager, Jakarta</p>
        </div>
      </div>
    </div>
    <div class="testimonial-card">
      <div class="stars text-lg mb-3">★★★★★</div>
      <p class="text-stone-600 leading-relaxed mb-5">"Sebagai mahasiswa yang sering ganti perangkat, Notepad jadi penyelamat. Catatan kuliah saya aman dan selalu sinkron."</p>
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 font-semibold text-sm">FH</div>
        <div>
          <p class="font-medium text-stone-800 text-sm">Farhan Hakim</p>
          <p class="text-stone-400 text-xs">Mahasiswa, Bandung</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PRICING -->
<section id="harga" class="bg-[#FAF7F2] border-t border-stone-200 py-24">
  <div class="max-w-4xl mx-auto px-6">
    <div class="text-center mb-16">
      <span class="tag">Harga</span>
      <h2 class="text-4xl mt-4">Mulai Gratis, Upgrade Kapan Saja</h2>
    </div>
    <div class="grid md:grid-cols-2 gap-8">
      <!-- Free -->
      <div class="paper-card p-10">
        <p class="text-stone-400 text-sm font-medium tracking-wide uppercase mb-2">Gratis</p>
        <div class="text-5xl font-bold mb-1" style="font-family:'Lora',serif;">Rp0</div>
        <p class="text-stone-400 text-sm mb-8">Selamanya</p>
        <ul class="space-y-3 text-stone-600 mb-10">
          <li class="flex items-center gap-3"><span class="text-green-600">✓</span> 50 catatan</li>
          <li class="flex items-center gap-3"><span class="text-green-600">✓</span> Sinkronisasi 1 perangkat</li>
          <li class="flex items-center gap-3"><span class="text-green-600">✓</span> Ekspor teks biasa</li>
          <li class="flex items-center gap-3"><span class="text-green-600">✓</span> Editor dasar</li>
        </ul>
        <a href="#register" class="btn-outline w-full py-3 text-center rounded-none block">Daftar Gratis</a>
      </div>
      <!-- Pro -->
      <div class="bg-stone-900 p-10 text-white" style="box-shadow: 6px 6px 0px #D97706;">
        <p class="text-amber-400 text-sm font-medium tracking-wide uppercase mb-2">Pro</p>
        <div class="text-5xl font-bold mb-1" style="font-family:'Lora',serif;">Rp29K</div>
        <p class="text-stone-400 text-sm mb-8">per bulan</p>
        <ul class="space-y-3 text-stone-300 mb-10">
          <li class="flex items-center gap-3"><span class="text-amber-400">✓</span> Catatan tak terbatas</li>
          <li class="flex items-center gap-3"><span class="text-amber-400">✓</span> Sinkronisasi semua perangkat</li>
          <li class="flex items-center gap-3"><span class="text-amber-400">✓</span> Ekspor PDF & Markdown</li>
          <li class="flex items-center gap-3"><span class="text-amber-400">✓</span> Enkripsi end-to-end</li>
          <li class="flex items-center gap-3"><span class="text-amber-400">✓</span> Folder & tag lanjutan</li>
          <li class="flex items-center gap-3"><span class="text-amber-400">✓</span> Prioritas dukungan</li>
        </ul>
        <a href="#register" class="btn-primary w-full py-3 text-center rounded-none block" style="background:#D97706; border-color:#D97706;">Coba Pro 14 Hari Gratis →</a>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="max-w-4xl mx-auto px-6 py-24 text-center">
  <h2 class="text-4xl lg:text-5xl mb-6">Ide Bagus Tidak Menunggu.<br/><span class="italic gradient-text">Begitu Juga Kamu.</span></h2>
  <p class="text-stone-500 text-lg mb-10">Bergabunglah dengan 50.000+ pengguna yang sudah mulai menulis lebih bebas.</p>
  <div class="flex flex-col sm:flex-row gap-4 justify-center">
    <a href="#register" class="btn-primary px-10 py-4 text-base rounded-none">Daftar Sekarang — Gratis</a>
    <a href="#login" class="btn-outline px-10 py-4 text-base rounded-none">Sudah punya akun? Masuk</a>
  </div>
</section>

<!-- FOOTER -->
<footer class="border-t border-stone-200 py-12">
  <div class="max-w-6xl mx-auto px-6">
    <div class="flex flex-col md:flex-row items-start justify-between gap-10">
      <div>
        <div class="flex items-center gap-2 mb-3">
          <div class="w-7 h-7 bg-amber-600 rounded flex items-center justify-center">
            <svg width="13" height="13" viewBox="0 0 16 16" fill="none">
              <rect x="2" y="1" width="11" height="14" rx="1" fill="white" opacity="0.9"/>
              <line x1="4" y1="5" x2="11" y2="5" stroke="#D97706" stroke-width="1.2"/>
              <line x1="4" y1="8" x2="11" y2="8" stroke="#D97706" stroke-width="1.2"/>
              <line x1="4" y1="11" x2="8" y2="11" stroke="#D97706" stroke-width="1.2"/>
            </svg>
          </div>
          <span class="font-semibold" style="font-family:'Lora',serif;">Notepad</span>
        </div>
        <p class="text-stone-400 text-sm max-w-xs">Ruang tulis yang tenang untuk pikiran yang tak pernah berhenti.</p>
      </div>
      <div class="grid grid-cols-3 gap-12 text-sm">
        <div>
          <p class="font-medium text-stone-800 mb-3">Produk</p>
          <ul class="space-y-2">
            <li><a href="#" class="footer-link">Fitur</a></li>
            <li><a href="#" class="footer-link">Harga</a></li>
            <li><a href="#" class="footer-link">Changelog</a></li>
          </ul>
        </div>
        <div>
          <p class="font-medium text-stone-800 mb-3">Perusahaan</p>
          <ul class="space-y-2">
            <li><a href="#" class="footer-link">Tentang</a></li>
            <li><a href="#" class="footer-link">Blog</a></li>
            <li><a href="#" class="footer-link">Karir</a></li>
          </ul>
        </div>
        <div>
          <p class="font-medium text-stone-800 mb-3">Legal</p>
          <ul class="space-y-2">
            <li><a href="#" class="footer-link">Privasi</a></li>
            <li><a href="#" class="footer-link">Syarat</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="border-t border-stone-200 mt-10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
      <p class="text-stone-400 text-sm">© 2025 Notepad. Dibuat dengan ☕ dan banyak catatan.</p>
      <div class="flex gap-6">
        <a href="#" class="footer-link">Twitter</a>
        <a href="#" class="footer-link">Instagram</a>
        <a href="#" class="footer-link">LinkedIn</a>
      </div>
    </div>
  </div>
</footer>

</body>
</html>