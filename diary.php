<?php
require 'config.php';
if (!isset($_SESSION['logged_in'])) { header("Location: index.php"); exit; }
date_default_timezone_set('Asia/Makassar');
$user = $_SESSION['username'];

// 1. FITUR DELETE
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM diary WHERE id='$del_id' AND username='$user'");
    header("Location: diary.php"); exit;
}

// 2. FITUR CREATE & UPDATE (SMART MERGE)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mood = mysqli_real_escape_string($conn, $_POST['mood']); 
    $note = mysqli_real_escape_string($conn, trim($_POST['note']));
    
    if (!empty($_POST['edit_id'])) {
        // Update langsung kalau dari tombol Edit
        $edit_id = (int)$_POST['edit_id'];
        mysqli_query($conn, "UPDATE diary SET mood='$mood', note='$note' WHERE id='$edit_id' AND username='$user'");
    } else {
        $date = date("Y-m-d"); 
        $cek = mysqli_query($conn, "SELECT id, note FROM diary WHERE username='$user' AND date='$date'");
        
        if (mysqli_num_rows($cek) == 0) {
            // Belum ada entri hari ini, insert baru
            mysqli_query($conn, "INSERT INTO diary (username, date, mood, note) VALUES ('$user', '$date', '$mood', '$note')");
        } else {
            // SMART MERGE: ada log otomatis dari routine, gabungkan
            $row = mysqli_fetch_assoc($cek);
            $existing_note = $row['note'];
            
            // Cek apakah ada log otomatis (tandanya ada "✅")
            if (strpos($existing_note, '✅') !== false) {
                // Catatan user di atas, log sistem di bawah
                $merged = mysqli_real_escape_string($conn, $note . "\n---\n" . $existing_note);
                mysqli_query($conn, "UPDATE diary SET mood='$mood', note='$merged' WHERE id={$row['id']} AND username='$user'");
            } else {
                // Tidak ada log otomatis, timpa saja
                mysqli_query($conn, "UPDATE diary SET mood='$mood', note='$note' WHERE id={$row['id']} AND username='$user'");
            }
        }
    }
    header("Location: diary.php"); exit;
}

// 3. AMBIL DATA UNTUK FORM EDIT
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM diary WHERE id='$edit_id' AND username='$user'");
    $edit_data = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glow.exe - Diary</title>
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

    <div class="main-container split-50">
        <!-- FORM TULIS DIARY -->
        <div class="retro-window">
            <div class="window-titlebar bg-pink">
                <span><?php echo $edit_data ? 'edit_log.exe' : 'add_diary_log.exe'; ?></span>
                <div>_ ◻ X</div>
            </div>
            <div class="window-content">
                <h2 class="subtitle-syne" style="margin-top: 0; text-align: left;">
                    <?php echo $edit_data ? 'EDIT DIARY ✏️' : 'HOW\'S THE SKIN? 📔'; ?>
                </h2>
                
                <p style="font-family: 'Space Mono'; font-weight: bold; color: var(--hot-pink); margin-bottom: 20px;">
                    Date: <?php echo $edit_data ? date("d F Y", strtotime($edit_data['date'])) : date("d F Y"); ?>
                </p>

                <form action="diary.php" method="POST">
                    <input type="hidden" name="edit_id" value="<?php echo $edit_data ? $edit_data['id'] : ''; ?>">
                    
                    <select name="mood" class="y2k-select" required>
                        <option value="Glowing ✨" <?php echo ($edit_data && $edit_data['mood'] == 'Glowing ✨') ? 'selected' : ''; ?>>Glowing ✨</option>
                        <option value="Breakout 🚨" <?php echo ($edit_data && $edit_data['mood'] == 'Breakout 🚨') ? 'selected' : ''; ?>>Breakout 🚨</option>
                        <option value="Dry/Flaky 🌵" <?php echo ($edit_data && $edit_data['mood'] == 'Dry/Flaky 🌵') ? 'selected' : ''; ?>>Dry/Flaky 🌵</option>
                        <option value="Normal 😊" <?php echo ($edit_data && $edit_data['mood'] == 'Normal 😊') ? 'selected' : ''; ?>>Normal 😊</option>
                        <option value="Oily 💦" <?php echo ($edit_data && $edit_data['mood'] == 'Oily 💦') ? 'selected' : ''; ?>>Oily 💦</option>
                    </select>
                    
                    <textarea name="note" class="y2k-input" rows="5" placeholder="Ceritain kondisi kulit kamu hari ini..." required style="resize: none;"><?php 
                        if ($edit_data) {
                            // Kalau edit, tampilkan hanya bagian user note (sebelum ---)
                            $parts = explode("\n---\n", $edit_data['note'], 2);
                            echo htmlspecialchars($parts[0]);
                        }
                    ?></textarea>
                    
                    <?php if($edit_data): ?>
                        <button type="submit" class="y2k-btn btn-cyan">UPDATE DIARY 💾</button>
                        <a href="diary.php"><button type="button" class="y2k-btn btn-yellow">CANCEL EDIT ❌</button></a>
                    <?php else: ?>
                        <button type="submit" class="y2k-btn btn-green">SAVE DIARY ENTRY 💾</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- LIST DIARY -->
        <div class="retro-window">
            <div class="window-titlebar bg-black"><span>vault_logs.txt</span><div>_ ◻ X</div></div>
            <div class="window-content" style="max-height: 400px; overflow-y: auto; padding: 15px;">
                <?php
                $res = mysqli_query($conn, "SELECT * FROM diary WHERE username='$user' ORDER BY date DESC");
                if (mysqli_num_rows($res) == 0) { 
                    echo '<p style="text-align: center; font-weight: bold;">Belum ada catatan skincare-mu di vault ini. Yuk isi!</p>'; 
                }
                while($entry = mysqli_fetch_assoc($res)):
                    // Smart split: pisahkan catatan user dan log sistem
                    $parts = explode("\n---\n", $entry['note'], 2);
                    $user_note = $parts[0];
                    $sys_log   = isset($parts[1]) ? $parts[1] : null;
                ?>
                    <div style="border: 3px solid var(--black); padding: 15px; margin-bottom: 15px; background: var(--white); box-shadow: 4px 4px 0 var(--black);">
                        <div style="display: flex; justify-content: space-between; font-weight: bold; border-bottom: 2px solid var(--black); padding-bottom: 8px; margin-bottom: 8px;">
                            <span><?php echo date("d M Y", strtotime($entry['date'])); ?></span>
                            <span style="color: var(--hot-pink);"><?php echo htmlspecialchars($entry['mood']); ?></span>
                        </div>

                        <!-- Catatan user -->
                        <p style="white-space: pre-wrap; margin: 0 0 10px 0; font-size: 0.9rem; line-height: 1.5;"><?php echo htmlspecialchars($user_note); ?></p>
                        
                        <!-- Log sistem (kalau ada) — ditampilkan sebagai badge Y2K -->
                        <?php if($sys_log): ?>
                        <div style="background: #00FFFF; border: 2px solid var(--black); padding: 6px 10px; font-family: 'Silkscreen'; font-size: 0.75rem; color: var(--black); margin-bottom: 10px;">
                            🖥️ SYS LOG: <?php echo htmlspecialchars($sys_log); ?>
                        </div>
                        <?php endif; ?>
                        
                        <div style="text-align: right; margin-top: 10px;">
                            <a href="diary.php?edit=<?php echo $entry['id']; ?>" style="text-decoration:none; border:2px solid black; background:var(--yellow); padding:2px 8px; color:black; font-weight:bold; font-size:0.8rem;">✏️ EDIT</a>
                            <a href="diary.php?delete=<?php echo $entry['id']; ?>" onclick="return confirm('Hapus jurnal hari ini? Streak kamu bisa terpengaruh lho!')" style="text-decoration:none; border:2px solid black; background:var(--hot-pink); padding:2px 8px; color:white; font-weight:bold; font-size:0.8rem;">🗑️ HAPUS</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>