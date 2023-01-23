<?php
    session_start();
    if( !isset($_SESSION["login"]) ) {
        header("Location: login.php");
        exit;
    }

    $role = $_SESSION["role"];

    require 'functions.php';

    $trans = query("SELECT pembelian.idpembelian, namabarang, konsumen.idkonsumen as idkonsumen,namakonsumen, waktu AS wkt,jumlahbeli,status, DATE_FORMAT(waktu, '%d %M %Y') AS waktu ,harga,harga * jumlahbeli AS 'harga pembelian'
                    FROM pembelian
                    INNER JOIN konsumen
                    ON pembelian.idkonsumen = konsumen.idkonsumen
                    INNER JOIN inventoribarang
                    ON pembelian.idbarang = inventoribarang.idbarang
                    ORDER BY wkt DESC");
    // aksi cari
    if(isset($_POST["cari"])){
        $trans = cariTrans($_POST["keyword"]); 
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
        <title>Transaksi Barang</title>
        <!-- icon -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Toko AnekaSuka</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" action="" method="post">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Masukkan keyword" name="keyword" aria-label="" aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-search" id="cari" type="submit" name="cari"><i class="fas fa-search"></i></button>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i> Hai <?= $_SESSION["namapegawai"];?> </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                        <div class="sb-sidenav-menu-heading">Halaman Utama</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="bi bi-house-door-fill"></i></div>
                                HOME
                            </a>

                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTransaksi" aria-expanded="false" aria-controls="collapseTransaksi">
                                <div class="sb-nav-link-icon"><i class="bi bi-currency-dollar"></i></div>
                                Transaksi
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseTransaksi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="transaksi.php">Menampilkan Transaksi</a>
                                    <a class="nav-link" href="menambahTransaksi.php">Menambah Transaksi</a>
                                    <a class="nav-link" href="menghitungTransaksi.php">Hitung Transaksi</a>
                                </nav>
                            </div>

                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Menampilkan Data Transaksi</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Data Transaksi</li>
                        </ol>
                        <div class="div">
                        <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Waktu</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Nama Konsumen</th>
                            <th scope="col">Jumlah Beli</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Status Pembayaran</th>
                            <?php if ($role == "spv") { ?>
                                <th scope="col" style="text-align: center;">Aksi</th>
                            <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($trans as $row) : ?>
                            <tr>
                            <td><?= $row["waktu"]?></td>
                            <td><?= $row["namabarang"]?></td>
                            <td><?= $row["namakonsumen"]?></td>
                            <td><?= $row["jumlahbeli"]?></td>
                            <td>RP. <?= $row["harga pembelian"]?></td>

                            <?php if ($row["status"] == "belum dibayar") { ?>
                                <td class="text-danger" ><?= $row["status"]?></td>
                            <?php } else { ?>
                                <td><?= $row["status"]?></td>
                            <?php } ?>

                            <?php if ($role == "spv") { ?>
                                <td style="text-align: center;">
                                        <a class="btn btn-success" href="mengubahTransaksi.php?idpembelian=<?= $row["idpembelian"]; ?>"><i class="bi bi-pencil-fill"></i></a>
                                        <a class="btn btn-danger" href="hapusTransaksi.php?idpembelian=<?= $row["idpembelian"]; ?>"onclick="return confirm('yakin?');"> <i class="bi bi-trash-fill"></i></a>
                                </td>
                            <?php } ?>


                        </tr>
                            <?php endforeach; ?>
                        </tbody>
                        </table>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Kelompok 4 IF-2</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
