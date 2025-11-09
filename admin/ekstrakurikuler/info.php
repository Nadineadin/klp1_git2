<?php
// admin/ekstrakurikuler/info.php
$title = "Info Ekstrakurikuler";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require("../../includes/header.php");
require("../../includes/admin_navbar.php");
require_nim_allow('240209501084');

$id = $_GET['id'] ?? '';
if ($id === '') { header('Location: index.php'); exit; }

// handle add kegiatan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_kegiatan') {
    $kegiatan = trim($_POST['kegiatan'] ?? '');
    if ($kegiatan !== '') {
        $stmt = $mysqli->prepare("INSERT INTO ekstra_kegiatan (ekstrakurikuler_id, kegiatan) VALUES (?, ?)");
        $stmt->bind_param('is', $id, $kegiatan);
        $stmt->execute();
        $stmt->close();
        $_SESSION['flash']['success'] = 'Kegiatan ditambahkan.';
        header("Location: info.php?id=" . urlencode($id));
        exit;
    } else {
        $_SESSION['flash']['success'] = 'Kegiatan kosong.';
    }
}

// handle add prestasi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_prestasi') {
    $prestasi = trim($_POST['prestasi'] ?? '');
    $tahun = trim($_POST['tahun'] ?? '');
    $gambar = null;
    if (!empty($_FILES['gambar']['name'])) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','webp'];
        if (in_array(strtolower($ext), $allowed)) {
            $dest_dir = __DIR__ . '/../../assets/images/prestasi/';
            if (!is_dir($dest_dir)) mkdir($dest_dir, 0755, true);
            $fname = uniqid('eksprest_') . '.' . $ext;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $dest_dir . $fname)) {
                $gambar = $fname;
            }
        }
    }
    if ($prestasi !== '') {
        $stmt = $mysqli->prepare("INSERT INTO ekstra_prestasi (ekstrakurikuler_id, prestasi, gambar, tahun) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isss', $id, $prestasi, $gambar, $tahun);
        $stmt->execute();
        $stmt->close();
        $_SESSION['flash']['success'] = 'Prestasi ditambahkan.';
        header("Location: info.php?id=" . urlencode($id));
        exit;
    } else {
        $_SESSION['flash']['success'] = 'Judul prestasi kosong.';
    }
}

// handle delete kegiatan (via GET del_keg)
if (isset($_GET['del_keg'])) {
    $del = (int) $_GET['del_keg'];
    $stmt = $mysqli->prepare("DELETE FROM ekstra_kegiatan WHERE id = ? AND ekstrakurikuler_id = ?");
    $stmt->bind_param('ii', $del, $id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['flash']['success'] = 'Kegiatan dihapus.';
    header("Location: info.php?id=" . urlencode($id));
    exit;
}

// handle delete prestasi (via GET del_pres)
if (isset($_GET['del_pres'])) {
    $del = (int) $_GET['del_pres'];
    // ambil gambar dulu
    $p = $mysqli->prepare("SELECT gambar FROM ekstra_prestasi WHERE id = ? AND ekstrakurikuler_id = ? LIMIT 1");
    $p->bind_param('ii', $del, $id);
    $p->execute();
    $res_p = $p->get_result();
    $row_p = $res_p->fetch_assoc();
    $p->close();
    if ($row_p && !empty($row_p['gambar'])) {
        @unlink(__DIR__ . '/../../assets/images/prestasi/' . $row_p['gambar']);
    }
    $stmt = $mysqli->prepare("DELETE FROM ekstra_prestasi WHERE id = ? AND ekstrakurikuler_id = ?");
    $stmt->bind_param('ii', $del, $id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['flash']['success'] = 'Prestasi dihapus.';
    header("Location: info.php?id=" . urlencode($id));
    exit;
}

// ambil data ekstrakurikuler
$stmt = $mysqli->prepare("SELECT * FROM ekstrakurikuler WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$ek = $res->fetch_assoc();
$stmt->close();
if (!$ek) { $_SESSION['flash']['success']='Data tidak ditemukan.'; header('Location:index.php'); exit; }

// ambil kegiatan & prestasi
$kegiatan = [];
$kq = $mysqli->prepare("SELECT id, kegiatan, created_at FROM ekstra_kegiatan WHERE ekstrakurikuler_id = ? ORDER BY id");
$kq->bind_param('i', $id);
$kq->execute();
$kres = $kq->get_result();
while ($r = $kres->fetch_assoc()) $kegiatan[] = $r;
$kq->close();

$prestasi = [];
$pq = $mysqli->prepare("SELECT id, prestasi, gambar, tahun, created_at FROM ekstra_prestasi WHERE ekstrakurikuler_id = ? ORDER BY tahun DESC, id");
$pq->bind_param('i', $id);
$pq->execute();
$pres = $pq->get_result();
while ($r = $pres->fetch_assoc()) $prestasi[] = $r;
$pq->close();
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container my-5">
      <?php if (!empty($_SESSION['flash']['success'])): ?><div class="alert alert-success"><?=htmlspecialchars($_SESSION['flash']['success']); unset($_SESSION['flash']['success']); ?></div><?php endif; ?>

      <div class="card border-primary shadow-sm">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <?php if (!empty($ek['gambar']) && file_exists(__DIR__.'/../../assets/images/ekstrakurikuler/'.$ek['gambar'])): ?>
                <img src="<?= $base_url ?>/assets/images/ekstrakurikuler/<?=htmlspecialchars($ek['gambar'])?>" class="img-fluid rounded" alt="gambar">
              <?php else: ?>
                <div class="border p-5 text-center text-muted">Tidak ada gambar</div>
              <?php endif; ?>
            </div>
            <div class="col-md-8">
              <h3 class="text-primary"><?=htmlspecialchars($ek['nama'])?></h3>
              <p><?=nl2br(htmlspecialchars($ek['deskripsi']))?></p>
              <a href="edit.php?id=<?=urlencode($ek['id'])?>" class="btn btn-warning">Edit</a>
              <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Kegiatan -->
      <div class="card mt-4">
        <div class="card-body">
          <h5>Kegiatan</h5>
          <form method="post" class="mb-3">
            <input type="hidden" name="action" value="add_kegiatan">
            <div class="input-group">
              <input name="kegiatan" class="form-control" placeholder="Judul kegiatan...">
              <button class="btn btn-outline-primary">Tambah</button>
            </div>
          </form>

          <?php if (!empty($kegiatan)): ?>
            <ul class="list-group">
              <?php foreach ($kegiatan as $k): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <?=htmlspecialchars($k['kegiatan'])?>
                <div>
                  <a href="edit_kegiatan.php?id=<?=urlencode($k['id'])?>&ek=<?=urlencode($ek['id'])?>" class="btn btn-sm btn-warning me-1">Edit</a>
                  <a href="?id=<?=urlencode($id)?>&del_keg=<?=urlencode($k['id'])?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kegiatan?')">Hapus</a>
                </div>
              </li>
            <?php endforeach; ?>

            </ul>
          <?php else: ?>
            <div class="text-muted">Belum ada kegiatan.</div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Prestasi -->
      <div class="card mt-4">
        <div class="card-body">
          <h5>Prestasi</h5>
          <form method="post" enctype="multipart/form-data" class="mb-3">
            <input type="hidden" name="action" value="add_prestasi">
            <div class="mb-2">
              <input name="prestasi" class="form-control" placeholder="Judul prestasi...">
            </div>
            <div class="mb-2">
              <input name="tahun" class="form-control" placeholder="Tahun (YYYY)">
            </div>
            <div class="mb-2">
              <input type="file" name="gambar" class="form-control">
            </div>
            <button class="btn btn-outline-success">Tambah Prestasi</button>
          </form>

          <?php if (!empty($prestasi)): ?>
            <ul class="list-group">
              <?php foreach ($prestasi as $p): ?>
                <li class="list-group-item">
                  <div class="d-flex justify-content-between">
                    <div>
                      <strong><?=htmlspecialchars($p['prestasi'])?></strong>
                      <?php if (!empty($p['tahun'])): ?> <span class="text-muted">(<?=htmlspecialchars($p['tahun'])?>)</span><?php endif; ?>
                      <div class="small text-muted"><?=htmlspecialchars($p['created_at'] ?? '')?></div>
                    </div>
                    <div>
                      <a href="edit_prestasi.php?id=<?=urlencode($p['id'])?>&ek=<?=urlencode($ek['id'])?>" class="btn btn-sm btn-warning me-1">Edit</a>
                      <a href="?id=<?=urlencode($id)?>&del_pres=<?=urlencode($p['id'])?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus prestasi?')">Hapus</a>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <div class="text-muted">Belum ada prestasi.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </main>
<?php require_once("../../includes/footer.php"); ?>
</div>
