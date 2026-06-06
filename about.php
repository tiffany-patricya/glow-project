<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glow.exe - About Team</title>
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
    </div>

    <div class="main-container">
        <div class="retro-window" style="max-width: 800px; margin: 0 auto;">
            <div class="window-titlebar bg-pink"><span>system_info_devs.txt</span><div>_ ◻ X</div></div>
            <div class="window-content" style="background-color: var(--white);">
                <h2 class="title-syne" style="text-align: center; font-size: 2.5rem; color: var(--black); margin-bottom: 5px;">DEVELOPER TEAM 🚀</h2>
                <p style="text-align: center; font-family: 'Space Mono'; font-weight: bold; margin-bottom: 30px;">Behind the aesthetic code of GLOW.EXE</p>

                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <?php
                    // Data statis anggota kelompok (ditambah key 'image' untuk letak file foto)
                    $team = [
                        ['name' => 'Levizera Sylomita Passah', 'role' => 'Frontend & AI lead', 'icon' => '🎀', 'image' => 'static/image/lepi.jpeg'],
                        ['name' => 'Tiffany Patricya Laurelle Pondaag', 'role' => 'Frontend & Backend Engineer', 'icon' => '🗄️', 'image' => 'static/image/tip.jpeg'],
                        ['name' => 'Myflower Nadine Pangemanan', 'role' => 'Technical Writer', 'icon' => '🤖', 'image' => 'static/image/abung.jpeg'],
                        ['name' => 'Michelle Maria Michiko Sumuweng ', 'role' => 'Technical Writer', 'icon' => '😏', 'image' => 'static/image/kimich.jpeg'],
                    ];

                    foreach ($team as $idx => $member) {
                        echo '<div style="border: 3px solid var(--black); background: #f8f8f8; padding: 15px; box-shadow: 4px 4px 0 var(--black); display: flex; align-items: center; gap: 15px; transition: transform 0.2s;">';
                        
                        // Menampilkan Foto Profil
                        echo '<img src="' . $member['image'] . '" alt="Foto ' . $member['name'] . '" style="width: 55px; height: 55px; object-fit: cover; border: 2px solid var(--black); border-radius: 4px; background-color: #eaeaea;">';
                        
                        // Menampilkan Icon Emoji bawaan kamu
                        echo '<div style="font-size: 2rem;">' . $member['icon'] . '</div>';
                        
                        // Menampilkan Nama dan Role
                        echo '<div>';
                        echo '<strong style="color: var(--hot-pink); font-family: \'Syne\', sans-serif; font-size: 1.2rem; text-transform: uppercase;">' . $member['name'] . '</strong>';
                        echo '<p style="margin: 5px 0 0 0; font-family: \'Space Mono\'; font-size: 0.9rem; font-weight: bold;">Role: ' . $member['role'] . '</p>';
                        echo '</div></div>';
                    }
                    ?>
                </div>

                <div style="margin-top: 30px; text-align: center;">
                    <a href="index.php" style="text-decoration: none;">
                        <button class="y2k-btn btn-cyan" style="width: auto; padding: 10px 30px;">⬅ BACK TO SYSTEM</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>



