<?php 
require 'config.php'; 
if (!isset($_SESSION['logged_in'])) { header("Location: index.php"); exit; } 

date_default_timezone_set('Asia/Makassar');
$user = $_SESSION['username'];

// Ambil semua tanggal unik dari diary, terbaru dulu
$query = mysqli_query($conn, "SELECT DISTINCT date FROM diary WHERE username='$user' ORDER BY date DESC");

$streak = 0;
$today     = date("Y-m-d");
$yesterday = date("Y-m-d", strtotime("-1 day"));
$total_days = mysqli_num_rows($query);

if ($total_days > 0) {
    $dates = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $dates[] = $row['date'];
    }
    
    // Streak hanya valid kalau hari ini atau kemarin ada entri
    if ($dates[0] == $today || $dates[0] == $yesterday) {
        $streak = 1;
        $expected_date = $dates[0];
        
        for ($i = 1; $i < count($dates); $i++) {
            $expected_date = date("Y-m-d", strtotime($expected_date . " -1 day"));
            if ($dates[$i] == $expected_date) {
                $streak++;
            } else {
                break;
            }
        }
    }
}

// Pesan motivasi berdasarkan streak
if ($streak == 0) {
    $pesan = "Yuk mulai isi diary hari ini buat ngebangun streak kamu! 🚀";
    $color = "var(--hot-pink)";
} elseif ($streak < 3) {
    $pesan = "Baru mulai nih! Pertahankan terus ya bestie! 💪";
    $color = "var(--yellow)";
} elseif ($streak < 7) {
    $pesan = "Hari konsisten merawat skin barrier! Keep it up! 💅✨";
    $color = "var(--cyan)";
} else {
    $pesan = "LEGEND! $streak hari berturut-turut! Skin barrier kamu pasti kuat banget! 👑";
    $color = "var(--green)";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glow.exe - Streak</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@700;800&family=Silkscreen&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="static/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="navbar">
        <div class="logo">GLOW.EXE</div>
        <div class="links">
            <a href="routine.php">Routine</a> 
            <a href="streak.php">Streak</a> 
            <a href="diary.php">Diary</a> 
            <a href="stash.php">Stash</a> 
            <a href="tips.php">Tips</a>
            <a href="model.php">Scanner</a>
            <!-- Tombol Logout kita kasih warna merah/pink biar mencolok! -->
            <a href="logout.php" style="color: var(--hot-pink); font-weight: bold;">LOGOUT 🚪</a>
        </div>
    </div>

    <div class="main-container" style="display: flex; justify-content: center; align-items: center; min-height: 70vh;">
        <div class="retro-window" style="width: 100%; max-width: 500px; text-align: center;">
            <div class="window-titlebar bg-pink"><span>streak_status.exe</span><div>_ ◻ X</div></div>
            <div class="window-content" style="padding: 40px;">
                <h2 class="subtitle-syne" style="margin-top: 0; color: var(--black); text-shadow: 2px 2px 0px var(--yellow);">YOUR STREAK 🔥</h2>
                
                <!-- Angka streak -->
                <div style="font-family: 'Syne', sans-serif; font-weight: 800; font-size: 8rem; line-height: 1; margin: 20px 0; color: var(--black); text-shadow: 4px 4px 0px var(--cyan);">
                    <?php echo $streak; ?>
                </div>
                
                <p style="font-weight: bold; font-size: 0.9rem; margin-bottom: 10px; line-height: 1.6; color: <?php echo $color; ?>">
                    <?php echo $pesan; ?>
                </p>

                <!-- Total hari -->
                <div style="border: 2px solid var(--black); padding: 10px; margin: 20px 0; font-family: 'Space Mono'; font-size: 0.85rem;">
                    <strong>Total hari ngisi diary:</strong> <?php echo $total_days; ?> hari
                </div>

                <!-- Cek apakah sudah isi hari ini -->
                <?php
                $cek_today = mysqli_query($conn, "SELECT id FROM diary WHERE username='$user' AND date='$today'");
                if (mysqli_num_rows($cek_today) > 0): ?>
                    <div style="background: var(--cyan); border: 2px solid var(--black); padding: 8px; font-family: 'Silkscreen'; font-size: 0.8rem; margin-bottom: 20px;">
                        ✅ DIARY HARI INI SUDAH DIISI!
                    </div>
                <?php else: ?>
                    <div style="background: var(--yellow); border: 2px solid var(--black); padding: 8px; font-family: 'Silkscreen'; font-size: 0.8rem; margin-bottom: 20px;">
                        ⚠️ BELUM ISI DIARY HARI INI!
                    </div>
                <?php endif; ?>
                
                <a href="diary.php" style="text-decoration: none;">
                    <button class="y2k-btn btn-yellow">➡ LANJUT ISI DIARY 📝</button>
                </a>
            </div>
        </div>
    </div>
</body>
</html>