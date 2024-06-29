<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>Responsive Drop Down Navigation Menu | CodingLab</title>
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Googlefont Poppins CDN Link */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-size: 16px;
      font-family: 'Poppins', sans-serif;
    }

    #bodyy {
      min-height: 100vh;
    }

    nav {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 70px;
      background: #0F1035;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
      z-index: 99;
    }

    nav .navbar {
      height: 100%;
      max-width: 1250px;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: auto;
      padding: 0 50px;
    }

    .navbar .logo a {
      font-size: 30px;
      color: green;
      text-decoration: none;
      font-weight: 600;
    }

    nav .navbar .nav-links {
      line-height: 70px;
      height: 100%;
    }

    nav .navbar .links {
      display: flex;
    }

    nav .navbar .links li {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: space-between;
      list-style: none;
      padding: 0 14px;
    }

    nav .navbar .links li a {
      height: 100%;
      text-decoration: none;
      white-space: nowrap;
      color: #fff;
      font-size: 15px;
      font-weight: 500;
    }

    .links li:hover .htmlcss-arrow,
    .links li:hover .js-arrow {
      transform: rotate(180deg);
    }

    nav .navbar .links li .arrow {
      height: 100%;
      width: 22px;
      line-height: 70px;
      text-align: center;
      display: inline-block;
      color: #fff;
      transition: all 0.3s ease;
    }

    nav .navbar .links li .sub-menu {
      position: absolute;
      top: 70px;
      left: 0;
      line-height: 40px;
      background-color: rgba(128, 128, 128, 0.7);
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
      border-radius: 0 0 4px 4px;
      display: none;
      z-index: 2;
    }

    nav .navbar .links li:hover .htmlCss-sub-menu,
    nav .navbar .links li:hover .js-sub-menu {
      display: block;
    }

    .navbar .links li .sub-menu li {
      padding: 0 22px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .navbar .links li .sub-menu a {
      color: #fff;
      font-size: 15px;
      font-weight: 500;
    }



    .navbar .links li .sub-menu .more-sub-menu {
      position: absolute;
      top: 0;
      left: 100%;
      border-radius: 0 4px 4px 4px;
      z-index: 1;
      display: none;
    }

    .links li .sub-menu .more:hover .more-sub-menu {
      display: block;
    }

    .navbar .search-box {
      position: relative;
      height: 40px;
      width: 40px;
    }

    .navbar .search-box i {
      position: absolute;
      height: 100%;
      width: 100%;
      line-height: 40px;
      text-align: center;
      font-size: 22px;
      color: #fff;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .navbar .search-box .input-box {
      position: absolute;
      right: calc(100% - 40px);
      top: 80px;
      height: 60px;
      width: 300px;
      background: #3E8DA8;
      border-radius: 6px;
      opacity: 0;
      pointer-events: none;
      transition: all 0.4s ease;
    }

    .navbar .nav-links .sidebar-logo {
      display: none;
    }

    .navbar .bx-menu {
      display: none;
    }

    @media (max-width: 920px) {
      nav .navbar {
        max-width: 100%;
        padding: 0 25px;
      }

      nav .navbar .logo a {
        font-size: 27px;
      }

      nav .navbar .links li {
        padding: 0 10px;
        white-space: nowrap;
      }

      nav .navbar .links li a {
        font-size: 15px;
      }
    }

    @media (max-width: 800px) {
      nav {
        /* position: relative; */
      }

      .navbar .bx-menu {
        display: block;
      }

      nav .navbar .nav-links {
        position: fixed;
        top: 0;
        left: -100%;
        display: block;
        max-width: 270px;
        width: 100%;
        background: #3E8DA8;
        line-height: 40px;
        padding: 20px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.5s ease;
        z-index: 1000;
      }

      .navbar .nav-links .sidebar-logo {
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .navbar .nav-links .sidebar-logo a {
        display: block;
        /* Mengubah display agar bisa menggunakan text-align */
        text-align: center;
        /* Memusatkan teks secara horizontal */
        width: 100%;
        /* Pastikan elemen mengambil seluruh lebar */
        padding-top: 10px;
        /* Tambahkan jarak antara gambar dan teks */
        font-size: 24px;
      }

      .sidebar-logo .logo-name {
        font-size: 25px;
        color: #fff;
      }

      .sidebar-logo i,
      .navbar .bx-menu {
        font-size: 25px;
        color: #fff;
      }

      .sidebar-logo a {
        color: white;
        /* Mengatur warna teks menjadi putih */
        transition: color 0.3s;
        /* Efek transisi untuk perubahan warna */
        font-size: 21px;
        font-family: 'Poppins', sans-serif;
        font-weight: bold;


      }

      .sidebar-logo a:hover {
        color: white;
        /* Warna teks saat dihover menjadi putih */
        text-decoration: none;
        /* Nonaktifkan garis bawah saat dihover */
      }


      nav .navbar .links {
        display: block;
        margin-top: 20px;
      }

      nav .navbar .links li .arrow {
        line-height: 40px;
      }

      nav .navbar .links li {
        display: block;
      }

      nav .navbar .links li .sub-menu {
        position: relative;
        top: 0;
        box-shadow: none;
        display: none;
      }

      nav .navbar .links li .sub-menu li {
        border-bottom: none;
      }

      .navbar .links li .sub-menu .more-sub-menu {
        display: none;
        position: relative;
        left: 0;
      }

      .navbar .links li .sub-menu .more-sub-menu li {
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .links li:hover .htmlcss-arrow,
      .links li:hover .js-arrow {
        transform: rotate(0deg);
      }

      .navbar .links li .sub-menu .more-sub-menu {
        display: none;
      }

      .navbar .links li .sub-menu .more span {
        display: flex;
        align-items: center;
      }

      .links li .sub-menu .more:hover .more-sub-menu {
        display: none;
      }

      nav .navbar .links li:hover .htmlCss-sub-menu,
      nav .navbar .links li:hover .js-sub-menu {
        display: none;
      }

      .navbar .nav-links.show1 .links .htmlCss-sub-menu,
      .navbar .nav-links.show3 .links .js-sub-menu,
      .navbar .nav-links.show2 .links .more .more-sub-menu {
        display: block;
      }

      .navbar .nav-links.show1 .links .htmlcss-arrow,
      .navbar .nav-links.show3 .links .js-arrow {
        transform: rotate(180deg);
      }

      .navbar .nav-links.show2 .links .more-arrow {
        transform: rotate(90deg);
      }
    }

    .social-icons-mobile {
      display: none;
    }

    @media (max-width: 800px) {
      .social-icons-mobile {
        display: flex;
        /* Menampilkan ikon dalam baris */
        margin-top: 20px;
        /* Sesuaikan jarak ikon jika diperlukan */
        color: white;
      }

      .social-icons-mobile a {
        margin-right: 10px;
        color: white;
      }
    }


    .navbar .links li a {
      position: relative;
      /* Menambahkan posisi relative untuk menempatkan garis bawah */
    }

    .navbar .links li a:hover {
      border-bottom: 2px solid transparent;
      /* Menambahkan garis bawah transparan sebelum animasi */
    }

    .navbar .links li a::after {
      content: '';
      /* Menambahkan elemen pseudo-after */
      position: absolute;
      /* Menjadikan posisi absolute untuk elemen pseudo-after */
      bottom: -2px;
      /* Menempatkan elemen pseudo-after tepat di bawah teks */
      left: 50%;
      /* Posisi awal elemen pseudo-after di tengah */
      width: 0;
      /* Menetapkan lebar awal elemen pseudo-after menjadi 0 */
      height: 2px;
      /* Mengatur tinggi elemen pseudo-after (gaya garis bawah) */
      background-color: white;
      /* Mengatur warna garis bawah menjadi putih */
      transition: width 0.5s ease, left 0.5s ease;
      /* Menambahkan animasi smooth ke lebar dan posisi */
      border-bottom: 3px solid white;
      /* Menjadikan garis bawah lebih tebal saat menu disorot */
    }

    .navbar .links li a:hover::after {
      width: 100%;
      /* Memperluas lebar elemen pseudo-after ke 100% saat menu disorot */
      left: 0;
      /* Memindahkan elemen pseudo-after ke posisi awal (kiri) saat menu disorot */
    }

    /* CSS untuk menyembunyikan efek hover pada layar mobile atau Android */
    @media (max-width: 800px) {
      .navbar .links li a::after {
        display: none;
        /* Menyembunyikan efek hover pada layar mobile atau Android */
      }
    }


    @media only screen and (max-width: 800px) {
      nav .navbar .links li .sub-menu {
        background-color: transparent;
        /* Menjadikan latar belakang transparan */
      }

      nav .navbar .nav-links {
        position: fixed;
        top: 0;
        left: -100%;
        display: block;
        max-width: 270px;
        width: 100%;
        background: #3E8DA8;
        line-height: 40px;
        padding: 20px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.5s ease;
        z-index: 1000;
      }
    }
  </style>
</head>

<nav>
  <div class="navbar">
    <i class='bx bx-menu'></i>
    <div class="logo">
      <a href="#"><img id="logo-image" src="icon/Logo.png?v=<?php echo time(); ?>" alt="Logo TPID SUMENEP" style="width: auto; height: 50px;"></a>
    </div>
    <div class="nav-links">
      <div class="sidebar-logo">
        <a href="#"><img id="logo-image" src="icon/Logo.png?v=<?php echo time(); ?>" alt="Logo TPID SUMENEP" style="width: auto; height: 50px; margin-right: 13PX;"><br>TPID SUMENEP</a>
        <i class='bx bx-x'></i>
      </div>

      <ul class="links">
        <!-- Your existing menu items -->
        <li><a href="http://localhost/sembako/" style="font-size: 14px; font-family: 'Poppins', sans-serif;">BERANDA</a></li>
        <li><a href="komoditi.php" style="font-size: 14px; font-family: 'Poppins', sans-serif;">KOMODITI</a></li>
        <li><a href="data_inflasi.php" style="font-size: 14px; font-family: 'Poppins', sans-serif;">INFO INFLASI</a></li>
        <li><a href="ekonomi.php" style="font-size: 14px; font-family: 'Poppins', sans-serif;">MAKRO EKONOMI</a></li>
        <li><a href="berita.php" style="font-size: 14px; font-family: 'Poppins', sans-serif;">BERITA</a></li>

        <li>
          <a href="#" style="font-size: 14px; font-family: 'Poppins', sans-serif;">LOGIN</a>
          <i class='bx bxs-chevron-down htmlcss-arrow arrow'></i>
          <ul class="htmlCss-sub-menu sub-menu">
            <li><a href="login_admin.php" style="font-size: 14px; font-family: 'Poppins', sans-serif;">ADMIN</a></li>
            <li><a href="login.php" style="font-size: 14px; font-family: 'Poppins', sans-serif;">OPERATOR PASAR</a></li>
            <li><a href="edit_inflasi.php" style="font-size: 14px; font-family: 'Poppins', sans-serif;">OPERATOR INFLASI</a></li>
          </ul>
        </li>

        <!-- Social media icons -->
        <div class="social-icons-mobile">
          <a href="https://www.facebook.com/diskominfosumenep/" style="margin-right: 10px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
              <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
            </svg></a>
          <a href="https://www.instagram.com/kominfosumenep/" style="margin-right: 10px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
              <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
            </svg></a>
          <a href="https://www.youtube.com/channel/UC3brb61Fk7YAyNHdjP0ogTA"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
              <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z" />
            </svg></a>
          <a href="https://twitter.com/kominfosumenep"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
              <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
            </svg></a>
          <a href="https://www.tiktok.com/@kominfo.sumenep"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
              <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z" />
            </svg></a>
          <a href="https://wa.me/6287712377783"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
              <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
            </svg></a>
        </div>
      </ul>
    </div>
  </div>
</nav>

<script>
  let navLinks = document.querySelector(".nav-links");
  let menuOpenBtn = document.querySelector(".navbar .bx-menu");
  let menuCloseBtn = document.querySelector(".nav-links .bx-x");

  menuOpenBtn.onclick = function() {
    navLinks.style.left = "0";
  }

  menuCloseBtn.onclick = function() {
    navLinks.style.left = "-100%";
  }

  let htmlcssArrow = document.querySelector(".htmlcss-arrow");
  htmlcssArrow.onclick = function() {
    navLinks.classList.toggle("show1");
  }
  let moreArrow = document.querySelector(".more-arrow");
  moreArrow.onclick = function() {
    navLinks.classList.toggle("show2");
  }
  let jsArrow = document.querySelector(".js-arrow");
  jsArrow.onclick = function() {
    navLinks.classList.toggle("show3");
  }

  const logoForm = document.getElementById('logo-form');
  const logoFileInput = document.getElementById('logo-file');
  const logoImage = document.getElementById('logo-image');

  logoForm.addEventListener('submit', function(event) {
    event.preventDefault();

    const file = logoFileInput.files[0];
    if (file) {
      const formData = new FormData();
      formData.append('logo', file);

      fetch('save_logo.php', {
          method: 'POST',
          body: formData
        })
        .then(response => {
          if (response.ok) {
            return response.text();
          }
          throw new Error('Terjadi kesalahan saat menyimpan logo.');
        })
        .then(result => {
          console.log(result);
          // Update src attribute of logo image with unique query string
          logoImage.src = 'icon/Logo.png?v=' + new Date().getTime();
          alert('Logo berhasil disimpan!');
        })
        .catch(error => {
          console.error(error.message);
          alert('Terjadi kesalahan saat menyimpan logo.');
        });
    }
  });
</script>

</html>