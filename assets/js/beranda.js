$(function () {
    $("#header").load("../components/header.html");
    $("#sidebar").load("../components/sidebar.html");
});

$(document).ready(function () {
      let currentIndex = 0;
      const slides = $(".carousel-slide");
      const totalSlides = slides.length;

      function showSlide(index) {
        slides.removeClass("active");
        slides.eq(index).addClass("active");
      }

      $(".next").click(function () {
        currentIndex = (currentIndex + 1) % totalSlides;
        showSlide(currentIndex);
      });

      $(".prev").click(function () {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        showSlide(currentIndex);
      });

      // Auto slide setiap 5 detik
      setInterval(() => {
        currentIndex = (currentIndex + 1) % totalSlides;
        showSlide(currentIndex);
      }, 5000);
});