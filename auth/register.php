<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Registrasi Warga | EcoTrack</title>

<style>
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Arial, sans-serif;
    background:linear-gradient(135deg,#20c997,#0d6efd);
}

.box{
    width:380px;
    background:#fff;
    padding:30px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,.2);
}

.box h2{
    text-align:center;
    margin-bottom:20px;
}

input{
    width:100%;
    padding:12px;
    margin-bottom:12px;
    border-radius:10px;
    border:1px solid #ccc;
}

button{
    width:100%;
    padding:12px;
    background:#20c997;
    border:none;
    color:white;
    border-radius:10px;
    font-size:15px;
    cursor:pointer;
}

button:hover{
    background:#198754;
}

a{
    display:block;
    text-align:center;
    margin-top:15px;
    color:#0d6efd;
    font-weight:bold;
    text-decoration:none;
}
</style>
</head>

<body>

<div class="box">
    <h2>Registrasi Warga</h2>

    <form method="POST" action="register_process.php">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="alamat" placeholder="Alamat" required>
        <input type="text" name="no_wa" placeholder="No WhatsApp" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="register">Daftar</button>
    </form>

    <a href="login.php">← Kembali ke Login</a>
</div>

</body>
</html>
