<?php
$title = "Kontak";
require_once("../includes/config.php");
require("../includes/db_connect.php");
require("../includes/header.php"); 
?>
<main class="container my-5">
  <div class="container-main shadow-sm fade-in">
    <!-- Header Halaman -->
    <div class="text-center mb-5">
      <i
        class="bi bi-telephone-inbound-fill text-primary fs-1 d-block mb-2"
      ></i>
      <h1 class="fw-bold">Kontak & Jam Pelayanan</h1>
      <p class="text-muted">
        Hubungi kami atau lihat jadwal kegiatan di bawah ini.
      </p>
      <hr
        class="mx-auto"
        style="width: 120px; border-top: 3px solid #0d6efd"
      />
    </div>

    <!-- Informasi Kontak -->
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-body">
        <h2 class="h4 mb-3 text-primary">
          <i class="bi bi-info-circle-fill me-2"></i>Informasi Kontak
        </h2>
        <div class="table-responsive">
          <table class="table align-middle table-hover table-bordered">
            <thead class="table-light">
              <tr>
                <th>Jenis</th>
                <th>Detail</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th><i class="bi bi-geo-alt-fill me-1"></i>Alamat</th>
                <td>Jl. Karungrung Raya No.37, Makassar</td>
              </tr>
              <tr>
                <th><i class="bi bi-telephone-fill me-1"></i>Telepon</th>
                <td>
                  (0411) 882109
                  <span class="badge bg-primary ms-2">Telepon Sekolah</span>
                </td>
              </tr>
              <tr>
                <th><i class="bi bi-envelope-fill me-1"></i>Email</th>
                <td>
                  <a
                    href="mailto:sekolah.sman9makassar@gmail.com"
                    class="text-decoration-none"
                    >sekolah.sman9makassar@gmail.com</a
                  >
                </td>
              </tr>
              <tr>
                <th><i class="bi bi-award-fill me-1"></i>Akreditasi</th>
                <td><span class="badge bg-success fs-6">A</span></td>
              </tr>
              <tr>
                <th><i class="bi bi-globe2 me-1"></i>Website</th>
                <td>
                  <a
                    href="https://sman9makassar.sch.id/"
                    target="_blank"
                    class="text-decoration-none"
                    >Kunjungi Website Resmi</a
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Jam Layanan -->
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-body">
        <h2 class="h4 mb-3 text-primary">
          <i class="bi bi-clock-fill me-2"></i>Jam Layanan
        </h2>
        <table class="table table-bordered text-center">
          <thead class="table-light">
            <tr>
              <th>Hari</th>
              <th>Jam</th>
            </tr>
          </thead>
          <tbody>
            <tr class="table-primary">
              <td>Senin - Jumat</td>
              <td>07:00 - 16:00 WITA</td>
            </tr>
            <tr class="table-secondary">
              <td>Sabtu - Minggu / Libur Nasional</td>
              <td>Tutup</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Jadwal Pelajaran -->
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-body">
        <h2 class="h4 mb-3 text-primary">
          <i class="bi bi-calendar-event-fill me-2"></i>Jadwal Pelajaran
        </h2>

        <!-- Kelas X.11 -->
        <h5 class="fw-bold mt-3">Kelas X</h5>
        <div class="table-responsive mb-4">
          <table class="table table-bordered table-sm align-middle">
            <thead class="table-light">
              <tr>
                <th>Hari</th>
                <th>07:30-08:15</th>
                <th>08:15-09:00</th>
                <th>09:00-09:45</th>
                <th>09:45-10:30</th>
                <th>11:00-11:45</th>
                <th>11:45-12:30</th>
                <th>13:00-13:45</th>
                <th>13:45-14:30</th>
                <th>14:30-15:15</th>
                <th>15:15-16:00</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Senin</td>
                <td></td>
                <td colspan="2">SOS</td>
                <td>PP</td>
                <td colspan="2">P. SENI</td>
                <td colspan="2"></td>
                <td colspan="2">B. ING</td>
              </tr>
              <tr>
                <td>Selasa</td>
                <td colspan="3">B. IND</td>
                <td>B. ING</td>
                <td>MBD</td>
                <td>BIO</td>
                <td>MAT. WAJIB</td>
                <td colspan="3">P. AI</td>
              </tr>
              <tr>
                <td>Rabu</td>
                <td colspan="2">S. IND</td>
                <td colspan="3">PJOK</td>
                <td>FIS</td>
                <td colspan="2">FIS</td>
                <td>B. IND</td>
                <td>MBD</td>
              </tr>
              <tr>
                <td>Kamis</td>
                <td colspan="3">KIM</td>
                <td colspan="2">GEO</td>
                <td>PP</td>
                <td>S. IND</td>
                <td colspan="3">MAT. WAJIB</td>
              </tr>
              <tr>
                <td>Jumat</td>
                <td></td>
                <td colspan="2">BIO</td>
                <td colspan="2">EKO</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Kelas XI.7 -->
        <h5 class="fw-bold mt-3">Kelas XI</h5>
        <div class="table-responsive mb-4">
          <table class="table table-bordered table-sm align-middle">
            <thead class="table-light">
              <tr>
                <th>Hari</th>
                <th>07:30-08:15</th>
                <th>08:15-09:00</th>
                <th>09:00-09:45</th>
                <th>09:45-10:30</th>
                <th>11:00-11:45</th>
                <th>11:45-12:30</th>
                <th>13:00-13:45</th>
                <th>13:45-14:30</th>
                <th>14:30-15:15</th>
                <th>15:15-16:00</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Senin</td>
                <td></td>
                <td colspan="3">B. IND</td>
                <td colspan="3">ANTROPOLOGI</td>
                <td colspan="3">SOSIOLOGI</td>
              </tr>
              <tr>
                <td>Selasa</td>
                <td></td>
                <td colspan="2">Bing</td>
                <td></td>
                <td colspan="2">Biologi</td>
                <td colspan="2">Antropologi</td>
                <td colspan="2">Sosiologi</td>
              </tr>
              <tr>
                <td>Rabu</td>
                <td colspan="2">P. AI</td>
                <td colspan="2">PP</td>
                <td colspan="2">P. SENI</td>
                <td colspan="3">MAT. WAJIB</td>
                <td>B. ING</td>
              </tr>
              <tr>
                <td>Kamis</td>
                <td colspan="2">S. IND</td>
                <td colspan="2">PJOK</td>
                <td>B.IND</td>
                <td colspan="2">B.ING</td>
                <td>P.AI</td>
                <td colspan="2">KF</td>
              </tr>
              <tr>
                <td>Jumat</td>
                <td></td>
                <td colspan="2">BING</td>
                <td colspan="2">Biologi</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Kelas XII.7 -->
        <h5 class="fw-bold mt-3">Kelas XII</h5>
        <div class="table-responsive">
          <table class="table table-bordered table-sm align-middle">
            <thead class="table-light">
              <tr>
                <th>Hari</th>
                <th>07:30-08:15</th>
                <th>08:15-09:00</th>
                <th>09:00-09:45</th>
                <th>09:45-10:30</th>
                <th>11:00-11:45</th>
                <th>11:45-12:30</th>
                <th>13:00-13:45</th>
                <th>13:45-14:30</th>
                <th>14:30-15:15</th>
                <th>15:15-16:00</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Senin</td>
                <td></td>
                <td colspan="3">MAT. WAJIB</td>
                <td colspan="3">B. ING</td>
                <td>MAT. WAJIB</td>
                <td colspan="2">P. SENI</td>
              </tr>
              <tr>
                <td>Selasa</td>
                <td colspan="3">PAI</td>
                <td>B.IND</td>
                <td colspan="2">PJOK</td>
                <td colspan="2">PP</td>
                <td colspan="2">S.IND</td>
              </tr>
              <tr>
                <td>Rabu</td>
                <td colspan="10" class="text-muted">-</td>
              </tr>
              <tr>
                <td>Kamis</td>
                <td colspan="10" class="text-muted">-</td>
              </tr>
              <tr>
                <td>Jumat</td>
                <td></td>
                <td colspan="2">B. IND</td>
                <td colspan="2">KWR. EKO</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Form Kontak -->
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-body">
        <h2 class="h4 mb-3 text-primary">
          <i class="bi bi-chat-dots-fill me-2"></i>Formulir Kontak
        </h2>
        <form id="contactForm" class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama:</label
            ><input type="text" name="nama" class="form-control" required />
          </div>
          <div class="col-md-6">
            <label class="form-label">Email:</label
            ><input
              type="email"
              name="email"
              placeholder="nama@gmail.com"
              class="form-control"
              required
            />
          </div>
          <div class="col-12">
            <label class="form-label">Subjek:</label
            ><input type="text" name="subjek" class="form-control" />
          </div>
          <div class="col-12">
            <label class="form-label">Pesan:</label
            ><textarea
              name="pesan"
              rows="5"
              class="form-control"
              required
            ></textarea>
          </div>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary px-5">
              Kirim Pesan
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Peta Lokasi -->
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center">
        <h2 class="h4 mb-3 text-primary">
          <i class="bi bi-geo-fill me-2"></i>Peta Lokasi
        </h2>
        <p class="mb-3">
          Klik tautan di bawah untuk membuka lokasi di Google Maps:
        </p>
        <a
          href="https://maps.app.goo.gl/Ea9bTUZ1zWZokDDo8"
          target="_blank"
          class="btn btn-outline-primary"
          rel="noopener noreferrer"
        >
          <i class="bi bi-map-fill me-2"></i>Lihat Lokasi Sekolah
        </a>
      </div>
    </div>
  </div>
</main>
<?php
require_once("../includes/footer.php")
?>