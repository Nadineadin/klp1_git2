<?php
// admin/ekstrakurikuler/create.php
$title = "Tambah Ekstrakurikuler";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require("../../includes/header.php");
require("../../includes/admin_navbar.php");
require_nim_allow('240209501084');

$errors = [];
$old = ['nama'=>'','deskripsi'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['nama'] = trim($_POST['nama'] ?? '');
    $old['deskripsi'] = trim($_POST['deskripsi'] ?? '');

    if ($old['nama'] === '') $errors['nama'] = 'Nama wajib diisi.';

    // handle gambar
    $gambar = null;
    if (!empty($_FILES['gambar']['name'])) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','webp'];
        if (!in_array(strtolower($ext), $allowed)) {
            $errors['gambar'] = 'Tipe gambar tidak didukung.';
        } else {
            $dest_dir = __DIR__ . '/../../assets/images/ekstrakurikuler/';
            if (!is_dir($dest_dir)) mkdir($dest_dir, 0755, true);
            $fname = uniqid('ekstra_') . '.' . $ext;
            $target = $dest_dir . $fname;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                $gambar = $fname;
            } else {
                $errors['gambar'] = 'Gagal mengunggah gambar.';
            }
        }
    }

    if (empty($errors)) {
        $sql = "INSERT INTO ekstrakurikuler (nama, deskripsi, gambar) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('sss', $old['nama'], $old['deskripsi'], $gambar);
        if ($stmt->execute()) {
            $_SESSION['flash']['success'] = 'Ekstrakurikuler berhasil ditambahkan.';
            header('Location: index.php');
            exit;
        } else {
            $errors['general'] = 'Gagal menyimpan: ' . $mysqli->error;
        }
    }
}
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container my-5">
      <h3 class="text-primary mb-3">Tambah Ekstrakurikuler</h3>
      <div class="card border-primary shadow-sm">
        <div class="card-body">
          <?php if (!empty($errors['general'])): ?><div class="alert alert-danger"><?=htmlspecialchars($errors['general'])?></div><?php endif; ?>

          <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input name="nama" class="form-control <?=isset($errors['nama']) ? 'is-invalid' : ''?>" value="<?=htmlspecialchars($old['nama'])?>">
              <?php if (isset($errors['nama'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['nama'])?></div><?php endif; ?>
            </div>

            <div class="mb-3">
              <label class="form-label">Deskripsi</label>
              <textarea name="deskripsi" class="form-control"><?=htmlspecialchars($old['deskripsi'])?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Gambar (opsional)</label>
              <input type="file" name="gambar" class="form-control <?=isset($errors['gambar']) ? 'is-invalid' : ''?>">
              <?php if (isset($errors['gambar'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['gambar'])?></div><?php endif; ?>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </main>
<?php require_once("../../includes/footer.php"); ?>
</div>
