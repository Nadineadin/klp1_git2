<?php
// admin/fasilitas/edit.php
$title = "Edit Fasilitas";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require("../../includes/header.php");
require("../../includes/admin_navbar.php");
require_nim_allow('240209501089');

$id = $_GET['id'] ?? '';
if ($id === '') { header('Location: index.php'); exit; }

$stmt = $mysqli->prepare("SELECT * FROM fasilitas WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$old = $res->fetch_assoc();
$stmt->close();
if (!$old) { $_SESSION['flash']['success']='Data tidak ditemukan.'; header('Location:index.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_fasilitas = trim($_POST['nama_fasilitas'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');
    $jumlah = (int) ($_POST['jumlah'] ?? 1);

    if ($nama_fasilitas === '') $errors['nama_fasilitas'] = 'Nama fasilitas wajib diisi.';
    if ($jumlah < 1) $errors['jumlah'] = 'Jumlah minimal 1.';

    // handle image replace
    $gambar = $old['gambar'];
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
                // hapus file lama jika ada
                if (!empty($old['gambar']) && file_exists($dest_dir . $old['gambar'])) {
                    @unlink($dest_dir . $old['gambar']);
                }
                $gambar = $fname;
            } else {
                $errors['gambar'] = 'Gagal mengunggah gambar.';
            }
        }
    }

    if (empty($errors)) {
        $sql = "UPDATE fasilitas SET nama_fasilitas=?, keterangan=?, jumlah=?, gambar=? WHERE id=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ssisi', $nama_fasilitas, $keterangan, $jumlah, $gambar, $id);
        if ($stmt->execute()) {
            $_SESSION['flash']['success'] = 'Fasilitas berhasil diperbarui.';
            header('Location: index.php');
            exit;
        } else {
            $errors['general'] = 'Gagal update: ' . $mysqli->error;
        }
    }

    $old = array_merge($old, [
        'nama_fasilitas'=>$nama_fasilitas, 'keterangan'=>$keterangan, 'jumlah'=>$jumlah, 'gambar'=>$gambar
    ]);
}
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container my-5">
      <h3 class="text-primary mb-3">Edit Fasilitas</h3>
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
              <label class="form-label">Gambar (ganti jika perlu)</label>
              <?php if (!empty($old['gambar']) && file_exists(__DIR__.'/../../assets/images/fasilitas/'.$old['gambar'])): ?>
                <div class="mb-2"><img src="<?= $base_url ?>/assets/images/fasilitas/<?=htmlspecialchars($old['gambar'])?>" style="width:120px; height:120px; object-fit:cover; border-radius:6px;"></div>
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
  </main>
<?php require_once("../../includes/footer.php"); ?>
</div>