<?php
$title = "Home"; 
require_once("includes/config.php");
require("includes/db_connect.php");
require("includes/header.php"); 
require("includes/navbar.php");
?>
<div>
  <!-- Hero -->
  <section class="hero text-center text-white d-flex align-items-center justify-content-center">
    <div>
      <h1 class="fw-bold">Selamat Datang di SMA Negeri 9 Makassar</h1>
      <p class="lead mt-3 mb-4">
        SMA Negeri 9 Makassar berdiri sejak tahun 1985 dan berkomitmen menciptakan
        generasi unggul, berakhlak, dan berwawasan global.
      </p>
      <img
        src="<?= $base_url ?>assets/images/lainnya/lambang.png"
        alt="Logo Sekolah"
        width="120"
        class="mb-3"
      />
      <div>
        <img
          src="<?= $base_url ?>assets/images/fasilitas/foto gedung.jpg"
          alt="Gedung SMA Negeri 9 Makassar"
          class="rounded shadow-lg"
          width="600"
        />
      </div>
    </div>
  </section>

  <!-- Konten -->
  <main class="container py-5">
    <div class="container-main fade-in">
      <h2 class="text-center mb-3">
        <i class="bi bi-eye"></i> <strong>Visi</strong>
      </h2>
      <p class="text-center fs-5">
        Terwujudnya peserta didik yang berakhlak mulia, berkualitas, ramah
        lingkungan, dan berkebinekaan global.
      </p>
    </div>

    <div class="container-main fade-in mt-5">
      <h2 class="text-center mb-3">
        <i class="bi bi-bullseye"></i> <strong>Misi</strong>
      </h2>
      <ol class="fs-5">
        <li>Menciptakan budaya sekolah yang menumbuhkan akhlak mulia.</li>
        <li>Meningkatkan profesionalisme pendidik dan tenaga kependidikan.</li>
        <li>Melaksanakan pembelajaran yang interaktif dan menyenangkan.</li>
        <li>Pembinaan kegiatan ekstrakurikuler yang produktif.</li>
        <li>Menerapkan teknologi informasi dalam pembelajaran.</li>
        <li>Mewujudkan lingkungan sekolah yang aman, indah, dan bersih.</li>
      </ol>
    </div>

    <div class="container-main fade-in mt-5">
      <h2 class="text-center mb-3">
        <i class="bi bi-flag"></i> <strong>Tujuan</strong>
      </h2>
      <ol class="fs-5">
        <li>
          Peserta didik berperilaku sesuai nilai agama dan profil Pancasila.
        </li>
        <li>Peserta didik memiliki kemampuan berpikir kritis dan solutif.</li>
        <li>Mampu menciptakan karya yang bermanfaat bagi lingkungan.</li>
        <li>Menjaga dan memanfaatkan lingkungan secara bijak.</li>
        <li>Mewujudkan pelayanan prima dan profesional.</li>
      </ol>
    </div>
  </main>
  <!-- Tombol Back to Top -->
</div>
<?php
require_once("includes/footer.php")
?>
