<?php
  include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>register ke perpustakaan digital</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-secondary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">register perpustakaan digital</h3></div>
                                    <div class="card-body">
                                        <?php
                                             if(isset($_POST['register'])) {
                                                $nama = $_POST['nama'];
                                                $email = $_POST['email'];
                                                $alamat = $_POST['alamat'];
                                                $no_telepon = $_POST['no_telepon'];
                                                $username = $_POST['username'];
                                                $level = $_POST['level'];
                                                $password = md5($_POST['password']);

                                                $insert = mysqli_query($koneksi, "INSERT INTO user(nama,email,alamat,no_telepon,username,password,level) VALUES('$nama','$email','$alamat','$no_telepon','$username','$password','$level')");

                                                if($insert){
                                                    echo '<script>alert("selamat, register berhasil. silahkan login"); location.href="login.php";</script>';
                                                }else{
                                                    echo '<script>alert("register gagal, silahkan ulangi kembali.")</script>';
                                                }
                                             }
                                        ?>
                                        <form method="post"> 
                                            <div class="form-group">
                                                <label for="inputEmail">Nama Nengkap</label>
                                                <input class="form-control" type="text" required name= "nama" placeholder="Masukan Nama Lengkap" />
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail">Email</label>
                                                <input class="form-control" type="text" required name= "email" placeholder="Masukan Email" />
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail">No Telepon</label>
                                                <input class="form-control" type="text" required name= "no_telepon" placeholder="Masukan No.Telepon" />
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail">Alamat</label>
                                                <textarea name="alamat" rows="5" required class="form-control"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label >Username</label>
                                                <input class="form-control" type="username" required name= "username" placeholder="Enter Username" />
                                            </div>
                                            <div class="form-group">
                                                <label for="inputPassword">Password</label>
                                                <input class="form-control" id="inputPassword" required name="password" type="password" placeholder="Masukan Password" />
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <input type="hidden" name="level" value="peminjam">
                                                <button class="btn btn-primary" type="submit" name="register" value="register">register</button>
                                                <a class="btn btn-danger" href="login.php">login</a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">
                                            &copy; 2024 perpustakaan digital.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
