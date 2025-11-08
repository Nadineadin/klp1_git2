<?php
// admin/user/create.php
$title = "Tambah Anggota";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require("../../includes/header.php");
require('../../includes/auth.php');
require_nim_allow('240209501085');

$errors = [];
$old = ['nim'=>'','nama'=>'','kelas'=>'','alamat'=>'','asal_sekolah'=>'','motto'=>'','pengalaman'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['nim'] = trim($_POST['nim'] ?? '');
    $old['nama'] = trim($_POST['nama'] ?? '');
    $old['kelas'] = trim($_POST['kelas'] ?? '');
    $old['alamat'] = trim($_POST['alamat'] ?? '');
    $old['asal_sekolah'] = trim($_POST['asal_sekolah'] ?? '');
    $old['motto'] = trim($_POST['motto'] ?? '');
    $old['pengalaman'] = trim($_POST['pengalaman'] ?? '');

    if ($old['nim'] === '') $errors['nim'] = 'NIM wajib diisi.';
    if ($old['nama'] === '') $errors['nama'] = 'Nama wajib diisi.';

    // handle gambar
    $gambar_path = null;
    if (!empty($_FILES['gambar']['name'])) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','webp'];
        if (!in_array(strtolower($ext), $allowed)) {
            $errors['gambar'] = 'Tipe gambar tidak didukung.';
        } else {
            $dest_dir = __DIR__ . '/../../assets/images/mahasiswa/';
            if (!is_dir($dest_dir)) mkdir($dest_dir, 0755, true);
            $fname = uniqid('mhs_') . '.' . $ext;
            $target = $dest_dir . $fname;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                // simpan relative path dari root project
                $gambar_path = 'assets/images/mahasiswa/' . $fname;
            } else {
                $errors['gambar'] = 'Gagal mengunggah gambar.';
            }
        }
    }

    if (empty($errors)) {
        $sql = "INSERT INTO anggota (nim,nama,kelas,alamat,asal_sekolah,motto,pengalaman,gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ssssssss', $old['nim'],$old['nama'],$old['kelas'],$old['alamat'],$old['asal_sekolah'],$old['motto'],$old['pengalaman'],$gambar_path);
        if ($stmt->execute()) {
            $_SESSION['flash']['success'] = 'Anggota berhasil ditambahkan.';
            header('Location: index.php');
            exit;
        } else {
            $errors['general'] = 'Gagal menyimpan ke database: ' . $mysqli->error;
        }
    }
}
?>
<div class="container my-5">
  <h3 class="text-primary mb-3">Tambah Anggota</h3>
  <div class="card border-primary shadow-sm">
    <div class="card-body">
      <?php if (!empty($errors['general'])): ?><div class="alert alert-danger"><?=htmlspecialchars($errors['general'])?></div><?php endif; ?>

      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">NIM</label>
          <input name="nim" class="form-control <?=isset($errors['nim']) ? 'is-invalid' : ''?>" value="<?=htmlspecialchars($old['nim'])?>">
          <?php if (isset($errors['nim'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['nim'])?></div><?php endif; ?>
        </div>

        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input name="nama" class="form-control <?=isset($errors['nama']) ? 'is-invalid' : ''?>" value="<?=htmlspecialchars($old['nama'])?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Kelas</label>
          <input name="kelas" class="form-control" value="<?=htmlspecialchars($old['kelas'])?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Alamat</label>
          <input name="alamat" class="form-control" value="<?=htmlspecialchars($old['alamat'])?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Asal Sekolah</label>
          <input name="asal_sekolah" class="form-control" value="<?=htmlspecialchars($old['asal_sekolah'])?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Motto</label>
          <input name="motto" class="form-control" value="<?=htmlspecialchars($old['motto'])?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Pengalaman (ringkas)</label>
          <textarea name="pengalaman" class="form-control"><?=htmlspecialchars($old['pengalaman'])?></textarea>
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

<?php require_once("../../includes/footer.php"); ?>
