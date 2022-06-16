<?php 

    session_start();
    include 'koneksi.php';

    if( !isset($_SESSION['login']) ) {

        header('location: login.php');
        exit;

    }

    date_default_timezone_set('Asia/Jakarta');

    $idUser = $_SESSION['idUser'];

    $imgP = mysqli_query($conn, "SELECT * FROM tbl_siswa WHERE id_user = '$idUser'")->fetch_assoc();

    $queryUser = mysqli_query($conn, "SELECT * FROM tbl_siswa INNER JOIN kelas ON tbl_siswa.id_kelas = kelas.id_kelas WHERE id_user = '$idUser'");

    $rowUser = mysqli_fetch_assoc($queryUser);

    $kelas = $rowUser['kelas'];

    $queryTugas = mysqli_query($conn, "SELECT DISTINCT mapel FROM tbl_tugas WHERE kelas = '$kelas' AND status = 'belum'");

    // $mapelT = mysqli_fetch_assoc($queryTugas);
    // $mapelT = $mapelT['mapel'];

    $queryMateri = mysqli_query($conn, "SELECT DISTINCT mapel FROM tbl_materi WHERE kelas = '$kelas' AND status = 'belum' ");

    if( mysqli_num_rows($queryMateri) >= 1 ) {

        $mapelM = mysqli_fetch_assoc($queryMateri);
        $mapelM = $mapelM['mapel'];

    }

    $queryMeet = mysqli_query($conn, "SELECT DISTINCT mapel FROM tbl_meet WHERE kelas = '$kelas' AND status = 'belum'");

    if( mysqli_num_rows($queryMeet) >= 1 ) {

        $mapelMeet = mysqli_fetch_assoc($queryMeet);
        $mapelMeet = $mapelMeet['mapel'];

    }

    if( mysqli_num_rows($queryTugas) >= 1 ) {

        $queryTugas = mysqli_query($conn, "SELECT DISTINCT mapel FROM tbl_tugas WHERE kelas = '$kelas' AND status = 'belum'");       

        // $queryTugas = mysqli_query($conn, "SELECT DISTINCT tbl_tugas.mapel, tbl_meet.mapel, tbl_materi.mapel FROM tbl_tugas INNER JOIN tbl_materi ON tbl_materi.kelas = tbl_tugas.kelas INNER JOIN tbl_meet ON tbl_meet.kelas = tbl_tugas.kelas WHERE tbl_tugas.kelas = '$kelas' AND tbl_tugas.status = 'belum'");        

    } else if( mysqli_num_rows($queryTugas) == 0 ) {

        $queryTugas = mysqli_query($conn, "SELECT DISTINCT mapel FROM tbl_materi WHERE kelas = '$kelas' AND status = 'belum'");
        

        if( mysqli_num_rows($queryTugas) == 0 ) {

            $queryTugas = mysqli_query($conn, "SELECT DISTINCT mapel FROM tbl_meet WHERE kelas = '$kelas' AND status = 'belum'");

        }

    } 

    $jumlahTugas = mysqli_num_rows($queryTugas);
    

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
    <title>Home</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
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
                            <img src="assets/img_profile/<?= $imgP['img'] ?>" class="rounded-circle"
                                style="width: 45px; height: 45px;">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="ubahData.php">Ubah data</a>
                            <a class="dropdown-item" href="logout.php">logOut</a>
                        </div>
                        <?php 
                        
                            $_SESSION['nama'] = $rowUser['nama'];
                            $_SESSION['kelas'] = $rowUser['kelas'];
                        
                        ?>
                        <div class="name">
                            <p><?= $rowUser['nama'] ?></p>
                            <label><?= $rowUser['kelas'] ?></label>
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
                    <a href="#" class="btn active btn-nav"><i class="fas fa-book-open mr-2"></i>Pelajaran </a>
                    <a href="nilai.php" class="btn btn-nav"><i class="fas fa-file-signature mr-2"></i>Nilai Saya</a>
                    <a href="absen.php" class="btn btn-nav"><i class="far fa-clipboard mr-2"></i>Absen Saya</a>
                    <!-- <a href="leaderboard.php" class="btn btn-nav"><i class="fas fa-medal mr-2"></i>Leaderboard</a> -->
                    <a href="dataGuru.php" class="btn btn-nav"><i class="fas fa-user-tie mr-2"></i>Data Guru</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card2">
                    <?php if( mysqli_num_rows($queryTugas) == 0 ) : ?>
                    <div class="noData mt-4 mb-3 w-100 d-flex flex-column align-items-center">
                        <img src="assets/img/no data.svg" width="200">
                        <h6 class="mt-4 text-secondary">Tidak ada tugas</h6>
                    </div>
                    <?php endif; ?>
                    <?php while($mapel3  = mysqli_fetch_assoc($queryTugas)) : ?>
                    <div class="btn-mapel mt-4"><?= $mapel3['mapel'] ?></div>
                    <div class="mapel-row mt-4">
                        <?php 
                                
                            $mapel = $mapel3['mapel'];
                            $queryMapel = mysqli_query($conn, "SELECT * FROM tbl_tugas WHERE kelas = '$kelas' AND mapel = '$mapel' AND status = 'belum'");

                            
                        ?>
                        <?php while( $rowMapel = mysqli_fetch_assoc($queryMapel) ) : ?>
                        <?php 
                                    
                            $idTugas = $rowMapel['id_tugas'];

                            $querySelesai = mysqli_query($conn, "SELECT * FROM tbl_nilai WHERE id_user = '$idUser' AND id_tugas = '$idTugas'");
                                    
                        ?>
                        <div class="mapel card mr-4">
                            <h5><?= $rowMapel['materi'] ?></h5>
                            <p>Oleh <?= $rowMapel['guru'] ?></p>
                            <label>Pada <?= $rowMapel['tgl'] ?></label>
                            <div class="button">
                                <?php if( mysqli_num_rows($querySelesai) == 1 ) : ?>
                                <a href="detail.php" class="btn btn-buka disabled">Buka</a>
                                <div class="selesai">Selesai</div>
                                <?php endif;?>
                                <?php if( mysqli_num_rows($querySelesai) == 0 ) : ?>
                                <a href="detail.php?idTugas=<?= $rowMapel['id_tugas'] ?>" class="btn btn-buka">Buka</a>
                                <div class="belum">Belum selesai</div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endwhile; ?>
                        <?php 
                                
                            $mapel = $mapel3['mapel'];
                            $queryMateri = mysqli_query($conn, "SELECT * FROM tbl_materi WHERE kelas = '$kelas' AND mapel = '$mapel' AND status = 'belum'");

                            
                        ?>
                        <?php while( $materi = mysqli_fetch_assoc($queryMateri) ) : ?>
                        <?php 
                                    
                            $idTugas = $materi['id_materi'];
                                    
                        ?>
                        <div class="mapel card mr-4">
                            <h5><?= $materi['materi'] ?> (Materi)</h5>
                            <p>Oleh <?= $materi['guru'] ?></p>
                            <label>Pada <?= $materi['tgl'] ?></label>
                            <div class="button">
                                <a href="detailMateri.php?idMateri=<?= $materi['id_materi'] ?>"
                                    class="btn btn-buka">Buka</a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                        <?php 
                                
                            $mapel = $mapel3['mapel'];
                            $queryMeet = mysqli_query($conn, "SELECT * FROM tbl_meet WHERE kelas = '$kelas' AND mapel = '$mapel' AND status = 'belum'");

                            
                        ?>
                        <?php while( $meet = mysqli_fetch_assoc($queryMeet) ) : ?>
                        <div class="mapel card mr-4">
                            <h5><?= $meet['mapel'] ?> (Meet)</h5>
                            <p>Oleh <?= $meet['guru'] ?></p>
                            <label><?= $meet['mulai'] ?> - <?= $meet['selesai'] ?></label>
                            <?php 
                                    
                            $jamNow = date('H:i');
                                
                            ?>
                            <?php if( $jamNow >= $meet['mulai'] && $jamNow <= $meet['selesai'] ) : ?>
                            <div class="button">
                                <a href="<?= $meet['link'] ?>" class="btn btn-buka" target="_blank">Meet</a>
                            </div>
                            <?php endif; ?>
                            <?php if( $jamNow >= $meet['selesai'] ) : ?>
                            <div class="button">
                                <a href="#" class="btn btn-buka disabled" target="">Meet</a>
                            </div>
                            <?php endif; ?>
                            <?php if( $jamNow <= $meet['mulai'] ) : ?>
                            <div class="button">
                                <a href="#" class="btn btn-buka disabled" target="">Meet</a>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <?php endwhile; ?>
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