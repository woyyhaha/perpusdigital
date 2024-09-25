<?php

// Cek apakah user yang login adalah admin
if ($_SESSION['user']['level'] != 'admin') {
    echo '<script>alert("Akses Ditolak! Hanya admin yang dapat melihat halaman ini"); location.href="index.php"</script>';
}
?>

<h1 class="m-4">Daftar Pengguna</h1>
<div class="card m-3">
    <div class="card-body p-5">
        <table class="table table-bordered mt-3" id="dataTable" width="100%" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Nama Lengkap</th>
                <th>No. Telepon</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
            <?php
            $i = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM user");
            while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?php echo $data['id_user']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['username']; ?></td>
                <td><?php echo $data['password']; ?></td>
                <td><?php echo $data['email']; ?></td>
                <td><?php echo $data['alamat']; ?></td>
                <td><?php echo $data['no_telepon']; ?></td>
                <td><?php echo $data['level']; ?></td>
                <td>
                    <a href="?page=user_ubah&id=<?php echo $data['id_user']; ?>" class="btn btn-info">Ubah</a>
                    <a onclick="return confirm('Apakah Anda yakin menghapus User ini?')" href="?page=user_hapus&id=<?php echo $data['id_user']; ?>" class="btn btn-danger">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>