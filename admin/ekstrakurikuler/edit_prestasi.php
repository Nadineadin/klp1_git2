<?php
// admin/ekstrakurikuler/edit_prestasi.php
$title = "Edit Prestasi Ekstrakurikuler";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require_nim_allow('240209501084');
require("../../includes/header.php");
require("../../includes/admin_navbar.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$ekid = isset($_GET['ek']) ? (int)$_GET['ek'] : 0;
if (!$id || !$ekid) { header("Location: index.php"); exit; }

$stmt = $mysqli->prepare("SELECT * FROM ekstra_prestasi WHERE id=? AND ekstrakurikuler_id=? LIMIT 1");
$stmt->bind_param('ii',$id,$ekid);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();
if (!$row) { $_SESSION['flash']['success']='Prestasi tidak ditemukan.'; header("Location: info.php?id=$ekid"); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $prestasi = trim($_POST['prestasi'] ?? '');
  $tahun = trim($_POST['tahun'] ?? '');

  if ($prestasi === '') $errors[] = 'Judul prestasi wajib diisi.';

  // file handling (max 2MB)
  if (!empty($_FILES['gambar']['name'])) {
    if ($_FILES['gambar']['size'] > 2*1024*1024) $errors[] = 'Gambar maksimal 2MB.';
    $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg','jpeg','png','webp'])) $errors[] = 'Tipe gambar tidak didukung.';
    if (empty($errors)) {
      $dest = __DIR__.'/../../assets/images/prestasi/';
      if (!is_dir($dest)) mkdir($dest,0755,true);
      $fname = uniqid('eksprest_').'.'.$ext;
      if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $dest.$fname)) $errors[] = 'Gagal mengunggah gambar.';
      else {
        // hapus lama
        if (!empty($row['gambar']) && file_exists($dest.$row['gambar'])) @unlink($dest.$row['gambar']);
        $row['gambar'] = $fname;
      }
    }
  }

  if (empty($errors)) {
    $u = $mysqli->prepare("UPDATE ekstra_prestasi SET prestasi=?, tahun=?, gambar=? WHERE id=? AND ekstrakurikuler_id=?");
    $u->bind_param('ssiii', $prestasi, $tahun, $row['gambar'], $id, $ekid); // note: adjust types if gambar nullable
    if ($u->execute()) {
      $_SESSION['flash']['success'] = 'Prestasi diperbarui.';
      header("Location: info.php?id=$ekid"); exit;
    } else {
      $errors[] = 'Gagal update: ' . $mysqli->error;
    }
  }
}
?>

<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container my-5 card border-primary shadow-sm p-4">
      <h3>Edit Prestasi</h3>
      <?php foreach($errors as $e): ?><div class="alert alert-danger"><?=htmlspecialchars($e)?></div><?php endforeach; ?>
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3"><label>Judul</label><input name="prestasi" class="form-control" value="<?=htmlspecialchars($row['prestasi'])?>"></div>
        <div class="mb-3"><label>Tahun</label><input name="tahun" class="form-control" value="<?=htmlspecialchars($row['tahun'])?>"></div>
        <button class="btn btn-primary">Simpan</button>
        <a class="btn btn-secondary" href="info.php?id=<?=$ekid?>">Batal</a>
      </form>
    </div>
  </main>
<?php require_once("../../includes/footer.php"); ?>
</div>