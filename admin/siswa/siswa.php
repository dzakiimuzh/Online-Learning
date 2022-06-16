<?php 

    include '../../koneksi.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Siswa</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php  include 'sidebar.php'; ?>
        <!-- End of Sidebar -->

        <?php 

            function query($query) {

                global $conn;
                $result = mysqli_query($conn, $query);
                $rows = [];
                while( $row = mysqli_fetch_assoc($result) ) {

                $rows[] = $row;

                }

                return $rows;

            }

            $batas = 5;
            $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
            $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;
        
            $previous = $halaman - 1;
            $next = $halaman + 1;
        
            $jumlah_data = count(query("SELECT * FROM tbl_siswa"));
            $total_halaman = ceil($jumlah_data / $batas);
        
            $nomor = $halaman_awal+1;
        
            $siswa = mysqli_query($conn, "SELECT * FROM tbl_siswa INNER JOIN kelas ON tbl_siswa.id_kelas = kelas.id_kelas LIMIT $halaman_awal, $batas");

            if( isset($_POST['cari']) ) {

                $keyword = $_POST['keyword'];

                $jumlah_data = count(query("SELECT * FROM tbl_siswa INNER JOIN kelas ON tbl_siswa.id_kelas = kelas.id_kelas WHERE nama LIKE '%$keyword%' OR kelas LIKE '%$keyword%'"));
                $total_halaman = ceil($jumlah_data / $batas);

                $siswa = mysqli_query($conn, "SELECT * FROM tbl_siswa INNER JOIN kelas ON tbl_siswa.id_kelas = kelas.id_kelas WHERE nama LIKE '%$keyword%' OR kelas LIKE '%$keyword%' LIMIT $halaman_awal, $batas");

            }
        
        ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div class="container mt-5 mb-4 px-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card p-4">
                            <h1 class="h3 mb-4 text-gray-800">Data Siswa</h1>
                            <div class="aksi d-flex justify-content-between">
                                <a href="tambahSiswa.php" class="btn btn-primary mb-3">Tambah Data</a>
                                <form action="" method="post">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search"
                                            aria-label="Recipient's username" aria-describedby="button-addon2"
                                            name="keyword">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2"
                                                name="cari">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Kelas</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while( $s = mysqli_fetch_assoc($siswa) ) : ?>
                                    <tr>
                                        <th scope="row"><?= $nomor++; ?></th>
                                        <td><?= $s['nama'] ?></td>
                                        <td><?= $s['kelas'] ?></td>
                                        <td>
                                            <a href="editSiswa.php?id=<?= $s['id_siswa'] ?>"
                                                class="btn btn-success">Edit</a>
                                            <a href="deleteSiswa.php?id=<?= $s['id_siswa'] ?>&idUser=<?= $s['id_user'] ?>"
                                                class="btn btn-danger"
                                                onclick="return confirm('Yakin hapus?')">Delete</a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <nav class="mt-4 ml-auto">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link previous"
                                            <?php if($halaman > 1){ echo "href='?halaman=$previous'"; } ?>>Previous</a>
                                    </li>
                                    <?php 
                                    for($x=1;$x<=$total_halaman;$x++){
                                ?>
                                    <li class="page-item <?= ($halaman == $x) ? 'active' : '' ?>"><a class="page-link"
                                            href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                                    <?php
                                    }
                                ?>
                                    <li class="page-item">
                                        <a class="page-link"
                                            <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../js/demo/chart-area-demo.js"></script>
        <script src="../js/demo/chart-pie-demo.js"></script>

</body>

</html>