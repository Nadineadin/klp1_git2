$(document).ready(function () {
  $(".container-main").addClass("fade-in");

  setTimeout(() => {
    $(".fade-in").addClass("show");
  }, 300);
});

$(window).on("scroll", function () {
  $(".container-main").each(function () {
    const top = $(this).offset().top;
    const scroll = $(window).scrollTop();
    const windowHeight = $(window).height();

    if (scroll > top - windowHeight + 150) {
      $(this).addClass("show");
    }
  });
});
// Fitur 5: Tombol Back to Top
$(window).scroll(function () {
  if ($(this).scrollTop() > 300) {
    $("#backToTop").fadeIn();
  } else {
    $("#backToTop").fadeOut();
  }
});

$("#backToTop").click(function () {
  $("html, body").animate({ scrollTop: 0 }, 200);
  return false;
});

// Fitur khusus halaman fasilitas
$(document).ready(function () {
  // 1️⃣ Klik gambar fasilitas → buka modal Bootstrap
  $(".fasilitas-img").click(function () {
    const src = $(this).attr("src");
    $("#gambarModalImg").attr("src", src);
    $("#gambarModal").modal("show");
  });

  // 2️⃣ Efek hover baris tabel dengan animasi kecil
  $("#tabelFasilitas tbody tr").hover(
    function () {
      $(this).addClass("table-info");
    },
    function () {
      $(this).removeClass("table-info");
    }
  );
});

// Efek animasi fade-in khusus halaman ekstrakurikuler
$(document).ready(function () {
  $(".card, .container-main").each(function (i) {
    $(this)
      .delay(i * 150)
      .queue(function (next) {
        $(this).addClass("fade-in show");
        next();
      });
  });

  // Hover efek lembut untuk card
  $(".card").hover(
    function () {
      $(this).addClass("shadow-lg").css("transform", "scale(1.02)");
    },
    function () {
      $(this).removeClass("shadow-lg").css("transform", "scale(1)");
    }
  );
});

// Fitur tambahan untuk halaman kontak
$("#contactForm").on("submit", function (e) {
  e.preventDefault();
  const nama = $("input[name='nama']").val().trim();
  const email = $("input[name='email']").val().trim();
  const pesan = $("textarea[name='pesan']").val().trim();

  if (!nama || !email || !pesan) {
    alert("Harap isi semua kolom sebelum mengirim pesan!");
    return;
  }

  $("#formAlert").removeClass("d-none").hide().fadeIn(400);
  $(this).trigger("reset");
  setTimeout(() => $("#formAlert").fadeOut(600), 2500);
});

// Fitur tambahan khusus halaman About Us
$("#feedbackForm").on("submit", function (e) {
  e.preventDefault();
  const nama = $("input[name='nama']").val().trim();
  const email = $("input[name='email']").val().trim();
  const pesan = $("textarea[name='pesan']").val().trim();

  if (!nama || !email || !pesan) {
    alert("Harap isi semua kolom sebelum mengirim!");
    return;
  }

  // Tampilkan alert sukses dengan animasi
  $("#feedbackAlert").removeClass("d-none").hide().fadeIn(400);
  $(this).trigger("reset");
  setTimeout(() => $("#feedbackAlert").fadeOut(600), 3000);
});

document.addEventListener("DOMContentLoaded", function () {
  // Show/hide password
  const toggle = document.getElementById("togglePwd");
  const pwd = document.getElementById("passwordInput");
  toggle.addEventListener("click", function () {
    if (pwd.type === "password") {
      pwd.type = "text";
      toggle.textContent = "Hide";
    } else {
      pwd.type = "password";
      toggle.textContent = "Show";
    }
  });

  // small UX: focus nim when page loads on small screens too
  const nim = document.querySelector('input[name="nim"]');
  if (nim) nim.focus();
});
