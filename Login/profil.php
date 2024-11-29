<?php 
require('../koneksi.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kos</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f9fc;
            color: #333;
        }
        header {
            background-color: #1a3b5d;
            color: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        header .logo {
            font-size: 32px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        header .login-btn {
            background-color: #fff;
            color: #1a3b5d;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        header .login-btn:hover {
            background-color: #1a3b5d;
            color: #fff;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .slider {
            position: relative;
            max-width: 100%;
            height: 400px;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .slides img {
            width: 100%;
            display: none;
            border-radius: 10px;
        }
        .slides img.active {
            display: block;
        }
        .description {
            text-align: center;
            margin-bottom: 40px;
            font-weight: 300;
            color: #555;
            font-size: 18px;
        }
        .description h2 {
            font-weight: 600;
            color: #1a3b5d;
            font-size: 28px;
        }
        .facilities, .testimonials {
            margin-bottom: 40px;
        }
        .facilities h3, .testimonials h3 {
            color: #1a3b5d;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .facilities ul {
            list-style-type: none;
            padding: 0;
        }
        .facilities ul li {
            margin: 10px 0;
            font-size: 18px;
            font-weight: 400;
        }
        .testimonials p {
            font-style: italic;
            color: #444;
            font-size: 16px;
            margin: 15px 0;
        }
        .testimonials p.author {
            text-align: right;
            color: #777;
            font-size: 14px;
        }
        .cta {
            text-align: center;
            margin: 50px 0;
        }
        .cta button {
            background-color: #1a3b5d;
            color: #fff;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .cta button:hover {
            background-color: #2b4f7a;
        }
        .contacts {
            background-color: #e8f1fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .contacts ul {
            list-style-type: none;
            padding: 0;
        }
        .contacts ul li {
            margin: 10px 0;
            font-weight: 400;
            font-size: 18px;
        }
        footer {
            text-align: center;
            padding: 15px;
            background-color: #1a3b5d;
            color: #fff;
            font-weight: 300;
            margin-top: 20px;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Kos Tenang</div>
        <a href="login.php"><button class="login-btn">Login</button></a>
    </header>
    <div class="container">
        <div class="slider">
            <div class="slides">
                <img src="HomeKost.jpeg" alt="Kos 1" class="active">
                <img src="WhatsApp Image 2024-11-21 at 13.51.50_a3b0fedd.jpg" alt="Kos 2">
                <img src="tempe.jpg" alt="Kos 3">
            </div>
        </div>
        <div class="description">
            <h2>Selamat Datang di Kos Tenang</h2>
            <p>
                Kami menyediakan kos dengan suasana yang nyaman dan fasilitas lengkap 
                untuk menunjang kebutuhan Anda. Lokasi strategis, aman, dan harga terjangkau.
            </p>
        </div>
        <div class="facilities">
            <h3>Fasilitas Unggulan</h3>
            <ul>
                <li>Kamar lengkap dengan AC dan WiFi</li>
                <li>Dapur bersama dengan peralatan lengkap</li>
                <li>Area parkir luas</li>
                <li>Keamanan 24 jam dengan CCTV</li>
                <li>Lokasi dekat dengan kampus dan pusat perbelanjaan</li>
            </ul>
        </div>
        <div class="testimonials">
            <h3>Testimoni Penghuni</h3>
            <p>"Kos Tenang benar-benar nyaman dan sesuai namanya! Saya sangat puas tinggal di sini."</p>
            <p class="author">- Siti, penghuni sejak 2023</p>
            <p>"Pelayanan ramah, fasilitas lengkap, dan harga sangat bersaing. Highly recommended!"</p>
            <p class="author">- Budi, mahasiswa</p>
        </div>
        <div class="cta">
            <button>Reservasi Sekarang</button>
        </div>
        <div class="contacts">
            <h3>Kontak Kami</h3>
            <ul>
                <li>Alamat: Jalan Tenang No. 123, Kota Biru</li>
                <li>Telepon: 0812-3456-7890</li>
                <li>Email: kost.tenang@email.com</li>
            </ul>
        </div>
    </div>
    <footer>
        &copy; 2024 Kos Tenang - All Rights Reserved.
    </footer>
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slides img');
        setInterval(() => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }, 3000);
    </script>
</body>
</html>
