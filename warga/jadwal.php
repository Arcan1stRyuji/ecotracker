<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'warga') {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* PROSES UPLOAD */
if (isset($_POST['upload'])) {
    $tanggal = $_POST['tanggal'];

    if (!empty($_FILES['foto']['name'])) {
        $ext  = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = uniqid().".".$ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/ronda/".$foto);

        mysqli_query($conn, "
            INSERT INTO bukti_ronda (user_id, tanggal, foto)
            VALUES ('$user_id', '$tanggal', '$foto')
        ");
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Jadwal Ronda Warga</title>

<style>
body{
    font-family:Arial, sans-serif;
    background:#f4f6f9;
    padding:20px;
}
h2{color:#0d6efd}
table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 6px 15px rgba(0,0,0,.08);
}
th,td{
    padding:14px;
    border-bottom:1px solid #eee;
}
th{
    background:#0d6efd;
    color:#fff;
}
.badge{
    display:inline-block;
    background:#20c997;
    color:#fff;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
}
button{
    padding:8px 14px;
    background:#0d6efd;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
}
button:hover{background:#0b5ed7}
.status{
    background:#adb5bd;
    padding:6px 12px;
    border-radius:20px;
    color:#fff;
    font-size:13px;
}
img{
    width:70px;
    border-radius:10px;
}
</style>
</head>

<body>

<h2>📅 Jadwal Ronda Warga</h2>
<a href="dashboard.php">⬅ Kembali</a><br><br>

<table>
<tr>
<th>Tanggal</th>
<th>Petugas</th>
<th>Bukti Ronda</th>
</tr>

<?php
$jadwal = [
    "2025-12-13" => ["Kastono","Kenan","Subeki","Hendra","Rudi"],
    "2025-12-14" => ["Sugianto","Sutarno","Karno","Adit","Basukin"],
    "2025-12-15" => ["Kemin","Zaki","Widodo","Manu","Gunadi"],

    "2025-12-16" => ["Tarjo","Dedi","Rudi T","Suraji","Misdi"],
    "2025-12-17" => ["Aji","Eko","Marda","Syahrir","Tanjung"],
    "2025-12-18" => ["Rohman","Rendi","Abas","Supri","Topan"],

    "2025-12-19" => ["Yudi","Kastono","Kenan","Subeki","Hendra"],
    "2025-12-20" => ["Rudi","Sugianto","Sutarno","Karno","Adit"],
    "2025-12-21" => ["Basuki","Kemin","Zaki","Widodo","Manu"],

    "2025-12-22" => ["Gunadi","Tarjo","Dedi","Rudi T","Marda"],
    "2025-12-23" => ["Sugianto","Sutarno","Karno","Adit","Basukin"],
    "2025-12-24" => ["Kemin","Zaki","Widodo","Manu","Gunadi"]
];


foreach ($jadwal as $tgl => $nama) {

$bukti = mysqli_query($conn,"
    SELECT * FROM bukti_ronda 
    WHERE user_id='$user_id' AND tanggal='$tgl'
");
$data = mysqli_fetch_assoc($bukti);
?>

<tr>
<td><?= date('d M Y', strtotime($tgl)) ?></td>
<td>
<?php foreach($nama as $n){ ?>
    <span class="badge"><?= $n ?></span>
<?php } ?>
</td>
<td>
<?php if ($data) { ?>
    <img src="../uploads/ronda/<?= $data['foto'] ?>"><br>
    <span class="status">Menunggu Konfirmasi</span>
<?php } else { ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="tanggal" value="<?= $tgl ?>">
        <input type="file" name="foto" required>
        <br><br>
        <button name="upload">Upload Bukti</button>
    </form>
<?php } ?>
</td>
</tr>

<?php } ?>

</table>

</body>
</html>
