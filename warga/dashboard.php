<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'warga') {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/database.php";
$agenda = mysqli_query($conn, "SELECT COUNT(*) AS total FROM agenda_rt");
$dataAgenda = mysqli_fetch_assoc($agenda);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Warga | EcoTrack RT 18</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, sans-serif;
    background:#f4f6f9;
    color:#333;
}

/* NAVBAR */
nav{
    background:#0d6efd;
    padding:15px 25px;
}

nav span{
    color:#fff;
    font-weight:bold;
    font-size:18px;
}

nav a{
    color:#fff;
    margin-left:15px;
    text-decoration:none;
    font-size:14px;
}

nav a:hover{
    text-decoration:underline;
}

/* HEADER */
.header{
    padding:25px;
}

.header h2{
    margin-bottom:6px;
}

/* SLIDER */
.slider{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
    padding:0 25px 25px;
}

.slider img{
    width:100%;
    height:150px;
    object-fit:cover;
    border-radius:14px;
    box-shadow:0 6px 15px rgba(0,0,0,.15);
}

/* CARD */
.card{
    background:#fff;
    margin:0 25px 25px;
    padding:25px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.card h3{
    margin-bottom:15px;
    color:#0d6efd;
}

/* STRUKTUR PENGURUS */
.struktur{
    display:flex;
    justify-content:center;
    margin-bottom:25px;
}

.struktur .ketua{
    text-align:center;
}

.struktur img{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #0d6efd;
}

.bawahan{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin-top:25px;
}

.bawahan div{
    text-align:center;
}

.bawahan img{
    width:100px;
    height:100px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #6c757d;
}

/* TABS */
.tabs{
    display:flex;
    gap:10px;
    margin-bottom:15px;
}

.tabs button{
    padding:8px 16px;
    border:none;
    background:#e9ecef;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

.tabs button.active{
    background:#0d6efd;
    color:#fff;
}

.tab-content{
    background:#f8f9fa;
    padding:15px;
    border-radius:10px;
}

/* FOOTER */
footer{
    background:#e9ecef;
    text-align:center;
    padding:20px;
    margin-top:30px;
    color:#555;
}
</style>
</head>

<body>

<nav>
    <span>EcoTrack RT 18</span>
    <a href="dashboard.php">Dashboard</a>
    <a href="jadwal.php">Jadwal Ronda</a>
    <a href="laporan.php">Laporan Warga</a>
    <a href="agenda.php">Agenda RT</a>
    <a href="daftar_warga.php">Daftar Warga</a>
    <a href="profile.php">Profil Saya</a>
    <a href="../auth/logout.php" style="float:right;">Logout</a>
</nav>

<div class="header">
    <h2>Selamat Datang, <?= $_SESSION['nama']; ?></h2>
    <p>Portal resmi informasi dan kegiatan warga RT 18</p>
</div>

<!-- BANNER INFORMASI -->
<div class="card">
    <img 
        src="https://asset-2.tribunnews.com/kaltim/foto/bank/images/20250802_banner-17-agustus.jpg"
        style="
            width:100%;
            height: 800px;
            object-fit:cover;
            border-radius:14px;
            margin-bottom:15px;
        "
        alt="Informasi RT 18"
    >
    <h3>Informasi RT 18</h3>
    <p>🏘️ Selamat Datang di Dashboard RT

Sistem Informasi Administrasi Warga

Dashboard ini dirancang sebagai pusat pengelolaan informasi dan layanan RT secara terintegrasi. Melalui sistem ini, pengurus dan warga dapat mengakses data kependudukan, agenda kegiatan, pengumuman, serta layanan administrasi dengan lebih cepat, transparan, dan efisien.

Digitalisasi administrasi RT bertujuan untuk meningkatkan kualitas pelayanan kepada warga, mempermudah pencatatan data, serta mendukung pengambilan keputusan berbasis informasi yang akurat dan terkini.</p>



</p>📌 Tujuan Sistem
</p>-Mempermudah pengelolaan data warga secara terpusat
</p>-Meningkatkan transparansi kegiatan dan agenda RT
</p>-Mempercepat layanan administrasi berbasis digital
</p>-Mewujudkan tata kelola RT yang modern dan tertib</p>
</div>

</div>

<!-- INFO -->
<div class="card">
    <h3>Informasi Umum</h3>
    <p>Total agenda RT: <b><?= $dataAgenda['total']; ?></b></p>
    <small>Update terakhir: <?= date('d-m-Y H:i:s'); ?></small>
</div>

<!-- STRUKTUR PENGURUS -->
<div class="card">
    <h3>Struktur Pengurus RT 18</h3>

    <div class="struktur">
        <div class="ketua">
            <img src="https://cloud.jpnn.com/photo/arsip/normal/2022/12/14/otis-pamutih-foto-instagram-mhpab-j2nu.jpg">
            <h4>SUTARNO</h4>
            <small>Ketua RT</small>
        </div>
    </div>

    <div class="bawahan">
        <div>
            <img src="https://static.republika.co.id/uploads/images/inpicture_slide/perdana-menteri-malaysia-yang-baru-diangkat-anwar-ibrahim_221125001513-187.jpg">
            <h4>NUROHMAN</h4>
            <small>Sekretaris</small>
        </div>

        <div>
            <img src="https://thumb.viva.id/vivabandung/665x374/2023/02/16/63ede01d96d4f-menteri-bumn-erick-thohir_bandung.jpg">
            <h4>AJI SURAJI</h4>
            <small>Bendahara</small>
        </div>
    </div>
</div>


<!-- INFORMASI -->
<div class="card">
    <div class="tabs">
        <button class="active">Info Terbaru</button>
        <button>Kegiatan</button>
        <button>Pengumuman</button>
    </div>

    <div class="tab-content">
        <p>Kerja bakti lingkungan akan dilaksanakan hari Minggu pukul 07.00 WIB.</p>
        <p>Tahlilan rutin malam Jumat ba’da Isya.</p>
    </div>
</div>

<footer>
    <b>EcoTrack RT 18</b><br>
    Sistem Informasi Warga © <?= date('Y'); ?><br>
    -alma ashofi-
</footer>

</body>
</html>
