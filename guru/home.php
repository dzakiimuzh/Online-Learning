<?php 


    session_start();
    include '../koneksi.php';

    if( !isset($_SESSION['login']) ) {

        header('location: ../login.php');
        exit;

    }

    date_default_timezone_set('Asia/Jakarta');

    $idUser2 = $_SESSION['idUser'];

    $imgP = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user = '$idUser2'")->fetch_assoc();

    $ambilKelas = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user ='$idUser2'");

    $ambil = mysqli_fetch_assoc($ambilKelas);
    $kelas2 = $ambil['kelas'];
    $kelas3 = explode(',', $kelas2);
    $kelas2 = $kelas3[0];

    $_SESSION['name'] = $ambil['nama']; 
    $_SESSION['mapel'] = $ambil['mapel']; 

    if( isset($_GET['kelas']) ) {

        $kelas2 = $_GET['kelas'];
        
    }
    

    $queryTugas = mysqli_query($conn, "SELECT * FROM tbl_tugas WHERE id_guru = '$idUser2' AND kelas = '$kelas2' AND status = 'belum'");

    $queryMateri = mysqli_query($conn, "SELECT * FROM tbl_materi WHERE id_guru = '$idUser2' AND kelas = '$kelas2' AND status = 'belum'");

    $queryMeet = mysqli_query($conn, "SELECT * FROM tbl_meet WHERE id_guru = '$idUser2' AND kelas = '$kelas2' AND status = 'belum'");
    

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
                            <img src="../assets/img_guru/<?= $imgP['img'] ?>" class="rounded-circle"
                                style="width: 45px; height: 45px;">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="ubahData.php">Ubah data</a>
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

    <div class="container container2 mb-5">
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
                    <div class="textKelas mt-4">Tugas Kelas <?= $kelas2 ?></div>
                    <div class="dropdown mt-3">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-expanded="false">
                            Tambah
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="tambahTugas.php?kelas=<?= $kelas2 ?>">Tugas</a>
                            <a class="dropdown-item" href="tambahMateri.php?kelas=<?= $kelas2 ?>">Materi</a>
                            <a class="dropdown-item" href="tambahMeet.php?kelas=<?= $kelas2 ?>">Meet</a>
                        </div>
                    </div>
                    <div class="mapel-row mt-4">
                        <?php if( mysqli_num_rows($queryTugas) == 0 && mysqli_num_rows($queryMateri) == 0 && mysqli_num_rows($queryMeet) == 0 ) : ?>
                            <div class="noData w-100 d-flex flex-column align-items-center">
                                <img src="../assets/img/no data.svg" width="200">
                                <h6 class="text-secondary mt-4">Tidak ada tugas</h6>
                            </div>
                        <?php endif; ?>
                        <?php while( $t = mysqli_fetch_assoc($queryTugas) ) : ?>
                        <div class="mapel card mr-4">
                            <h5><?= $t['materi'] ?></h5>
                            <p>Oleh <?= $t['guru'] ?></p>
                            <label>Pada <?= $t['tgl'] ?></label>
                            <div class="button">
                                <a href="detail.php?kelas=<?= $kelas2 ?>&idTugas=<?= $t['id_tugas'] ?>"
                                    class="btn btn-buka">Buka</a>
                                <a href="tugasSelesai.php?kelas=<?= $kelas2 ?>&idTugas=<?= $t['id_tugas'] ?>"
                                    class="btn btn-success"
                                    style="background-color: #28a745 !important; width: 100px; border-radius: 7px">Selesai</a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                        <?php while( $m = mysqli_fetch_assoc($queryMateri) ) : ?>
                        <div class="mapel card mr-4">
                            <h5><?= $m['materi'] ?> (Materi)</h5>
                            <p>Oleh <?= $m['guru'] ?></p>
                            <label>Pada <?= $m['tgl'] ?></label>
                            <div class="button">
                                <a href="detailMateri.php?kelas=<?= $kelas2 ?>&idMateri=<?= $m['id_materi'] ?>"
                                    class="btn btn-buka">Buka</a>
                                <a href="materiSelesai.php?kelas=<?= $kelas2 ?>&idMateri=<?= $m['id_materi'] ?>"
                                    class="btn btn-success"
                                    style="background-color: #28a745 !important; width: 100px; border-radius: 7px">Selesai</a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                        <?php while( $meet = mysqli_fetch_assoc($queryMeet) ) :?>
                        <div class="mapel card mr-4">
                            <h5><?= $meet['mapel'] ?> (Meet)</h5>
                            <p>Oleh <?= $meet['guru'] ?></p>
                            <label><?= $meet['mulai'] ?> - <?= $meet['selesai'] ?></label>
                            <?php 
                                    
                                $jamNow = date('H:i');
                                    
                            ?>
                            <div class="button">
                                <!-- <a href="<?= $meet['link'] ?>" class="btn btn-buka" target="_blank">Meet</a> -->
                                <a href="detailMeet.php?idMeet=<?= $meet['id_meet'] ?>&kelas=<?= $kelas2 ?>"
                                    class="btn btn-buka">Buka</a>
                                <a href="meetSelesai.php?kelas=<?= $kelas2 ?>&idMeet=<?= $meet['id_meet'] ?>"
                                    class="btn btn-success"
                                    style="background-color: #28a745 !important; width: 100px">Selesai</a>
                            </div>
                        </div>
                        <?php endwhile; ?>
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