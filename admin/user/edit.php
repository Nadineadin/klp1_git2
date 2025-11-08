<?php
// admin/user/edit.php
$title = "Edit Anggota";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require("../../includes/header.php");
require('../../includes/auth.php');
require_nim_allow('240209501085');

$nim = $_GET['nim'] ?? '';
if ($nim === '') { header('Location: index.php'); exit; }

$stmt = $mysqli->prepare("SELECT * FROM anggota WHERE nim = ? LIMIT 1");
$stmt->bind_param('s', $nim);
$stmt->execute();
$res = $stmt->get_result();
$old = $res->fetch_assoc();
$stmt->close();
if (!$old) { $_SESSION['flash']['success']='Data tidak ditemukan.'; header('Location:index.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $asal_sekolah = trim($_POST['asal_sekolah'] ?? '');
    $motto = trim($_POST['motto'] ?? '');
    $pengalaman = trim($_POST['pengalaman'] ?? '');

    if ($nama === '') $errors['nama'] = 'Nama wajib diisi.';

    // handle image replace
    $gambar_path = $old['gambar'];
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
                // hapus file lama jika ada
                if (!empty($old['gambar']) && file_exists(__DIR__ . '/../../' . $old['gambar'])) {
                    @unlink(__DIR__ . '/../../' . $old['gambar']);
                }
                $gambar_path = 'assets/images/mahasiswa/' . $fname;
            } else {
                $errors['gambar'] = 'Gagal mengunggah gambar.';
            }
        }
    }

    if (empty($errors)) {
        $sql = "UPDATE anggota SET nama=?, kelas=?, alamat=?, asal_sekolah=?, motto=?, pengalaman=?, gambar=? WHERE nim=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ssssssss', $nama, $kelas, $alamat, $asal_sekolah, $motto, $pengalaman, $gambar_path, $nim);
        if ($stmt->execute()) {
            $_SESSION['flash']['success'] = 'Data berhasil diperbarui.';
            header('Location: index.php');
            exit;
        } else {
            $errors['general'] = 'Gagal update: ' . $mysqli->error;
        }
    }
    // jika error, tampilkan form lagi; gunakan posted values jika ada
    $old = array_merge($old, [
        'nama'=>$nama, 'kelas'=>$kelas, 'alamat'=>$alamat, 'asal_sekolah'=>$asal_sekolah,
        'motto'=>$motto, 'pengalaman'=>$pengalaman, 'gambar'=>$gambar_path
    ]);
}
?>
<div class="container my-5">
  <h3 class="text-primary mb-3">Edit Anggota</h3>
  <div class="card border-primary shadow-sm">
    <div class="card-body">
      <?php if (!empty($errors['general'])): ?><div class="alert alert-danger"><?=htmlspecialchars($errors['general'])?></div><?php endif; ?>
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">NIM</label>
          <input class="form-control" value="<?=htmlspecialchars($old['nim'])?>" readonly>
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
          <label class="form-label">Pengalaman</label>
          <textarea name="pengalaman" class="form-control"><?=htmlspecialchars($old['pengalaman'])?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Gambar (ganti jika perlu)</label>
          <?php if (!empty($old['gambar']) && file_exists(__DIR__.'/../../'.$old['gambar'])): ?>
            <div class="mb-2"><img src="<?= '/klp1pemrogweb/' . htmlspecialchars($old['gambar']) ?>" style="width:120px; height:120px; object-fit:cover; border-radius:6px;"></div>
          <?php endif; ?>
          <input type="file" name="gambar" class="form-control <?=isset($errors['gambar']) ? 'is-invalid' : ''?>">
          <?php if (isset($errors['gambar'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['gambar'])?></div><?php endif; ?>
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
<?php require_once("../../includes/footer.php"); ?>
