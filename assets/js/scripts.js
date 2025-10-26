$(document).ready(function () {
//Pendaftaran dan Antrian Button Navigation
  function setActiveButton(currentPage) {
    $(".tabs button").removeClass("active");

    if (currentPage.includes("antrian")) {
      $("#btnAntrian").addClass("active");
    } else {
      $("#btnPendaftaran").addClass("active");
    }
  }
  const currentPage = window.location.pathname;
  setActiveButton(currentPage);

  $(document).on("click", "#btnPendaftaran", function () {
    window.location.href = "/pages/pendaftaran.html";
  });

  $(document).on("click", "#btnAntrian", function () {
    window.location.href = "/pages/antrian.html";
  });

  console.log("✅ Navigasi eLabora aktif (mode redirect langsung)");
});
