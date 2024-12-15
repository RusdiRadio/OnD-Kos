<?php
// Memulai sesi untuk mengambil data pengguna yang login
session_start();

// Koneksi ke database
$host = "localhost";
$pengguna = "root";
$sandi = "";
$dbname = "ondkos";

$koneksi = new mysqli($host, $pengguna, $sandi, $dbname);

// Periksa koneksi database
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Mengambil data pengguna berdasarkan sesi login
$id_user = $_SESSION['id_user'] ?? null;
if (!$id_user) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

$query = $koneksi->query("SELECT * FROM daftar_user WHERE id_user = '" . $koneksi->real_escape_string($id_user) . "'");
if (!$query) {
    die("Query gagal: " . $koneksi->error);
}
$user = $query->fetch_assoc();

// Memproses perubahan data jika form dikirimkan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Periksa apakah setiap kolom diatur sebelum digunakan untuk menghindari kesalahan undefined index
    $nama_user = isset($_POST['nama_user']) ? $koneksi->real_escape_string($_POST['nama_user']) : '';
    $user_email = isset($_POST['user_email']) ? $koneksi->real_escape_string($_POST['user_email']) : '';
    $alamat_user = isset($_POST['alamat_user']) ? $koneksi->real_escape_string($_POST['alamat_user']) : '';
    $no_hp = isset($_POST['no_hp']) ? $koneksi->real_escape_string($_POST['no_hp']) : '';
    $username = isset($_POST['username']) ? $koneksi->real_escape_string($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Sisa kode tetap berlanjut...

    $foto = $user['foto']; // Menyimpan foto lama sebagai default

    if (!empty($_FILES['foto']['name'])) {
        $file_name = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $file_size = $_FILES['foto']['size'];

        // Validasi jenis file dan ukuran file sudah ada
        $upload_dir = __DIR__ . '/../uploads/';
        $foto_dir = $upload_dir . $file_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Jika file berhasil diunggah
        if (move_uploaded_file($tmp_name, $foto_dir)) {
            if ($user['foto'] && file_exists($upload_dir . $user['foto'])) {
                unlink($upload_dir . $user['foto']);  // Hapus foto lama
            }
            $foto = $file_name;  // Perbarui nama foto
            $_SESSION['foto'] = $foto;  // Simpan nama foto di session
        } else {
            echo "<script>alert('Gagal mengunggah foto. Pastikan folder uploads/ ada dan memiliki izin yang sesuai.');</script>";
            exit;
        }
    }

   // Mengupdate data user
$fields_to_update = [
    "nama_user" => $nama_user,
    "user_email" => $user_email,
    "alamat_user" => $alamat_user,
    "no_hp" => $no_hp,
    "username" => $username,
    "foto" => $foto,
];

// Menambahkan password hanya jika diubah
if (!empty($password)) {
    $fields_to_update["password"] = $password; // Menyimpan password tanpa hashing
}

// Persiapkan query update dengan prepared statements
$update_query = "UPDATE daftar_user SET ";
$types = "";
$values = [];

// Menambahkan setiap field yang akan diupdate ke query
foreach ($fields_to_update as $key => $value) {
    $update_query .= "$key = ?, ";
    $types .= "s";  // Tipe data untuk string
    $values[] = $value;
}

// Menghapus koma di akhir query
$update_query = rtrim($update_query, ", ");
$update_query .= " WHERE id_user = ?";
$types .= "i";  // Tipe data untuk integer (id_user)
$values[] = $id_user;

// Eksekusi query menggunakan prepared statements
$stmt = $koneksi->prepare($update_query);
if ($stmt) {
    $stmt->bind_param($types, ...$values);
    if ($stmt->execute()) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data berhasil diperbarui.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Update src gambar profil dengan foto yang baru
                document.getElementById('fotoPreview').src = '../uploads/$foto'; // Update gambar profil
                window.location.reload(); // Muat ulang halaman untuk menampilkan foto yang baru
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat memperbarui data.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
    }
} else {
    echo "<script>
        Swal.fire({
            title: 'Gagal!',
            text: 'Terjadi kesalahan dalam mempersiapkan query.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>";
}
} // <-- closing this if block
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6f7ff;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #007bff;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .menu-bar {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu-bar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .menu-bar a:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .menu-bar a:active {
            transform: scale(0.95);
        }

        main {
            margin-left: 270px;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding-top: 40px;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #495057;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            color: #495057;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #0056b3;
        }

        form button:active {
            transform: scale(0.95);
        }

        img {
            display: block;
            margin: 0 auto 20px;
            max-width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 2px solid #dee2e6;
            cursor: pointer;
        }

        .logout {
            position: fixed;
            top: 10px;
            right: 20px;
            padding: 10px 20px;
            background-color: #d3d3d3;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .logout:hover {
            background-color: #bfbfbf;
            transform: translateY(-2px);
        }

        .logout:active {
            transform: scale(0.95);
        }

        input[type="file"] {
            display: none;
        }
    </style>
</head>
<body>
<a href="logout.php" class="logout">Logout</a>
<?php include '../Sidebar/user.php'; ?>
<main>
    <div class="container">
        <h2>Pengaturan Profil</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div style="text-align: center;">
                <label for="foto">Foto Profil:</label>
                <div style="cursor: pointer;">
                    <img src="../uploads/<?php echo htmlspecialchars($user['foto']); ?>" alt="Foto Profil" id="fotoPreview" style="max-width: 150px; border-radius: 50%;" onclick="document.getElementById('foto').click();">
                </div>
                <input type="file" id="foto" name="foto" onchange="previewImage(event)" style="display: none;">
            </div>
            <label for="nama_user">Nama:</label>
            <input type="text" id="nama_user" name="nama_user" value="<?php echo htmlspecialchars($user['nama_user']); ?>" required>

            <label for="user_email">Email:</label>
            <input type="email" id="user_email" name="user_email" value="<?php echo htmlspecialchars($user['user_email']); ?>" required>

            <label for="alamat_user">Alamat:</label>
            <input type="text" id="alamat_user" name="alamat_user" value="<?php echo htmlspecialchars($user['alamat_user']); ?>" required>

            <label for="no_hp">Nomor HP:</label>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($user['no_hp']); ?>" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah">
            <!-- Other form fields remain unchanged -->

            <button type="submit" onclick="confirmSaveChanges(event)">Simpan Perubahan</button>
        </form>
    </div>
</main>

<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('fotoPreview');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);

    // Simpan nama foto yang baru di sesi untuk memperbarui preview saat form disubmit
    document.getElementById('fotoPreview').src = reader.result;
}

function confirmSaveChanges(event) {
    event.preventDefault(); // Prevent form submission

    // Display SweetAlert confirmation
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Perubahan akan disimpan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, simpan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form if confirmed
            event.target.form.submit();
        }
    });
}
</script>

</body>
</html>