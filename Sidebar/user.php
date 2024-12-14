<div class="sidebar">
    <h1>
        <i class="bi bi-house-door"></i> OnD-Kos
    </h1>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Foto Profil dan Username -->
    <div style="text-align: center; margin-bottom: 20px;">
        <!-- Foto Profil -->
        <img src="../uploads/<?php echo htmlspecialchars($_SESSION['foto'] ?? 'default.png'); ?>" alt="Foto Profil" style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid white; object-fit: cover;">
        
        <!-- Username -->
        <div style="margin-top: 10px; color: white; font-weight: bold;">
            <?php echo htmlspecialchars($user['username'] ?? 'Tidak Diketahui'); ?>
        </div>
    </div>
    
    <!-- Menu Bar -->
    <div class="menu-bar">
        <a href="/OnDKos/Login/dashboarduser.php">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="/OnDKos/Kamar/index2user.php">
            <i class="bi bi-door-open"></i> Booking Kamar
        </a>
        <a href="/OnDKos/Transaksi/index7.php">
            <i class="bi bi-file-earmark-check"></i> Pemesanan dan pembayaran online
        </a>
        <a href="/OnDKos/Feedback/feedback_user.php">
            <i class="bi bi-chat-dots"></i> Feedback atau Komplain
        </a>
        <a href="/OnDKos/Pengaturan profil/Pengaturan profil.php">
            <i class="bi bi-person-circle"></i> Pengaturan Profil
        </a>
    </div>
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
        text-align: center;
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
