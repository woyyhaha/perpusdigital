<?php

// Koneksi database
$koneksi = new mysqli("localhost", "root", "", "ukk_rpl");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk mengambil data buku
$query = "SELECT * FROM buku";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Proses request peminjaman
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_buku']) && isset($_POST['tanggal_peminjaman'])) {
    $id_buku = intval($_POST['id_buku']);
    $tanggal_peminjaman = $_POST['tanggal_peminjaman']; // Ambil tanggal peminjaman dari input

    // Pastikan sesi telah dimulai dan ID pengguna tersedia
    if (isset($_SESSION['user']['id_user'])) {
        $id_user = $_SESSION['user']['id_user'];

        // Cek jika buku sudah ada dalam status 'pending'
        $query_check = "SELECT * FROM peminjaman WHERE id_buku = ? AND id_user = ? AND status_peminjaman = 'pending'";
        $stmt_check = $koneksi->prepare($query_check);
        $stmt_check->bind_param("ii", $id_buku, $id_user);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo "<script>alert('Anda sudah memiliki request peminjaman untuk buku ini.');</script>";
        } else {
            // Menambahkan request peminjaman
            $query_insert = "INSERT INTO peminjaman (id_buku, id_user, tanggal_peminjaman, status_peminjaman) VALUES (?, ?, ?, 'pending')";
            $stmt = $koneksi->prepare($query_insert);
            $stmt->bind_param("iis", $id_buku, $id_user, $tanggal_peminjaman);

            if ($stmt->execute()) {
                echo "<script>alert('Request peminjaman berhasil!');</script>";
            } else {
                echo "<script>alert('Gagal melakukan request peminjaman.');</script>";
            }

            $stmt->close();
        }

        $stmt_check->close();
    } else {
        // Jika ID pengguna tidak tersedia dalam sesi, tampilkan pesan kesalahan
        echo "Anda perlu login untuk melakukan peminjaman.";
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Buku - User</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Kumpulan buku</h1>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    DataTable Buku
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sampul</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Tahun Terbit</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Sampul</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Tahun Terbit</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
    <?php
    $i = 1;
    while ($data = mysqli_fetch_array($result)) {
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td>No Sampul</td>
            <td><?php echo htmlspecialchars($data['judul']); ?></td>
            <td><?php echo htmlspecialchars($data['penulis']); ?></td>
            <td><?php echo htmlspecialchars($data['penerbit']); ?></td>
            <td><?php echo htmlspecialchars($data['tahun_terbit']); ?></td>
            <td><?php echo htmlspecialchars($data['deskripsi']); ?></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="id_buku" value="<?php echo $data['id_buku']; ?>">
                    <label for="tanggal_peminjaman_<?php echo $data['id_buku']; ?>">Tanggal Peminjaman:</label>
                    <input type="date" id="tanggal_peminjaman_<?php echo $data['id_buku']; ?>" name="tanggal_peminjaman" required>
                    <button type="submit" class="btn btn-warning btn-sm">Pinjam</button>
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
    </main>
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>