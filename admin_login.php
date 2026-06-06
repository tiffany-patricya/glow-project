<?php
// require_once config.php akan otomatis menjalankan session_start() dan koneksi DB
require_once 'config.php'; 

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cari user berdasarkan username DAN role-nya harus 'admin'
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = 'admin'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Cek kecocokan password dengan hash di database
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $user['username'];
            
            // Arahkan ke dashboard admin
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error_message = "ACCESS DENIED: Password salah.";
        }
    } else {
        $error_message = "ACCESS DENIED: Username tidak ditemukan atau bukan admin.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GLOW.EXE - Admin Login</title>
    <style>
        /* Tema Retro Terminal ala Hacker */
        body {
            background-color: #000;
            color: #0f0;
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            border: 2px solid #0f0;
            padding: 30px;
            width: 350px;
            box-shadow: 0 0 10px #0f0;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #0f0;
            padding-bottom: 15px;
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            background-color: #000;
            color: #0f0;
            border: 1px solid #0f0;
            padding: 8px;
            font-family: inherit;
            box-sizing: border-box;
            outline: none;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            box-shadow: 0 0 5px #0f0;
        }
        button {
            width: 100%;
            background-color: #0f0;
            color: #000;
            border: none;
            padding: 10px;
            font-family: inherit;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0a0;
        }
        .error {
            color: #f00; /* Merah untuk pesan error */
            margin-bottom: 15px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="header">
        root@glow_server:~#<br>
        SYSTEM LOGIN
    </div>

    <?php if ($error_message != ''): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="username">USERNAME_</label>
            <input type="text" id="username" name="username" required autocomplete="off">
        </div>
        <div class="form-group">
            <label for="password">PASSWORD_</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">INITIATE LOGIN</button>
    </form>
</div>

</body>
</html>