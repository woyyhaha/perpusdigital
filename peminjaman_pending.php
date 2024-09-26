<?php
// Include the database connection
include_once 'koneksi.php';

// Cek apakah pengguna sudah login dan memiliki akses yang tepat
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] !== 'petugas') {
    include '404.php';
    exit();
}

// Handle request approval or rejection with date of return
if (isset($_POST['update'])) {
    $id_peminjaman = intval($_POST['id_peminjaman']);
    $status_peminjaman = mysqli_real_escape_string($koneksi, $_POST['status_peminjaman']);
    $tanggal_pengembalian = isset($_POST['tanggal_pengembalian']) ? mysqli_real_escape_string($koneksi, $_POST['tanggal_pengembalian']) : '';

    if ($status_peminjaman == 'disetujui' && empty($tanggal_pengembalian)) {
        echo json_encode(['success' => false, 'message' => 'Tanggal pengembalian harus diisi jika menyetujui peminjaman.']);
    } else {
        $query = mysqli_query($koneksi, "
            UPDATE peminjaman 
            SET status_peminjaman = '$status_peminjaman', tanggal_pengembalian = '$tanggal_pengembalian' 
            WHERE id_peminjaman = $id_peminjaman
        ");

        if($query) {
            echo '<script>alert("Ubah Data Berhasil.");</script>';
        } else {
            echo '<script>alert("Ubah Data Gagal: ' . mysqli_error($koneksi) . '");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku - Pending Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-4">
        <h1 class="mt-4">Peminjaman Buku - Pending Requests</h1>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Buku</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $query = mysqli_query($koneksi, "
                                    SELECT peminjaman.id_peminjaman, user.nama, buku.judul, peminjaman.tanggal_peminjaman, peminjaman.tanggal_pengembalian, peminjaman.status_peminjaman
                                    FROM peminjaman 
                                    LEFT JOIN user AS user ON user.id_user = peminjaman.id_user 
                                    LEFT JOIN buku ON buku.id_buku = peminjaman.id_buku 
                                    WHERE peminjaman.status_peminjaman = 'pending'
                                ");

                                // Check if the query was successful
                                if (!$query) {
                                    die("Query failed: " . mysqli_error($koneksi));
                                }

                                while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($data['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($data['judul']); ?></td>
                                        <td><?php echo htmlspecialchars($data['tanggal_peminjaman']); ?></td>
                                        <td>
                                            <?php if ($data['status_peminjaman'] == 'disetujui'): ?>
                                                <?php echo htmlspecialchars($data['tanggal_pengembalian']); ?>
                                            <?php else: ?>
                                                <form method="post" style="display:inline;">
                                                    <input type="hidden" name="id_peminjaman" value="<?php echo $data['id_peminjaman']; ?>">
                                                    <input type="hidden" name="status_peminjaman" value="disetujui">
                                                    <div class="form-group">
                                                        <label for="tanggal_pengembalian_<?php echo $data['id_peminjaman']; ?>">Tanggal Pengembalian:</label>
                                                        <input type="date" id="tanggal_pengembalian_<?php echo $data['id_peminjaman']; ?>" name="tanggal_pengembalian" required>
                                                    </div>
                                                    <button type="submit" name="update" class="btn btn-success btn-sm">Setujui</button>
                                                </form>
                                            <?php endif; ?>
                                            <form method="post" style="display:inline;">
                                                <input type="hidden" name="id_peminjaman" value="<?php echo $data['id_peminjaman']; ?>">
                                                <input type="hidden" name="status_peminjaman" value="ditolak">
                                                <button type="submit" name="update" class="btn btn-danger btn-sm">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
