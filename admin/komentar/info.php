<?php
// admin/komentar/info.php
$title = "Detail Komentar";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require("../../includes/header.php");
require("../../includes/admin_navbar.php");

require_nim_allow('240209501093');

$nama = $_GET['nama'] ?? '';
$email = $_GET['email'] ?? '';
if ($nama === '' || $email === '') {
    $_SESSION['flash']['success'] = 'Parameter tidak lengkap.';
    header('Location: index.php'); exit;
}

// aman: gunakan prepared statement, meskipun kolom bukan unik di skema ini
$stmt = $mysqli->prepare("SELECT Nama_Lengkap, email, pesan FROM komentar WHERE Nama_Lengkap = ? AND email = ? LIMIT 1");
$stmt->bind_param('ss', $nama, $email);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if (!$row) {
    $_SESSION['flash']['success'] = 'Komentar tidak ditemukan.';
    header('Location: index.php'); exit;
}
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container my-5">
      <div class="card border-primary shadow-sm">
        <div class="card-body">
          <h3 class="text-primary">Komentar dari <?=htmlspecialchars($row['Nama_Lengkap'])?></h3>
          <table class="table table-borderless">
            <tr><th>Nama</th><td><?=htmlspecialchars($row['Nama_Lengkap'])?></td></tr>
            <tr><th>Email</th><td><?=htmlspecialchars($row['email'])?></td></tr>
            <tr><th>Pesan</th><td><?=nl2br(htmlspecialchars($row['pesan']))?></td></tr>
          </table>

          <a href="index.php" class="btn btn-secondary">Kembali</a>
          <a href="delete.php?nama=<?=urlencode($row['Nama_Lengkap'])?>&email=<?=urlencode($row['email'])?>" class="btn btn-danger" onclick="return confirm('Hapus komentar ini?')">Hapus</a>
        </div>
      </div>
    </div>
  </main>
  <?php require_once("../../includes/footer.php"); ?>
</div>
