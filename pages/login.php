<?php
$title = "Login";
require_once("../includes/config.php");
require("../includes/db_connect.php");
require("../includes/header.php"); 
session_start();

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
$old = ['username' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['username'] = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($old['username'] === '') $errors['username'] = 'Masukkan username atau email.';
    if ($password === '') $errors['password'] = 'Masukkan kata sandi.';

    if (empty($errors)) {
        // ===== DEMO AUTH (replace this block with DB lookup & password_verify) =====
        // Example hardcoded credential (for demo only)
        $demo_user = 'admin';
        $demo_pass = 'password123'; // in real app, never store plain text

        if ($old['username'] === $demo_user && $password === $demo_pass) {
            // login successful
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'username' => $demo_user,
                'display_name' => 'Administrator'
            ];
            flash('success', 'Login berhasil. Selamat datang!');
            header('Location: index.php');
            exit;
        } else {
            $errors['general'] = 'Username atau password salah.';
        }
        // =======================================================================
    }
}
?>

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

            <form method="post" novalidate>
              <div class="mt-3">
                <label for="username" class="form-label">Username atau Email</label>
                <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= htmlspecialchars($old['username']) ?>" placeholder="masukkan username atau email">
                <?php if (isset($errors['username'])): ?>
                  <div class="invalid-feedback"><?= htmlspecialchars($errors['username']) ?></div>
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