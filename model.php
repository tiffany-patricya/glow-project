<?php
require 'config.php';
if (!isset($_SESSION['logged_in'])) { header("Location: index.php"); exit; }
$user = $_SESSION['username'];
date_default_timezone_set('Asia/Makassar');
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glow.exe - AI Scanner</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="static/css/style.css">
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
            <a href="logout.php" style="color: var(--hot-pink); font-weight: bold;">LOGOUT 🚪</a>
        </div>
    </div>

    <div class="main-container split-50">
        <div class="retro-window">
            <div class="window-titlebar bg-pink"><span>ai_acne_scanner.exe</span><div>_ ◻ X</div></div>
            <div class="window-content" style="text-align: center;">
                <h2 class="subtitle-syne" style="margin-top: 0;">AI SKIN SCANNER 📸</h2>
                <p style="font-size: 0.85rem; font-weight: bold; margin-bottom: 20px;">Upload foto kondisi kulitmu biar AI kita ngecek tingkat keparahannya!</p>
                
                <div style="border: 3px dashed var(--black); padding: 15px; background: #f8f8f8; margin-bottom: 15px;">
                    <img id="imagePreview" src="" style="max-width: 100%; max-height: 250px; display: none; margin: 0 auto 10px auto; border: 3px solid var(--black);">
                    <input type="file" id="imageInput" accept="image/*" class="y2k-input" onchange="previewImage(event)">
                </div>
                
                <button id="scanBtn" class="y2k-btn btn-yellow" onclick="runScanner()">RUN AI SCANNER ⚙️</button>
                <p id="loadingText" style="display: none; color: var(--hot-pink); font-weight: bold; margin-top: 15px; font-family: 'Space Mono';">AI sedang menganalisis... ⏳</p>
            </div>
        </div>

        <div class="retro-window">
            <div class="window-titlebar bg-black"><span>scan_results.log</span><div>_ ◻ X</div></div>
            <div class="window-content">
                <h2 class="subtitle-syne" style="margin-top: 0; color: var(--cyan); text-shadow: 2px 2px 0px var(--black);">RESULTS 📊</h2>
                
                <div id="result-box" style="margin-top: 20px; display: none;">
                    <div style="border: 3px solid var(--black); padding: 15px; margin-bottom: 15px;">
                        <p style="margin: 0 0 10px 0; font-weight: bold;">DIAGNOSIS AI:</p>
                        <h3 id="out-class" style="margin: 0; color: var(--hot-pink); font-family: 'Syne'; font-size: 1.5rem;">-</h3>
                        <p style="margin: 10px 0 0 0; font-size: 0.85rem;">Tingkat Akurasi: <span id="out-conf" style="font-weight:bold;">-</span></p>
                    </div>
                    
                    <div style="background: var(--black); color: var(--white); padding: 15px; border: 3px solid var(--black);">
                        <p style="margin: 0 0 5px 0; font-weight: bold; color: var(--yellow);">💡 REKOMENDASI:</p>
                        <p id="out-solusi" style="margin: 0; font-size: 0.85rem; line-height: 1.5;">-</p>
                    </div>
                </div>
                
                <p id="placeholder-text" style="text-align: center; color: gray; margin-top: 50px; font-weight: bold;">Upload foto untuk melihat hasil.</p>
            </div>
        </div>
    </div>

<script>
let base64Image = "";

function previewImage(event) {
    const reader = new FileReader(); 
    reader.onload = function() {
        document.getElementById('imagePreview').src = reader.result; 
        document.getElementById('imagePreview').style.display = 'block'; 
        base64Image = reader.result;
    }; 
    reader.readAsDataURL(event.target.files[0]);
}

function runScanner() {
    if (!base64Image) { alert("Upload foto dulu bestie! 📸"); return; }
    
    document.getElementById('scanBtn').style.display = 'none'; 
    document.getElementById('loadingText').style.display = 'block';
    
    // Kirim gambar ke process_model.php
    fetch('process_model.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'image=' + encodeURIComponent(base64Image)
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('scanBtn').style.display = 'block'; 
        document.getElementById('loadingText').style.display = 'none';
        
        document.getElementById('placeholder-text').style.display = 'none'; 
        document.getElementById('result-box').style.display = 'block';
        
        document.getElementById('out-class').innerText = data.classification; 
        document.getElementById('out-conf').innerText = data.confidence; 
        document.getElementById('out-solusi').innerText = data.solusi;
    })
    .catch(err => {
        alert("Gagal terhubung ke AI. Pastikan python jalan!");
        document.getElementById('scanBtn').style.display = 'block'; 
        document.getElementById('loadingText').style.display = 'none';
    });
}
</script>
</body>
</html>