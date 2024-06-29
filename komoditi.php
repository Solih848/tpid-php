<?php
$db = new PDO('mysql:host=localhost;dbname=sem', 'root', '');

// Query untuk mengambil data sub judul produk
$query_subjudul = 'SELECT * FROM sub_judul_produk ORDER BY tanggal DESC, judul_produk ASC, nama_bahan_pokok ASC';
$stmt_subjudul = $db->query($query_subjudul);
$data_subjudul = $stmt_subjudul->fetchAll(PDO::FETCH_ASSOC);
?>
?>


<?php
include 'koneksi_sembako.php'; // Menggunakan file koneksi database

// Fungsi pencarian berdasarkan tanggal dan nama pasar
if (isset($_POST['cari'])) {
  $tanggal = $_POST['tanggal'];
  $nama_pasar = $_POST['nama_pasar'];
  // Query untuk mengambil data sesuai dengan tanggal dan nama pasar yang dipilih
  $query = "SELECT * FROM sub_judul_produk WHERE tanggal='$tanggal' AND nama_pasar='$nama_pasar' ORDER BY tanggal DESC"; // Query pencarian
  $stmt = $db->query($query); // Eksekusi query
  $data_subjudul = $stmt->fetchAll(PDO::FETCH_ASSOC); // Ambil hasil query
} else if (isset($_POST['tampilkan_semua'])) {
  $query = "SELECT * FROM sub_judul_produk ORDER BY tanggal DESC"; // Query tampilkan semua data
  $stmt = $db->query($query); // Eksekusi query
  $data_subjudul = $stmt->fetchAll(PDO::FETCH_ASSOC); // Ambil hasil query
}

// Membaca penjelasan dari file JSON
$json_file_path = 'data.json';
$json_data = file_get_contents($json_file_path);
$penjelasan = json_decode($json_data, true);

?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TPID | Komoditi</title>
  <link rel="website icon" href="icon/Logo.png?v=<?php echo time(); ?>">

  <style>
    * {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }

    .pagination .page-link:hover {
      color: #0056b3;
      text-decoration: none;
      background-color: #e9ecef;
      border-color: #dee2e6;
    }


    body {
      background-color: #f2f2f2;
      padding-top: 70px;
    }

    .header {
      background-color: #3498db;
      color: white;
      padding: 20px;
      text-align: center;
      padding-top: -100px;
    }

    #cont {
      border: 1px solid #ccc;
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 90%;
      max-width: 1200px;
      margin: 20px auto 0;
      margin-top: 60px;
      margin-bottom: 60px;
    }

    select {
      margin: 5px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    input[type="date"],
    select {
      width: 20%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-top: 5px;
      box-sizing: border-box;
    }

    input[type="date"] {
      appearance: none;
      -webkit-appearance: none;
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M7 14h14v-2H7v2zm4-4h6v-2H11v2zm4-4h2v-2h-2v2zM7 10h14v-2H7v2zm12 8h-2v-2h2v2zm-4 0h-2v-2h2v2zm4-6h-2v-2h2v2zm-8 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-4-4h-2v-2h2v2zm4-4h-2v-2h2v2zm-4 0h-2v-2h2v2zm4-4h-2v-2h2v2z"/></svg>'),
        linear-gradient(to right, #ccc, #fff);
      background-position: right 10px center;
      background-repeat: no-repeat;
      background-size: 18px 18px;
      padding-right: 40px;
    }

    button[name="cari"],
    button[name="tampilkan_semua"] {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #365486;
      color: white;
      border: none;
      border-radius: 10px;
      cursor: pointer;
    }

    button:hover {
      background-color: #3a6a9e;
    }

    button[name="cari"] {
      margin-left: 5px;
    }

    button[name="tampilkan_semua"] {
      margin-left: 5px;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 60px;
      text-align: center;
    }

    th,
    td {
      padding: 10px;
      vertical-align: middle;
      border-bottom: 1px solid #ddd;
      border-right: 1px solid #ddd;
      font-size: 0.9em;
    }

    th:first-child,
    td:first-child {
      border-left: 1px solid #ddd;
    }

    th:nth-child(2),
    td:nth-child(2) {
      width: 120px;
      /* Lebar kolom Tanggal */
    }

    th:nth-child(3),
    td:nth-child(3) {
      width: 120px;
      /* Lebar kolom Tanggal */
    }

    th {
      font-size: 0.8em;
      background-color: #f2f2f2;
    }

    tr.judul-row {
      background-color: #7FC7D9;
    }

    .sub-judul {
      font-size: 0.8em;
      color: gray;
    }

    label {
      font-size: 0.9em;
      font-weight: bold;
    }

    .info-text {
      font-size: 1em;
      margin-top: 20px;
    }

    input[type="date"] {
      margin-right: 12px;
    }

    th:nth-child(5),
    td:nth-child(5) {
      min-width: 220px;
      /* Lebar kolom Tanggal */
    }

    /* CSS untuk tampilan mobile */
    @media only screen and (max-width: 768px) and (min-device-width: 320px) and (max-device-width: 1024px) {

      th:nth-child(5),
      td:nth-child(5) {
        min-width: 220px;
        /* Lebar kolom Tanggal */
      }

      table {
        overflow-x: auto;
        display: block;
      }

      th,
      td {
        min-width: 120px;
      }

      th:first-child,
      td:first-child {
        min-width: 60px;
      }

      .judul-row td {
        min-width: auto;
      }

      .header {
        padding-top: 20px;
        /* Menyesuaikan padding untuk header */
      }

      #cont {
        padding: 10px;
        /* Menyesuaikan padding untuk konten */
        margin-top: 60px;
        margin-bottom: 60px;
      }

      /* Ukuran form dan tombol yang lebih kecil */
      input[type="date"],
      select,
      button {
        width: auto;
        padding: 2px 6px;
        font-size: 0.8em;
        /* Ukuran font yang lebih kecil */
      }

      /* Perubahan untuk tombol pada ukuran layar kecil */
      button[name="cari"],
      button[name="tampilkan_semua"] {
        margin: 20px auto;
        /* Mengatur margin atas dan bawah ke 20px dan margin kiri-kanan menjadi auto */
        padding: 5px 10px;
        background-color: dodgerblue;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.8em;
        /* Ukuran font yang lebih kecil */
        display: block;
        /* Mengubah tombol menjadi blok agar bisa diatur lebar dan posisi */
      }

      input[type="date"] {
        width: 42%;
        /* Lebar yang lebih besar untuk mode Android */
        margin-bottom: 10px;
        margin-left: 2px;
      }

      label[for="tanggal"] {
        margin-right: 27px;
      }

      .info-text {
        font-size: 1em;
        /* Ukuran font lebih kecil untuk mode Android */
        margin-top: 25px;
        /* Ubah margin-top jika diperlukan */
        text-align: center;
      }

      #nama_pasar {
        margin-top: 5px;
        /* Memberikan jarak antara label dan select */
        margin-left: 0;
        /* Menghilangkan margin kiri yang diberikan pada tampilan desktop */
      }

      #date {
        display: block;
        /* Mengubah select menjadi blok agar berada di bawah label */
      }

      label[for="nama_pasar"],
      select[name="nama_pasar"] {
        display: block;
        /* Mengubah label dan select menjadi blok agar berada di bawah */
        width: 60%;
        /* Menyesuaikan lebar dengan lebar kontainer */
        margin-bottom: 10px;
        /* Memberikan jarak antara label dan select */
        margin-left: 0;
        /* Menghilangkan margin kiri yang diberikan pada tampilan desktop */
      }

      label[for="tanggal"],
      input[name="tanggal"] {
        display: block;
        /* Mengubah label dan select menjadi blok agar berada di bawah */
        width: 60%;
        /* Menyesuaikan lebar dengan lebar kontainer */
        margin-bottom: 10px;
        /* Memberikan jarak antara label dan select */
        margin-left: 0;
        /* Menghilangkan margin kiri yang diberikan pada tampilan desktop */
      }

    }
  </style>

</head>

<body>

  <?php include 'navbar.php'; ?>

  <div class="container" id="cont">
    <h2 style="text-align: center;">Tabel Harga Konsumen</h2>
    <br>

    <form action="" method="post">
      <label for="tanggal">Tanggal:</label>
      <input type="date" id="tanggal" name="tanggal">

      <label for="nama_pasar">Nama Pasar:</label>
      <select name="nama_pasar" id="nama_pasar">
        <option value="">Pilih Pasar</option>
        <?php
        include 'koneksi_coba.php';

        $query_pasar = "SELECT * FROM pasar order by id desc";
        $result_pasar = mysqli_query($koneksi, $query_pasar);

        if ($result_pasar) {
          while ($row_pasar = mysqli_fetch_assoc($result_pasar)) {
            echo "<option value='{$row_pasar['nama_pasar']}'>{$row_pasar['nama_pasar']}</option>";
          }
        } else {
          echo "Gagal menjalankan query: " . mysqli_error($koneksi);
        }

        mysqli_close($koneksi);
        ?>
      </select>

      <button type="submit" name="cari">Cari</button>
      <button type="submit" name="tampilkan_semua">Tampilkan Semua</button> <!-- Tombol Tampilkan Semua -->

    </form>

    <p class="info-text"><?php echo htmlspecialchars($penjelasan['infoText']); ?> <span id="today-date"></span></p>

    <table class="table table-bordered" id="harga-tabel">
      <thead>
        <tr>
          <th>NO</th>
          <th>TANGGAL</th>
          <th>PASAR</th>
          <th>NAMA BAHAN POKOK</th>
          <th>SATUAN</th>
          <th>HARGA KEMAREN</th>
          <th>HARGA SEKARANG</th>
          <th>PERUBAHAN (Rp)</th>
          <th>PERUBAHAN (%)</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $prev_judul = '';
        foreach ($data_subjudul as $subjudul) {
          if ($subjudul['judul_produk'] !== $prev_judul) {
            echo "<tr class='judul-row'>";
            echo "<td>" . $no++ . "</td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo '<td><strong style="color: #000000;">' . $subjudul['judul_produk'] . '</strong></td>';
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "</tr>";
          }

          echo "<tr>";
          echo "<td></td>";
          echo '<td style="width: 80px;">' . $subjudul['tanggal'] . '</td>';
          echo "<td>" . $subjudul['nama_pasar'] . "</td>";
          echo '<td style="width: 180px;">' . $subjudul['nama_bahan_pokok'] . '</td>';
          echo "<td>" . $subjudul['satuan'] . "</td>";
          echo "<td>" . number_format($subjudul['harga_kemarin'], 0, ',', '.') . "</td>";
          echo "<td>" . number_format($subjudul['harga_sekarang'], 0, ',', '.') . "</td>";

          $perubahan_rp = $subjudul['harga_sekarang'] - $subjudul['harga_kemarin'];
          $perubahan_persen = ($subjudul['harga_sekarang'] - $subjudul['harga_kemarin']) / $subjudul['harga_sekarang'] * 100;

          echo "<td>" . number_format($perubahan_rp, 0, ',', '.') . "</td>";
          echo "<td>" . number_format($perubahan_persen, 2, ',', '.') . "%</td>";
          echo "</tr>";

          $prev_judul = $subjudul['judul_produk'];
        }
        ?>
      </tbody>
    </table>
    <ul class="pagination justify-content-center" id="pagination">
      <!-- Navigasi pagination akan ditambahkan di sini -->
    </ul>

  </div>

  <div style="height: 22px;"></div>


  <script>
    const table = document.getElementById('harga-tabel');
    const pagination = document.getElementById('pagination');
    const rowsPerPage = 50; // Tentukan jumlah baris per halaman
    let currentPage = 1;
    const rows = table.querySelectorAll('tbody tr');
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    function displayTable(page) {
      currentPage = page;
      const start = (currentPage - 1) * rowsPerPage;
      const end = start + rowsPerPage;

      rows.forEach((row, index) => {
        row.style.display = (index >= start && index < end) ? '' : 'none';
      });

      updatePagination();
    }

    function updatePagination() {
      pagination.innerHTML = '';

      const prevLi = document.createElement('li');
      prevLi.classList.add('page-item');
      const prevButton = document.createElement('button');
      prevButton.classList.add('page-link');
      prevButton.innerText = 'Sebelumnya';
      prevButton.disabled = currentPage === 1;
      prevButton.addEventListener('click', () => displayTable(currentPage - 1));
      prevLi.appendChild(prevButton);
      pagination.appendChild(prevLi);

      let startPage = Math.max(1, currentPage - 1);
      let endPage = Math.min(totalPages, currentPage + 1);

      if (startPage > 1) {
        const firstLi = document.createElement('li');
        firstLi.classList.add('page-item');
        const firstButton = document.createElement('button');
        firstButton.classList.add('page-link');
        firstButton.innerText = '1';
        firstButton.addEventListener('click', () => displayTable(1));
        firstLi.appendChild(firstButton);
        pagination.appendChild(firstLi);

        if (startPage > 2) {
          const dots = document.createElement('li');
          dots.classList.add('page-item');
          dots.innerHTML = '<span class="page-link">...</span>';
          pagination.appendChild(dots);
        }
      }

      for (let i = startPage; i <= endPage; i++) {
        const li = document.createElement('li');
        li.classList.add('page-item');
        if (i === currentPage) li.classList.add('active');
        const button = document.createElement('button');
        button.classList.add('page-link');
        button.innerText = i;
        button.addEventListener('click', () => displayTable(i));
        li.appendChild(button);
        pagination.appendChild(li);
      }

      if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
          const dots = document.createElement('li');
          dots.classList.add('page-item');
          dots.innerHTML = '<span class="page-link">...</span>';
          pagination.appendChild(dots);
        }

        const lastLi = document.createElement('li');
        lastLi.classList.add('page-item');
        const lastButton = document.createElement('button');
        lastButton.classList.add('page-link');
        lastButton.innerText = totalPages;
        lastButton.addEventListener('click', () => displayTable(totalPages));
        lastLi.appendChild(lastButton);
        pagination.appendChild(lastLi);
      }

      const nextLi = document.createElement('li');
      nextLi.classList.add('page-item');
      const nextButton = document.createElement('button');
      nextButton.classList.add('page-link');
      nextButton.innerText = 'Selanjutnya';
      nextButton.disabled = currentPage === totalPages;
      nextButton.addEventListener('click', () => displayTable(currentPage + 1));
      nextLi.appendChild(nextButton);
      pagination.appendChild(nextLi);
    }

    displayTable(currentPage);
  </script>

  <script>
    // Fungsi untuk membuat animasi
    function animateTable() {
      var table = document.getElementById('harga-tabel');
      table.style.transition = 'transform 0.5s ease'; // Menambahkan efek transisi

      // Menggeser tabel ke kanan
      table.style.transform = 'translateY(100%)';

      // Setelah 0.5 detik, kembalikan tabel ke posisi semula
      setTimeout(function() {
        table.style.transform = 'translateY(0)';
      }, 500);
    }

    // Cek apakah tampilan saat ini adalah dari perangkat Android
    var isAndroid = /android/i.test(navigator.userAgent);

    // Jika tampilan dari perangkat Android, panggil fungsi animateTable
    if (isAndroid) {
      animateTable();
    }


    document.getElementById('tampilkan').addEventListener('click', function() {
      var tanggal = document.getElementById('tanggal').value;
      var area = document.getElementById('area').value;

      // Mengirimkan permintaan AJAX untuk mengambil data berdasarkan tanggal dan area
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            populateTable(data);
          } else {
            console.error('Terjadi kesalahan saat mengambil data:', xhr.status);
          }
        }
      };
      xhr.open('GET', 'get_data.php?tanggal=' + tanggal + '&area=' + area);
      xhr.send();
    });

    // Fungsi untuk memasukkan data ke dalam tabel
    function populateTable(data) {
      var tbody = document.querySelector('#harga-tabel tbody');
      tbody.innerHTML = ''; // Kosongkan tabel sebelum menambahkan data baru

      data.forEach(function(item, index) {
        var row = '<tr>' +
          '<td>' + (index + 1) + '</td>' +
          '<td>' + item.nama_bahan_pokok + '</td>' +
          '<td>' + item.satuan + '</td>' +
          '<td>' + item.harga_kemarin + '</td>' +
          '<td>' + item.harga_sekarang + '</td>' +
          '<td>' + item.perubahan_rp + '</td>' +
          '<td>' + item.perubahan_persen + '%</td>' +
          '</tr>';
        tbody.innerHTML += row;
      });
    }

    document.getElementById('today-date').textContent = new Date().toLocaleDateString();
  </script>

  <script>
    document.getElementById('today-date').textContent = new Date().toLocaleDateString();
  </script>

  <?php include 'footer.php'; ?>

</body>

</html>