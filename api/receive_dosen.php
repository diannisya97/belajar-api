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
if (!in_array('dosen:write', $valid_api_keys[$api_key]['access'])) {
    http_response_code(403);
    die(json_encode(["error" => "Forbidden: Insufficient access"]));
}

// 3. Terima data
$input = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    die(json_encode(["error" => "Invalid JSON data"]));
}

// 4. Simpan ke database
$success = 0;
foreach ($input as $item) {
    $nip = mysqli_real_escape_string($conn, $item['nip']);
    $nama = mysqli_real_escape_string($conn, $item['nama_dosen']);
    $alamat = mysqli_real_escape_string($conn, $item['alamat']);

    $query = "INSERT INTO dosen (nip, nama_dosen, alamat) 
              VALUES ('$nip', '$nama', '$alamat')
              ON DUPLICATE KEY UPDATE 
                  nama_dosen = VALUES(nama_dosen),
                  alamat = VALUES(alamat)";

    if (mysqli_query($conn, $query)) $success++;
}

// 5. Response
http_response_code(200);
echo json_encode([
    "status" => "success",
    "received" => count($input),
    "saved" => $success,
    "client" => $valid_api_keys[$api_key]['name']
]);
?>