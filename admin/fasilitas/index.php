<?php
// admin/fasilitas/index.php
$title = "Daftar Fasilitas";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require("../../includes/header.php");
require("../../includes/admin_navbar.php");
require_nim_allow('240209501089');
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container my-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Daftar Fasilitas</h2>
        <a href="create.php" class="btn btn-primary">Tambah Fasilitas</a>
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
                  <th>Nama Fasilitas</th>
                  <th>Jumlah</th>
                  <th>Gambar</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $q = "SELECT id, nama_fasilitas, jumlah, gambar FROM fasilitas ORDER BY nama_fasilitas";
                $res = $mysqli->query($q);
                $no = 1;
                while ($row = $res->fetch_assoc()):
                ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($row['nama_fasilitas']) ?></td>
                  <td><?= htmlspecialchars($row['jumlah']) ?></td>
                  <td>
                    <?php if (!empty($row['gambar']) && file_exists(__DIR__ . '/../../assets/images/fasilitas/' . $row['gambar'])): ?>
                      <img src="<?= $base_url ?>/assets/images/fasilitas/<?= htmlspecialchars($row['gambar']) ?>" alt="foto" style="width:64px; height:64px; object-fit:cover; border-radius:6px;">
                    <?php else: ?>
                      <span class="text-muted small">-</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="info.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-info">Info</a>
                    <a href="edit.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus fasilitas ini?')">Delete</a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </main>
<?php require_once("../../includes/footer.php"); ?>
</div>
