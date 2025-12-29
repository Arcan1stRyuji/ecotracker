<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_SESSION['user_id'];
$q = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Profil Saya | EcoTrack</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f9;
}
.container {
    max-width: 900px;
    margin: 40px auto;
}
.back {
    text-decoration: none;
    color: #0d6efd;
    font-weight: bold;
}
.card {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
    display: flex;
    gap: 30px;
    margin-top: 20px;
}
.profile-img {
    text-align: center;
}
.profile-img img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #0d6efd;
}
.profile-info {
    flex: 1;
}
.profile-info h2 {
    margin-bottom: 15px;
}
.info p {
    margin: 6px 0;
    color: #444;
}
label {
    font-weight: bold;
    margin-top: 10px;
    display: block;
}
input, textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 6px;
    border: 1px solid #ccc;
}
button {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
.edit-btn {
    background: #0d6efd;
    color: #fff;
}
.save-btn {
    background: #198754;
    color: #fff;
}
.cancel-btn {
    background: #6c757d;
    color: #fff;
    margin-left: 10px;
}
.hidden {
    display: none;
}
</style>
</head>

<body>

<div class="container">
    <a href="dashboard.php" class="btn-back">← Kembali ke Dashboard</a>

    <div class="card">
        <!-- FOTO -->
        <div class="profile-img">
            <img src="/ecotrack/uploads/profile/<?= $user['foto']; ?>">
            <p><strong><?= $user['nama']; ?></strong></p>
            <small><?= ucfirst($user['role']); ?></small>
        </div>

        <!-- INFO VIEW -->
        <div class="profile-info">

            <h2>Profil Saya</h2>

            <div id="viewMode" class="info">
                <p><strong>Nama:</strong> <?= $user['nama']; ?></p>
                <p><strong>Alamat:</strong> <?= $user['alamat']; ?></p>
                <p><strong>No WhatsApp:</strong> <?= $user['no_wa']; ?></p>

                <br>
                <button class="edit-btn" onclick="editProfile()">✏️ Edit Profil</button>
            </div>

            <!-- FORM EDIT -->
            <form id="editMode" class="hidden" action="update_profile.php" method="POST" enctype="multipart/form-data">
                <label>Nama</label>
                <input type="text" name="nama" value="<?= $user['nama']; ?>" required>

                <label>Alamat</label>
                <textarea name="alamat"><?= $user['alamat']; ?></textarea>

                <label>No WhatsApp</label>
                <input type="text" name="no_wa" value="<?= $user['no_wa']; ?>">

                <label>Foto Profil</label>
                <input type="file" name="foto">

                <br>
                <button type="submit" class="save-btn">💾 Simpan</button>
                <button type="button" class="cancel-btn" onclick="cancelEdit()">Batal</button>
            </form>

        </div>
    </div>
</div>

<script>
function editProfile(){
    document.getElementById('viewMode').classList.add('hidden');
    document.getElementById('editMode').classList.remove('hidden');
}
function cancelEdit(){
    document.getElementById('editMode').classList.add('hidden');
    document.getElementById('viewMode').classList.remove('hidden');
}
</script>

</body>
</html>
