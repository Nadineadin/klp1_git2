<?php
// admin/index.php
$title = "Dashboard Anggota";
if (session_status() === PHP_SESSION_NONE) session_start();

require_once("../includes/config.php");
require("../includes/db_connect.php");
require('../includes/auth.php'); // pastikan file ini mengecek session login
require("../includes/header.php");
require("../includes/admin_navbar.php");

// Ambil nim dari session (di-set saat login)
$nim_session = $_SESSION['user']['nim'] ?? '';

if ($nim_session === '') {
    // jika tidak login atau session tidak berisi nim, redirect ke login
    $_SESSION['flash']['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../pages/login.php');
    exit;
}

// Ambil data anggota sesuai nim session
$stmt = $mysqli->prepare("SELECT nim, nama, kelas, alamat, asal_sekolah, motto, pengalaman, gambar FROM anggota WHERE nim = ? LIMIT 1");
if (!$stmt) {
    $_SESSION['flash']['error'] = 'Terjadi kesalahan server: ' . $mysqli->error;
    // tetap tampilkan halaman kosong dengan pesan
    $row = null;
} else {
    $stmt->bind_param('s', $nim_session);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
}

?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill d-flex justify-content-center align-items-center">
    <div class="container my-5">
      <div class="card border-primary shadow-sm">
        <div class="card-body">
          <h3 class="text-primary">Detail: <?=htmlspecialchars($row['nama'])?></h3>
          <div class="row">
            <div class="col-md-4">
              <?php if (!empty($row['gambar'])): ?>
                <img src="<?= '/klp1pemrogweb/assets/images/mahasiswa/' . htmlspecialchars($row['gambar']) ?>" class="img-fluid rounded" alt="foto">
              <?php else: ?>
                <div class="border p-5 text-center text-muted">Tidak ada gambar</div>
              <?php endif; ?>
            </div>
            <div class="col-md-8">
              <table class="table table-borderless">
                <tr><th>NIM</th><td><?=htmlspecialchars($row['nim'])?></td></tr>
                <tr><th>Nama</th><td><?=htmlspecialchars($row['nama'])?></td></tr>
                <tr><th>Kelas</th><td><?=htmlspecialchars($row['kelas'])?></td></tr>
                <tr><th>Alamat</th><td><?=htmlspecialchars($row['alamat'])?></td></tr>
                <tr><th>Asal Sekolah</th><td><?=htmlspecialchars($row['asal_sekolah'])?></td></tr>
                <tr><th>Motto</th><td><?=nl2br(htmlspecialchars($row['motto']))?></td></tr>
                <tr><th>Pengalaman</th><td><?=nl2br(htmlspecialchars($row['pengalaman']))?></td></tr>
                <tr><th>Dibuat</th><td><?=htmlspecialchars($row['created_at'] ?? '-')?></td></tr>
              </table>
              <a href="edit.php?nim=<?=urlencode($row['nim'])?>" class="btn btn-warning">Edit</a>
              <a href="../index.php" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
<?php require_once("../includes/footer.php"); ?>
</div>
