<?php
// File: menu.php

// 1. Memuat file Class dan Koneksi
include 'config/db.php';
include 'class/Menu.php';       // <-- Memuat class Menu
include 'class/Kategori.php';   // <-- (Anda harus buat ini dulu) Memuat class Kategori

// 2. Inisialisasi Objek
$database = new Database();
$db = $database->getConnection();

$menu = new Menu($db);
$kategori = new Kategori($db); // <-- Kita perlu objek Kategori untuk dropdown

// == LOGIKA KONTROLLER (PROSES FORM) ==
$action = isset($_GET['action']) ? $_GET['action'] : '';
$data_edit = null;

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form_action = $_POST['form_action'];

        if ($form_action == 'create') {
            // Perhatikan 3 parameter
			if (!is_numeric($_POST['harga'])) {
				header("Location: index.php?page=menu&message=Harga harus berupa angka");
				exit;
			}
			$menu->create($_POST['nama'], $_POST['harga'], $_POST['id_kategori']);
			header("Location: index.php?page=menu&message=Data berhasil ditambahkan!");

        } else if ($form_action == 'update') {
            // Perhatikan 4 parameter
			if (!is_numeric($_POST['harga'])) {
				header("Location: index.php?page=menu&message=Harga harus berupa angka");
				exit;
			}
			$menu->update($_POST['id'], $_POST['nama'], $_POST['harga'], $_POST['id_kategori']);
			header("Location: index.php?page=menu&message=Data berhasil diupdate!");
		} else if ($form_action == 'delete') {
			$menu->delete($_POST['id']);
			header("Location: index.php?page=menu&message=Data berhasil dihapus!");
        }
    }

	// Logika untuk mengambil data yang akan di-edit
	if ($action == 'edit' && isset($_GET['id'])) {
		$data_edit = $menu->read($_GET['id']);
	}
    
    // Mengambil semua data menu untuk ditampilkan di tabel
    $stmt_menu = $menu->readAll();
    
    // Mengambil semua data kategori untuk dropdown
    $stmt_kategori = $kategori->readAll();
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<div class="card">
	<h1>Manajemen Menu</h1>

<?php if(isset($_GET['message'])): ?>
	<div class="message">
		<?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?>
	</div>
<?php endif; ?>

<form action="index.php?page=menu" method="POST">
	<h3><?php echo $data_edit ? 'Edit Menu' : 'Tambah Menu Baru'; ?></h3>
	
	<?php if ($data_edit): ?>
		<input type="hidden" name="id" value="<?php echo htmlspecialchars($data_edit['id_menu'], ENT_QUOTES, 'UTF-8'); ?>">
		<input type="hidden" name="form_action" value="update">
	<?php else: ?>
		<input type="hidden" name="form_action" value="create">
	<?php endif; ?>

	<label>Nama Menu:</label><br>
	<input type="text" name="nama" value="<?php echo $data_edit ? htmlspecialchars($data_edit['nama_menu'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
	<br><br>
	
	<label>Harga:</label><br>
	<input type="text" name="harga" value="<?php echo $data_edit ? htmlspecialchars($data_edit['harga'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
	<br><br>

	<label>Kategori:</label><br>
	<select name="id_kategori" required>
		<option value="">-- Pilih Kategori --</option>
		<?php while ($row_kat = $stmt_kategori->fetch(PDO::FETCH_ASSOC)): ?>
			<option value="<?php echo htmlspecialchars($row_kat['id_kategori'], ENT_QUOTES, 'UTF-8'); ?>" 
				<?php echo ($data_edit && $data_edit['id_kategori'] == $row_kat['id_kategori']) ? 'selected' : ''; ?>
			>
				<?php echo htmlspecialchars($row_kat['nama_kategori'], ENT_QUOTES, 'UTF-8'); ?>
			</option>
		<?php endwhile; ?>
	</select>
	<br><br>

	<button type="submit" class="btn btn-primary"><?php echo $data_edit ? 'Update Data' : 'Simpan Data Baru'; ?></button>
</form>

</div>

<div class="card">
	<h2>Daftar Menu</h2>
	<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Nama Menu</th>
			<th>Harga</th>
			<th>Kategori</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($row = $stmt_menu->fetch(PDO::FETCH_ASSOC)): ?>
			<tr>
				<td><?php echo htmlspecialchars($row['id_menu'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($row['nama_menu'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($row['harga'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($row['nama_kategori'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td class="table-actions actions">
					<a class="btn btn-secondary" href="index.php?page=menu&action=edit&id=<?php echo htmlspecialchars($row['id_menu'], ENT_QUOTES, 'UTF-8'); ?>">Edit</a>
					<form action="index.php?page=menu" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
					<input type="hidden" name="id" value="<?php echo $row['id_menu']; ?>">
					<input type="hidden" name="form_action" value="delete">

						<button type="submit" class="btn btn-danger">Hapus</button>
					</form>
				</td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>
</div>