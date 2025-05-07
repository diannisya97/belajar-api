<?php
require_once __DIR__ . '/../koneksi.php';
require_once __DIR__ . '/../api_keys.php';

// 1. Verifikasi API Key
$api_key = $_SERVER['HTTP_X_API_KEY'] ?? '';

if (!isset($valid_api_keys[$api_key])) {
    http_response_code(401);
    die(json_encode(["error" => "Invalid API Key"]));
}

// 2. Cek hak akses
if (!in_array('petugas:write', $valid_api_keys[$api_key]['access'])) {
    http_response_code(403);
    die(json_encode(["error" => "Forbidden: Insufficient access"]));
}

// 3. Terima dan validasi input JSON
$input = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    die(json_encode(["error" => "Invalid JSON data"]));
}

// 4. Simpan ke database
$success = 0;
foreach ($input as $item) {
    $nama    = isset($item['nama_petugas']) ? mysqli_real_escape_string($conn, $item['nama_petugas']) : '';
    $noregis = isset($item['no_regis']) ? mysqli_real_escape_string($conn, $item['no_regis']) : '';
    $alamat  = isset($item['alamat_petugas']) ? mysqli_real_escape_string($conn, $item['alamat_petugas']) : '';

    // Validasi minimum data
    if (empty($nama) || empty($noregis)) {
        error_log("Data tidak lengkap: " . print_r($item, true));
        continue;
    }

    $query = "INSERT INTO petugas (nama_petugas, no_regis, alamat_petugas)
              VALUES ('$nama', '$noregis', '$alamat')
              ON DUPLICATE KEY UPDATE 
                  nama_petugas = VALUES(nama_petugas),
                  alamat_petugas = VALUES(alamat_petugas)";

    if (mysqli_query($conn, $query)) {
        $success++;
    } else {
        error_log("Query Gagal: " . mysqli_error($conn));
    }
}

// 5. Response ke client
http_response_code(200);
echo json_encode([
    "status" => "success",
    "received" => count($input),
    "saved" => $success,
    "client" => $valid_api_keys[$api_key]['name']
]);
