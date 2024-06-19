<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "boyolali";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die('Koneksi gagal: ' . mysqli_error());
}

// Query untuk mengambil data koordinat dari tabel
$query = "SELECT * FROM dataresponsi";
$result = mysqli_query($koneksi, $query);

// Format hasil query menjadi JSON
$markers = array();
while ($row = mysqli_fetch_assoc($result)) {
    $markers[] = array(
        'latitude' => $row['Latitude'],
        'longitude' => $row['Longitude'],
        'nama_lokasi' => $row['Nama Lokasi'],
        'jenis' => $row['Jenis'],
    );
}

// Tambahkan header untuk menentukan tipe konten
header('Content-Type: application/json');

// Keluarkan hasil sebagai JSON
echo json_encode($markers);

// Tutup koneksi database
mysqli_close($koneksi);
?>
