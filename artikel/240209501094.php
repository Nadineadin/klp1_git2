<?php 
require_once("../includes/config.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengenalan Diri | Nirwana</title>

    <!-- Bootstrap CSS -->
    <link
      href="<?= $base_url ?>assets/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Google Fonts -->
    <link
      href="<?= $base_url ?>assets/fonts/Poppins/Poppins.css"
      rel="stylesheet"
    />

    <!-- Bootstrap Icons -->
    <link
      href="<?= $base_url ?>assets/bootstrap-icons/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/styleaboutus.css" />
  </head>
  <body>
    <div class="overlay">
      <!-- Header Section -->
      <div class="header-section">
        <div class="container">
          <h1><i class="bi bi-person-circle"></i> Portofolio</h1>
          <p class="subtitle">   | PTIK F</p>
        </div>
      </div>

      <div class="container">
        <!-- Pengenalan Diri - FOTO KIRI, BIODATA KANAN -->
        <div class="content-card">
          <h2 class="section-title">
            <i class="bi bi-person-badge"></i> Pengenalan Diri
          </h2>

          <div class="row align-items-stretch g-4">
            <!-- FOTO DI KIRI -->
            <div class="col-md-6 col-lg-6">
              <div
                class="profile-photo h-100 d-flex align-items-center justify-content-center"
              >
                <img
                  src="<?= $base_url ?>assets/images/mahasiswa/Nirwana.jpg"
                  alt="Foto Nirwana"
                  class="img-fluid"
                />
              </div>
            </div>

            <!-- BIODATA-->
            <div class="col-md-6 col-lg-6">
              <div class="profile-box">
                <p><strong>Nama:</strong> Nirwana</p>
                <p><strong>NIM:</strong> 240209501094</p>
                <p><strong>Kelas:</strong> PTIK F</p>
                <p><strong>Alamat:</strong> <mark>Jln. Turatea</mark></p>
                <p><strong>Asal Sekolah:</strong> SMKN 1 Selayar</p>
              </div>

              <div class="motto-box">
                <i class="bi bi-quote" style="font-size: 2rem"></i>
                <p class="mt-3 mb-0">
                  Belajar bukan untuk hari ini saja, tetapi untuk masa depan
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Pengalaman -->
        <div class="content-card">
          <h2 class="section-title">
            <i class="bi bi-journal-text"></i> Pengalaman
          </h2>
          <div class="experience-text">
            <p>
              Selama mengikuti kuliah di PTIK, saya mendapatkan banyak
              pengalaman baru. Saya belajar berbagai mata kuliah yang berkaitan
              dengan teknologi informasi, pemrograman, dan pendidikan. Hal ini
              menambah wawasan dan pengetahuan saya terutama dalam bidang
              komputer dan jaringan.
            </p>
            <p class="mt-3">
              Tidak hanya materi kuliah, saya juga belajar bagaimana bekerja
              dalam tim, mengerjakan tugas kelompok bersama, dan
              mempresentasikan hasil kerja. Semua pengalaman ini membuat saya
              lebih percaya diri dan siap menghadapi tantangan di masa depan.
            </p>
          </div>
        </div>

        <!-- Mata Kuliah Favorit -->
        <div class="content-card">
          <h2 class="section-title">
            <i class="bi bi-star-fill"></i> Daftar Mata Kuliah
          </h2>
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <ol class="list-group list-group-numbered">
                <li class="list-group-item">Jaringan Komputer</li>
                <li class="list-group-item">Profesi Kependidikan</li>
                <li class="list-group-item">Pemrograman Web</li>
                <li class="list-group-item">Keamanan Komputer</li>
                <li class="list-group-item">Strategi Pembelajaran</li>
                <li class="list-group-item">Struktur Data</li>
                <li class="list-group-item">Inovasi Teknologi</li>
                <li class="list-group-item">Kecerdasan Buatan</li>
              </ol>
            </div>
          </div>
        </div>

        <!-- Dosen -->
        <div class="content-card">
          <h2 class="section-title"><i class="bi bi-people-fill"></i> Dosen</h2>
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <ul class="list-group">
                <li class="list-group-item">
                  <i class="bi bi-person-check-fill text-primary"></i> Haekal
                  Febriansyah Ramadhan, S.T., M.T., M.Pd.
                </li>
                <li class="list-group-item">
                  <i class="bi bi-person-check-fill text-primary"></i> Prof. Dr.
                  Ir. Riana Tangkin Mangesa, M.T.
                </li>
                <li class="list-group-item">
                  <i class="bi bi-person-check-fill text-primary"></i> Alifya
                  NFH, S.Pd., M.Pd.
                </li>
                <li class="list-group-item">
                  <i class="bi bi-person-check-fill text-primary"></i> Wahyu
                  Hidayat M, S.Pd., M.Pd.
                </li>
                <li class="list-group-item">
                  <i class="bi bi-person-check-fill text-primary"></i> Dr. Ir.
                  Ridwan Daud Mahande, S.Pd., M.Pd., IPM.
                </li>
                <li class="list-group-item">
                  <i class="bi bi-person-check-fill text-primary"></i> Kurnia
                  Wahyu Prima, S.Pd., M.Pd.T
                </li>
                <li class="list-group-item">
                  <i class="bi bi-person-check-fill text-primary"></i> Muhammad
                  Romario Basirung, S.Pd., M.Pd.
                </li>
                <li class="list-group-item">
                  <i class="bi bi-person-check-fill text-primary"></i> Dyah
                  Darma Andayani, S.T., M.Tel.Eng.
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Tabel -->
        <div class="content-card">
          <h2 class="section-title"><i class="bi bi-table"></i> Kelompok 1</h2>
          <div class="table-responsive">
            <table class="table custom-table">
              <thead>
                <tr>
                  <th rowspan="2">No</th>
                  <th colspan="2">Nama</th>
                  <th rowspan="2">Jenis Kelamin</th>
                  <th rowspan="2">Alamat</th>
                  <th rowspan="2">Asal Sekolah</th>
                </tr>
                <tr>
                  <th>Lengkap</th>
                  <th>Panggilan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Nirwana</td>
                  <td>Wana</td>
                  <td>Perempuan</td>
                  <td>Selayar</td>
                  <td>SMKN 1 selayar</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Sri Wulandari</td>
                  <td>Sri</td>
                  <td>Perempuan</td>
                  <td>Selayar</td>
                  <td>SMKN 5 Selayar</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Nayla Alfinka Azka</td>
                  <td>Nay</td>
                  <td>Perempuan</td>
                  <td>Luwu Timur</td>
                  <td>MAN Luwu Timur</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Ahmad Nur Rahmatuullah</td>
                  <td>Rere</td>
                  <td>Laki-laki</td>
                  <td>Enrekang</td>
                  <td>SMAN 2 Enrekang</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer>
        <div class="container">
          <p>&copy; 2025 Kelompok 1 Pemrograman Web | SMA Negeri 9 Makassar</p>
        </div>
      </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="<?= $base_url ?>assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
