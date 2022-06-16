<?php 

    include '../../koneksi.php';

    $kelas = mysqli_query($conn, "SELECT * FROM kelas");
    $mapel = mysqli_query($conn, "SELECT * FROM mapel");

    if( isset($_POST['tambah']) ) {

        $nama = $_POST['name'];
        $no = $_POST['no'];
        $kelas = $_POST['kelas'];
        $mapel = $_POST['mapel'];

        $kelas = implode(',', $kelas);

        $username = str_replace(' ', '', $nama);
        $username = strtolower($username);

        $password = password_hash($username, PASSWORD_DEFAULT);

        $queryTambah =  mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password', 'guru')");

        $q = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        $id = mysqli_fetch_assoc($q);
        $id = $id['id_user'];

        $queryInput = mysqli_query($conn, "INSERT INTO tbl_guru VALUES('', '$id', '$nama', '$kelas', '$mapel', '$no', 'profile.svg')");

        if( $queryInput ) {

            echo "
            
                <script>
                    alert('Tambah guru berhasil');
                    alert('Username & Password = $username');
                    document.location.href = 'guru.php';
                </script>
            
            ";
            
        } else {

            
            echo "
            
                <script>
                    alert('Tambah guru gagal');
                    document.location.href = 'tambahGuru.php';
                </script>
            
            ";

        }

    }

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

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

        <div id="content-wrapper" class="d-flex flex-column">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card p-4">
                            <h1 class="h3 mb-4 mt-3 text-gray-800">Tambah data guru</h1>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nama</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1"
                                        placeholder="Masukkan nama" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Mapel</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="mapel">
                                        <?php while( $m = mysqli_fetch_assoc($mapel) ) : ?>
                                        <option value="<?= $m['mapel'] ?>"><?= $m['mapel'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Mengajar Kelas</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="kelas[]" multiple>
                                        <?php while( $k = mysqli_fetch_assoc($kelas) ) : ?>
                                        <option value="<?= $k['kelas'] ?>"><?= $k['kelas'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">No Hp</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1"
                                        placeholder="Masukkan no hp" name="no">
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-2" name="tambah">Tambah</button>
                            </form>
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