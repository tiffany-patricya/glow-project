<?php
require 'config.php';
if (isset($_SESSION['logged_in'])) { header("Location: routine.php"); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: routine.php");
        }
        exit;
    } else {
        $error = "Username atau Password salah! 💔";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glow.exe - Login</title>
    <!-- MANTRA ANTI-MELAR: Tarik font langsung dari Google -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
    <!-- Navbar Persis SS -->
    <div class="navbar">
        <div class="logo">GLOW.EXE</div>
        <div class="links">
            <a href="routine.php">Routine</a> <a href="streak.php">Streak</a> <a href="diary.php">Diary</a> <a href="stash.php">Stash</a> <a href="tips.php">Tips</a> <a href="model.php">Scanner</a>
        </div>
    </div>

    <!-- Layout Split 50:50 -->
    <div class="main-container split-50">
        <!-- Kiri: Teks Estetik -->
        <div class="hero-text">
            <h1 class="title-syne">YOUR<br>GLOW UP<br>ERA. ✨</h1>
            <div class="retro-window" style="background-color: #E8E4F8; box-shadow: 6px 6px 0px var(--black);">
                <div class="window-content" style="padding: 20px; font-weight: bold; font-size: 0.95rem; line-height: 1.6;">
                    <p style="margin-top:0;">No more gatekeeping your own glow up! 💅</p>
                    <p style="margin-bottom:0;">Web app ini buat nge-track AM/PM routine kamu, flex consistency streak, dan dump skin mood kamu di satu vault yang aesthetic parah. Biar skin barrier tetep slay dan kamu otomatis masuk anti-breakout club. Periodt. 🎀</p>
                </div>
            </div>
        </div>

        <!-- Kanan: Form Login -->
        <div style="max-width: 400px; margin-left: auto; width: 100%;">
            <div class="retro-window">
                <div class="window-titlebar"><span>login.exe</span><div>_ ◻ X</div></div>
                <div class="window-content">
                    <h2 class="subtitle-syne" style="margin-top: 0;">ENTER THE<br>VAULT 🔓</h2>
                    
                    <?php if($error): ?>
                        <div style="background: #ff4757; color: white; padding: 10px; margin-bottom: 15px; border: 2px solid black; font-weight: bold; font-size: 0.85rem;">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <input type="text" name="username" class="y2k-input" placeholder="Username" required autocomplete="off">
                        <input type="password" name="password" class="y2k-input" placeholder="Password" required>
                        <button type="submit" class="y2k-btn btn-yellow">LOGIN TO SYSTEM</button>
                    </form>
                    <p style="margin-top: 20px; font-size: 0.85rem; text-align: center; font-weight: bold;">
    Belum punya akun? <a href="register.php" style="color: var(--hot-pink);">Daftar</a>
</p>

<hr style="border: 1px dashed var(--black); margin: 20px 0;">
<a href="about.php" style="text-decoration: none;">
    <button type="button" class="y2k-btn btn-cyan" style="font-size: 0.85rem; margin-top: 0;">📂 ABOUT US </button>
</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
