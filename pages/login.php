<?php
// pages/login.php
$title = "Login";
if (session_status() === PHP_SESSION_NONE) session_start();

require_once("../includes/config.php");
require("../includes/db_connect.php");
require("../includes/header.php");
require("../includes/navbar.php");

// Jika sudah login, redirect ke home/admin
if (!empty($_SESSION['user']['nim'])) {
  header("Location: " . $base_url);
  exit;
}

$errors = [];
$old = ['nim'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $old['nim'] = trim($_POST['nim'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if ($old['nim'] === '' || $password === '') {
    $errors[] = "Harap isi semua kolom.";
  } else {
    // Cari user berdasarkan nim (prepared statement)
    $stmt = $mysqli->prepare("SELECT nim, password FROM user WHERE nim = ? LIMIT 1");
    $stmt->bind_param('s', $old['nim']);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();

    if ($user) {
      // NOTE: DB saat ini menyimpan password plain (contoh: '12345').
      // Jika nanti kamu menyimpan hash (password_hash), ganti pengecekan menjadi:
      // if (password_verify($password, $user['password'])) { ... }
      if ($user['password'] === $password) {
        // berhasil login
        $_SESSION['user'] = ['nim' => $user['nim']];
        $_SESSION['flash']['success'] = 'Login berhasil. Selamat datang!';
        header("Location: " . $base_url);
        exit;
      } else {
        $errors[] = "NIM atau password tidak cocok.";
      }
    } else {
      $errors[] = "NIM atau password tidak cocok.";
    }
  }
}
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

              <form method="post" novalidate>
                <div class="mb-3">
                  <label class="form-label">NIM</label>
                  <input name="nim" type="text" class="form-control" value="<?=htmlspecialchars($old['nim'])?>" required autofocus>
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