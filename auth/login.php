<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login | EcoTrack RT 18</title>

<style>
*{box-sizing:border-box}
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Arial, sans-serif;
    background:linear-gradient(135deg,#0d6efd,#20c997);
}

/* CARD */
.login-box{
    width:360px;
    background:#fff;
    padding:32px;
    border-radius:18px;
    box-shadow:0 15px 35px rgba(0,0,0,.25);
}

.login-box h2{
    text-align:center;
    margin-bottom:6px;
}

.login-box p{
    text-align:center;
    color:#666;
    margin-bottom:22px;
}

/* INPUT */
input{
    width:100%;
    padding:13px;
    margin-bottom:14px;
    border-radius:10px;
    border:1px solid #ccc;
    font-size:14px;
}

input:focus{
    outline:none;
    border-color:#0d6efd;
}

/* BUTTON */
button{
    width:100%;
    padding:13px;
    background:#0d6efd;
    border:none;
    color:white;
    font-size:15px;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    background:#0b5ed7;
}

/* FOOTER */
.footer{
    margin-top:16px;
    text-align:center;
    font-size:13px;
    color:#888;
}
</style>
</head>

<body>

<div class="login-box">
    <h2>EcoTrack RT 18</h2>
    <p>Login Admin & Warga</p>

    <form method="POST" action="login_process.php">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Masuk</button>
    </form>

    <div class="footer">
        © <?= date('Y') ?> EcoTrack RT 18
    </div>
</div>

</body>
</html>
