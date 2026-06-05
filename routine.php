<?php
require 'config.php';
if (!isset($_SESSION['logged_in'])) { header("Location: index.php"); exit; }
$user = $_SESSION['username'];
date_default_timezone_set('Asia/Makassar');

// Ambil produk dari stash user untuk dropdown
$cleanser    = mysqli_query($conn, "SELECT * FROM stash WHERE username='$user' AND product_type='Cleanser'");
$moisturizer = mysqli_query($conn, "SELECT * FROM stash WHERE username='$user' AND product_type='Moisturizer'");
$sunscreen   = mysqli_query($conn, "SELECT * FROM stash WHERE username='$user' AND product_type='Sunscreen'");
$treatment   = mysqli_query($conn, "SELECT * FROM stash WHERE username='$user' AND product_type='Toner/Serum'");

// Tombol DONE
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['routine_done'])) {
    $date = date("Y-m-d");
    $type = isset($_POST['routine_type']) ? $_POST['routine_type'] : 'AM';

    $cek = mysqli_query($conn, "SELECT id, note FROM diary WHERE username='$user' AND date='$date'");
    $row = mysqli_fetch_assoc($cek);

    $sys_log = "✅ Skincare routine $type completed automatically!";

    if ($row) {
        $merged = mysqli_real_escape_string($conn, $row['note'] . "\n---\n" . $sys_log);
        mysqli_query($conn, "UPDATE diary SET note='$merged' WHERE id={$row['id']}");
    } else {
        $sys_log_esc = mysqli_real_escape_string($conn, $sys_log);
        mysqli_query($conn, "INSERT INTO diary (username, date, mood, note) 
                             VALUES ('$user', '$date', 'Glowing ✨', '$sys_log_esc')");
    }

    header("Location: streak.php"); exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glow.exe - Routine</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@700;800&family=Silkscreen&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="static/css/style.css?v=<?php echo time(); ?>">
    <style>
        .custom-cb { width: 22px; height: 22px; accent-color: var(--yellow); cursor: pointer; border: 2px solid black; }
        .routine-item { margin-bottom: 25px; }
        .routine-item .y2k-input, .routine-item .y2k-select { padding: 8px; font-size: 0.85rem; margin-bottom: 5px; }
    </style>
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

    <form method="POST" action="">
        <div class="main-container">
            <div class="split-50">
                <div class="retro-window">
                    <div class="window-content">
                        <h2 class="title-syne" style="font-size: 2.3rem; text-shadow: none; margin-bottom: 30px;">MORNING<br>GLOW ☀️</h2>
                        
                        <div class="routine-item">
                            <label class="routine-label"><input type="checkbox" class="custom-cb"> <span style="margin-left: 10px;">Cleanser</span></label>
                            <select class="y2k-select" name="am_cleanser">
                                <?php if(mysqli_num_rows($cleanser) > 0): ?>
                                    <option value="">-- Select Cleanser Used --</option>
                                    <?php while($p = mysqli_fetch_assoc($cleanser)): ?>
                                        <option value="<?= htmlspecialchars($p['product_name']) ?>"><?= htmlspecialchars($p['product_name']) ?></option>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <option disabled>Stash Cleanser Kosong!</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="routine-item">
                            <label class="routine-label"><input type="checkbox" class="custom-cb"> <span style="margin-left: 10px;">Moisturizer</span></label>
                            <select class="y2k-select" name="am_moisturizer">
                                <?php if(mysqli_num_rows($moisturizer) > 0): ?>
                                    <option value="">-- Select Moisturizer Used --</option>
                                    <?php while($p = mysqli_fetch_assoc($moisturizer)): ?>
                                        <option value="<?= htmlspecialchars($p['product_name']) ?>"><?= htmlspecialchars($p['product_name']) ?></option>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <option disabled>Stash Moisturizer Kosong!</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="routine-item">
                            <label class="routine-label"><input type="checkbox" class="custom-cb"> <span style="margin-left: 10px;">Sunscreen (Wajib!)</span></label>
                            <select class="y2k-select" name="am_sunscreen">
                                <?php if(mysqli_num_rows($sunscreen) > 0): ?>
                                    <option value="">-- Select Sunscreen Used --</option>
                                    <?php while($p = mysqli_fetch_assoc($sunscreen)): ?>
                                        <option value="<?= htmlspecialchars($p['product_name']) ?>"><?= htmlspecialchars($p['product_name']) ?></option>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <option disabled>Stash Sunscreen Kosong!</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="retro-window">
                    <div class="window-content">
                        <h2 class="title-syne" style="font-size: 2.3rem; text-shadow: none; margin-bottom: 30px;">NIGHT<br>REPAIR 🌙</h2>
                        
                        <div class="routine-item">
                            <label class="routine-label"><input type="checkbox" class="custom-cb"> <span style="margin-left: 10px;">Double Cleanse</span></label>
                            <select class="y2k-select" name="pm_cleanser">
                                <?php if(mysqli_num_rows($cleanser) > 0): ?>
                                    <option value="">-- Select Cleanser Used --</option>
                                    <?php mysqli_data_seek($cleanser, 0); while($p = mysqli_fetch_assoc($cleanser)): ?>
                                        <option value="<?= htmlspecialchars($p['product_name']) ?>"><?= htmlspecialchars($p['product_name']) ?></option>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <option disabled>Stash Cleanser Kosong!</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="routine-item">
                            <label class="routine-label"><input type="checkbox" class="custom-cb"> <span style="margin-left: 10px;">Treatment (Toner/Serum)</span></label>
                            <select class="y2k-select" name="pm_treatment">
                                <?php if(mysqli_num_rows($treatment) > 0): ?>
                                    <option value="">-- Select Treatment Used --</option>
                                    <?php while($p = mysqli_fetch_assoc($treatment)): ?>
                                        <option value="<?= htmlspecialchars($p['product_name']) ?>"><?= htmlspecialchars($p['product_name']) ?></option>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <option disabled>Stash Treatment Kosong!</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="routine-item">
                            <label class="routine-label"><input type="checkbox" class="custom-cb"> <span style="margin-left: 10px;">Night Cream</span></label>
                            <select class="y2k-select" name="pm_moisturizer">
                                <?php if(mysqli_num_rows($moisturizer) > 0): ?>
                                    <option value="">-- Select Night Cream Used --</option>
                                    <?php mysqli_data_seek($moisturizer, 0); while($p = mysqli_fetch_assoc($moisturizer)): ?>
                                        <option value="<?= htmlspecialchars($p['product_name']) ?>"><?= htmlspecialchars($p['product_name']) ?></option>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <option disabled>Stash Moisturizer Kosong!</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 50px; margin-bottom: 50px;">
                <input type="hidden" name="routine_type" value="AM/PM">
                <button type="submit" name="routine_done" class="y2k-btn btn-green" style="font-size: 1.5rem; padding: 15px 40px; width: auto; box-shadow: 6px 6px 0px var(--black);">
                    ✨ DONE ✨
                </button>
            </div>
        </div>
    </form>
</body>
</html>