<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback atau Komplain</title>
    <style>
   :root {
    /* Elegant Color Palette */
    --primary-color: #1a5f7a;     /* Deep teal-blue */
    --secondary-color: #e6f1f7;   /* Soft, pale blue */
    --accent-color: #6b8e9f;      /* Muted slate blue */
    --text-dark: #2c3e50;         /* Deep charcoal */
    --text-light: #f4f9ff;        /* Soft off-white */
    --card-shadow: rgba(0, 0, 0, 0.12);
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    transition: all 0.3s ease-in-out;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--secondary-color);
    line-height: 1.6;
    color: var(--text-dark);
}

.sidebar {
    width: 280px;
    height: 100vh;
    background: linear-gradient(135deg, var(--primary-color), #133b5c);
    color: var(--text-light);
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    padding: 30px 20px;
    box-shadow: 8px 0 20px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.sidebar h1 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 40px;
    text-align: center;
    letter-spacing: 1.5px;
    background: linear-gradient(to right, var(--text-light), #e0e0e0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.menu-bar {
    flex-grow: 1;
}

.menu-bar a {
    display: block;
    color: var(--text-light);
    text-decoration: none;
    padding: 12px 15px;
    margin: 8px 0;
    border-radius: 8px;
    font-weight: 500;
    position: relative;
    overflow: hidden;
}

.menu-bar a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: 0.5s;
}

.menu-bar a:hover::before {
    left: 100%;
}

.menu-bar a:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transform: translateX(10px);
}

.logout {
    position: fixed;
    top: 20px;
    right: 30px;
    padding: 10px 20px;
    background-color: var(--accent-color);
    color: var(--text-light);
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    letter-spacing: 0.5px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.logout:hover {
    background-color: var(--primary-color);
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

main {
    margin-left: 300px;
    padding: 40px 30px;
}

.container {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
    padding-top: 40px;
}

.container h2 {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 30px;
    text-align: center;
}

.form-container {
    background-color: white;
    padding: 30px;
    box-shadow: 0 10px 30px var(--card-shadow);
    border-radius: 15px;
}

.form-container h2 {
    color: var(--primary-color);
    font-size: 26px;
    margin-bottom: 25px;
}

.form-container label {
    font-size: 16px;
    margin: 12px 0 8px;
    display: block;
    color: var(--text-dark);
    text-align: left;
}

.form-container input,
.form-container textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 18px;
    border-radius: 8px;
    border: 1px solid var(--accent-color);
    font-size: 16px;
    transition: border-color 0.3s ease;
}

.form-container input:focus,
.form-container textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(26, 95, 122, 0.2);
}

.form-container button {
    background-color: var(--primary-color);
    color: var(--text-light);
    padding: 12px 25px;
    border-radius: 8px;
    border: none;
    font-size: 16px;
    cursor: pointer;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.form-container button:hover {
    background-color: #133b5c;
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.card-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    margin-top: 25px;
}

.card {
    background-color: white;
    box-shadow: 0 10px 30px var(--card-shadow);
    padding: 30px;
    text-align: center;
    border-radius: 15px;
    width: 300px;
    transform: translateY(0);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.card:hover {
    transform: translateY(-15px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.card h3 {
    margin: 0 0 15px;
    color: var(--primary-color);
    font-size: 22px;
    font-weight: 600;
}

.card p {
    color: var(--accent-color);
    font-size: 18px;
}

.chart-container {
    margin-top: 20px;
    width: 100%;
    height: 250px;
    background-color: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px var(--card-shadow);
    padding: 20px;
}

/* Responsive Adjustments */
@media screen and (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding: 20px;
    }

    main {
        margin-left: 0;
        padding: 20px;
    }

    .card {
        width: 100%;
        max-width: 350px;
    }
}
    </style>
</head>
<body>

<div class="sidebar">
    <h1>OnD-Kos</h1>
    <div class="menu-bar">
        <a href="/OnDKos/Login/dashboarduser.php">Dashboard</a>
        <a href="/OnDKos/Kamar/index2user.php">Booking Kamar</a>
        <a href="/OnDKos/Transaksi/index7.php">Pemesanan dan pembayaran online</a>
        <a href="/OnDKos/User/index3user.php">Feedback atau Komplain</a>
        <a href="/OnDKos/User/index5.php">Pengaturan Profil</a>
    </div>
</div>

<a href="logout.php" class="logout">Logout</a>

<main>
    <div class="container">
        <div class="form-container">
            <h2>Feedback atau Komplain</h2>
            <form method="POST" action="/OnDKos/Feedback/submit.php">
                <label for="subjek">Subjek:</label>
                <input type="text" id="subjek" name="subjek" placeholder="Masukkan subjek" required>

                <label for="pesan">Pesan:</label>
                <textarea id="pesan" name="pesan" rows="5" placeholder="Masukkan pesan Anda" required></textarea>

                <button type="submit">Kirim Feedback</button>
            </form>
        </div>
    </div>
</main>

</body>
</html>
