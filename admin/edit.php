<?php
// admin/user/edit.php
$title = "Edit Anggota";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../includes/config.php");
require("../includes/db_connect.php");
require('../includes/auth.php');
require("../includes/header.php");
require("../includes/admin_navbar.php");

$nim = $_GET['nim'] ?? '';
if ($nim === '') { header('Location: index.php'); exit; }

$stmt = $mysqli->prepare("SELECT * FROM anggota WHERE nim = ? LIMIT 1");
$stmt->bind_param('s', $nim);
$stmt->execute();
$res = $stmt->get_result();
$old = $res->fetch_assoc();
$stmt->close();
if (!$old) { $_SESSION['flash']['success']='Data tidak ditemukan.'; header('Location:index.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $asal_sekolah = trim($_POST['asal_sekolah'] ?? '');
    $motto = trim($_POST['motto'] ?? '');
    $pengalaman = trim($_POST['pengalaman'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if ($nama === '') $errors['nama'] = 'Nama wajib diisi.';

    // Validasi password hanya jika diisi (opsional saat edit)
    if ($password !== '') {
        if (strlen($password) < 6) $errors['password'] = 'Password minimal 6 karakter.';
        if ($password !== $password_confirm) $errors['password_confirm'] = 'Konfirmasi password tidak cocok.';
    }

    // handle image replace
    $gambar = $old['gambar'];
    if (!empty($_FILES['gambar']['name'])) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','webp'];
        if (!in_array(strtolower($ext), $allowed)) {
            $errors['gambar'] = 'Tipe gambar tidak didukung.';
        } else {
            $dest_dir = __DIR__ . '/../assets/images/mahasiswa/';
            if (!is_dir($dest_dir)) mkdir($dest_dir, 0755, true);
            $fname = uniqid('mhs_') . '.' . $ext;
            $target = $dest_dir . $fname;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                // hapus file lama jika ada
                if (!empty($old['gambar']) && file_exists(__DIR__ . '/../assets/images/mahasiswa/' . $old['gambar'])) {
                    @unlink(__DIR__ . '/../assets/images/mahasiswa/' . $old['gambar']);
                }
                $gambar = $fname;
            } else {
                $errors['gambar'] = 'Gagal mengunggah gambar.';
            }
        }
    }

    if (empty($errors)) {
        $sql = "UPDATE anggota SET nama=?, kelas=?, alamat=?, asal_sekolah=?, motto=?, pengalaman=?, gambar=? WHERE nim=?";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            $errors['general'] = 'Gagal prepare: ' . $mysqli->error;
        } else {
            $stmt->bind_param('ssssssss', $nama, $kelas, $alamat, $asal_sekolah, $motto, $pengalaman, $gambar, $nim);
            if ($stmt->execute()) {
                $stmt->close();

                // Jika admin mengisi password baru -> hash dan update table user
                if ($password !== '') {
                    if (defined('PASSWORD_ARGON2ID')) {
                        $algo = PASSWORD_ARGON2ID;
                        $options = [];
                    } else {
                        $algo = PASSWORD_BCRYPT;
                        $options = ['cost' => 12];
                    }
                    $pw_hash = password_hash($password, $algo, $options);
                    if ($pw_hash !== false) {
                        // update or insert into user table
                        // cek apakah ada user dengan nim ini
                        $check = $mysqli->prepare("SELECT id FROM `user` WHERE nim = ? LIMIT 1");
                        if ($check) {
                            $check->bind_param('s', $nim);
                            $check->execute();
                            $r = $check->get_result();
                            $exists = $r->fetch_assoc();
                            $check->close();
                            if ($exists) {
                                $up = $mysqli->prepare("UPDATE `user` SET password = ? WHERE nim = ?");
                                if ($up) {
                                    $up->bind_param('ss', $pw_hash, $nim);
                                    $up->execute();
                                    $up->close();
                                }
                            } else {
                                $ins = $mysqli->prepare("INSERT INTO `user` (nim,password) VALUES (?, ?)");
                                if ($ins) {
                                    $ins->bind_param('ss', $nim, $pw_hash);
                                    $ins->execute();
                                    $ins->close();
                                }
                            }
                        }
                    } else {
                        // gagal hash -> log jika perlu
                    }
                }

                $_SESSION['flash']['success'] = 'Data berhasil diperbarui.';
                header('Location: index.php');
                exit;
            } else {
                $errors['general'] = 'Gagal update: ' . $stmt->error;
                $stmt->close();
            }
        }
    }
    // jika error, tampilkan form lagi; gunakan posted values jika ada
    $old = array_merge($old, [
        'nama'=>$nama, 'kelas'=>$kelas, 'alamat'=>$alamat, 'asal_sekolah'=>$asal_sekolah,
        'motto'=>$motto, 'pengalaman'=>$pengalaman, 'gambar'=>$gambar
    ]);
}
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill d-flex justify-content-center align-items-center">
    <div class="container my-5">
      <h3 class="text-primary mb-3">Edit Anggota</h3>
      <div class="card border-primary shadow-sm">
        <div class="card-body">
          <?php if (!empty($errors['general'])): ?><div class="alert alert-danger"><?=htmlspecialchars($errors['general'])?></div><?php endif; ?>
          <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label">NIM</label>
              <input class="form-control" value="<?=htmlspecialchars($old['nim'])?>" readonly>
            </div>

            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input name="nama" class="form-control <?=isset($errors['nama']) ? 'is-invalid' : ''?>" value="<?=htmlspecialchars($old['nama'])?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Kelas</label>
              <input name="kelas" class="form-control" value="<?=htmlspecialchars($old['kelas'])?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Alamat</label>
              <input name="alamat" class="form-control" value="<?=htmlspecialchars($old['alamat'])?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Asal Sekolah</label>
              <input name="asal_sekolah" class="form-control" value="<?=htmlspecialchars($old['asal_sekolah'])?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Motto</label>
              <input name="motto" class="form-control" value="<?=htmlspecialchars($old['motto'])?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Pengalaman</label>
              <textarea name="pengalaman" class="form-control"><?=htmlspecialchars($old['pengalaman'])?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Gambar (ganti jika perlu)</label>
              <?php if (!empty($old['gambar']) && file_exists(__DIR__.'/../assets/images/mahasiswa/'. $old['gambar'])): ?>
                <div class="mb-2"><img src="<?= '/klp1pemrogweb/assets/images/mahasiswa/' . htmlspecialchars($old['gambar']) ?>" style="width:120px; height:120px; object-fit:cover; border-radius:6px;"></div>
              <?php endif; ?>
              <input type="file" name="gambar" class="form-control <?=isset($errors['gambar']) ? 'is-invalid' : ''?>">
              <?php if (isset($errors['gambar'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['gambar'])?></div><?php endif; ?>
            </div>

            <!-- Password fields (opsional saat edit) -->
            <div class="mb-3">
              <label class="form-label">Password baru (kosong = tidak diubah)</label>
              <input type="password" name="password" class="form-control <?=isset($errors['password']) ? 'is-invalid' : ''?>" value="">
              <?php if (isset($errors['password'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['password'])?></div><?php endif; ?>
            </div>

            <div class="mb-3">
              <label class="form-label">Konfirmasi Password Baru</label>
              <input type="password" name="password_confirm" class="form-control <?=isset($errors['password_confirm']) ? 'is-invalid' : ''?>" value="">
              <?php if (isset($errors['password_confirm'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['password_confirm'])?></div><?php endif; ?>
            </div>

            <button class="btn btn-primary">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </main>
<?php require_once("../includes/footer.php"); ?>
</div>
