<?php
require 'config.php';

echo "<h2 style='font-family: monospace;'>Menjalankan misi injeksi data... 🚀</h2>";

// 1. Masukin User (Abaikan kalau udah ada)
mysqli_query($conn, "INSERT IGNORE INTO users (username, password) VALUES ('levizera', 'password123')");
echo "<p>✅ Akun 'levizera' berhasil dibuat!</p>";

// 2. Kosongkan tabel stash & diary biar nggak dobel kalau diklik berkali-kali
mysqli_query($conn, "DELETE FROM stash WHERE username='levizera'");
mysqli_query($conn, "DELETE FROM diary WHERE username='levizera'");

// 3. Inject data Stash
$query_stash = "INSERT INTO stash (username, product_name, product_type, status) VALUES
('levizera', 'Garnier Micellar Water Pink', 'Cleanser', 'Holy Grail ✨'),
('levizera', 'Skintific 5X Ceramide', 'Moisturizer', 'Running Low ⚠️'),
('levizera', 'Azarine Hydrasoothe Sunscreen', 'Sunscreen', 'Holy Grail ✨'),
('levizera', 'The Originote Peeling Solution', 'Toner/Serum', 'Just Okay 🤷‍♀️')";
mysqli_query($conn, $query_stash);
echo "<p>✅ Data Skincare berhasil masuk ke Stash!</p>";

// 4. Inject data Diary (3 Hari ke belakang)
$query_diary = "INSERT INTO diary (username, date, mood, note) VALUES
('levizera', '2026-06-01', 'Dry/Flaky 🌵', 'Panas banget di Manado hari ini, kulit kerasa agak ketarik. Harus banyak-banyak pakai moisturizer!'),
('levizera', '2026-06-02', 'Breakout 🚨', 'Ada kemerahan dikit di pipi. Kayaknya gara-gara kelupaan double cleansing semalem gara-gara ketiduran ngoding.'),
('levizera', '2026-06-03', 'Glowing ✨', 'Bangun tidur kulit super plumpy! Kombinasi skincare semalem bener-bener nendang dan bikin slay.')";
mysqli_query($conn, $query_diary);
echo "<p>✅ Data History Diary berhasil dimasukkan!</p>";

// 5. Inject Traffic buat ngetes grafik Admin
$today = date("Y-m-d");
mysqli_query($conn, "DELETE FROM page_views WHERE view_date='$today'");
mysqli_query($conn, "INSERT INTO page_views (page_name, view_date, views) VALUES 
('routine.php', '$today', 15),
('stash.php', '$today', 28),
('diary.php', '$today', 10),
('tips.php', '$today', 7)");
echo "<p>✅ Data Traffic Admin berhasil dimanipulasi!</p>";

echo "<hr>";
echo "<h3 style='color: #FF00FF; font-family: monospace;'>INJEKSI SELESAI! Web GLOW.EXE kamu udah penuh data. 🎀</h3>";
echo "<a href='index.php'><button style='padding: 10px; background: #FFFF00; border: 2px solid black; font-weight: bold; cursor: pointer;'>➡ BALIK KE HALAMAN LOGIN</button></a>";
?>