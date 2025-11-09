<?php
// admin/ekstrakurikuler/edit_kegiatan.php
$title = "Edit Kegiatan Ekstrakurikuler";
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

$err = '';
// ambil data
$stmt = $mysqli->prepare("SELECT id, kegiatan FROM ekstra_kegiatan WHERE id=? AND ekstrakurikuler_id=? LIMIT 1");
$stmt->bind_param('ii',$id,$ekid);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();
if (!$row) { $_SESSION['flash']['success']='Kegiatan tidak ditemukan.'; header("Location: info.php?id=$ekid"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $keg = trim($_POST['kegiatan'] ?? '');
  if ($keg === '') { $err = 'Kegiatan tidak boleh kosong.'; }
  else {
    $u = $mysqli->prepare("UPDATE ekstra_kegiatan SET kegiatan = ? WHERE id = ? AND ekstrakurikuler_id = ?");
    $u->bind_param('sii', $keg, $id, $ekid);
    if ($u->execute()) {
      $_SESSION['flash']['success'] = 'Kegiatan diperbarui.';
      header("Location: info.php?id=$ekid"); exit;
    } else {
      $err = 'Gagal update: ' . $mysqli->error;
    }
  }
}
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container my-5 card border-primary shadow-sm p-4">
      <h3>Edit Kegiatan</h3>
      <?php if ($err): ?><div class="alert alert-danger"><?=htmlspecialchars($err)?></div><?php endif; ?>
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Kegiatan</label>
          <input name="kegiatan" class="form-control" value="<?=htmlspecialchars($row['kegiatan'])?>">
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a class="btn btn-secondary" href="info.php?id=<?=$ekid?>">Batal</a>
      </form>
    </div>
  </main>
<?php require_once("../../includes/footer.php"); ?>
</div>