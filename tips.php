<?php
require 'config.php';
// Pastikan user sudah login
if (!isset($_SESSION['logged_in'])) { header("Location: index.php"); exit; }
$user = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glow.exe - Tips & AI</title>
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
            <div class="window-titlebar bg-pink"><span>sos_clinic.exe</span><div>_ ◻ X</div></div>
            <div class="window-content" style="text-align: center;">
                <h2 class="subtitle-syne" style="margin-top: 0;">🚨 SOS CLINIC</h2>
                <p style="font-family: 'Space Mono'; font-size: 0.85rem; font-weight: bold; margin-bottom: 20px;">Lagi breakout? Masukin tipe kulitmu dan biarin AI kita nyelesaiin!</p>
                
                <select id="skinType" class="y2k-select">
                    <option value="" disabled selected>Pilih Tipe Kulit...</option>
                    <option value="Berminyak & Berjerawat">Berminyak & Berjerawat</option>
                    <option value="Kering & Sensitif">Kering & Sensitif</option>
                    <option value="Kusam & Bekas Jerawat">Kusam & Bekas Jerawat</option>
                    <option value="Kombinasi">Kombinasi</option>
                </select>

                <button onclick="getGeminiTips()" class="y2k-btn btn-yellow" id="btnSos">GET SOS TIPS & MATCH</button>
                
                <div id="sosResult" style="display:none; margin-top: 20px; border: 2px dashed var(--black); padding: 15px; text-align: left; background: #fff; font-size: 0.9rem; line-height: 1.5; font-weight: bold;"></div>
            </div>
        </div>

        <div class="retro-window">
            <div class="window-titlebar bg-black"><span>time_machine.exe</span><div>_ ◻ X</div></div>
            <div class="window-content" style="text-align: center;">
                <h2 class="subtitle-syne" style="margin-top: 0; color: var(--cyan); text-shadow: 2px 2px 0 var(--black);">⏱️ SKIN PROJECTION</h2>
                <p style="font-family: 'Space Mono'; font-size: 0.85rem; font-weight: bold; margin-bottom: 20px;">Simulasi hasil kalau kamu pakai produk dari STASH kamu secara konsisten!</p>
                
                <select id="productUsed" class="y2k-select">
                    <option value="" disabled selected>Pilih produk dari Stash...</option>
                    <?php
                    $stash_query = mysqli_query($conn, "SELECT product_name FROM stash WHERE username='$user'");
                    if(mysqli_num_rows($stash_query) > 0) {
                        while($item = mysqli_fetch_assoc($stash_query)) {
                            echo '<option value="'.htmlspecialchars($item['product_name']).'">'.htmlspecialchars($item['product_name']).'</option>';
                        }
                    } else {
                        echo '<option value="" disabled>Stash masih kosong! Isi dulu di menu Stash.</option>';
                    }
                    ?>
                </select>

                <select id="timeFrame" class="y2k-select">
                    <option value="" disabled selected>Mau simulasi berapa lama?</option>
                    <option value="1 Minggu">1 Minggu</option>
                    <option value="1 Bulan">1 Bulan</option>
                    <option value="3 Bulan">3 Bulan</option>
                    <option value="6 Bulan">6 Bulan</option>
                </select>

                <button onclick="getGeminiProjection()" class="y2k-btn btn-green" id="btnTime">TIME TRAVEL 🚀</button>

                <div id="timeResult" style="display:none; margin-top: 20px; border: 2px dashed var(--black); padding: 15px; text-align: left; background: #fff; font-size: 0.9rem; line-height: 1.5; font-weight: bold;"></div>
            </div>
        </div>
    </div>

<script>
// ==========================================
// KONFIGURASI GEMINI API
// ==========================================
// 🚨 GANTI DENGAN API KEY BARUMU YANG BERAWALAN "AIzaSy..."
const GEMINI_API_KEY = "TARUH DISINI"; 
const GEMINI_URL = "ADA DI ENV";

// FUNGSI 1: SOS CLINIC
async function getGeminiTips() {
    const skinType = document.getElementById('skinType').value;
    const resultBox = document.getElementById('sosResult');
    const btn = document.getElementById('btnSos');

    if(!skinType) {
        alert("Pilih tipe kulitmu dulu dong bestie!");
        return;
    }

    btn.innerText = "MENGHUBUNGI AI... ⏳";
    btn.disabled = true;
    resultBox.style.display = "block";
    resultBox.innerHTML = "<i>AI sedang menganalisis tipe kulitmu...</i>";

    const promptText = `Berikan 3 tips skincare yang aman dan praktis untuk tipe kulit: ${skinType}. LANGSUNG ke poin-poinnya saja. DILARANG KERAS memberikan salam pembuka, kalimat pengantar, atau kalimat penutup. Format output wajib menggunakan HTML ringan (<br>, <b>, <ul>, <li>) tanpa tag markdown.`;
    try {
        const response = await fetch(GEMINI_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                contents: [{ parts: [{ text: promptText }] }]
            })
        });

        const data = await response.json();

        // Pelindung Error Google
        if (!response.ok) {
            throw new Error(data.error?.message || "API Key salah atau ditolak oleh Google.");
        }

        const aiResponse = data.candidates[0].content.parts[0].text;
        
        resultBox.innerHTML = aiResponse;
        btn.innerText = "GET SOS TIPS & MATCH";
        btn.disabled = false;

    } catch (error) {
        console.error("DEBUGGING ERROR:", error);
        resultBox.innerHTML = `<span style='color:red;'><b>Oops! Gagal:</b> ${error.message}</span>`;
        btn.innerText = "GET SOS TIPS & MATCH";
        btn.disabled = false;
    }
}

// FUNGSI 2: TIME MACHINE (SKIN PROJECTION)
async function getGeminiProjection() {
    const product = document.getElementById('productUsed').value;
    const time = document.getElementById('timeFrame').value;
    const resultBox = document.getElementById('timeResult');
    const btn = document.getElementById('btnTime');

    if(!product || !time) {
        alert("Pilih produk dari stash dan waktunya dulu ya!");
        return;
    }

    btn.innerText = "MEMUTAR WAKTU... ⏱️";
    btn.disabled = true;
    resultBox.style.display = "block";
    resultBox.innerHTML = "<i>AI sedang mensimulasikan masa depan kulitmu...</i>";

    const promptText = `Sebagai pakar Skincare, buatkan simulasi singkat, realistis, dan memotivasi jika seseorang rutin memakai produk "${product}" selama waktu "${time}". Jelaskan efek positif apa yang kemungkinan besar akan terlihat pada kulitnya. Format output menggunakan HTML ringan (<br>, <b>) tanpa tag markdown.`;

    try {
        const response = await fetch(GEMINI_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                contents: [{ parts: [{ text: promptText }] }]
            })
        });

        const data = await response.json();

        // Pelindung Error Google
        if (!response.ok) {
            throw new Error(data.error?.message || "API Key salah atau ditolak oleh Google.");
        }

        const aiResponse = data.candidates[0].content.parts[0].text;
        
        resultBox.innerHTML = aiResponse;
        btn.innerText = "TIME TRAVEL 🚀";
        btn.disabled = false;

    } catch (error) {
        console.error("DEBUGGING ERROR:", error);
        resultBox.innerHTML = `<span style='color:red;'><b>Oops! Mesin waktu error:</b> ${error.message}</span>`;
        btn.innerText = "TIME TRAVEL 🚀";
        btn.disabled = false;
    }
}
</script>
</body>
</html>