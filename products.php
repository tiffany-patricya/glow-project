<?php
require 'config.php';
if (!isset($_SESSION['logged_in'])) { header("Location: index.php"); exit; }
$user = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $type = (stripos($name, 'cleanser') !== false || stripos($name, 'wash') !== false) ? 'Cleanser' : 'Sunscreen/Moisturizer';
        mysqli_query($conn, "INSERT INTO stash (username, name, type, status) VALUES ('$user', '$name', '$type', '$status')");
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['edit_id'];
        $new_status = mysqli_real_escape_string($conn, $_POST['new_status']);
        mysqli_query($conn, "UPDATE stash SET status='$new_status' WHERE id='$id' AND username='$user'");
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        mysqli_query($conn, "DELETE FROM stash WHERE id='$id' AND username='$user'");
    }
    header("Location: products.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glow.exe - My Stash</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body class="dashboard-container">

<div style="text-align: right; max-width: 1100px; margin: 0 auto 20px auto;">
    <a href="model.php" class="y2k-btn" style="background: var(--pastel-yellow); display:inline-block; width:auto; text-decoration: none; color: black;">🧠 AI SCANNER</a>
    <a href="diary.php" class="y2k-btn" style="background: var(--cyan); display:inline-block; width:auto; text-decoration: none; color: black; margin: 0 10px;">📔 SKIN DIARY</a>
    <a href="logout.php" class="y2k-btn" style="background: #ff4757; display:inline-block; width:auto; text-decoration: none; color: white;">LOGOUT ❌</a>
</div>

<div class="split-layout">
    <div class="retro-window" style="flex: 1;">
        <div class="window-titlebar bg-pink"><span>add_product.exe</span></div>
        <div class="window-content">
            <h2 class="y2k-title">UPDATE STASH 🛍️</h2>
            <form action="" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                <input type="hidden" name="add" value="1">
                <input type="text" name="name" class="y2k-input" placeholder="Ketik nama skincare..." required>
                <select name="status" class="y2k-select" required>
                    <option value="" disabled selected>-- Kondisi --</option>
                    <option value="Holy Grail ✨">Holy Grail ✨</option>
                    <option value="Just Bought 🛍️">Just Bought 🛍️</option>
                    <option value="Breakout 😭">Bikin Breakout 😭</option>
                </select>
                <button type="submit" class="y2k-btn" style="background: var(--pastel-green); color: black;">ADD TO STASH ➕</button>
            </form>
        </div>
    </div>
    
    <div class="retro-window" style="flex: 1;">
        <div class="window-titlebar" style="background: var(--pastel-yellow); color: var(--black);"><span>my_inventory.txt</span></div>
        <div class="window-content" style="background: white;">
            <h2 class="y2k-title" style="color: var(--hot-pink);">MY STASH 🗃️</h2>
            <div style="margin-top: 15px; max-height: 400px; overflow-y: auto; padding-right: 10px;">
                <?php
                $result = mysqli_query($conn, "SELECT * FROM stash WHERE username='$user' ORDER BY id DESC");
                if (mysqli_num_rows($result) == 0) { 
                    echo '<p style="text-align:center; font-family: Verdana;">Stash masih kosong! ✨</p>'; 
                } else { 
                    while ($row = mysqli_fetch_assoc($result)): 
                ?>
                    <div style="border: 2px dashed black; padding: 15px; margin-bottom: 12px; background: var(--cream);">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <strong style="color: var(--hot-pink); font-family: Verdana; font-size: 1.1rem;"><?php echo htmlspecialchars($row['name']); ?></strong><br>
                                <small style="font-family: Verdana; line-height: 1.6;">Type: <?php echo htmlspecialchars($row['type']); ?> | Status: <b><?php echo htmlspecialchars($row['status']); ?></b></small>
                            </div>
                            <div style="display: flex; gap: 5px;">
                                <button type="button" class="y2k-btn" style="background: #ffcc00; width:auto; padding:8px 12px;" onclick="toggleEdit('<?php echo $row['id']; ?>')">✏️</button>
                                <form action="" method="POST" style="margin: 0;" onsubmit="return confirm('Hapus produk ini dari lemarimu?');">
                                    <input type="hidden" name="delete" value="1">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="y2k-btn" style="background: #ff4757; color: white; width:auto; padding:8px 12px;">🗑️</button>
                                </form>
                            </div>
                        </div>
                        <form action="" method="POST" id="edit-form-<?php echo $row['id']; ?>" style="display: none; margin-top: 15px; gap: 10px;">
                            <input type="hidden" name="edit" value="1">
                            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                            <select name="new_status" class="y2k-select" style="flex: 1;" required>
                                <option value="Holy Grail ✨">Holy Grail ✨</option>
                                <option value="Running Low ⚠️">Running Low ⚠️</option>
                                <option value="Breakout 😭">Bikin Breakout 😭</option>
                            </select>
                            <button type="submit" class="y2k-btn" style="background: var(--cyan); width:auto; padding: 8px 15px;">SAVE</button>
                        </form>
                    </div>
                <?php endwhile; } ?>
            </div>
        </div>
    </div>
</div>

<script>
function toggleEdit(id) { 
    let f = document.getElementById('edit-form-'+id); 
    f.style.display = (f.style.display==="none" || f.style.display==="") ? "flex" : "none"; 
}
</script>
</body>
</html>