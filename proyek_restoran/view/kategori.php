<?php
// File: kategori.php (Letakkan di folder root)

// 1. Memuat file Class dan Koneksi
include 'config/db.php';
include 'class/Kategori.php'; // <-- Memuat class Kategori

// 2. Inisialisasi Objek
$database = new Database();
$db = $database->getConnection();

$kategori = new Kategori($db); // <-- Membuat objek Kategori

// == LOGIKA KONTROLLER (PROSES FORM) ==
$action = isset($_GET['action']) ? $_GET['action'] : '';
$data_edit = null;

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form_action = $_POST['form_action'];

        if ($form_action == 'create') {
            $kategori->create($_POST['nama']);
			header("Location: index.php?page=kategori&message=Kategori berhasil ditambahkan!");

        } else if ($form_action == 'update') {
            $kategori->update($_POST['id'], $_POST['nama']);
			header("Location: index.php?page=kategori&message=Kategori berhasil diupdate!");

        } else if ($form_action == 'delete') {
            $kategori->delete($_POST['id']);
			header("Location: index.php?page=kategori&message=Kategori berhasil dihapus!");
        }
    }

    // Logika untuk mengambil data yang akan di-edit
    if ($action == 'edit' && isset($_GET['id'])) {
        $data_edit = $kategori->read($_GET['id']);
    }

    // Mengambil semua data untuk ditampilkan di tabel
    $stmt = $kategori->readAll();
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<div class="card">
	<h1>Manajemen Kategori</h1>
	<p>Mengelola kategori menu restoran.</p>

<?php if(isset($_GET['message'])): ?>
	<div class="message">
		<?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?>
	</div>
<?php endif; ?>

<form action="index.php?page=kategori" method="POST">
	<h3><?php echo $data_edit ? 'Edit Kategori' : 'Tambah Kategori Baru'; ?></h3>
	
	<?php if ($data_edit): ?>
		<input type="hidden" name="id" value="<?php echo htmlspecialchars($data_edit['id_kategori'], ENT_QUOTES, 'UTF-8'); ?>">
		<input type="hidden" name="form_action" value="update">
	<?php else: ?>
		<input type="hidden" name="form_action" value="create">
	<?php endif; ?>

	<label>Nama Kategori:</label><br>
	<input type="text" name="nama" value="<?php echo $data_edit ? htmlspecialchars($data_edit['nama_kategori'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
	<br><br>

	<button type="submit" class="btn btn-primary"><?php echo $data_edit ? 'Update Data' : 'Simpan Data Baru'; ?></button>
	<?php if ($data_edit): ?>
		<a class="btn btn-secondary" href="index.php?page=kategori">Batal Edit</a>
	<?php endif; ?>
</form>

</div>

<div class="card">
	<h2>Daftar Kategori</h2>
	<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Nama Kategori</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
			<tr>
				<td><?php echo htmlspecialchars($row['id_kategori'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($row['nama_kategori'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td class="table-actions actions">
					<a class="btn btn-secondary" href="index.php?page=kategori&action=edit&id=<?php echo htmlspecialchars($row['id_kategori'], ENT_QUOTES, 'UTF-8'); ?>">Edit</a>
					
					<form action="index.php?page=kategori" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
						<input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id_kategori'], ENT_QUOTES, 'UTF-8'); ?>">
						<input type="hidden" name="form_action" value="delete">
						<button type="submit" class="btn btn-danger">Hapus</button>
					</form>
				</td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>
</div>