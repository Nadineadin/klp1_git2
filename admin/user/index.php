<?php
// admin/user/index.php
$title = "Admin Nadin - Daftar Anggota";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require("../../includes/header.php");
require('../../includes/auth.php');
require_nim_allow('240209501085');
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" >
  <div class="container">
    <a class="navbar-brand" href="/klp1pemrogweb/" style="color:white;">My App</a>

    <div class="ms-auto d-flex align-items-center">
      <?php if (!empty($_SESSION['user']['nim'])): ?>
        <span class="me-2" style="color:white;">Hi, <?= htmlspecialchars($_SESSION['user']['nim']) ?></span>
        <a href="/klp1pemrogweb/pages/logout.php" class="btn btn-outline-primary btn-sm" style="color:white;">Logout</a>
      <?php else: ?>
        <a href="/klp1pemrogweb/pages/login.php" class="btn btn-primary btn-sm" style="color:white;">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="text-primary">Daftar Anggota</h2>
    <a href="create.php" class="btn btn-primary">Tambah Anggota</a>
  </div>

  <div class="card border-primary shadow-sm">
    <div class="card-body">
      <?php if (!empty($_SESSION['flash']['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash']['success']); unset($_SESSION['flash']['success']); ?></div>
      <?php endif; ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="table-primary">
            <tr>
              <th>#</th>
              <th>NIM</th>
              <th>Nama</th>
              <th>Kelas</th>
              <th>Asal Sekolah</th>
              <th>Gambar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $q = "SELECT nim, nama, kelas, asal_sekolah, gambar FROM anggota ORDER BY nama";
            $res = $mysqli->query($q);
            $no = 1;
            while ($row = $res->fetch_assoc()):
            ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['nim']) ?></td>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= htmlspecialchars($row['kelas']) ?></td>
              <td><?= htmlspecialchars($row['asal_sekolah']) ?></td>
              <td>
                <?php if (!empty($row['gambar']) && file_exists(__DIR__ . '/../../' . $row['gambar'])): ?>
                  <img src="<?= htmlspecialchars('/klp1pemrogweb/' . $row['gambar']) ?>" alt="foto" style="width:64px; height:64px; object-fit:cover; border-radius:6px;">
                <?php else: ?>
                  <span class="text-muted small">-</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="info.php?nim=<?= urlencode($row['nim']) ?>" class="btn btn-sm btn-info">Info</a>
                <a href="edit.php?nim=<?= urlencode($row['nim']) ?>" class="btn btn-sm btn-warning text-white">Edit</a>
                <a href="delete.php?nim=<?= urlencode($row['nim']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus anggota ini?')">Delete</a>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php require_once("../../includes/footer.php"); ?>
