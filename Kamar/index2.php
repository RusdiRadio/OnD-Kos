    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Data Kamar</title>
        <style>
        body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
        display: flex;
    }

    .content {
        margin-left: 280px; /* Lebar sidebar sedikit diperbesar */
        padding: 30px; /* Padding lebih besar */
        flex-grow: 1;
        min-height: 100vh;
        background-color: #ffffff;
        box-shadow: -3px 0 6px rgba(0, 0, 0, 0.15);
    }

    .container {
        width: 96%; /* Lebih luas sedikit */
        max-width: 1300px; /* Lebar maksimum diperbesar */
        margin: auto;
        padding: 30px; /* Padding lebih besar */
    }

    .container h2 {
        color: #007bff;
        text-align: left;
        margin-bottom: 25px; /* Spasi bawah lebih besar */
        font-size: 28px; /* Ukuran font lebih besar */
        border-bottom: 3px solid #007bff; /* Garis bawah lebih tebal */
        padding-bottom: 15px; /* Padding bawah lebih besar */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px; /* Jarak atas tabel diperbesar */
        background-color: #ffffff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15); /* Efek elevasi lebih kuat */
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 15px 20px; /* Padding lebih luas */
        text-align: left;
        font-size: 16px; /* Ukuran font lebih besar */
    }

    th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    td a {
        text-decoration: none;
        color: #007bff;
        padding: 8px 12px; /* Padding lebih besar */
        border-radius: 5px;
        transition: all 0.3s ease;
        font-size: 15px; /* Ukuran font diperbesar */
    }

    td a:hover {
        background-color: #0056b3;
        color: white;
    }

    .btn-tambah {
        padding: 12px 25px; /* Padding lebih besar */
        text-decoration: none;
        font-size: 18px; /* Ukuran font lebih besar */
        border-radius: 6px;
        background-color: #28a745;
        color: white;
        margin-top: 25px; /* Jarak atas lebih besar */
        display: inline-block;
        text-align: center;
        cursor: pointer;
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3); /* Shadow diperbesar */
        transition: all 0.3s ease;
    }

    .btn-tambah:hover {
        background-color: #218838;
        box-shadow: 0 5px 8px rgba(0, 0, 0, 0.4);
    }

    /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #ffffff;
        padding: 30px; /* Padding lebih besar */
        border-radius: 10px;
        width: 85%; /* Lebar modal diperbesar */
        max-width: 700px; /* Ukuran maksimum lebih besar */
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        position: relative; /* Posisi tetap relatif */
    }

    .modal-content h3 {
        color: #007bff;
        margin-bottom: 25px; /* Jarak bawah heading diperbesar */
        font-size: 24px; /* Ukuran font diperbesar */
    }

    .close {
        position: absolute;
        top: 15px; /* Posisi top diperbesar */
        right: 20px; /* Posisi right diperbesar */
        font-size: 28px; /* Ukuran font lebih besar */
        font-weight: bold;
        color: #333;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close:hover {
        color: #007bff;
    }

    form input, form textarea {
        display: block; /* Pastikan elemen berada dalam satu baris */
        width: 97%; /* Sesuaikan lebar */
        margin: 10px 0; /* Jarak atas dan bawah */
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
        background-color: #f9f9f9;
    }


    form textarea {
        resize: vertical;
        height: 120px; /* Tinggi textarea diperbesar */
    }

    form input[type="submit"] {
        background-color: #007bff;
        color: white;
        padding: 12px 25px; /* Padding lebih besar */
        border: none;
        border-radius: 6px;
        font-size: 18px; /* Ukuran font diperbesar */
        cursor: pointer;
        transition: all 0.3s ease;
    }

    form input[type="submit"]:hover {
        background-color: #0056b3;
    }

        </style>
    </head>
    <body>

    <?php include '../Sidebar/admin.php'; ?> <!-- Memuat Sidebar -->

    <div class="content">
        <div class="container">
            <h2>DATA KAMAR</h2>

            <!-- Tombol Tambah Kamar -->
            <button class="btn-tambah" id="btnTambah">Tambah Kamar</button>

            <!-- Tabel Data Kamar -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ukuran</th>
                        <th>Fasilitas</th>
                        <th>Harga</th>
                        <th>Kamar Mandi</th>
                        <th>Ketersediaan</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once "../koneksi.php";
                    $sql = "SELECT * FROM kamar";
                    $result = mysqli_query($koneksi, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($kamar = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $kamar['id_kamar'] . "</td>";
                            echo "<td>" . $kamar['ukuran'] . "</td>";
                            echo "<td>" . $kamar['fasilitas'] . "</td>";
                            echo "<td>" . $kamar['harga_kamar'] . "</td>";
                            echo "<td>" . $kamar['kamar_mandi'] . "</td>";
                            echo "<td>" . $kamar['ketersediaan'] . "</td>";
                            echo "<td>
                                <a href='edit.php?id_kamar=" . $kamar['id_kamar'] . "'>Edit</a> | 
                                <a href='delete.php?id_kamar=" . $kamar['id_kamar'] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">Hapus</a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                    }

                    mysqli_close($koneksi);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Popup Modal -->
    <div class="modal" id="modalTambah">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h3>Tambah Kamar</h3>
            <form action="create.php" method="POST">
                <label>Ukuran:</label>
                <input type="text" name="ukuran" required><br>

                <label>Fasilitas:</label>
                <textarea name="fasilitas" required></textarea><br>

                <label>Harga:</label>
                <input type="number" name="harga" required><br>

                <label>Kamar Mandi:</label>
                <input type="text" name="kamar_mandi" required><br>

                <label>Ketersediaan:</label>
                <input type="text" name="ketersediaan" required><br>

                <input type="submit" value="Tambah Kamar">
            </form>
        </div>
    </div>

    <script>
        // Ambil elemen tombol dan modal
        const btnTambah = document.getElementById('btnTambah');
        const modalTambah = document.getElementById('modalTambah');
        const closeModal = document.getElementById('closeModal');

        // Event untuk membuka modal
        btnTambah.addEventListener('click', () => {
            modalTambah.style.display = 'flex';
        });

        // Event untuk menutup modal
        closeModal.addEventListener('click', () => {
            modalTambah.style.display = 'none';
        });

        // Event untuk menutup modal jika klik di luar konten
        window.addEventListener('click', (event) => {
            if (event.target === modalTambah) {
                modalTambah.style.display = 'none';
            }
        });
    </script>

    </body>
    </html>