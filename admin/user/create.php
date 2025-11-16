<?php
// admin/user/create.php
$title = "Tambah Anggota";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require("../../includes/header.php");
require("../../includes/admin_navbar.php");
require_nim_allow('240209501085');

$errors = [];
$old = [
    'nim'=>'','nama'=>'','kelas'=>'','alamat'=>'','asal_sekolah'=>'','motto'=>'','pengalaman'=>'',
    'password'=>'','password_confirm'=>''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['nim'] = trim($_POST['nim'] ?? '');
    $old['nama'] = trim($_POST['nama'] ?? '');
    $old['kelas'] = trim($_POST['kelas'] ?? '');
    $old['alamat'] = trim($_POST['alamat'] ?? '');
    $old['asal_sekolah'] = trim($_POST['asal_sekolah'] ?? '');
    $old['motto'] = trim($_POST['motto'] ?? '');
    $old['pengalaman'] = trim($_POST['pengalaman'] ?? '');
    $old['password'] = $_POST['password'] ?? '';
    $old['password_confirm'] = $_POST['password_confirm'] ?? '';

    if ($old['nim'] === '') $errors['nim'] = 'NIM wajib diisi.';
    if ($old['nama'] === '') $errors['nama'] = 'Nama wajib diisi.';

    // Validasi password (wajib saat create)
    if ($old['password'] === '') {
        $errors['password'] = 'Password wajib diisi.';
    } else {
        if (strlen($old['password']) < 6) $errors['password'] = 'Password minimal 6 karakter.';
        if ($old['password'] !== $old['password_confirm']) $errors['password_confirm'] = 'Konfirmasi password tidak cocok.';
    }

    // handle gambar
    $gambar = null;
    if (!empty($_FILES['gambar']['name'])) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','webp'];
        if (!in_array(strtolower($ext), $allowed)) {
            $errors['gambar'] = 'Tipe gambar tidak didukung.';
        } else {
            $dest_dir = __DIR__ . '/../../assets/images/mahasiswa/';
            if (!is_dir($dest_dir)) mkdir($dest_dir, 0755, true);
            $fname = uniqid('mhs_') . '.' . $ext;
            $target = $dest_dir . $fname;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                // simpan filename saja (kamu tampilin dengan base path di view)
                $gambar = $fname;
            } else {
                $errors['gambar'] = 'Gagal mengunggah gambar.';
            }
        }
    }

    if (empty($errors)) {
        // Simpan ke table anggota
        $sql = "INSERT INTO anggota (nim,nama,kelas,alamat,asal_sekolah,motto,pengalaman,gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            $errors['general'] = 'Gagal prepare: ' . $mysqli->error;
        } else {
            $stmt->bind_param('ssssssss', $old['nim'],$old['nama'],$old['kelas'],$old['alamat'],$old['asal_sekolah'],$old['motto'],$old['pengalaman'],$gambar);
            if ($stmt->execute()) {
                $stmt->close();

                // Hash password dan simpan ke table user (insert atau update jika sudah ada)
                // Pilih algoritma
                if (defined('PASSWORD_ARGON2ID')) {
                    $algo = PASSWORD_ARGON2ID;
                    $options = [];
                } else {
                    $algo = PASSWORD_BCRYPT;
                    $options = ['cost' => 12];
                }
                $pw_hash = password_hash($old['password'], $algo, $options);

                if ($pw_hash === false) {
                    // Hash gagal — tetap redirect tapi beri peringatan
                    $_SESSION['flash']['success'] = 'Anggota berhasil ditambahkan. Namun hashing password gagal (periksa server).';
                    header('Location: index.php');
                    exit;
                }

                // Coba insert user
                $u_stmt = $mysqli->prepare("INSERT INTO `user` (nim, password) VALUES (?, ?)");
                if ($u_stmt) {
                    $u_stmt->bind_param('ss', $old['nim'], $pw_hash);
                    if (!$u_stmt->execute()) {
                        // Kalau gagal karena duplicate nim, coba update password saja
                        if ($mysqli->errno === 1062) {
                            $u_stmt->close();
                            $up = $mysqli->prepare("UPDATE `user` SET password = ? WHERE nim = ?");
                            if ($up) {
                                $up->bind_param('ss', $pw_hash, $old['nim']);
                                $up->execute();
                                $up->close();
                            }
                        } else {
                            // non-duplicate error
                            // catat error tapi jangan rollback anggota yang sudah dibuat
                        }
                    } else {
                        $u_stmt->close();
                    }
                } else {
                    // prepare gagal -> bisa log
                }

                $_SESSION['flash']['success'] = 'Anggota berhasil ditambahkan.';
                header('Location: index.php');
                exit;
            } else {
                $errors['general'] = 'Gagal menyimpan ke database: ' . $stmt->error;
                $stmt->close();
            }
        }
    }
}
?>
<div id="page" class="d-flex flex-column min-vh-100">
  <main class="flex-fill d-flex justify-content-center align-items-center">
    <div class="container my-5">
      <h3 class="text-primary mb-3">Tambah Anggota</h3>
      <div class="card border-primary shadow-sm">
        <div class="card-body">
          <?php if (!empty($errors['general'])): ?><div class="alert alert-danger"><?=htmlspecialchars($errors['general'])?></div><?php endif; ?>

          <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label">NIM</label>
              <input name="nim" class="form-control <?=isset($errors['nim']) ? 'is-invalid' : ''?>" value="<?=htmlspecialchars($old['nim'])?>">
              <?php if (isset($errors['nim'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['nim'])?></div><?php endif; ?>
            </div>

            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input name="nama" class="form-control <?=isset($errors['nama']) ? 'is-invalid' : ''?>" value="<?=htmlspecialchars($old['nama'])?>">
              <?php if (isset($errors['nama'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['nama'])?></div><?php endif; ?>
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
              <label class="form-label">Pengalaman (ringkas)</label>
              <textarea name="pengalaman" class="form-control"><?=htmlspecialchars($old['pengalaman'])?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Gambar (opsional)</label>
              <input type="file" name="gambar" class="form-control <?=isset($errors['gambar']) ? 'is-invalid' : ''?>">
              <?php if (isset($errors['gambar'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['gambar'])?></div><?php endif; ?>
            </div>

            <!-- Password fields -->
            <div class="mb-3">
              <label class="form-label">Password akun (wajib)</label>
              <input type="password" name="password" class="form-control <?=isset($errors['password']) ? 'is-invalid' : ''?>" value="">
              <?php if (isset($errors['password'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['password'])?></div><?php endif; ?>
            </div>

            <div class="mb-3">
              <label class="form-label">Konfirmasi Password</label>
              <input type="password" name="password_confirm" class="form-control <?=isset($errors['password_confirm']) ? 'is-invalid' : ''?>" value="">
              <?php if (isset($errors['password_confirm'])): ?><div class="invalid-feedback"><?=htmlspecialchars($errors['password_confirm'])?></div><?php endif; ?>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </main>
<?php require_once("../../includes/footer.php"); ?>
</div>
