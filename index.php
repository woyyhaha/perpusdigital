<?php
include "koneksi.php";

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Perpustakaan Digital</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="?">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Navigasi</div>

                        <?php if ($_SESSION['user']['level'] == 'admin' || $_SESSION['user']['level'] == 'petugas'): ?>
                            <?php if ($_SESSION['user']['level'] == 'admin'): ?>
                                <a class="nav-link" href="?page=buku">
                                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                    Buku
                                </a>
                                <a class="nav-link" href="?page=user">
                                    <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                                    Daftar pengguna
                                </a>
                                <a class="nav-link" href="?page=kategori">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Kategori
                            </a>
                            <?php endif; ?>
                            <?php if ($_SESSION['user']['level'] == 'petugas'): ?>
                                <a class="nav-link" href="?page=peminjaman_pending">
                                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                    Pending Buku
                                </a>
                            <?php endif; ?>
                        <?php elseif ($_SESSION['user']['level'] == 'peminjam'): ?>
                            <a class="nav-link" href="?page=buku_user">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Kumpulan Buku
                            </a>
                        <?php endif; ?>

                        <a class="nav-link" href="?page=ulasan">
                            <div class="sb-nav-link-icon"><i class="fas fa-comment"></i></div>
                            Ulasan
                        </a>
                        
                        <!-- Show laporan link for all users -->
                        <a class="nav-link" href="?page=laporan">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Laporan Peminjaman
                        </a>

                        <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-power-off"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo htmlspecialchars($_SESSION['user']['nama']); ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                    if (file_exists($page . '.php')) {
                        // Include the page only if the user has the right access
                        $user_level = $_SESSION['user']['level'];
                        if (($page === 'buku' && $user_level !== 'admin') ||
                            ($page === 'peminjaman_admin' && $user_level !== 'petugas')) {
                            include '404.php';
                        } else {
                            include $page . '.php';
                        }
                    } else {
                        include '404.php';
                    }
                    ?>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <!-- Footer content -->
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>