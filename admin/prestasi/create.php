<?php
// admin/prestasi/create.php
$title = "Tambah Prestasi";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require("../../includes/header.php");
require("../../includes/admin_navbar.php");

require_nim_allow('240209501094');

$errors = [];
$old = ['nama_siswa'=>'','judul_prestasi'=>'','tingkat'=>'','tahun'=>'','deskripsi'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['nama_siswa'] = trim($_POST['nama_siswa'] ?? '');
    $old['judul_prestasi'] = trim($_POST['judul_prestasi'] ?? '');
    $old['tingkat'] = trim($_POST['tingkat'] ?? '');
    $old['tahun'] = trim($_POST['tahun'] ?? '');
    $old['deskripsi'] = trim($_POST['deskripsi'] ?? '');

    if ($old['nama_siswa'] === '') $errors['nama_siswa'] = 'Nama / Tim wajib diisi.';
    if ($old['judul_prestasi'] === '') $errors['judul_prestasi'] = 'Judul prestasi wajib diisi.';

    // handle gambar
    $gambar = null;
    if (!empty($_FILES['gambar']['name'])) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','webp'];
        if (!in_array(strtolower($ext), $allowed)) {
            $errors['gambar'] = 'Tipe gambar tidak didukung.';
        } else {
            $dest_dir = __DIR__ . '/../../assets/images/prestasi/';
            if (!is_dir($dest_dir)) mkdir($dest_dir, 0755, true);
            $fname = uniqid('prest_') . '.' . $ext;
            $target = $dest_dir . $fname;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                $gambar = $fname;
            } else {
                $errors['gambar'] = 'Gagal mengunggah gambar.';
            }
        }
    }

    if (empty($errors)) {
        $sql = "INSERT INTO prestasi_siswa (nama_siswa, judul_prestasi, tingkat, tahun, deskripsi, gambar) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ssssss', $old['nama_siswa'], $old['judul_prestasi'], $old['tingkat'], $old['tahun'], $old['deskripsi'], $gambar);
        if ($stmt->execute()) {
            $_SESSION['flash']['success'] = 'Prestasi berhasil ditambahkan.';
            header('Location: index.php');
            exit;
        } else {
            $errors['general'] = 'Gagal menyimpan ke database: ' . $mysqli->error;
        }
    }
}
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill d-flex justify-content-center align-items-center">
    <div class="container my-5">
      <h3 class="text-primary mb-3">Tambah Prestasi</h3>
      <div class="card border-primary shadow-sm">
        <div class="card-body">
          <?php if (!empty($errors['general'])): ?><div class="alert alert-danger"><?=htmlspecialchars($errors['general'])?></div><?php endif; ?>

          <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label">Nama / Tim</label>
              <input name="nama_siswa" class="form-control <?=isset($errors['nama_siswa']) ? 'is-invalid' : ''?>" value="<?=htmlspecialchars($old['nama_siswa'])?>">
              <?php if (isset($errors['nama_siswa'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['nama_siswa'])?></div><?php endif; ?>
            </div>

            <div class="mb-3">
              <label class="form-label">Judul Prestasi</label>
              <input name="judul_prestasi" class="form-control <?=isset($errors['judul_prestasi']) ? 'is-invalid' : ''?>" value="<?=htmlspecialchars($old['judul_prestasi'])?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Tingkat (mis. Sekolah/Provinsi/Nasional)</label>
              <input name="tingkat" class="form-control" value="<?=htmlspecialchars($old['tingkat'])?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Tahun (YYYY)</label>
              <input name="tahun" class="form-control" value="<?=htmlspecialchars($old['tahun'])?>">
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
