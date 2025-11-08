<?php
// pages/login.php (replace top part of your file with this block)

// 1) Mulai session PERTAMA dan paling awal (tidak ada output sebelum ini)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2) include config & db BEFORE header output but AFTER session_start
require_once("../includes/config.php");
require("../includes/db_connect.php");

// 3) Jika sudah login, verifikasi di DB lalu redirect ke halaman sesuai mapping
if (!empty($_SESSION['user']['nim'])) {
    $nim_session = $_SESSION['user']['nim'];

    // optional: ambil user di DB untuk memastikan nim valid dan (jika ada) ambil role
    $stmt = $mysqli->prepare("SELECT id, nim FROM `user` WHERE nim = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param('s', $nim_session);
        $stmt->execute();
        $res = $stmt->get_result();
        $u = $res->fetch_assoc();
        $stmt->close();

        if ($u) {
            // mapping nim -> folder (sesuaikan path sesuai project Anda)
            $mapping = [
                '240209501085' => '../admin/user/index.php',
                '240209501084' => '../admin/ekstrakurikuler/index.php',
                '240209501089' => '../admin/fasilitas/index.php',
                '240209501093' => '../admin/komentar/index.php',
                '240209501094' => '../admin/prestasi/index.php',
            ];

            // Jika ada role-based routing, gunakan role dari DB
            // contoh: if ($u['role'] === 'ekstrakurikuler') { $redirect = '../admin/ekstrakurikuler/index.php'; }

            if (isset($mapping[$u['nim']])) {
                header('Location: ' . $mapping[$u['nim']]);
                exit;
            } else {
                // default route bila user tabel valid tapi tidak ada mapping
                header('Location: ../admin/index.php');
                exit;
            }
        } else {
            // session nim tidak valid (mungkin dihapus di DB) -> logout dan lanjut ke login form
            $_SESSION = [];
            session_destroy();
            // no redirect: akan tampil form login
        }
    } else {
        // jika prepare gagal, biarkan user lanjut ke login form (atau tangani error khusus)
    }
}

// 4) Jika belum di-redirect, sekarang aman untuk include header/navbar (output dimulai setelah session check)
require("../includes/header.php");
require("../includes/navbar.php");

// lanjutkan sisa file login.php (form & logika POST existing)


// Simple flash message helper
function flash($key = null, $message = null) {
    if ($key === null) return;
    if ($message === null) {
        if (isset($_SESSION['flash'][$key])) {
            $m = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $m;
        }
        return null;
    }
    $_SESSION['flash'][$key] = $message;
}

// Handle POST (demo only). Replace with real DB checks using prepared statements.
$errors = [];
$old = ['nim' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['nim'] = trim($_POST['nim'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($old['nim'] === '') $errors['nim'] = 'Masukkan nim.';
    if ($password === '') $errors['password'] = 'Masukkan kata sandi.';

    if (empty($errors)) {
        // ===== DEMO AUTH (replace this block with DB lookup & password_verify) =====
        // Example hardcoded credential (for demo only)
        $demo_user = 'admin';
        $demo_pass = 'password123'; // in real app, never store plain text

        if ($old['nim'] === $demo_user && $password === $demo_pass) {
            // login successful
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'nim' => $demo_user,
                'display_name' => 'Administrator'
            ];
            flash('success', 'Login berhasil. Selamat datang!');
            header('Location: index.php');
            exit;
        } else {
            $errors['general'] = 'nim atau password salah.';
        }
        // =======================================================================
    }
}
?>
<?php
// (letakkan setelah session_start() atau biarkan login.php tetap seperti semula
// jika login.php punya fungsi flash yang sama, pastikan ia membaca $_SESSION['flash'])
// Tampilkan flash error (jika ada)
if (!empty($_SESSION['flash']['error'])): ?>
  <div class="alert alert-danger py-2" role="alert">
    <?= htmlspecialchars($_SESSION['flash']['error']) ?>
  </div>
<?php unset($_SESSION['flash']['error']); endif; ?>

<?php if (!empty($_SESSION['flash']['success'])): ?>
  <div class="alert alert-success py-2" role="alert">
    <?= htmlspecialchars($_SESSION['flash']['success']) ?>
  </div>
<?php unset($_SESSION['flash']['success']); endif; ?>
<!-- Login hero (styling follows homepage look) -->
<section class="hero text-center text-white d-flex align-items-center justify-content-center" style="min-height:60vh; background: linear-gradient(180deg, rgba(13,110,253,0.08), rgba(13,110,253,0.02));">
  <div class="w-100 mt-5 d-flex justify-content-center" style="max-width:920px;">

      <div class="col-md-6">
        <div class="card shadow-lg rounded-3" style="background: rgba(255,255,255,0.95);">
          <div class="card-body p-4">
            <?php if (!empty($errors['general'])): ?>
              <div class="alert alert-danger py-2" role="alert"><?= htmlspecialchars($errors['general']) ?></div>
            <?php endif; ?>
            <?php if ($msg = flash('success')): ?>
              <div class="alert alert-success py-2" role="alert"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>

            <form method="post" action="../model/sistem_login.php" novalidate>
              <div class="mt-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control <?= isset($errors['nim']) ? 'is-invalid' : '' ?>" id="nim" name="nim" value="<?= htmlspecialchars($old['nim']) ?>" placeholder="masukkan nim">
                <?php if (isset($errors['nim'])): ?>
                  <div class="invalid-feedback"><?= htmlspecialchars($errors['nim']) ?></div>
                <?php endif; ?>
              </div>

              <div class="mt-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="masukkan kata sandi">
                <?php if (isset($errors['password'])): ?>
                  <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
                <?php endif; ?>
              </div>

              <div class="mt-3">
                <button type="submit" class="btn btn-primary btn-lg fw-semibold">Masuk</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require_once("../includes/footer.php")
?>