/* The provided code snippet is creating a sidebar navigation menu using HTML and CSS. Here's a
breakdown of what each part of the code does: */
<div class="sidebar">
<h1><i class="bi bi-house-door"></i> OnD-Kos</h1>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <div class="menu-bar">
        <a href="/OnDKos/Login/dashboardadmin.php">Dashboard</a>
        <a href="/OnDKos/Kamar/index2.php">Kelola Kamar</a>
        <a href="/OnDKos/Transaksi/index6.php">Pemesanan dan pembayaran online</a>
        <a href="/OnDKos/User/index3.php">Kelola User</a>
        <a href="/OnDKos/User/index4.php">Kelola Penghuni</a>
        <a href="/OnDKos/Riwayat/index5.php">Riwayat Penghuni</a>
        <a href="/OnDKos/Grafik/grafik.php">Pemasukan</a>
        <a href="/OnDkOS/User/admin_feedback.php">Kelola Feedback</a>
    </div>
</div>

<style>
    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #007bff; /* Biru */
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column; /* Pastikan elemen dalam sidebar mengatur secara kolom */
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar h1 {
        font-size: 24px;
        margin-bottom: 20px;
        text-align: center;
        color: white;
        display: flex;
        align-items: center; /* Vertikal tengah */
        justify-content: center; /* Horizontal tengah */
        gap: 10px; /* Jarak antara ikon dan teks */
    }

    .menu-bar {
        flex-grow: 1;
        display: flex;
        flex-direction: column; /* Menyusun menu-menu secara vertikal */
        gap: 10px; /* Memberi jarak antar menu */
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
</style>

