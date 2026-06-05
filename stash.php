<?php 
require 'config.php'; 
if (!isset($_SESSION['logged_in'])) { header("Location: index.php"); exit; }
$user = $_SESSION['username'];

// 1. FITUR DELETE (HAPUS)
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM stash WHERE id='$del_id' AND username='$user'");
    header("Location: stash.php"); exit;
}

// 2. FITUR CREATE & UPDATE (TAMBAH & EDIT)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    if (!empty($_POST['edit_id'])) {
        $edit_id = (int)$_POST['edit_id'];
        mysqli_query($conn, "UPDATE stash SET product_name='$name', product_type='$type', status='$status' WHERE id='$edit_id' AND username='$user'");
    } else {
        mysqli_query($conn, "INSERT INTO stash (username, product_name, product_type, status) VALUES ('$user', '$name', '$type', '$status')");
    }
    header("Location: stash.php"); exit;
}

// 3. AMBIL DATA UNTUK FORM EDIT
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM stash WHERE id='$edit_id' AND username='$user'");
    $edit_data = mysqli_fetch_assoc($result);
}

// 4. AMBIL KATALOG SKINCARE DARI DATABASE (DYNAMIC) 🌟
$katalog_skincare = [];
$prod_query = mysqli_query($conn, "SELECT * FROM products ORDER BY category, name");
while($row = mysqli_fetch_assoc($prod_query)) {
    $katalog_skincare[$row['category']][] = $row['name'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glow.exe - Stash</title>
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
        <div class="retro-window">
            <div class="window-titlebar bg-pink">
                <span><?php echo $edit_data ? 'edit_product.exe' : 'add_product.exe'; ?></span>
                <div>_ ◻ X</div>
            </div>
            <div class="window-content">
                <h2 class="subtitle-syne" style="text-align:left; margin-top:0;">
                    <?php echo $edit_data ? 'EDIT STASH ✏️' : 'UPDATE STASH 🧴'; ?>
                </h2>
                <form action="stash.php" method="POST">
                    <input type="hidden" name="edit_id" value="<?php echo $edit_data ? $edit_data['id'] : ''; ?>">
                    
                    <select name="name" class="y2k-select" required>
                        <option value="" disabled <?php echo !$edit_data ? 'selected' : ''; ?>>Pilih Produk Skincare...</option>
                        <?php foreach($katalog_skincare as $kategori => $produk_list): ?>
                            <optgroup label="=== <?php echo strtoupper($kategori); ?> ===">
                                <?php foreach($produk_list as $produk): ?>
                                    <option value="<?php echo htmlspecialchars($produk); ?>" <?php echo ($edit_data && $edit_data['product_name'] == $produk) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($produk); ?>
                                    </option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>
                    
                    <select name="type" class="y2k-select" required>
                        <option value="Cleanser" <?php echo ($edit_data && $edit_data['product_type'] == 'Cleanser') ? 'selected' : ''; ?>>Tipe: Cleanser</option>
                        <option value="Toner/Serum" <?php echo ($edit_data && $edit_data['product_type'] == 'Toner/Serum') ? 'selected' : ''; ?>>Tipe: Toner/Serum</option>
                        <option value="Moisturizer" <?php echo ($edit_data && $edit_data['product_type'] == 'Moisturizer') ? 'selected' : ''; ?>>Tipe: Moisturizer</option>
                        <option value="Sunscreen" <?php echo ($edit_data && $edit_data['product_type'] == 'Sunscreen') ? 'selected' : ''; ?>>Tipe: Sunscreen</option>
                    </select>
                    
                    <select name="status" class="y2k-select" required>
                        <option value="Holy Grail ✨" <?php echo ($edit_data && $edit_data['status'] == 'Holy Grail ✨') ? 'selected' : ''; ?>>Status: Holy Grail ✨</option>
                        <option value="Running Low ⚠️" <?php echo ($edit_data && $edit_data['status'] == 'Running Low ⚠️') ? 'selected' : ''; ?>>Status: Running Low ⚠️</option>
                        <option value="Just Okay 🤷‍♀️" <?php echo ($edit_data && $edit_data['status'] == 'Just Okay 🤷‍♀️') ? 'selected' : ''; ?>>Status: Just Okay 🤷‍♀️</option>
                    </select>
                    
                    <?php if($edit_data): ?>
                        <button type="submit" class="y2k-btn btn-green">SAVE CHANGES 💾</button>
                        <a href="stash.php"><button type="button" class="y2k-btn btn-yellow">CANCEL EDIT ❌</button></a>
                    <?php else: ?>
                        <button type="submit" class="y2k-btn btn-yellow">ADD TO STASH</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="retro-window">
            <div class="window-titlebar bg-black"><span>my_inventory.db</span><div>_ ◻ X</div></div>
            <div class="window-content" style="max-height: 400px; overflow-y: auto; padding: 15px;">
                <?php
                $res = mysqli_query($conn, "SELECT * FROM stash WHERE username='$user' ORDER BY id DESC");
                if(mysqli_num_rows($res) == 0) echo "<p style='text-align:center;'>Stash masih kosong nih! Tambah dulu di sebelah kiri.</p>";
                while($item = mysqli_fetch_assoc($res)): 
                ?>
                <div style="border: 3px solid var(--black); padding: 15px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; background: white; box-shadow: 3px 3px 0 var(--black);">
                    <div>
                        <strong style="font-family:'Space Mono'; font-size:1.1rem;"><?php echo htmlspecialchars($item['product_name']); ?></strong><br>
                        <span style="background:var(--black); color:white; padding:2px 5px; font-size:0.8rem; font-family:'Silkscreen';"><?php echo htmlspecialchars($item['product_type']); ?></span>
                    </div>
                    <div style="text-align: right;">
                        <div style="color: var(--hot-pink); font-weight: bold; margin-bottom: 10px;">
                            <?php echo htmlspecialchars($item['status']); ?>
                        </div>
                        <a href="stash.php?edit=<?php echo $item['id']; ?>" style="text-decoration:none; border:2px solid black; background:var(--yellow); padding:2px 8px; color:black; font-weight:bold; font-size:0.8rem;">✏️ EDIT</a>
                        <a href="stash.php?delete=<?php echo $item['id']; ?>" onclick="return confirm('Yakin mau buang produk ini dari stash?')" style="text-decoration:none; border:2px solid black; background:var(--hot-pink); padding:2px 8px; color:white; font-weight:bold; font-size:0.8rem;">🗑️ HAPUS</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>