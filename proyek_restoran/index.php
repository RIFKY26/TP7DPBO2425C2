<?php
// File: index.php

// Enable output buffering so header() in views works for redirects
ob_start();

// 1. Tentukan halaman default (beranda dihilangkan, default ke kategori)
$page = isset($_GET['page']) ? $_GET['page'] : 'kategori';

// 2. Tentukan judul halaman
$title = "Sistem Restoran";

// 3. Routing (Memilih file view yang akan dimuat)
switch ($page) {
	case 'kategori':
		$title = "Manajemen Kategori";
		$view_file = "view/kategori.php";
		break;
		
	case 'menu':
		$title = "Manajemen Menu";
		$view_file = "view/menu.php";
		break;
		
	case 'pelanggan':
		$title = "Manajemen Pelanggan";
		$view_file = "view/pelanggan.php";
		break;
		
	default:
		// fallback ke kategori jika page tidak dikenali
		$title = "Manajemen Kategori";
		$view_file = "view/kategori.php";
		break;
}

// 4. Memuat Header (Tampilan Atas)
// 'title' akan digunakan di dalam header
include 'view/header.php';

// 5. Memuat Halaman Konten yang Dipilih
// Cek apakah file view-nya ada
if (file_exists($view_file)) {
	include $view_file;
} else {
	// Tampilkan pesan error jika file tidak ditemukan
	echo "<h1>Error 404</h1><p>Halaman tidak ditemukan.</p>";
}

// 6. Memuat Footer (Tampilan Bawah)
include 'view/footer.php';

// Flush buffered output
ob_end_flush();

?>