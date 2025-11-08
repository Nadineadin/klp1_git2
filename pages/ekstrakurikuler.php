<?php
$title = "Ekstrakurikuler";
require_once("../includes/config.php");
require("../includes/db_connect.php");
require("../includes/header.php"); 
require("../includes/navbar.php");
?>
<main class="container my-5">
  <div class="container-main fade-in">
    <!-- Header Halaman -->
    <div class="text-center mb-5">
      <i class="bi bi-trophy-fill text-primary fs-1 d-block mb-2"></i>
      <h1 class="fw-bold">Ekstrakurikuler</h1>
      <p class="text-muted">
        SMA Negeri 9 Makassar memiliki berbagai kegiatan ekstrakurikuler
        yang membantu siswa mengembangkan minat, bakat, serta jiwa
        kepemimpinan.
      </p>
      <hr
        class="mx-auto"
        style="width: 120px; border-top: 3px solid #0d6efd"
      />
    </div>

    <!-- Daftar Ekstrakurikuler (dinamis) -->
    <div class="row g-4">
    <?php
    // Ambil semua ekstrakurikuler
    $ekstra_sql = "SELECT id, nama, deskripsi, gambar FROM ekstrakurikuler ORDER BY id";
    $ekstra_res = mysqli_query($mysqli, $ekstra_sql);

    $ekstra_list = [];
    $ids = [];
    if ($ekstra_res && mysqli_num_rows($ekstra_res) > 0) {
      while ($r = mysqli_fetch_assoc($ekstra_res)) {
        $ekstra_list[] = $r;
        $ids[] = (int)$r['id'];
      }
    }

    // Jika ada ekstrakurikuler, ambil semua kegiatan dan prestasi sekaligus
    $kegiatan_map = [];
    $prestasi_map = [];

    if (!empty($ids)) {
      $ids_csv = implode(',', $ids);

      // Kegiatan
      $k_sql = "SELECT ekstrakurikuler_id, kegiatan FROM ekstra_kegiatan WHERE ekstrakurikuler_id IN ($ids_csv) ORDER BY id";
      $k_res = mysqli_query($mysqli, $k_sql);
      if ($k_res) {
        while ($k = mysqli_fetch_assoc($k_res)) {
          $eid = (int)$k['ekstrakurikuler_id'];
          $kegiatan_map[$eid][] = $k['kegiatan'];
        }
      }

      // Prestasi
      $p_sql = "SELECT ekstrakurikuler_id, prestasi, tahun FROM ekstra_prestasi WHERE ekstrakurikuler_id IN ($ids_csv) ORDER BY tahun DESC, id";
      $p_res = mysqli_query($mysqli, $p_sql);
      if ($p_res) {
        while ($p = mysqli_fetch_assoc($p_res)) {
          $eid = (int)$p['ekstrakurikuler_id'];
          // gabungkan prestasi + tahun (jika ada)
          $txt = htmlspecialchars($p['prestasi'], ENT_QUOTES, 'UTF-8');
          if (!empty($p['tahun'])) $txt .= ' ' . (int)$p['tahun'];
          $prestasi_map[$eid][] = $txt;
        }
      }
    }

    // Render card per ekstrakurikuler (2 kolom: col-md-6)
    if (!empty($ekstra_list)) {
      foreach ($ekstra_list as $ek) {
        $id = (int)$ek['id'];
        $nama = htmlspecialchars($ek['nama'], ENT_QUOTES, 'UTF-8');
        $des  = htmlspecialchars($ek['deskripsi'], ENT_QUOTES, 'UTF-8');
        $gambarFile = trim($ek['gambar']);

        // Siapkan URL gambar kartu (fallback placeholder jika kosong)
        if ($gambarFile !== '') {
          $gambarUrl = $base_url . 'assets/images/fasilitas/' . rawurlencode($gambarFile);
          // Jika ingin memeriksa file ada di server, uncomment dan sesuaikan path:
          // $serverPath = __DIR__ . '/../assets/images/fasilitas/' . $gambarFile;
          // if (!file_exists($serverPath)) $gambarUrl = $base_url . 'assets/images/fasilitas/placeholder.png';
        } else {
          $gambarUrl = $base_url . 'assets/images/fasilitas/placeholder.png';
        }

        // Ambil list kegiatan/prestasi (jika ada)
        $k_list = isset($kegiatan_map[$id]) ? $kegiatan_map[$id] : [];
        $p_list = isset($prestasi_map[$id]) ? $prestasi_map[$id] : [];

        // collapse ids unik
        $kegiatanCollapseId = "kegiatan-{$id}";
        $prestasiCollapseId = "prestasi-{$id}";

        // Output card (col)
        echo '<div class="col-md-6">';
        echo '  <div class="card shadow-sm border-0 h-100 zoom-img">';
        echo "    <img src=\"{$gambarUrl}\" class=\"card-img-top rounded-top\" alt=\"{$nama}\" />";
        echo '    <div class="card-body">';
        echo "      <h3 class=\"card-title fw-semibold\">" . $nama . "</h3>";
        echo "      <p class=\"card-text\">{$des}</p>";

        // Tombol lihat kegiatan (tampilkan hanya bila ada)
        if (!empty($k_list)) {
          echo "      <button class=\"btn btn-outline-primary mt-2\" data-bs-toggle=\"collapse\" data-bs-target=\"#{$kegiatanCollapseId}\">Lihat Kegiatan</button>";
          echo "      <div id=\"{$kegiatanCollapseId}\" class=\"collapse mt-3\">";
          echo "        <ul>";
          foreach ($k_list as $item) {
            echo '<li>' . htmlspecialchars($item, ENT_QUOTES, 'UTF-8') . '</li>';
          }
          echo "        </ul>";
          echo "      </div>";
        }

        // Tombol lihat prestasi (tampilkan hanya bila ada)
        if (!empty($p_list)) {
          echo "      <button class=\"btn btn-outline-danger mt-2 ms-2\" data-bs-toggle=\"collapse\" data-bs-target=\"#{$prestasiCollapseId}\">Lihat Prestasi</button>";
          echo "      <div id=\"{$prestasiCollapseId}\" class=\"collapse mt-3\">";
          echo "        <ul>";
          foreach ($p_list as $item) {
            echo '<li>' . $item . '</li>'; // sudah di-escape saat map dibuat
          }
          echo "        </ul>";

          // OPTIONAL: tampilkan gambar prestasi jika kamu menyimpan nama file prestasi di DB
          // Contoh (jika kamu menambahkan kolom 'gambar' di ekstra_prestasi): 
          echo '<div class="text-center mt-3"><img src="'.$base_url.'assets/images/prestasi/prestasi pmr.jpg " class="img-fluid rounded shadow-sm" width="300" alt="Prestasi"/></div>';

          echo "      </div>";
        }

        echo '    </div>';
        echo '  </div>';
        echo '</div>';
      }
    } else {
      echo '<div class="col-12"><div class="alert alert-info">Belum ada data ekstrakurikuler.</div></div>';
    }
    ?>
    </div>
    <!-- end Daftar Ekstrakurikuler -->


    <!-- Prestasi Siswa (dinamis) -->
    <hr class="my-5" />
    <?php
    // Ambil data prestasi
    $sql = "SELECT id, nama_siswa, judul_prestasi, tingkat, tahun, deskripsi, gambar
            FROM prestasi_siswa
            ORDER BY COALESCE(tahun, 0) DESC, id DESC";
    $res = mysqli_query($mysqli, $sql);

    $prestasi_rows = [];
    if ($res && mysqli_num_rows($res) > 0) {
      while ($r = mysqli_fetch_assoc($res)) {
        $prestasi_rows[] = $r;
      }
    }

    // Tentukan gambar representatif (ambil gambar dari row pertama yang ada gambar)
    $gambar_kiri = '';
    if (!empty($prestasi_rows)) {
      foreach ($prestasi_rows as $r) {
        if (!empty(trim($r['gambar']))) {
          $gambar_kiri = trim($r['gambar']);
          break;
        }
      }
    }
    // fallback jika tidak ada gambar di DB
    if (empty($gambar_kiri)) {
      $gambar_kiri = 'prestasi.jpg';
    }
    $gambar_kiri_url = $base_url . 'assets/images/prestasi/' . rawurlencode($gambar_kiri);
    ?>
    <div class="card border-0 shadow-sm fade-in">
      <div class="row g-0 align-items-center">
        <div class="col-md-5 text-center p-3">
          <img
            src="<?= $gambar_kiri_url ?>"
            class="img-fluid rounded shadow-sm"
            alt="Prestasi"
          />
        </div>
        <div class="col-md-7 p-4">
          <h3 class="fw-bold text-success mb-3">Prestasi Siswa</h3>
          <p>Beberapa prestasi membanggakan yang telah diraih siswa SMAN 9 Makassar:</p>

          <?php if (!empty($prestasi_rows)): ?>
            <ol class="ps-3">
              <?php foreach ($prestasi_rows as $row): 
                // Siapkan teks item
                $nama   = trim($row['nama_siswa']);
                $judul  = trim($row['judul_prestasi']);
                $tahun  = !empty($row['tahun']) ? (int)$row['tahun'] : null;

                // Buat tampilan mirip teks asli: jika ada nama, tampilkan "Nama - Judul". Jika tidak, tampilkan Judul saja.
                if ($nama !== '' && $judul !== '') {
                  $item_text = htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') . ' - ' . htmlspecialchars($judul, ENT_QUOTES, 'UTF-8');
                } elseif ($judul !== '') {
                  $item_text = htmlspecialchars($judul, ENT_QUOTES, 'UTF-8');
                } else {
                  // fallback: gabungkan tingkat/deskripsi
                  $item_text = htmlspecialchars($row['deskripsi'] ?? 'Prestasi', ENT_QUOTES, 'UTF-8');
                }
                if ($tahun) $item_text .= ' ' . $tahun;
              ?>
                <li><?= $item_text ?></li>
              <?php endforeach; ?>
            </ol>
          <?php else: ?>
            <div class="alert alert-info">Belum ada data prestasi siswa.</div>
          <?php endif; ?>

        </div>
      </div>
    </div>
    <!-- end Prestasi Siswa -->

  </div>
</main>
<?php
require_once("../includes/footer.php")
?>