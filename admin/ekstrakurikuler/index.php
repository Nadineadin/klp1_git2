<?php
// admin/ekstrakurikuler/index.php
$title = "Daftar Ekstrakurikuler";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require("../../includes/header.php");
require("../../includes/admin_navbar.php");

// ubah NIM di bawah sesuai yang berhak
require_nim_allow('240209501084');
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container my-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Daftar Ekstrakurikuler</h2>
        <a href="create.php" class="btn btn-primary">Tambah Ekstrakurikuler</a>
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
                  <th>Deskripsi (preview)</th>
                  <th>Gambar</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $q = "SELECT id, nama, deskripsi, gambar FROM ekstrakurikuler ORDER BY nama";
                $res = $mysqli->query($q);
                $no = 1;
                while ($row = $res->fetch_assoc()):
                ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($row['nama']) ?></td>
                  <td><?= htmlspecialchars(strlen($row['deskripsi'])>80 ? substr($row['deskripsi'],0,80).'...' : $row['deskripsi']) ?></td>
                  <td>
                    <?php if (!empty($row['gambar']) && file_exists(__DIR__ . '/../../assets/images/ekstrakurikuler/' . $row['gambar'])): ?>
                      <img src="<?= $base_url ?>/assets/images/ekstrakurikuler/<?= htmlspecialchars($row['gambar']) ?>" alt="foto" style="width:64px; height:64px; object-fit:cover; border-radius:6px;">
                    <?php else: ?>
                      <span class="text-muted small">-</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="info.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-info">Info</a>
                    <a href="edit.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Delete</a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>

            <?php if ($res->num_rows === 0): ?>
              <div class="text-center text-muted p-3">Belum ada data ekstrakurikuler.</div>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </div>
  </main>
<?php require_once("../../includes/footer.php"); ?>
</div>
