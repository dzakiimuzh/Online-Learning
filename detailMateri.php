<?php 

    session_start();
    include 'koneksi.php';

    if( !isset($_SESSION['login']) ) {

        header('location: login.php');
        exit;

    }

    $idMateri = $_GET['idMateri'];
    $idUser2 = $_SESSION['idUser'];

    $imgP = mysqli_query($conn, "SELECT * FROM tbl_siswa WHERE id_user = '$idUser2'")->fetch_assoc();

    $idMateri = $_GET['idMateri'];

    $queryDetail = mysqli_query($conn, "SELECT * FROM tbl_materi WHERE id_materi = '$idMateri'");

    $materi = mysqli_fetch_assoc($queryDetail);
    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- My CSS -->
    <!-- <link rel="stylesheet" href="assets/css/home.css"> -->
    <link rel="stylesheet" href="assets/css/home2.css">
    <link rel="stylesheet" href="assets/css/detail2.css">
    <title>Home</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light shadow-sm pt-4">
        <div class="container">
            <a class="navbar-brand" href="#">SmkBm3</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    <div class="dropdown d-flex">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="assets/img_profile/<?= $imgP['img'] ?>" class="rounded-circle" style="width: 45px; height: 45px;">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="ubahData.php">Ubah data</a>
                            <a class="dropdown-item" href="logout.php">logOut</a>
                        </div>
                        <div class="name">
                            <p><?= $_SESSION['nama'] ?></p>
                            <label><?= $_SESSION['kelas'] ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container container2">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-row">
                    <a href="home.php" class="btn active btn-nav"><i class="fas fa-book-open mr-2"></i>Pelajaran </a>
                    <a href="nilai.php" class="btn btn-nav"><i class="fas fa-file-signature mr-2"></i>Nilai Saya</a>
                    <a href="absen.php" class="btn btn-nav"><i class="far fa-clipboard mr-2"></i>Absen Saya</a>
                    <a href="leaderborad.php" class="btn btn-nav"><i class="fas fa-medal mr-2"></i>Leaderboard</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card2">
                    <div class="detail d-flex align-items-center">
                        <a href="home.php">
                            <div class="bulat">
                                <i class="fas fa-arrow-left"></i>
                            </div>
                        </a>
                        <h2 class="ml-3">Detail Pelajaran</h2>
                    </div>
                    <div class="detail-mapel">
                        <table>
                            <tr>
                                <th>Mapel</th>
                                <td>:</td>
                                <td><?= $materi['mapel'] ?></td>
                            </tr>
                            <tr>
                                <th>Dibuat Oleh</th>
                                <td>:</td>
                                <td><?= $materi['guru'] ?></td>
                            </tr>
                            <tr>
                                  <th>Tanggal</th>
                                <td>:</td>
                                <td><?= $materi['tgl'] ?></td>
                            </tr>
                            <tr>
                                <th>Materi</th>
                                <td>:</td>
                                <td><?= $materi['materi'] ?></td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>:</td>
                                <td><?= $materi['desk'] ?></td>
                            </tr>
                        </table>
                    </div>
                    <a href="download.php?filename=<?= $materi['file']; ?>" class="btn btn-soal w-100 mt-5">Download</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>
</body>

</html>