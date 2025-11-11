<?php
// File: pelanggan.php (Letakkan di folder root atau di dalam /view/)

// 1. Memuat file Class dan Koneksi
include 'config/db.php';
include 'class/Pelanggan.php';

// 2. Inisialisasi Objek
$database = new Database();
$db = $database->getConnection();

$pelanggan = new Pelanggan($db);

// == LOGIKA KONTROLLER (PROSES FORM) ==
$action = isset($_GET['action']) ? $_GET['action'] : '';
$data_edit = null;

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Mendeteksi aksi dari form (tambah, edit, atau hapus)
        $form_action = $_POST['form_action'];

        if ($form_action == 'create') {
            $pelanggan->create($_POST['nama'], $_POST['email'], $_POST['no_hp']);
			header("Location: index.php?page=pelanggan&message=Data berhasil ditambahkan!");

        } else if ($form_action == 'update') {
            $pelanggan->update($_POST['id'], $_POST['nama'], $_POST['email'], $_POST['no_hp']);
			header("Location: index.php?page=pelanggan&message=Data berhasil diupdate!");

        } else if ($form_action == 'delete') {
            $pelanggan->delete($_POST['id']);
			header("Location: index.php?page=pelanggan&message=Data berhasil dihapus!");
        }
    }

    // Logika untuk mengambil data yang akan di-edit
    if ($action == 'edit' && isset($_GET['id'])) {
        $data_edit = $pelanggan->read($_GET['id']);
    }

    // Mengambil semua data untuk ditampilkan di tabel
    $stmt = $pelanggan->readAll();
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<div class="card">
	<h1>Manajemen Pelanggan</h1>
	<p>Mengelola data pelanggan restoran.</p>

<?php if(isset($_GET['message'])): ?>
	<div class="message">
		<?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?>
	</div>
<?php endif; ?>

<form action="index.php?page=pelanggan" method="POST">
	<h3><?php echo $data_edit ? 'Edit Pelanggan' : 'Tambah Pelanggan Baru'; ?></h3>
	
	<?php if ($data_edit): ?>
		<input type="hidden" name="id" value="<?php echo htmlspecialchars($data_edit['id_pelanggan'], ENT_QUOTES, 'UTF-8'); ?>">
		<input type="hidden" name="form_action" value="update">
	<?php else: ?>
		<input type="hidden" name="form_action" value="create">
	<?php endif; ?>

	<label>Nama:</label><br>
	<input type="text" name="nama" value="<?php echo $data_edit ? htmlspecialchars($data_edit['nama_pelanggan'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
	<br><br>
	
	<label>Email:</label><br>
	<input type="text" name="email" value="<?php echo $data_edit ? htmlspecialchars($data_edit['email'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
	<br><br>

	<label>No. HP:</label><br>
	<input type="text" name="no_hp" value="<?php echo $data_edit ? htmlspecialchars($data_edit['no_hp'], ENT_QUOTES, 'UTF-8') : ''; ?>">
	<br><br>

	<button type="submit" class="btn btn-primary"><?php echo $data_edit ? 'Update Data' : 'Simpan Data Baru'; ?></button>
	<?php if ($data_edit): ?>
		<a class="btn btn-secondary" href="index.php?page=pelanggan">Batal Edit</a>
	<?php endif; ?>
</form>

</div>

<div class="card">
	<h2>Daftar Pelanggan</h2>
	<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Nama Pelanggan</th>
			<th>Email</th>
			<th>No. HP</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
			<tr>
				<td><?php echo htmlspecialchars($row['id_pelanggan'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($row['nama_pelanggan'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($row['no_hp'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td class="table-actions actions">
					<a class="btn btn-secondary" href="index.php?page=pelanggan&action=edit&id=<?php echo htmlspecialchars($row['id_pelanggan'], ENT_QUOTES, 'UTF-8'); ?>">Edit</a>
					
					<form action="index.php?page=pelanggan" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
						<input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id_pelanggan'], ENT_QUOTES, 'UTF-8'); ?>">
						<input type="hidden" name="form_action" value="delete">
						<button type="submit" class="btn btn-danger">Hapus</button>
					</form>
				</td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>
</div>