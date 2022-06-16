<?php 

    session_start();
    include 'koneksi.php';

    if( !isset($_SESSION['login']) ) {

        header('location: login.php');
        exit;

    }

    $idUser = $_SESSION['idUser'];

    $imgP = mysqli_query($conn, "SELECT * FROM tbl_siswa WHERE id_user = '$idUser'")->fetch_assoc();

    $queryGuru = mysqli_query($conn, "SELECT * FROM tbl_guru");

    if( isset($_POST['cari']) ) {

        $keyword = $_POST['keyword'];

        $queryGuru = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE nama LIKE '%$keyword%' OR mapel LIKE '%$keyword%' OR kelas LIKE '%$keyword%'");

    }


    

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
    <link rel="stylesheet" href="assets/css/nilai.css">
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
                    <a href="home.php" class="btn btn-nav"><i class="fas fa-book-open mr-2"></i>Pelajaran </a>
                    <a href="nilai.php" class="btn btn-nav"><i class="fas fa-file-signature mr-2"></i>Nilai Saya</a>
                    <a href="absen.php" class="btn btn-nav"><i class="far fa-clipboard mr-2"></i>Absen Saya</a>
                    <!-- <a href="leaderboard.php" class="btn btn-nav"><i class="fas fa-medal mr-2"></i>Leaderboard</a> -->
                    <a href="dataGuru.php" class="btn btn-nav active"><i class="fas fa-user-tie mr-2"></i>Data Guru</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card2">
                    <div class="aksi mb-4 d-flex justify-content-between align-items-center">
                        <h3 class="tN">Data guru</h3>
                        <form action="" method="POST">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control cari" placeholder="Search"
                                    aria-label="Recipient's username" aria-describedby="button-addon2" name="keyword">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary btnC" type="submit" id="button-addon2"
                                        name="cari">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="over">
                        <table class="table mt-2">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Guru</th>
                                    <th scope="col">Mapel</th>
                                    <th scope="col">Mengajar Kelas</th>
                                    <th scope="col">Chat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php while( $g = mysqli_fetch_assoc($queryGuru) ) : ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= $g['nama'] ?></td>
                                    <td><?= $g['mapel'] ?></td>
                                    <td><?= $g['kelas'] ?></td>
                                    <td>
                                        <a href="https://wa.me/<?= $g['no_hp'] ?>" class="btn text-white" target="_blank"
                                            style="font-size: 14.5px; border-radius: 7px; background-color: #39e155;">Chat</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
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