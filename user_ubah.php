<?php



// Cek apakah user yang login adalah admin
if ($_SESSION['user']['level'] != 'admin') {
    echo "Akses ditolak! Hanya admin yang dapat mengubah data pengguna.";
    exit();
}

// Ambil ID user dari parameter URL
$id_user = $_GET['id'];

// Ambil data user dari database berdasarkan id_user
$query = $koneksi->prepare("SELECT * FROM user WHERE id_user = ?");
$query->bind_param("i", $id_user);
$query->execute();
$result = $query->get_result();
$data = $result->fetch_assoc();

// Jika form telah disubmit
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = !empty($_POST['password']) ? md5($_POST['password']) : $data['password'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $level = $_POST['level'];

    // Update data user
    $query_update = $koneksi->prepare("UPDATE user SET 
                        nama = ?, 
                        username = ?, 
                        password = ?, 
                        email = ?, 
                        alamat = ?, 
                        no_telepon = ?, 
                        level = ? 
                    WHERE id_user = ?");
    $query_update->bind_param("sssssssi", $nama, $username, $password, $email, $alamat, $no_telepon, $level, $id_user);

    if ($query_update->execute()) {
        echo "<script>alert('Data pengguna berhasil diubah!'); location.href='index.php?page=user';</script>";
    } else {
        echo "<script>alert('Gagal mengubah data pengguna!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Pengguna</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Ubah Data Pengguna</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($data['username']); ?>" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($data['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" value="<?php echo htmlspecialchars($data['alamat']); ?>" required>
            </div>
            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telepon" class="form-control" value="<?php echo htmlspecialchars($data['no_telepon']); ?>" required>
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <select name="level" class="form-control" required>
                    <option value="petugas" <?php echo ($data['level'] == 'petugas') ? 'selected' : ''; ?>>Petugas</option>
                    <option value="peminjam" <?php echo ($data['level'] == 'peminjam') ? 'selected' : ''; ?>>Peminjam</option>
                </select>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="index.php?page=user" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
