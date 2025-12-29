<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

/* PROSES SIMPAN LAPORAN */
if (isset($_POST['kirim'])) {
    $user_id = $_SESSION['user_id'];
    $judul   = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi     = mysqli_real_escape_string($conn, $_POST['isi']);

    $foto = "";
    if (!empty($_FILES['foto']['name'])) {
        $ext  = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = uniqid().".".$ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/laporan/".$foto);
    }

    mysqli_query($conn, "
        INSERT INTO laporan_warga (user_id, judul, isi_laporan, foto)
        VALUES ('$user_id', '$judul', '$isi', '$foto')
    ");

    echo "<script>alert('Laporan berhasil dikirim');</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Warga | EcoTrack RT 18</title>

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#f4f6f9;
}

/* CONTAINER */
.container{
    max-width:700px;
    margin:40px auto;
}

/* CARD */
.card{
    background:#fff;
    border-radius:16px;
    padding:25px;
    box-shadow:0 6px 14px rgba(0,0,0,.1);
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.header h2{
    color:#0d6efd;
}

.back{
    text-decoration:none;
    color:#0d6efd;
    font-weight:bold;
}

/* FORM */
label{
    font-weight:bold;
    display:block;
    margin-bottom:6px;
}

input[type="text"],
textarea,
input[type="file"]{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:1px solid #ccc;
    margin-bottom:15px;
}

textarea{
    resize:vertical;
}

button{
    width:100%;
    padding:12px;
    background:#0d6efd;
    border:none;
    color:white;
    border-radius:12px;
    font-size:15px;
    cursor:pointer;
}

button:hover{
    background:#0b5ed7;
}

/* NOTE */
.note{
    font-size:13px;
    color:#666;
    margin-top:10px;
}
</style>
</head>

<body>

<div class="container">

    <div class="header">
        <h2>📢 Laporan Warga</h2>
        <a href="dashboard.php" class="back">← Kembali</a>
    </div>

    <div class="card">
        <form method="POST" enctype="multipart/form-data">

            <label>Judul Laporan</label>
            <input type="text" name="judul" placeholder="Contoh: Lampu Jalan Mati" required>

            <label>Isi Laporan</label>
            <textarea name="isi" rows="5" placeholder="Tuliskan laporan Anda secara jelas..." required></textarea>

            <label>Foto Pendukung (Opsional)</label>
            <input type="file" name="foto">

            <button type="submit" name="kirim">Kirim Laporan</button>

            <p class="note">
                Laporan Anda akan diteruskan ke pengurus RT untuk ditindaklanjuti.
            </p>
        </form>
    </div>

</div>

</body>
</html>
