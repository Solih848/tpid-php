<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perkembangan Inflasi Sumenep</title>
  <style>
    .graph-container {
      width: 83%;
      margin: 0 auto;
      border-radius: 8px;  
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);  
      padding: 20px;  
      background: #f9f9f9;
      border: 1px solid #ccc;  /* Border tipis berwarna abu-abu */
      height: 10%;
    }

    .huruf {
      text-align: center;
      margin-top: 0;  
      margin-bottom: 30px;  
      color: black;
      margin-bottom: 30px;
      font-size: 1.7em;
    }

    canvas {
      margin-top: 30px;
      border-radius: 6px; 
      border: 1px solid #ccc;
    }

        /* Media query untuk perangkat yang lebih kecil */
    @media (max-width: 800px) {
      .graph-container {
        width: 93%;  /* Lebar penuh untuk perangkat kecil */
        padding: 10px;  /* Lebih sedikit padding untuk perangkat kecil */
      }

      .huruf {
      font-size: 1em;  
      text-align: center;
      margin-bottom: 20px;
      color: black;
    }

    }
    
  </style>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
  <div class="graph-container">
    <h1 class="huruf">Perkembangan Inflasi Sumenep</h1>
    <canvas id="myChart"></canvas>
  </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {

    var canvas = document.getElementById('myChart');

    // Ukuran untuk desktop
    if (window.innerWidth > 600) {
      canvas.height = 115;
    } else { // Ukuran untuk perangkat mobile
      canvas.height = 280;
    }

  $.ajax({
    url: "get_inflasi_data.php",
    method: "GET",
    success: function(data) {
      const labels = data.map(item => item.bulan);
      const inflasiBulanan = data.map(item => parseFloat(item.inflasi)).reverse();
      const inflasiTahunKalender = data.map(item => parseFloat(item.inflasi_tahun_kalender)).reverse();
      const inflasiTahunKeTahun = data.map(item => parseFloat(item.inflasi_tahun_ke_tahun)).reverse();

      const ctx = document.getElementById('myChart').getContext('2d');

      const chartData = {
        labels,
        datasets: [
          {
            label: 'Inflasi Bulanan',
            data: inflasiBulanan,
            borderColor: '#008001',
            backgroundColor: '#008001',
            borderWidth: 1,
            lineTension: 0.4, // Melengkungkan garis
            pointRadius: 3.5,  // Ukuran titik yang lebih kecil
            pointBorderColor: '#fff',  // Garis tepi berwarna putih

          },
          {
            label: 'Inflasi Tahun Kalender',
            data: inflasiTahunKalender,
            borderColor: '#00008B',
            backgroundColor: '#00008B',
            borderWidth: 1,
            lineTension: 0.4, // Melengkungkan garis
            pointRadius: 3.5,  // Ukuran titik yang lebih kecil
            pointBorderColor: '#fff',  // Garis tepi berwarna putih

          },
          {
            label: 'Inflasi Tahun ke Tahun',
            data: inflasiTahunKeTahun,
            borderColor: '#FF0000',
            backgroundColor: '#FF0000',
            borderWidth: 1,
            lineTension: 0.4, // Melengkungkan garis
            pointRadius: 3.5,  // Ukuran titik yang lebih kecil
            pointBorderColor: '#fff',  // Garis tepi berwarna putih

          },
        ],
      };

      const chart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
          scales: {
            x: {
              ticks: {
                color: '#000',

                // Mengatur sudut kemiringan ke 45 derajat
                callback: function(value) {
                  return this.getLabelForValue(value); // Biarkan teks tampak utuh
                },
                minRotation: 45, // Menentukan sudut rotasi minimum
                maxRotation: 45, // Menentukan sudut rotasi maksimum
              },
              grid: {
                display: false, // Menghapus garis sumbu Y
              },
            },
            y: {
              beginAtZero: true,
              ticks: {
                color: '#000',
              },
              grid: {
                color: '#ddd', // Warna garis sumbu X
              },
            },
          },
          plugins: {
            tooltip: {
              enabled: true,
              mode: 'index',
              intersect: false,
              backgroundColor: 'rgba(255, 255, 255, 0.8)', // Putih transparan
              bodyColor: '#000', // Warna hitam pada teks tooltip
              titleColor: '#000', // Warna hitam untuk judul tooltip
              borderColor: '#ccc', // Garis tepi pada tooltip
              borderWidth: 1, // Lebar garis tepi
            },
            legend: {
              display: true,
              position: 'top',
              labels: {
                usePointStyle: true,
                pointStyle: 'rectRounded', 
              },
            },
          },

          animation: {
            onComplete: function() {
              // Aktifkan tiga tooltip pada indeks pertama
              chart.tooltip.setActiveElements([
                {
                  datasetIndex: 0,
                  index: 0,
                },
                {
                  datasetIndex: 1,
                  index: 0,
                },
                {
                  datasetIndex: 2,
                  index: 0,
                },
              ], { x: 0, y: 0 });
              chart.update(); // Memperbarui grafik untuk memunculkan tooltip
            },
          },
        },
      });
    },

    error: function(err) {
      console.error("Error loading data:", err);
      alert("Gagal mengambil data inflasi. Coba lagi nanti.");
    },
  });
});
</script>
</body>
</html>
