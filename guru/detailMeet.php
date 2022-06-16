<?php 

    session_start();
    include '../koneksi.php';

    date_default_timezone_set("Asia/Jakarta");

    if( !isset($_SESSION['login']) ) {

        header('location: ../login.php');
        exit;

    }

    $idUser2 = $_SESSION['idUser'];

    $imgP = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user = '$idUser2'")->fetch_assoc();
    
    $ambilKelas = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user ='$idUser2'");

    $ambil = mysqli_fetch_assoc($ambilKelas);
    $kelas2 = $_GET['kelas'];
    $kelas3 = explode(',', $kelas2);

    $idMeet = $_GET['idMeet'];

    $queryDetail = mysqli_query($conn, "SELECT * FROM tbl_meet INNER JOIN tbl_guru ON tbl_meet.id_guru = tbl_guru.id_user WHERE tbl_meet.id_meet = '$idMeet' AND tbl_meet.id_guru = '$idUser2'");

    $row = mysqli_fetch_assoc($queryDetail);
    

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
    <link rel="stylesheet" href="../assets/css/home2.css">
    <link rel="stylesheet" href="../assets/css/detail2.css">
    <title>Home</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light pt-4 shadow-sm">
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
                            <img src="../assets/img_guru/<?= $imgP['img'] ?>" class="rounded-circle"
                                style="width: 45px; height: 45px;">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="logout.php">logOut</a>
                        </div>
                        <div class="name">
                            <p><?= $_SESSION['name'] ?></p>
                            <label>Guru <?= $_SESSION['mapel'] ?></label>
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
                    <div class="dropdown">
                        <button class="btn btn-nav active dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-book-open mr-2"></i>Pelajaran
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php foreach( $kelas3 as $k ) : ?>
                            <a class="dropdown-item" href="home.php?kelas=<?= $k ?>"><?= $k ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-nav dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-file-signature mr-2"></i>Nilai Siswa
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php foreach( $kelas3 as $k ) : ?>
                            <a class="dropdown-item" href="nilai.php?kelas=<?= $k ?>"><?= $k ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-nav dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="far fa-clipboard mr-2"></i>Absen Siswa
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php foreach( $kelas3 as $k ) : ?>
                            <a class="dropdown-item" href="absen.php?kelas=<?= $k ?>"><?= $k ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card2">
                    <div class="detail d-flex align-items-center">
                        <a href="home.php?kelas=<?= $kelas2 ?>">
                            <div class="bulat">
                                <i class="fas fa-arrow-left"></i>
                            </div>
                        </a>
                        <h2 class="ml-4 tT">Detail Pelajaran</h2>
                    </div>
                    <div class="detail-mapel">
                        <table>
                            <tr>
                                <th>Mapel</th>
                                <td>:</td>
                                <td><?= $row['mapel'] ?></td>
                            </tr>
                            <tr>
                                <th>Dibuat Oleh</th>
                                <td>:</td>
                                <td><?= $row['guru'] ?></td>
                            </tr>
                            <tr>
                                <th>Jam</th>
                                <td>:</td>
                                <td><?= $row['mulai'] ?> - <?= $row['selesai'] ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="btn-grup mt-5 d-flex align-items-center justify-content-center">
                        <?php 
                                            
                            $jamNow = date('H:i');
                                    
                        ?>
                        <?php if( $jamNow >= $row['mulai'] && $jamNow <= $row['selesai'] ) : ?>
                        <a href="<?= $row['link'] ?>" class="btn btn-soal mr-3" target="_blank" style="width: 90%;">Meet</a>
                        <?php endif; ?>
                        <?php if( $jamNow >= $row['selesai'] ) : ?>
                        <a href="<?= $row['link'] ?>" class="btn btn-soal mr-3 disabled" target="_blank" style="width: 90%;">Meet</a>
                        <?php endif; ?>
                        <?php if( $jamNow <= $row['mulai'] ) : ?>
                        <a href="<?= $row['link'] ?>" class="btn btn-soal mr-3 disabled" target="_blank" style="width: 90%;">Meet</a>
                        <?php endif; ?>
                        <a href="editMeet.php?idMeet=<?= $row['id_meet'] ?>&kelas=<?= $kelas2 ?>"
                            class="btn btn-edit btn-success mr-2 p-2"><i class="fas fa-edit"></i></a>
                        <a href="deleteMeet.php?idMeet=<?= $row['id_meet'] ?>&kelas=<?= $kelas2 ?>"
                            class="btn btn-edit btn-danger p-2"><i class="fas fa-trash-alt"></i></a>
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