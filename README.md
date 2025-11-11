# Janji
  Saya nama Rifky Fadhillah Akbar dengan Nim 2401248 mengerjakan tugas praktikum 7
  dalam mata kuliah DPBO untuk keberkahan-Nya maka saya
  tidak akan melakukan kecurangan seperti yang telah di spesifikasikan Aamiin.
# Deskripsi
  Website ini mengambil tema “Manajemen Restoran Sederhana” yang berfungsi untuk mengelola data menu makanan, kategori menu, dan pelanggan restoran.
  Melalui website ini, pengguna dapat melakukan beberapa fitur utama berikut :
  - Menampilkan daftar menu makanan lengkap dengan harga dan kategori.
  - Menambah, mengedit, dan menghapus data menu.
  - Menambah, mengubah, dan menghapus kategori makanan.
  - Mengelola data pelanggan yang melakukan pembelian di restoran.
  Website ini dibangun menggunakan PHP Native berbasis OOP (Object-Oriented Programming) dan menggunakan Prepared Statement untuk semua query database guna meningkatkan keamanan.
    
# Penjelasan Database
  Database bernama db_restoran, terdiri dari 3 tabel utama yaitu :
 ## 1. Tabel kategori
     - id_kategori : INT (PK, AUTO_INCREMENT)
     - nama_kategori : VARCHAR(100)
 ## 2. Tabel menu
     - id_menu : INT (PK, AUTO_INCREMENT)
     - nama_menu : VARCHAR(100)
     - harga : INT
     - id_kategori : INT (FK)
 ## 3. Tabel pelanggan
     - id_pelanggan : INT (PK, AUTO_INCREMENT)
     - nama_pelanggan : VARCHAR(100)
     - alamat : VARCHAR(255)
     - no_telp : VARCHAR(20)
     
# Penjelasan Struktur Kode
## 1. class/Kategori.php
     
  Kelas ini menangani manajemen data kategori makanan.
     
  Fungsi-fungsi utama:
  - create($nama_kategori) → menambah kategori baru.
  - readAll() → menampilkan seluruh kategori.
  - update($id, $nama_kategori) → mengubah nama kategori.
  - delete($id) → menghapus kategori.
  
 ## 2. class/Kategori.php
     
  Kelas ini mengatur seluruh proses CRUD (Create, Read, Update, Delete) untuk data menu.
     
  Fungsi-fungsi utama:
  - create($nama, $harga, $id_kategori) → menambah menu baru.
  - readAll() → menampilkan semua menu beserta nama kategori.
  - read($id) → mengambil data menu berdasarkan ID.
  - update($id, $nama, $harga, $id_kategori) → mengubah data menu.
  - delete($id) → menghapus data menu berdasarkan ID.

 ## 3. class/Pelanggan.php
     
  Kelas ini digunakan untuk mengelola data pelanggan restoran.
     
  Fungsi-fungsi utama:
  - create($nama_pelanggan, $alamat, $no_telp) → menambah pelanggan baru.
  - readAll() → menampilkan daftar pelanggan.
  - update($id, $nama_pelanggan, $alamat, $no_telp) → memperbarui data pelanggan.
  - delete($id) → menghapus pelanggan.

 ## 4. config/db.php
  - Berisi konfigurasi koneksi database menggunakan PDO.
Semua kelas (Menu, Kategori, dan Pelanggan) memanfaatkan koneksi ini agar dapat menjalankan query CRUD dengan aman.

 ## 5. index.php
  - Merupakan file utama sistem navigasi website.
File ini mengatur perpindahan halaman menggunakan parameter ?page= dan memanggil view yang sesuai (menu, kategori, pelanggan).

      Contoh: ?page=menu, ?page=kategori, ?page=pelanggan
 ## 6. view/
   Berisi tampilan antarmuka pengguna dalam bentuk tabel dan form CRUD:

  - menu.php → halaman daftar menu + form tambah/edit menu.
  - kategori.php → halaman daftar kategori.
  - pelanggan.php → halaman daftar pelanggan.

# Penjelasan Alur Program

## 1. Inisialisasi Program
  - Website dijalankan melalui index.php.
  - db.php membuat koneksi ke database.
  - Objek dari setiap class (Menu, Kategori, Pelanggan) dibuat untuk mengelola datanya masing-masing.

## 2. Navigasi dan Routing
  - Sistem berpindah halaman menggunakan parameter ?page=.
  - Misal: index.php?page=menu akan menampilkan halaman manajemen menu.
## 3. Proses CRUD
  - Tambah Data: Data baru dikirim melalui form → disimpan ke database via prepared statement.
  - Edit Data: Data lama diambil menggunakan read($id) lalu diperbarui.
  - Hapus Data: Menghapus baris tertentu berdasarkan ID.
## 4. Keamanan Query
  - Semua query dijalankan menggunakan Prepared Statement (PDO) untuk mencegah SQL Injection.
    
      
      
