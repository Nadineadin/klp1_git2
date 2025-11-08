<?php
$title = "About Us";
require_once("../includes/config.php");
require("../includes/db_connect.php");
require("../includes/header.php"); 
require("../includes/navbar.php");
session_start();
$feedback_errors = [];
$feedback_success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback_submit'])) {
    // Ambil dan trim input
    $nama  = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $pesan = isset($_POST['pesan']) ? trim($_POST['pesan']) : '';

    // Validasi
    if ($nama === '') {
        $feedback_errors[] = 'Nama tidak boleh kosong.';
    } elseif (mb_strlen($nama) > 20) {
        $feedback_errors[] = 'Nama maksimal 20 karakter.';
    }

    if ($email === '') {
        $feedback_errors[] = 'Email tidak boleh kosong.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $feedback_errors[] = 'Format email tidak valid.';
    } elseif (mb_strlen($email) > 30) {
        $feedback_errors[] = 'Email maksimal 30 karakter.';
    }

    if ($pesan === '') {
        $feedback_errors[] = 'Pesan tidak boleh kosong.';
    }

    // Jika valid, masukkan ke DB
    if (empty($feedback_errors)) {
        // pastikan charset
        if (method_exists($mysqli, 'set_charset')) {
            $mysqli->set_charset('utf8mb4');
        }

        $sql = "INSERT INTO `komentar` (`Nama_Lengkap`, `email`, `pesan`) VALUES (?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('sss', $nama, $email, $pesan);
            if ($stmt->execute()) {
                $feedback_success = true;
                // Kosongkan POST supaya form tidak tetap berisi (opsional)
                $_POST = [];
            } else {
                $feedback_errors[] = 'Gagal menyimpan data: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $feedback_errors[] = 'Gagal menyiapkan query: ' . $mysqli->error;
        }
    }
} 
?>
<main class="container my-5">
  <div class="container-main shadow-sm fade-in">
    <!-- Header Halaman -->
    <div class="text-center mb-5">
      <i class="bi bi-people-fill text-primary fs-1 d-block mb-2"></i>
      <h1 class="fw-bold">Tentang Kami</h1>
      <p class="text-muted">
        Kenali tim pengembang website SMAN 9 Makassar dan sampaikan kritik
        atau saranmu!
      </p>
      <hr
        class="mx-auto"
        style="width: 120px; border-top: 3px solid #0d6efd"
      />
    </div>

    <!-- Daftar Anggota Kelompok -->
    <section class="mb-5">
      <h2 class="h4 text-primary mb-3">
        <i class="bi bi-person-badge-fill me-2"></i>Daftar Anggota Kelompok
      </h2>

      <div class="row g-4">
        <?php

        // Ambil data anggota dari DB
        $query = "SELECT nim, nama, kelas, gambar FROM anggota ORDER BY nim";
        if ($result = $mysqli->query($query)) :
        ?>
          <div class="row g-4">
            <?php while ($row = $result->fetch_assoc()): 
              // aman-kan output
              $nim   = htmlspecialchars($row['nim']);
              $nama  = htmlspecialchars($row['nama']);
              $kelas = htmlspecialchars($row['kelas']);
              $gambarFile = $row['gambar'];

              // buat URL gambar
              $imgUrl = $base_url . 'assets/images/mahasiswa/' . rawurlencode($gambarFile);

            ?>
              <div class="col-md-6 col-lg-4">
                <div class="card h-100 text-center border-0 shadow-sm">
                  <img
                    src="<?= $imgUrl ?>"
                    class="card-img-top rounded-top zoom-img"
                    alt="<?= $nama ?>"
                  />
                  <div class="card-body">
                    <h5 class="card-title mb-1"><?= $nama ?></h5>
                    <p class="text-muted small mb-2">(<?= $nim ?> / <?= $kelas ?>)</p>
                    <a href="<?= htmlspecialchars($artikelUrl) ?>"
                      class="btn btn-outline-primary btn-sm"
                      >Lihat Artikel</a>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php
          $result->free();
        else:
          // query error
          echo '<div class="alert alert-danger">Gagal mengambil data anggota: ' . htmlspecialchars($mysqli->error) . '</div>';
        endif;
        ?>

      </div>
    </section>
    
    <!-- Form Kritik & Saran -->
    <section>
      <h2 class="h4 text-primary mb-3">
        <i class="bi bi-chat-dots-fill me-2"></i>Kritik & Saran
      </h2>
      <p class="text-muted mb-3">
        Kami sangat menghargai masukan Anda untuk pengembangan website ini 💬
      </p>

      <!-- tampilkan error server-side jika ada -->
      <?php if (!empty($feedback_errors)): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach ($feedback_errors as $err): ?>
              <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form  class="row g-3" method="post" action="">
        <!-- nama -->
        <div class="col-md-6">
          <label for="nama" class="form-label">Nama Lengkap</label>
          <input
            id="nama"
            type="text"
            name="nama"
            class="form-control"
            maxlength="20"
            placeholder="Masukkan nama Anda"
            required
            value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama'], ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8') : '' ?>"
          />
        </div>
        
        <!-- email -->
        <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input
            id="email"
            type="email"
            name="email"
            class="form-control"
            maxlength="30"
            placeholder="nama@gmail.com"
            required
            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8') : '' ?>"
          />
        </div>
        
        <!-- pesan -->
        <div class="col-12">
          <label for="pesan" class="form-label">Pesan</label>
          <textarea
            id="pesan"
            name="pesan"
            class="form-control"
            rows="5"
            placeholder="Tuliskan saran atau kritik Anda..."
            required
          ><?= isset($_POST['pesan']) ? htmlspecialchars($_POST['pesan'], ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8') : '' ?></textarea>
        </div>

        <!-- contoh token CSRF -->
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

        <input type="hidden" name="feedback_submit" value="1">

        <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary px-5">
            <i class="bi bi-send-fill me-2"></i>Kirim
          </button>
        </div>
      </form>


      <!-- Alert sukses (tetap di DOM, tampil jika $feedback_success true) -->
      <div
        id="feedbackAlert"
        class="alert alert-success text-center mt-3 <?= $feedback_success ? '' : 'd-none' ?>"
        role="alert"
      >
        <i class="bi bi-check-circle-fill me-2"></i>Terima kasih! Kritik & saran Anda telah dikirim.
      </div>
    </section>
  </div>
</main>
<?php
require_once("../includes/footer.php")
?>