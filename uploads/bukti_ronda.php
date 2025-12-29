<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'warga') {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/database.php";

/* ambil jadwal */
$jadwal = mysqli_query($conn, "SELECT id, tanggal, keterangan FROM jadwal_ronda ORDER BY tanggal ASC");
?>
<?php
if (isset($_POST['upload'])) {
    $jadwal_id = $_POST['jadwal_id'];
    $user_id   = $_SESSION['user_id'];
    $tanggal   = date('Y-m-d');

    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];

    $ext = pathinfo($foto, PATHINFO_EXTENSION);
    $nama_file = uniqid() . '.' . $ext;

    $folder = "../uploads/bukti_ronda/";

    if (move_uploaded_file($tmp, $folder . $nama_file)) {
        mysqli_query($conn, "
            INSERT INTO bukti_ronda (jadwal_id, user_id, foto, tanggal, status)
            VALUES ('$jadwal_id', '$user_id', '$nama_file', '$tanggal', 'menunggu')
        ");
        echo "<script>alert('Bukti berhasil diupload'); location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Upload gagal');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Upload Bukti Ronda</title>
</head>
<body>

<h2>📤 Upload Bukti Ronda</h2>
<a href="dashboard.php">⬅ Kembali</a>

<form action="" method="POST" enctype="multipart/form-data">
    <label>Pilih Jadwal</label><br>
    <select name="jadwal_id" required>
        <option value="">-- Pilih Jadwal --</option>
        <?php while ($j = mysqli_fetch_assoc($jadwal)) { ?>
            <option value="<?= $j['id'] ?>">
                <?= date('d-m-Y', strtotime($j['tanggal'])) ?> - <?= $j['keterangan'] ?>
            </option>
        <?php } ?>
    </select>
    <br><br>

    <label>Upload Foto Bukti</label><br>
    <input type="file" name="foto" accept="image/*" required>
    <br><br>

    <button type="submit" name="upload">Upload</button>
</form>

</body>
</html>
