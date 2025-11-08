<?php
$title = "Fasilitas";
require_once("../includes/config.php");
require("../includes/db_connect.php");
require("../includes/header.php"); 
require("../includes/navbar.php");
?>
<main class="container py-5">
  <div class="container-main fade-in">
    <!-- Header Halaman -->
    <div class="text-center mb-5">
      <i class="bi bi-building-fill text-primary fs-1 d-block mb-2"></i>
      <h1 class="fw-bold">Fasilitas Sekolah</h1>
      <p class="text-muted">
        SMA Negeri 9 Makassar memiliki berbagai fasilitas penunjang kegiatan
        belajar mengajar dan pengembangan diri siswa.
      </p>
      <hr
        class="mx-auto"
        style="width: 120px; border-top: 3px solid #0d6efd"
      />
    </div>

    <!-- Tabel Fasilitas -->
    <div class="table-responsive">
      <table
        id="tabelFasilitas"
        class="table table-hover table-bordered align-middle text-center"
      >
        <thead class="table-primary">
          <tr>
            <th>No.</th>
            <th>Nama Fasilitas</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
            <th>Gambar</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $no = 0;
        // Ambil semua fasilitas, urut berdasarkan id
        $sql = "SELECT id, nama_fasilitas, keterangan, jumlah, gambar FROM fasilitas ORDER BY id";
        $result = mysqli_query($mysqli, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $no++;
            // Escape output untuk mencegah XSS
            $nama = htmlspecialchars($row['nama_fasilitas'], ENT_QUOTES, 'UTF-8');
            $ket  = htmlspecialchars($row['keterangan'], ENT_QUOTES, 'UTF-8');
            $jml  = (int)$row['jumlah'];

            // Gambar: hanya nama file di DB — encode agar spasi jadi %20 jika ada
            $gambarFile = trim($row['gambar']);
            if ($gambarFile !== '') {
              // Jika kamu mengganti file di server agar tidak ada spasi, ganti dengan str_replace(' ', '_', $gambarFile)
              $gambarUrl = $base_url . 'assets/images/fasilitas/' . rawurlencode($gambarFile);
              // Opsional: cek apakah file ada di server sebelum ditampilkan (butuh path server)
              // $serverPath = __DIR__ . '/../assets/images/fasilitas/' . $gambarFile;
              // if (!file_exists($serverPath)) { $gambarUrl = $base_url . 'assets/images/fasilitas/placeholder.png'; }
            } else {
              // fallback bila kolom gambar kosong
              $gambarUrl = $base_url . 'assets/images/fasilitas/placeholder.png';
            }

            // Tampilkan baris tabel
            echo "<tr>";
            echo "<td>{$no}</td>";
            echo "<td>{$nama}</td>";
            echo "<td class=\"text-start\">{$ket}</td>";
            echo "<td>{$jml}</td>";
            echo "<td>";
            echo "<img src=\"{$gambarUrl}\" alt=\"".htmlspecialchars($nama,ENT_QUOTES,'UTF-8')."\" width=\"200\" class=\"img-fluid rounded zoom-img fasilitas-img\" />";
            echo "</td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan=\"5\">Belum ada data fasilitas.</td></tr>";
        }
        ?>
        </tbody>

      </table>
    </div>

    <hr class="my-5" />

    <h2 class="text-center mb-4">
      <i class="bi bi-map"></i> Denah Sekolah
    </h2>
    <p class="text-center fs-5">
      Berikut adalah denah SMA Negeri 9 Makassar untuk tahun ajaran
      2024-2025:
    </p>

    <div class="text-center">
      <img
        src="<?= $base_url ?>assets/images/lainnya/dena.png"
        alt="Denah SMA Negeri 9 Makassar"
        class="img-fluid rounded shadow-lg zoom-img fasilitas-img"
        width="700"
      />
    </div>
  </div>
</main>
<?php
require_once("../includes/footer.php")
?>