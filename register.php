<?php
require 'config.php';

if (isset($_SESSION['logged_in'])) { header("Location: routine.php"); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = $_POST['password'];

    if (strlen($username) < 3) {
        $error = "Username minimal 3 karakter!";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah dipakai, cari yang lain!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed', 'member')");
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'member';
            header("Location: routine.php"); exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glow.exe - Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@700;800&family=Silkscreen&display=swap" rel="stylesheet">
    <!-- Trik Cache Busting biar desain langsung update -->
    <link rel="stylesheet" href="static/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <!-- Navbar dengan tambahan About -->
    <div class="navbar">
        <div class="logo">GLOW.EXE</div>
        <div class="links">
            <a href="routine.php">Routine</a> 
            <a href="streak.php">Streak</a> 
            <a href="diary.php">Diary</a> 
            <a href="stash.php">Stash</a> 
            <a href="tips.php">Tips</a>
            <a href="about.php">About</a>
            <a href="model.php">Scanner</a>
        </div>
    </div>

    <div style="display: flex; justify-content: center; align-items: center; margin-top: 80px;">
        <div class="retro-window" style="width: 100%; max-width: 400px;">
            <div class="window-titlebar"><span>sys_signup.exe</span><div>_ ◻ X</div></div>
            <div class="window-content" style="text-align: center;">
                <h2 class="subtitle-syne" style="margin-top: 0;">CREATE<br>ACCOUNT 🎀</h2>
                <p style="font-weight: bold; margin-bottom: 20px; font-size: 0.85rem; font-family: 'Space Mono';">Kunci lemari skincare kamu</p>
                
                <?php if($error): ?>
                    <div style="background: #ff4757; color: white; padding: 10px; margin-bottom: 15px; border: 2px solid black; font-weight: bold; font-size: 0.85rem;">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <input type="text" name="username" class="y2k-input" placeholder="Choose Username..." required autocomplete="off" style="text-align: center;">
                    <input type="password" name="password" class="y2k-input" placeholder="Create Password..." required style="text-align: center;">
                    <button type="submit" class="y2k-btn btn-green">SIGN UP NOW 🚀</button>
                </form>
                
                <p style="margin-top: 25px; font-size: 0.85rem; font-weight: bold;">
                    Sudah punya akun? <a href="index.php" style="color: var(--hot-pink); text-decoration: none;">Login kembali</a>
                </p>

                <!-- INI DIA TOMBOL INFO ANGGOTA-NYA -->
                <hr style="border: 1px dashed var(--black); margin: 20px 0;">
                <a href="about.php" style="text-decoration: none;">
                    <button type="button" class="y2k-btn" style="font-size: 0.85rem; margin-top: 0; background-color: var(--cyan); color: var(--black);">📂 INFO KELOMPOK</button>
                </a>

            </div>
        </div>
    </div>
</body>
</html> 