<?php 
require 'config.php'; 
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') { header("Location: index.php"); exit; } 

$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$total_diary = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM diary"))['total'];

// Ambil data statistik untuk HARI INI
$today = date("Y-m-d");
$chart_query = mysqli_query($conn, "SELECT page_name, views FROM page_views WHERE view_date='$today' ORDER BY views DESC");

$labels = [];
$data = [];
while ($row = mysqli_fetch_assoc($chart_query)) {
    // Merapikan nama halaman (cth: "routine.php" jadi "routine")
    $labels[] = str_replace('.php', '', $row['page_name']); 
    $data[] = $row['views'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glow.exe - Admin Control</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@700;800&family=Silkscreen&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="static/css/style.css?v=<?php echo time(); ?>">
    <!-- PANGGIL LIBRARY CHART.JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: var(--black); background-image: none; color: var(--green); }
        .retro-window { border-color: var(--green); box-shadow: 8px 8px 0px var(--green); }
        .window-titlebar { background-color: var(--green); color: var(--black); }
        .subtitle-syne { color: var(--white); text-shadow: 2px 2px 0px var(--green); }
    </style>
</head>
<body>
    <div class="navbar" style="border-bottom: 2px solid var(--green);">
        <div class="logo" style="color: var(--green);">GLOW_ADMIN.EXE</div>
        <div class="links">
            <a href="logout.php" style="color: var(--hot-pink);">LOGOUT</a>
        </div>
    </div>

    <div class="main-container">
        <div class="retro-window" style="background-color: var(--black);">
            <div class="window-titlebar"><span>root@glow_server:~#</span><div>_ ◻ X</div></div>
            <div class="window-content">
                <h2 class="subtitle-syne" style="margin-top: 0;">SYSTEM OVERRIDE ⚙️</h2>
                
                <div style="display: flex; gap: 20px; margin-top: 20px;">
                    <div style="flex: 1; border: 2px solid var(--green); padding: 20px; text-align: center;">
                        <h3 style="margin:0; font-family: 'Silkscreen'; color: var(--white);">TOTAL USERS</h3>
                        <div style="font-size: 3rem; font-weight: bold; font-family: 'Syne'; color: var(--green); margin: 10px 0;"><?php echo $total_users; ?></div>
                    </div>
                    <div style="flex: 1; border: 2px solid var(--green); padding: 20px; text-align: center;">
                        <h3 style="margin:0; font-family: 'Silkscreen'; color: var(--white);">DIARY ENTRIES</h3>
                        <div style="font-size: 3rem; font-weight: bold; font-family: 'Syne'; color: var(--hot-pink); margin: 10px 0;"><?php echo $total_diary; ?></div>
                    </div>
                </div>

                <!-- AREA GRAFIK CHART.JS -->
                <div style="margin-top: 30px; border: 2px solid var(--white); padding: 20px; background: #111;">
                    <h3 style="margin: 0 0 15px 0; font-family: 'Space Mono'; color: var(--white); text-align: center;">📊 TRAFFIC HARI INI (<?php echo date("d M Y"); ?>)</h3>
                    
                    <?php if(empty($labels)): ?>
                        <p style="text-align: center; color: var(--hot-pink); font-family: 'Space Mono';">Belum ada traffic hari ini. Coba buka halaman lain pakai mode member!</p>
                    <?php else: ?>
                        <canvas id="trafficChart" height="100"></canvas>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <!-- SCRIPT UNTUK MENGGAMBAR GRAFIK -->
    <script>
    <?php if(!empty($labels)): ?>
        const ctx = document.getElementById('trafficChart').getContext('2d');
        
        // Data dari PHP dipindah ke Javascript
        const pageLabels = <?php echo json_encode($labels); ?>;
        const pageData = <?php echo json_encode($data); ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: pageLabels,
                datasets: [{
                    label: 'Total Klik / Views',
                    data: pageData,
                    backgroundColor: '#39FF14', // Neon Green Y2K
                    borderColor: '#FFFFFF',
                    borderWidth: 2,
                    hoverBackgroundColor: '#FF00FF' // Berubah Hot Pink pas disorot mouse
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { color: '#39FF14', stepSize: 1 },
                        grid: { color: 'rgba(57, 255, 20, 0.2)' }
                    },
                    x: { 
                        ticks: { color: '#FFFFFF', font: { family: 'Space Mono' } },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { labels: { color: '#FFFFFF', font: { family: 'Space Mono' } } }
                }
            }
        });
    <?php endif; ?>
    </script>
</body>
</html>