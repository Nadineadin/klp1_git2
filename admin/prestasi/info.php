<?php
// admin/prestasi/info.php
$title = "Info Prestasi";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require("../../includes/header.php");
require("../../includes/admin_navbar.php");

require_nim_allow('240209501094');

$id = $_GET['id'] ?? '';
if ($id === '') {
    header('Location: index.php'); exit;
}
$stmt = $mysqli->prepare("SELECT * FROM prestasi_siswa WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();
if (!$row) {
    $_SESSION['flash']['success'] = 'Data tidak ditemukan.';
    header('Location: index.php');
    exit;
}
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill d-flex justify-content-center align-items-center">
    <div class="container my-5">
      <div class="card border-primary shadow-sm">
        <div class="card-body">
          <h3 class="text-primary">Detail: <?=htmlspecialchars($row['judul_prestasi'])?></h3>
          <div class="row">
            <div class="col-md-4">
              <?php if (!empty($row['gambar']) && file_exists(__DIR__.'/../../assets/images/prestasi/'.$row['gambar'])): ?>
                <img src="<?= $base_url ?>/assets/images/prestasi/<?= htmlspecialchars($row['gambar']) ?>" class="img-fluid rounded" alt="foto">
              <?php else: ?>
                <div class="border p-5 text-center text-muted">Tidak ada gambar</div>
              <?php endif; ?>
            </div>
            <div class="col-md-8">
              <table class="table table-borderless">
                <tr><th>ID</th><td><?=htmlspecialchars($row['id'])?></td></tr>
                <tr><th>Nama / Tim</th><td><?=htmlspecialchars($row['nama_siswa'])?></td></tr>
                <tr><th>Judul</th><td><?=htmlspecialchars($row['judul_prestasi'])?></td></tr>
                <tr><th>Tingkat</th><td><?=htmlspecialchars($row['tingkat'])?></td></tr>
                <tr><th>Tahun</th><td><?=htmlspecialchars($row['tahun'])?></td></tr>
                <tr><th>Deskripsi</th><td><?=nl2br(htmlspecialchars($row['deskripsi']))?></td></tr>
                <tr><th>Dibuat</th><td><?=htmlspecialchars($row['created_at'] ?? '-')?></td></tr>
              </table>
              <a href="edit.php?id=<?=urlencode($row['id'])?>" class="btn btn-warning">Edit</a>
              <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
<?php require_once("../../includes/footer.php"); ?>
</div>
