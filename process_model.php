<?php
// Path ke Python (Sudah diupdate ke Laragon!)
$python_path = "C:\\laragon\\www\\glow\\venv_stable\\Scripts\\python.exe"; 
$script_path = "C:\\laragon\\www\\glow\\predict.py";

// Cek apakah file python ada
if (!file_exists($python_path)) {
    die(json_encode(["classification" => "Error", "confidence" => "0%", "solusi" => "File Python tidak ditemukan di path: " . $python_path]));
}

$image_data = $_POST['image'];
file_put_contents('temp_scan.txt', $image_data);

// Jalankan command
$command = escapeshellcmd("$python_path $script_path temp_scan.txt 2>&1");
$output = [];
exec($command, $output, $return_code);

// Kirim balik output
if ($return_code !== 0) {
    echo json_encode(["classification" => "Error Python", "confidence" => "0%", "solusi" => implode("<br>", $output)]);
} else {
    echo implode("", $output);
}
?>