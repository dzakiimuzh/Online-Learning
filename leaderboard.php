<?php 

    session_start();
    include 'koneksi.php';

    if( !isset($_SESSION['login']) ) {

        header('location: login.php');
        exit;

    }

    $idUser = $_SESSION['idUser'];

    $qLeaderboard = mysqli_query($conn, "SELECT * FROM leaderboard INNER JOIN tbl_siswa ON leaderboard.id_user = tbl_siswa.id_user INNER JOIN kelas ON kelas.id_kelas = tbl_siswa.id_kelas ORDER BY poin DESC LIMIT 10");

    $qPoinSaya = mysqli_query($conn, "SELECT * FROM leaderboard INNER JOIN tbl_siswa ON leaderboard.id_user = tbl_siswa.id_user INNER JOIN kelas ON kelas.id_kelas = tbl_siswa.id_kelas WHERE leaderboard.id_user = '$idUser'");

    $qRank = mysqli_query($conn, "SELECT * FROM leaderboard INNER JOIN tbl_siswa ON leaderboard.id_user = tbl_siswa.id_user INNER JOIN kelas ON kelas.id_kelas = tbl_siswa.id_kelas ORDER BY poin DESC");

    $poin = mysqli_fetch_assoc($qPoinSaya);
    

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
    <link rel="stylesheet" href="assets/css/leaderboard.css">
    <title>Home</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light pt-4">
        <div class="container">
            <a class="navbar-brand" href="#">SMK BM3</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    <div class="dropdown d-flex">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="assets/img/profile.svg" style="width: 45px;">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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
                    <a href="#" class="btn active btn-nav"><i class="fas fa-medal mr-2"></i>Leaderboard</a>
                    <a href="dataGuru.php" class="btn btn-nav"><i class="fas fa-user-tie mr-2"></i>Data Guru</a>
                </div>
            </div>
        </div>
        <?php 

        $rankSaya = 1;
        while( $rank = mysqli_fetch_assoc($qRank) ) {

            if( $rank['nama'] == $poin['nama'] ) {

                $noSaya = $rankSaya;

            }

            $rankSaya++;

        }

        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card2 cLeaderboard">
                    <h4 class="mb-3 mt-2">Leaderboard</h4>
                    <?php $no = 1; ?>
                    <?php while( $r = mysqli_fetch_assoc($qLeaderboard) ) : ?>
                    <div class="rowScore mt-3">
                        <b class="no"><?= $no++; ?>.</b>
                        <img src="assets/img/profile.svg" class="ml-2" width="60">
                        <div class="name ml-3">
                            <h5><?= $r['nama'] ?></h5>
                            <p><?= $r['kelas'] ?></p>
                        </div>
                        <div class="point ml-auto">
                            <h4><?= $r['poin'] ?> Point</h4>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <h4 class="mt-5">Rank Saya</h4>
                    <div class="rowScore rowSaya mt-3">
                        <b class="no"><?= $noSaya; ?>.</b>
                        <img src="assets/img/profile.svg" class="ml-2" width="60">
                        <div class="name ml-3">
                            <h5><?= $poin['nama'] ?></h5>
                            <p><?= $poin['kelas'] ?></p>
                        </div>
                        <div class="point ml-auto">
                            <h4><?= $poin['poin'] ?> Point</h4>
                        </div>
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