<div class="navbar">
    <div class="navbar-content">
        <span>Selamat datang, Admin</span>
        <a href="/OnDKos/Login/dashboardadmin.php" class="logout-button">Logout</a>
    </div>
</div>

<div class="sidebar">
    <h1>OnD-Kos</h1>
    <div class="menu-bar">
        <a href="/OnDKos/Login/dashboardadmin.php">Dashboard</a>

        <!-- Menu Master with dropdown arrow -->
        <div class="dropdown">
            <a href="#" class="dropdown-button">Menu Master <span class="arrow">↓</span></a>
            <div class="dropdown-content">
                <a href="/OnDKos/Kamar/index2.php">Kelola Kamar</a>
                <a href="/OnDKos/User/index3.php">Kelola User</a>
                <a href="/OnDKos/Penghuni/index4.php">Kelola Penghuni</a>
            </div>
        </div>

        <!-- Keuangan Menu with dropdown arrow -->
        <div class="dropdown">
            <a href="#" class="dropdown-button">Keuangan <span class="arrow">↓</span></a>
            <div class="dropdown-content">
                <a href="/OnDKos/Transaksi/index6.php">Pemesanan dan pembayaran online</a>
                <a href="/OnDKos/Grafik/grafik.php">Pemasukan</a>
                <a href="/OnDKos/Pengeluaran/index8.php">Pengeluaran</a>
            </div>
        </div>

        <a href="/OnDKos/Riwayat/index5.php">Riwayat Penghuni</a>
        <a href="/OnDkOS/Feedback/feedback_admin.php">Kelola Feedback</a>
    </div>
</div>

<style>
    /* Navbar styling */
    .navbar {
        width: 100%;
        height: 50px;
        background-color: #0056b3;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
    }

    .navbar-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .navbar-content span {
        font-size: 16px;
    }

    .logout-button {
        color: white;
        background-color: #ff4d4d;
        padding: 8px 15px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        transition: all 0.3s ease;
        margin-left: 100px;
        margin-right: 30px;
    }

    .logout-button:hover {
        background-color: #ff1a1a;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .sidebar {
        width: 250px;
        height: calc(100vh - 50px);
        background-color: rgb(0, 112, 231);
        color: white;
        position: fixed;
        top: 50px;
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

    /* Dropdown styling */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-button {
        display: block;
        color: white;
        text-decoration: none;
        padding: 10px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .dropdown-button:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: rgb(0, 104, 178);
        min-width: 200px;
        z-index: 1;
        left: 0;
        padding: 10px;
        border-radius: 5px;
    }

    .dropdown-content a {
        color: white;
        text-decoration: none;
        padding: 8px 10px;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #0056b3;
    }

    /* Arrow styling */
    .arrow {
        font-size: 14px;
        margin-left: 5px;
    }
</style>

<script>
    // JavaScript to toggle dropdown visibility on click
    document.querySelectorAll('.dropdown-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link action
            const dropdownContent = this.nextElementSibling;
            dropdownContent.style.display = (dropdownContent.style.display === 'block') ? 'none' : 'block';
        });
    });
</script>
