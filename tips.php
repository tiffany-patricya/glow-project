<?php
require 'config.php';
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
            <select id="productUsed" class="y2k-select">
                <option value="" disabled selected>Pilih produk dari Stash...</option>
                <?php
                $stash_query = mysqli_query($conn, "SELECT product_name FROM stash WHERE username='$user'");
                while($item = mysqli_fetch_assoc($stash_query)) {
                    echo '<option value="'.htmlspecialchars($item['product_name']).'">'.htmlspecialchars($item['product_name']).'</option>';
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
// 1. FUNGSI SMART SIMULATOR (PENGGANTI API)
async function callAI(prompt) {
    await new Promise(resolve => setTimeout(resolve, 1500)); 

    let responseText = "";
    
    // PERBAIKAN: semua input jadi huruf kecil agar tidak error gara-gara huruf kapital
    let p = prompt.toLowerCase();

    // -- Logika Klinis untuk Fitur SOS Clinic --
    if (p.includes("berikan 3 tips skincare")) {
        if (p.includes("berminyak dan berjerawat") || p.includes("berminyak")) {
            responseText = "<b>Anjuran Klinis untuk Kulit Berminyak & Berjerawat:</b><br><br>1. Gunakan pembersih wajah dengan kandungan Salicylic Acid (BHA) konsentrasi rendah (1-2%) untuk membersihkan pori-pori tersumbat dari sebum.<br>2. Aplikasikan pelembap bertekstur gel yang bersifat non-comedogenic agar hidrasi kulit terjaga tanpa memicu pembentukan komedo baru.<br>3. Gunakan obat totol jerawat (spot treatment) berbahan dasar Benzoyl Peroxide atau Sulfur secara tipis hanya pada area kulit yang meradang.";
        } 
        else if (p.includes("kering dan sensitif") || p.includes("kering")) {
            responseText = "<b>Anjuran Klinis untuk Kulit Kering & Sensitif:</b><br><br>1. Hindari pembersih wajah dengan surfaktan kuat (SLS/SLES). Gunakan gentle cleanser dengan pH seimbang agar lapisan lipid alami kulit tidak tergerus.<br>2. Terapkan produk yang mengandung Ceramide dan Hyaluronic Acid pada kondisi wajah yang masih setengah lembap (damp skin) untuk memaksimalkan retensi air.<br>3. Hindari produk dengan kandungan alkohol denaturasi dan pewangi tambahan (fragrance) untuk meminimalisir risiko dermatitis kontak atau kemerahan.";
        } 
        else if (p.includes("kusam dan bekas jerawat") || p.includes("kusam")) {
            responseText = "<b>Anjuran Klinis untuk Kulit Kusam & Bekas Jerawat:</b><br><br>1. Integrasikan serum derivatif Vitamin C atau Niacinamide pada rutinitas pagi untuk menekan produksi melanin dan meratakan warna kulit.<br>2. Lakukan eksfoliasi kimiawi menggunakan AHA (seperti Glycolic Acid atau Lactic Acid) 1-2 kali per minggu untuk mempercepat pergantian sel kulit mati.<br>3. Penggunaan tabir surya (sunscreen) minimal SPF 30 PA+++ bersifat wajib setiap pagi untuk mencegah hiperpigmentasi pasca-inflamasi (PIH) menggelap akibat paparan UV.";
        } 
        else if (p.includes("kombinasi")) {
            responseText = "<b>Anjuran Klinis untuk Kulit Kombinasi:</b><br><br>1. Gunakan pelembap bertekstur losion cair yang mampu menghidrasi area pipi (U-zone) tanpa membuat area hidung dan dahi (T-zone) mengalami over-produksi minyak.<br>2. Terapkan metode perawatan spesifik area: gunakan clay mask eksklusif pada T-zone, dan hindari penggunaannya pada area wajah yang cenderung kering.<br>3. Batasi penggunaan eksfoliator fisik; beralihlah pada toner PHA (Polyhydroxy Acid) yang molekulnya lebih besar sehingga eksfoliasi berjalan sangat minim iritasi.";
        } 
        else {
            responseText = "<b>Anjuran Perawatan Dasar:</b><br><br>Pastikan untuk selalu melakukan metode double cleansing di malam hari, menjaga kelembapan kulit (skin barrier), dan memberikan proteksi UV setiap pagi hari.";
        }
    } 
    // -- Logika Klinis untuk Fitur Skin Projection --
    else if (p.includes("simulasi hasil")) {
        if (p.includes("1 minggu")) {
            responseText = "<b>Proyeksi Klinis (1 Minggu):</b><br><br>Pada fase adaptasi awal ini, perubahan struktural belum terjadi secara signifikan. Kulit akan terasa lebih lembap dan hidrasi superfisial meningkat. Jika produk mengandung bahan aktif seperti retinoid atau asam eksfolian, kulit mungkin mengalami fase penyesuaian berupa pengelupasan mikro atau purging ringan. Tetap fokus pada pemeliharaan skin barrier.";
        } 
        else if (p.includes("3 bulan")) {
            responseText = "<b>Proyeksi Klinis (3 Bulan):</b><br><br>Siklus pergantian sel epidermis (cell turnover) telah melewati sekitar tiga fase penuh. Pada titik ini, inflamasi jerawat dan bruntusan mulai mereda secara konsisten. Bekas jerawat kemerahan (PIE) atau kehitaman (PIH) tingkat ringan menunjukan pemudaran yang dapat diobservasi. Tekstur mikro kulit terasa jauh lebih halus dan warna kulit tampak lebih seragam.";
        } 
        else if (p.includes("6 bulan")) {
            responseText = "<b>Proyeksi Klinis (6 Bulan):</b><br><br>Terdapat perbaikan nyata yang mencapai lapisan dermis bagian atas. Jika perawatan difokuskan pada perbaikan tekstur, stimulasi produksi kolagen mulai terbentuk dengan baik. Bekas jerawat yang persisten akan memudar secara drastis, integritas lapisan pelindung kulit berada pada kondisi optimal, dan frekuensi kekambuhan jerawat akan sangat menurun.";
        } 
        else if (p.includes("8 bulan")) {
             responseText = "<b>Proyeksi Klinis (8 Bulan):</b><br><br>Kondisi kulit telah memasuki fase pemeliharaan (maintenance) yang stabil. Hiperpigmentasi kronis menunjukkan tingkat perbaikan maksimal dari intervensi topikal. Kulit menunjukan toleransi yang sangat baik terhadap stresor lingkungan, elastisitas jaringan membaik, dan kemampuan epidermis dalam mengunci kelembapan alami berfungsi secara maksimal.";
        } 
        else {
             responseText = "<b>Proyeksi Pemakaian Jangka Panjang:</b><br><br>Penggunaan produk secara konsisten dan terarah akan mengoptimalkan fungsi regenerasi seluler dan memperkuat mekanisme perlindungan alami kulit.";
        }
    }

    return {
        candidates: [{
            content: {
                parts: [{ text: responseText }]
            }
        }]
    };
}


// 2. FUNGSI UNTUK TOMBOL SOS CLINIC

async function getGeminiTips() {
    const skinType = document.getElementById('skinType').value;
    const resultBox = document.getElementById('sosResult');
    const btn = document.getElementById('btnSos'); 
    
    if(!skinType) { 
        alert("Pilih tipe kulit terlebih dahulu."); 
        return; 
    }

    if(btn) btn.disabled = true;
    resultBox.style.display = "block";
    resultBox.innerHTML = "<p style='color: #666;'><i>Menganalisis kondisi klinis...</i></p>";

    try {
        const data = await callAI(`Berikan 3 tips skincare untuk: ${skinType}. Format HTML.`);
        resultBox.innerHTML = data.candidates[0].content.parts[0].text;
    } catch (e) {
        resultBox.innerHTML = "Sistem gagal memuat data: " + e.message;
    } finally {
        if(btn) btn.disabled = false;
    }
}


// 3. FUNGSI UNTUK TOMBOL SKIN PROJECTION

async function getGeminiProjection() {
    const product = document.getElementById('productUsed').value;
    const time = document.getElementById('timeFrame').value;
    const resultBox = document.getElementById('timeResult');
    const btn = document.getElementById('btnTime'); 

    if(!product || !time) { 
        alert("Parameter produk dan durasi wajib diisi."); 
        return; 
    }

    if(btn) btn.disabled = true;
    resultBox.style.display = "block";
    resultBox.innerHTML = "<p style='color: #666;'><i>Mengkalkulasi proyeksi seluler...</i></p>";

    try {
        const data = await callAI(`Buatkan simulasi hasil jika memakai ${product} selama ${time}. Format HTML.`);
        resultBox.innerHTML = data.candidates[0].content.parts[0].text;
    } catch (e) {
        resultBox.innerHTML = "Sistem gagal memuat data: " + e.message;
    } finally {
        if(btn) btn.disabled = false;
    }
}
</script>
</body>
</html>