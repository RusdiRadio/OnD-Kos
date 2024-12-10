<div class="sidebar">
    <h1>OnD-Kos</h1>
    <div class="menu-bar">
        <a href="/OnDKos/Login/dashboarduser.php">Dashboard</a>
        <a href="/OnDKos/Kamar/index2user.php">Booking Kamar</a>
        <a href="/OnDKos/Transaksi/index7.php">Pemesanan dan pembayaran online</a>
        <a href="/OnDKos/User/index3user.php">Feedback atau Komplain</a>
        <a href="/OnDKos/User/index5.php">Pengaturan Profil</a>
        <a href="/OnDKos/User/index5.php">P mabar</a>
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
        flex-direction: column;
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar h1 {
        font-size: 24px;
        margin-bottom: 20px;
        text-align: left;
        color: white;
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
</style>
