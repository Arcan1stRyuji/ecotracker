<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

/* ===== DATA AGENDA TAMBAHAN (HARDCODE) ===== */
$agendaTambahan = [
    ["judul" => "Tahlilan Warga", "tanggal" => "2025-12-14", "kategori" => "Keagamaan"],
    ["judul" => "Yasinan Ibu-Ibu", "tanggal" => "2025-12-16", "kategori" => "Keagamaan"],
    ["judul" => "Pengajian Rutin", "tanggal" => "2025-12-21", "kategori" => "Keagamaan"],

    ["judul" => "Kerja Bakti Lingkungan", "tanggal" => "2025-12-15", "kategori" => "Rutin"],
    ["judul" => "Kerja Bakti Saluran Air", "tanggal" => "2025-12-22", "kategori" => "Rutin"],

    ["judul" => "Posyandu Balita", "tanggal" => "2025-12-17", "kategori" => "Kesehatan"],
    ["judul" => "Cek Kesehatan Lansia", "tanggal" => "2025-12-24", "kategori" => "Kesehatan"],

    ["judul" => "Rapat RT Bulanan", "tanggal" => "2025-12-18", "kategori" => "Lainnya"],
    ["judul" => "Sosialisasi Keamanan Lingkungan", "tanggal" => "2025-12-23", "kategori" => "Lainnya"],

    ["judul" => "Kegiatan Karang Taruna", "tanggal" => "2025-12-20", "kategori" => "Karang Taruna"]
];

/* ===== AMBIL DATA DARI DB ===== */
$agendaDB = [];
$queryAgenda = mysqli_query($conn, "SELECT judul, tanggal, kategori FROM agenda_rt");
while ($row = mysqli_fetch_assoc($queryAgenda)) {
    $agendaDB[] = $row;
}

/* ===== GABUNG & URUTKAN ===== */
$agendaSemua = array_merge($agendaTambahan, $agendaDB);
usort($agendaSemua, fn($a, $b) => strtotime($a['tanggal']) - strtotime($b['tanggal']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Agenda RT 18</title>

<style>
body{
    font-family: Arial, sans-serif;
    background:#f7f9fc;
    margin:0;
}
.container{
    max-width:900px;
    margin:40px auto;
    padding:0 15px;
}
h1{
    color:#0d6efd;
}
.btn-back{
    display:inline-block;
    margin-bottom:15px;
    text-decoration:none;
    color:#0d6efd;
    font-weight:bold;
}
.card{
    background:#fff;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
    padding:10px 20px;
}
.agenda-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 0;
    border-bottom:1px solid #eee;
}
.agenda-item:last-child{border-bottom:none;}
.badge{
    padding:6px 16px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
    color:#fff;
}
.Rutin{background:#198754;}
.Kesehatan{background:#0dcaf0;}
.Keagamaan{background:#6c757d;}
.KarangTaruna{background:#fd7e14;}
.Lainnya{background:#ffc107;color:#000;}
</style>
</head>

<body>
<div class="container">
    <h1>Agenda & Kegiatan RT 18</h1>
    <a href="dashboard.php" class="btn-back">← Kembali ke Dashboard</a>

    <div class="card">
        <?php foreach ($agendaSemua as $agenda): ?>
            <div class="agenda-item">
                <div>
                    <strong><?= htmlspecialchars($agenda['judul']); ?></strong>
                    — <?= date('l, d M Y', strtotime($agenda['tanggal'])); ?>
                </div>
                <span class="badge <?= str_replace(' ', '', $agenda['kategori']); ?>">
                    <?= $agenda['kategori']; ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
