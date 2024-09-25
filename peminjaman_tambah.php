<?php

if (isset($_POST['submit'])) {
    // Pastikan semua input ada
    if (!isset($_SESSION['user']['id_user'])) {
        echo '<script>alert("ID User tidak ditemukan.");</script>';
        exit;
    }

    $id_user = $_SESSION['user']['id_user'];
    $id_buku = $_POST['id_buku'];
    $tanggal_peminjaman = $_POST['tanggal_peminjaman'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    $status_peminjaman = $_POST['status_peminjaman'];

    // Sanitasi data untuk mencegah SQL Injection
    $id_user = mysqli_real_escape_string($koneksi, $id_user);
    $id_buku = mysqli_real_escape_string($koneksi, $id_buku);
    $tanggal_peminjaman = mysqli_real_escape_string($koneksi, $tanggal_peminjaman);
    $tanggal_pengembalian = mysqli_real_escape_string($koneksi, $tanggal_pengembalian);
    $status_peminjaman = mysqli_real_escape_string($koneksi, $status_peminjaman);

    // Query SQL untuk insert data
    $query = ("INSERT INTO peminjaman (id_user, id_buku, tanggal_peminjaman, tanggal_pengembalian, status_peminjaman) VALUES ('$id_user', '$id_buku', '$tanggal_peminjaman', '$tanggal_pengembalian', '$status_peminjaman')");

    if (mysqli_query($koneksi, $query)) {
        echo '<script>alert("Tambah data berhasil."); window.location.href="?page=peminjaman";</script>';
    } else {
        echo '<script>alert("Tambah data gagal: ' . mysqli_error($koneksi) . '");</script>';
    }
}
?>


<h1 class="m-4">Peminjaman Buku</h1>
<div class="card m-3">
    <div class="card-body p-4">
        <form method="post">
            <div class="row mb-3">
                <div class="col-md-2">Buku</div>
                <div class="col-md-8">
                    <select name="id_buku" class="form-control" required>
                        <?php
                        $buk = mysqli_query($koneksi, "SELECT * FROM buku");
                        while ($buku = mysqli_fetch_array($buk)) {
                            echo '<option value="' . $buku['id_buku'] . '">' . $buku['judul'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-2">Tanggal Peminjaman</div>
                <div class="col-md-8">
                    <input type="date" class="form-control" name="tanggal_peminjaman" required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-2">Tanggal Pengembalian</div>
                <div class="col-md-8">
                    <input type="date" class="form-control" name="tanggal_pengembalian" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">Status Peminjaman</div>
                <div class="col-md-8">
                    <select name="status_peminjaman" class="form-select" required>
                        <option value="dipinjamkan">Dipinjamkan</option>
                        <option value="dikembalikan">Dikembalikan</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <button type="submit" class="btn btn-primary" name="submit" value="submit">Simpan</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <a href="?page=peminjaman" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
