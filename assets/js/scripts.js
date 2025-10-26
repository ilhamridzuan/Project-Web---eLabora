// LOAD HEADER DAN SIDEBAR
document.addEventListener("DOMContentLoaded", () => {
    loadComponent("../components/header.html", "#header");
    loadComponent("../components/sidebar.html", "#sidebar", () => {
        initSidebarNavigation();
        highlightActiveMenu();
    });
});

function loadComponent(filePath, targetSelector, callback) {
    fetch(filePath)
        .then((response) => {
            if (!response.ok) throw new Error(`Gagal memuat ${filePath}`);
            return response.text();
        })
        .then((html) => {
            document.querySelector(targetSelector).innerHTML = html;
            if (callback) callback();
        })
        .catch((err) => console.error("Error:", err));
}

// NAVIGASI SIDEBAR
function initSidebarNavigation() {
    document.querySelectorAll(".menu-item").forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const page = link.getAttribute("data-page");
            window.location.href = `../pages/${page}`;
        });
    });
}

// INDIKATOR MENU SIDEBAR AKTIF
function highlightActiveMenu() {
    const currentPage = window.location.pathname.split("/").pop();
    document.querySelectorAll(".menu-item").forEach((link) => {
        const page = link.getAttribute("data-page");
        if (page === currentPage) {
            document.querySelectorAll(".menu-item").forEach((l) => l.classList.remove("active"));
            link.classList.add("active");
        }
    });
}

// INTERAKSI CARD MENU DI BERANDA
document.addEventListener("click", (e) => {
    const card = e.target.closest(".menu-card");
    if (!card) return;
    const targetPage = card.getAttribute("data-target");
    if (!targetPage) return;

    card.classList.add("clicked");
    setTimeout(() => card.classList.remove("clicked"), 200);

    window.location.href = `../pages/${targetPage}`;
});

// JQUERY ANIMASI CAROUSEL BERANDA
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


// PENDAFTARAN & ANTRIAN TAB NAVIGATION
document.addEventListener("DOMContentLoaded", () => {
    // Dapatkan nama file halaman saat ini
    const currentPage = window.location.pathname.split("/").pop();

    // Fungsi untuk mengatur tombol aktif
    function setActiveButton() {
        const btnPendaftaran = document.getElementById("btnPendaftaran");
        const btnAntrian = document.getElementById("btnAntrian");

        if (!btnPendaftaran || !btnAntrian) return;

        btnPendaftaran.classList.remove("active");
        btnAntrian.classList.remove("active");

        if (currentPage.includes("antrian")) {
            btnAntrian.classList.add("active");
        } else {
            btnPendaftaran.classList.add("active");
        }
    }

    setActiveButton(); // Jalankan saat halaman dimuat

    // Event klik tombol
    const btnPendaftaran = document.getElementById("btnPendaftaran");
    const btnAntrian = document.getElementById("btnAntrian");

    if (btnPendaftaran) {
        btnPendaftaran.addEventListener("click", () => {
            window.location.href = "../pages/pendaftaran.html";
        });
    }

    if (btnAntrian) {
        btnAntrian.addEventListener("click", () => {
            window.location.href = "../pages/antrian.html";
        });
    }

    console.log("Navigasi tab Pendaftaran & Antrian aktif");
});

// SIMPAN DATA DETAIL PEMERIKSAAN DAN ALIHKAN HALAMAN
document.querySelectorAll('.card-hasil').forEach(card => {
    card.addEventListener('click', () => {
        const data = {
            jenis: card.dataset.jenis,
            kategori: card.dataset.kategori,
            status: card.dataset.status,
            tanggal: card.dataset.tanggal,
            waktu: card.dataset.waktu,
            lab: card.dataset.lab
        };
        localStorage.setItem('detailPemeriksaan', JSON.stringify(data));
        window.location.href = 'detailPemeriksaan.html';
    });
});

//untuk menampilkan data di halaman detail pemeriksaan  
document.addEventListener("DOMContentLoaded", () => {
    const data = JSON.parse(localStorage.getItem("detailPemeriksaan"));
    if (!data) return;
    document.querySelector(".jenis-pemeriksaan").textContent = data.jenis;
    document.querySelector(".kategori").textContent = data.kategori;
    document.querySelector(".status").textContent = data.status;
    document.querySelector(".tanggal").textContent = data.tanggal;
    document.querySelector(".waktu").textContent = data.waktu;
    document.querySelector(".lab").textContent = data.lab;
});

// FILTER HASIL PEMERIKSAAN (filter buttons + search input)
document.addEventListener("DOMContentLoaded", () => {
    const filterButtons = document.querySelectorAll('.filter');
    const cards = document.querySelectorAll('.card-hasil');
    const searchInput = document.getElementById('searchInput');
    const countEl = document.getElementById('count');

    if (!filterButtons.length || !cards.length) return;

    function applyFilters() {
        const activeBtn = document.querySelector('.filter.active');
        const type = activeBtn ? (activeBtn.dataset.type || 'all').toLowerCase() : 'all';
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';

        let visible = 0;
        cards.forEach(card => {
            const kategori = (card.dataset.kategori || '').toLowerCase();
            const lab = (card.dataset.lab || '').toLowerCase();
            const matchesType = type === 'all' || kategori === type;
            const matchesQuery = !query || lab.includes(query);

            if (matchesType && matchesQuery) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        if (countEl) countEl.textContent = visible;
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            applyFilters();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', () => applyFilters());
    }

    // initial apply
    applyFilters();
});