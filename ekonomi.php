<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TPID | Makro Ekonomi</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="website icon" href="icon/Logo.png?v=<?php echo time(); ?>">
    <style>
        /* General styles for the info container */
        #info-container {
            display: flex;
            flex-direction: column;
            width: 90%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #f0f0f0;
            /* Background color abu-abu */
            margin-bottom: 60px;
            margin-top: 120px;
            opacity: 0;
            /* Awalnya tidak terlihat */
            overflow: hidden;
            /* Sembunyikan overflow selama animasi */
            animation: expandContainer 1s ease-out forwards;
            /* Terapkan animasi */
        }

        /* Styles for the title */
        #info-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            padding: 25px;
            background-color: rgba(54, 84, 134, 0.8);
            color: #fff;
            /* Text color putih */
            border-radius: 5px;
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            /* Untuk memungkinkan pemosisian absolut */
            animation: expandBackground 1s ease-out forwards, typingText 1s ease-out forwards;
        }

        /* Animasi untuk memperluas background */
        @keyframes expandBackground {
            from {
                width: 0;
                opacity: 0;
                margin-left: 50%;
                /* Mulai dari tengah */
            }

            to {
                width: 100%;
                opacity: 1;
                margin-left: 0;
                /* Melebar ke samping kanan dan kiri */
            }
        }

        /* Animasi untuk memperluas container */
        @keyframes expandContainer {
            from {
                transform: translateY(100%);
                opacity: 0;
                margin-bottom: 1000px;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Animasi untuk mengetik */
        @keyframes typingText {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        /* Gaya untuk kalimat di dalam background */
        #info-title::before {
            content: "Halaman Informasi";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            white-space: nowrap;
            overflow: hidden;
            animation: typingText 4s forwards;
            text-align: center;
            /* Menengahkan teks horizontal */
        }

        /* Styles for each info item */
        .info-item {
            margin-bottom: 20px;
        }

        /* Styles for the title */
        .info-item h2 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Styles for the link */
        .info-item a {
            color: #007bff;
            text-decoration: none;
            font-style: italic;
        }

        /* Styles for the description */
        .info-item p {
            margin-top: 0;
        }

        /* Styles for the horizontal rule */
        .info-item:not(:last-child) {
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div id="info-container">
        <div id="info-title"></div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil data dari JSON dan tampilkan
            fetch('ekonomi.json')
                .then(response => response.json())
                .then(data => {
                    const infoContainer = document.getElementById('info-container');
                    data.forEach(item => {
                        const infoElement = document.createElement('div');
                        infoElement.classList.add('info-item');
                        infoElement.innerHTML = `
                        <h2>${item.title}</h2>
                        <a href="${item.link}" target="_blank">${item.link}</a>
                        <p>${item.description}</p>
                    `;
                        infoContainer.appendChild(infoElement);
                    });

                    // Set opacity to 1 after content is loaded to ensure it displays correctly
                    infoContainer.style.opacity = 1;
                });
        });
    </script>
    <?php include 'footer.php'; ?>
</body>

</html>