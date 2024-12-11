<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <!-- Tambahkan pustaka SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php if (isset($_SESSION['feedback_success'])): ?>
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Feedback berhasil dikirim.',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#007bff'
            });
        </script>
        <?php unset($_SESSION['feedback_success']); // Hapus sesi setelah menampilkan notifikasi ?>
    <?php endif; ?>

    <!-- Konten lainnya di halaman feedback -->
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback atau Komplain</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6f7ff; /* Biru muda */
        }
        .menu-bar {
            flex-grow: 1;
        }

        .menu-bar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            transition: all 0.3s ease-in-out; /* Animasi transisi */
        }

        .menu-bar a:hover {
            background-color: #0056b3; /* Biru lebih gelap */
            transform: translateY(-2px); /* Efek mengangkat tombol */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan tombol */
        }

        .menu-bar a:active {
            transform: scale(0.95); /* Efek mengecil saat diklik */
        }

        .logout {
            position: fixed;
            top: 10px;
            right: 20px;
            padding: 10px 20px;
            background-color: #d3d3d3; /* Abu-abu */
            color: black;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease-in-out; /* Animasi transisi */
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logout:hover {
            background-color: #bfbfbf; /* Abu-abu lebih gelap */
            transform: translateY(-2px); /* Efek mengangkat tombol */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan tombol */
        }

        .logout:active {
            transform: scale(0.95); /* Efek mengecil saat diklik */
        }

        main {
            margin-left: 270px; /* Menggeser konten utama agar tidak tertutup sidebar */
            padding: 20px;
        }

        .container {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            padding-top: 40px;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .form-container h2 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-container label {
            font-size: 16px;
            margin: 10px 0 5px;
            display: block;
        }

        .form-container input,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .form-container button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #0056b3; /* Biru lebih gelap */
        }

        .form-container button:active {
            transform: scale(0.95); /* Efek mengecil saat diklik */
        }

        .card-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .card {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            width: 250px;
        }

        .card h3 {
            margin: 0 0 10px;
            color: #333;
            font-size: 20px;
        }

        .card p {
            color: #555; /* Abu-abu */
            font-size: 16px;
        }

        .chart-container {
            margin-top: 15px;
            width: 100%;
            height: 200px; /* Tinggi chart */
        }
    </style>
</head>
<body>
<a href="logout.php" class="logout">Logout</a>
<?php
include '../Sidebar/user.php';?>
<main>
    <div class="container">
        <div class="form-container">
            <h2>Feedback atau Komplain</h2>
            <form method="POST" action="/OnDKos/User/submit_feedback.php">
                <label for="subjek">Subjek:</label>
                <input type="text" id="subjek" name="subjek" placeholder="Masukkan subjek" required>

                <label for="pesan">Pesan:</label>
                <textarea id="pesan" name="pesan" rows="5" placeholder="Masukkan pesan Anda" required></textarea>

                <button type="submit">Kirim Feedback</button>
            </form>
        </div>
    </div>
</main>
<script>
document.querySelector("#feedbackForm").addEventListener("submit", function(event) {
    var subjek = document.getElementById("subjek").value;
    var pesan = document.getElementById("pesan").value;
    
    // Validasi sebelum form dikirim
    if (subjek == "" || pesan == "") {
        alert("Semua kolom harus diisi!");
        event.preventDefault(); // Mencegah pengiriman form
    }
});
</script>
</body>
</html>

