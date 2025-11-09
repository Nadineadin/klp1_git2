<?php
// admin/komentar/index.php
$title = "Daftar Komentar";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require("../../includes/header.php");
require("../../includes/admin_navbar.php");

// siapa yang boleh akses (ubah NIM jika perlu)
require_nim_allow('240209501093');
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container my-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Komentar Masuk</h2>
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
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Pesan (preview)</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $q = "SELECT Nama_Lengkap, email, pesan FROM komentar ORDER BY Nama_Lengkap";
                $res = $mysqli->query($q);
                $no = 1;
                while ($row = $res->fetch_assoc()):
                ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($row['Nama_Lengkap']) ?></td>
                  <td><?= htmlspecialchars($row['email']) ?></td>
                  <td><?= htmlspecialchars(strlen($row['pesan']) > 60 ? substr($row['pesan'],0,60).'...' : $row['pesan']) ?></td>
                  <td>
                    <a href="info.php?nama=<?= urlencode($row['Nama_Lengkap']) ?>&email=<?= urlencode($row['email']) ?>" class="btn btn-sm btn-info">Info</a>
                    <a href="delete.php?nama=<?= urlencode($row['Nama_Lengkap']) ?>&email=<?= urlencode($row['email']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus komentar ini?')">Delete</a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
            <?php if ($res->num_rows === 0): ?>
              <div class="text-center text-muted p-3">Belum ada komentar.</div>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </div>
  </main>
<?php require_once("../../includes/footer.php"); ?>
</div>
