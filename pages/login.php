<?php
// pages/login.php
$title = "Login";
if (session_status() === PHP_SESSION_NONE) session_start();

require_once("../includes/config.php");
require("../includes/db_connect.php");
require("../includes/header.php");
require("../includes/navbar.php");
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container py-5">
      <div class="container-main fade-in" style="max-width:900px; margin:auto;">
        <div class="row g-0 align-items-center">
          <!-- Kiri: ilustrasi / gambar -->
          <div class="col-md-6 d-none d-md-block">
            <div class="p-4">
              <img src="<?= $base_url ?>assets/images/TdkTerpakai/foto guru.jpg" alt="login" class="img-fluid rounded card-img-top zoom-img" style="height:420px; object-fit:cover; object-position:center;">
            </div>
          </div>

          <!-- Kanan: form -->
          <div class="col-md-6">
            <div class="p-4">
              <h2 class="fw-bold text-primary mb-3">Masuk ke Panel</h2>
              <p class="text-muted mb-4">Masukkan NIM dan kata sandi untuk mengakses area admin.</p>

              <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    <?php foreach ($errors as $e): ?>
                      <li><?=htmlspecialchars($e)?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>

              <?php if (!empty($_SESSION['flash']['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash']['success']); unset($_SESSION['flash']['success']); ?></div>
              <?php endif; ?>

              <form method="post" action="<?= $base_url ?>model/sistem_login.php" novalidate>
                <div class="mb-3">
                  <label class="form-label">NIM</label>
                  <input name="nim" type="text" class="form-control" required autofocus>
                </div>

                <div class="mb-3 position-relative">
                  <label class="form-label">Password</label>
                  <div class="input-group">
                    <input id="passwordInput" name="password" type="password" class="form-control" required>
                    <button id="togglePwd" type="button" class="btn btn-outline-secondary" title="Tampilkan/Sembunyikan password">Show</button>
                  </div>
                </div>

                <div class="d-grid">
                  <button class="btn btn-primary btn-lg">Masuk</button>
                </div>

                <div class="mt-3 text-center text-muted">
                  Belum punya akun? <a href="<?= $base_url ?>pages/contact.php">Hubungi admin</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
<?php require_once("../includes/footer.php"); ?>
</div>