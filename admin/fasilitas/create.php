<?php
// admin/fasilitas/create.php
$title = "Tambah Fasilitas";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require("../../includes/header.php");
require("../../includes/admin_navbar.php");
require_nim_allow('240209501089');

$errors = [];
$old = ['nama_fasilitas'=>'','keterangan'=>'','jumlah'=>'1'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['nama_fasilitas'] = trim($_POST['nama_fasilitas'] ?? '');
    $old['keterangan'] = trim($_POST['keterangan'] ?? '');
    $old['jumlah'] = (int) ($_POST['jumlah'] ?? 1);

    if ($old['nama_fasilitas'] === '') $errors['nama_fasilitas'] = 'Nama fasilitas wajib diisi.';
    if ($old['jumlah'] < 1) $errors['jumlah'] = 'Jumlah minimal 1.';

    // handle gambar
    $gambar = null;
    if (!empty($_FILES['gambar']['name'])) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','webp'];
        if (!in_array(strtolower($ext), $allowed)) {
            $errors['gambar'] = 'Tipe gambar tidak didukung.';
        } else {
            $dest_dir = __DIR__ . '/../../assets/images/fasilitas/';
            if (!is_dir($dest_dir)) mkdir($dest_dir, 0755, true);
            $fname = uniqid('fas_') . '.' . $ext;
            $target = $dest_dir . $fname;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                $gambar = $fname;
            } else {
                $errors['gambar'] = 'Gagal mengunggah gambar.';
            }
        }
    }

    if (empty($errors)) {
        $sql = "INSERT INTO fasilitas (nama_fasilitas, keterangan, jumlah, gambar) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ssis', $old['nama_fasilitas'], $old['keterangan'], $old['jumlah'], $gambar);
        if ($stmt->execute()) {
            $_SESSION['flash']['success'] = 'Fasilitas berhasil ditambahkan.';
            header('Location: index.php');
            exit;
        } else {
            $errors['general'] = 'Gagal menyimpan ke database: ' . $mysqli->error;
        }
    }
}
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container my-5">
      <h3 class="text-primary mb-3">Tambah Fasilitas</h3>
      <div class="card border-primary shadow-sm">
        <div class="card-body">
          <?php if (!empty($errors['general'])): ?><div class="alert alert-danger"><?=htmlspecialchars($errors['general'])?></div><?php endif; ?>

          <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label">Nama Fasilitas</label>
              <input name="nama_fasilitas" class="form-control <?=isset($errors['nama_fasilitas']) ? 'is-invalid' : ''?>" value="<?=htmlspecialchars($old['nama_fasilitas'])?>">
              <?php if (isset($errors['nama_fasilitas'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['nama_fasilitas'])?></div><?php endif; ?>
            </div>

            <div class="mb-3">
              <label class="form-label">Keterangan</label>
              <textarea name="keterangan" class="form-control"><?=htmlspecialchars($old['keterangan'])?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Jumlah</label>
              <input type="number" name="jumlah" class="form-control <?=isset($errors['jumlah']) ? 'is-invalid' : ''?>" value="<?=htmlspecialchars($old['jumlah'])?>">
              <?php if (isset($errors['jumlah'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['jumlah'])?></div><?php endif; ?>
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