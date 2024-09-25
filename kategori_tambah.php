<h1 class="mt-4">Tambah Kategori</h1>
<div class="card">
    <div class="card-body">
    <div class="row">`
        <div class="col-md-12">
             <form method="post">
                <?php
                    if(isset($_POST['submit'])) {
                        $kategori = $_POST['kategori'];
                        $query = mysqli_query($koneksi, "INSERT INTO kategori(kategori) values('$kategori')");

                        if($query){
                            echo '<script>alert("tambah kategori berhasil.");</script>';
                        }else{
                            echo '<script>alert("tambah kategori gagal.");</script>';
                        }
                    }
                    ?>
                <div class="row mb-3">
                    <div class="col-md-2">Tambah kategori</div>
                    <div class="col-md-8"><input type="text" class="from-control" name="kategori"></div>
            </div>
            <div class="">
                <div class="col-md-2"></div>
                <div class="col-md-8"></div>
                    <button type="submit" class="btn btn-primary" name="submit" value="submit">Simpan</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <a href="?page=kategori" class="btn btn-danger">Kembali</a>
            </div>
            </div>
        </from>
     </div>
 </div>
 </div>
</div>