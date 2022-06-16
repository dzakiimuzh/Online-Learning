<?php 

    session_start();
    include '../koneksi.php';

    date_default_timezone_set('Asia/Jakarta');

    if( !isset($_SESSION['login']) ) {

        header('location: login.php');
        exit;

    }

    $materi = $_GET['materi'];
    $kelas2 = $_GET['kelas'];
    $idUser = $_SESSION['idUser'];

    $imgP = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user = '$idUser'")->fetch_assoc();

    $ambilKelas = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user ='$idUser'");

    $ambil = mysqli_fetch_assoc($ambilKelas);
    $kelas22 = $ambil['kelas'];
    $kelas3 = explode(',', $kelas22);

    $queryTugas = mysqli_query($conn, "SELECT * FROM tbl_tugas INNER JOIN tbl_guru ON tbl_guru.id_user = tbl_tugas.id_guru WHERE tbl_tugas.materi = '$materi' AND tbl_tugas.id_guru = '$idUser' AND tbl_tugas.kelas = '$kelas2' AND tbl_tugas.status = 'belum' AND jenis_soal = 'Pilihan ganda'");

    $row = mysqli_fetch_assoc($queryTugas);


    if( isset($_POST['buat']) ) {

        $idTugas = $row['id_tugas'];

        $jumlahSoal = $row['jumlah_soal'];

        $no = 1;
        while( $no <= $jumlahSoal ) {

            $soal = $_POST['soal' . $no];
            $pg = $_POST['pg' . $no];

            $querySoal = mysqli_query($conn, "INSERT INTO tbl_soal VALUES('', '$idTugas', '$no', '$soal', '$pg')");

            $qIdSoal = mysqli_query($conn, "SELECT * FROM tbl_soal WHERE id_tugas = '$idTugas' AND soal = '$soal'");
            
            $rowSoal = mysqli_fetch_assoc($qIdSoal);
            $idSoal = $rowSoal['id_soal'];

            $jawabanA = $_POST['jawaban_A' . $no]; 
            $jawabanB = $_POST['jawaban_B' . $no]; 
            $jawabanC = $_POST['jawaban_C' . $no]; 
            $jawabanD = $_POST['jawaban_D' . $no]; 

            mysqli_query($conn, "INSERT INTO tbl_jawaban VALUES('', '$idSoal', '$jawabanA', 'A')");
            mysqli_query($conn, "INSERT INTO tbl_jawaban VALUES('', '$idSoal', '$jawabanB', 'B')");
            mysqli_query($conn, "INSERT INTO tbl_jawaban VALUES('', '$idSoal', '$jawabanC', 'C')");
            mysqli_query($conn, "INSERT INTO tbl_jawaban VALUES('', '$idSoal', '$jawabanD', 'D')");

            $no++;


        }

        if( $qIdSoal ) {

            echo "
            
                <script>
                    alert('Berhasil membuat soal');
                    document.location.href = 'home.php?kelas=$kelas2';
                </script>
            
            ";

        } else {

            echo "
            
                <script>
                    alert('GAGAL membuat soal');
                    document.location.href = 'home.php?kelas=$kelas2';
                </script>
        
             ";

        }

        
       
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
    <link rel="stylesheet" href="../assets/css/home2.css">
    <link rel="stylesheet" href="../assets/css/detail2.css">
    <link rel="stylesheet" href="../assets/css/soal2.css">
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
        <div class="row px-3">
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
                        <a class="dropdown-item" href="home.php?kelas=<?= $k ?>"><?= $k ?></a>
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
                        <a class="dropdown-item" href="home.php?kelas=<?= $k ?>"><?= $k ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card2 card3">
                    <div class="detail">
                        <h2 class="text-center mt-3">Buat Soal</h2>
                    </div>
                    <form action="" method="POST">
                        <?php $i = 1; ?>
                        <?php while( $i <= $row['jumlah_soal'] ) : ?>
                        <div class="soal mt-5 ml-4">
                            <div class="detail-soal d-flex" style="width: 100% !important;">
                                <h6 class="no"><?= $i ?>.</h6>
                                <div class="form-group ml-3" style="width: 50%;">
                                    <textarea name="soal<?= $i; ?>" class="form-control input2"
                                        id="exampleFormControlTextarea1" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="jawaban ml-3">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="pg<?= $i; ?>" id="pg1" value="A"
                                        required>
                                    <label class="form-check-label d-flex" for="pg1">
                                        <div class="desk">A. </div>
                                        <div class="form-group ml-2 form4">
                                            <input type="text" class="form-control input2" id="exampleFormControlInput1"
                                                placeholder="Masukkan jawaban" required name="jawaban_A<?= $i; ?>">
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="pg<?= $i; ?>" id="pg1" value="B"
                                        required>
                                    <label class="form-check-label d-flex" for="pg1">
                                        <div class="desk">B. </div>
                                        <div class="form-group ml-2 form4">
                                            <input type="text" class="form-control input2" id="exampleFormControlInput1"
                                                placeholder="Masukkan jawaban" required name="jawaban_B<?= $i; ?>">
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="pg<?= $i; ?>" id="pg1" value="C"
                                        required>
                                    <label class="form-check-label d-flex" for="pg1">
                                        <div class="desk">C. </div>
                                        <div class="form-group ml-2 form4">
                                            <input type="text" class="form-control input2" id="exampleFormControlInput1"
                                                placeholder="Masukkan jawaban" required name="jawaban_C<?= $i; ?>">
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="pg<?= $i; ?>" id="pg1" value="D"
                                        required>
                                    <label class="form-check-label d-flex" for="pg1">
                                        <div class="desk">D. </div>
                                        <div class="form-group ml-2 form4">
                                            <input type="text" class="form-control input2" id="exampleFormControlInput1"
                                                placeholder="Masukkan jawaban" required name="jawaban_D<?= $i; ?>">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php $i++; ?>
                        <?php endwhile; ?>
                        <button type="submit" class="btn btn-kerjakan w-100 mt-5" name="buat">Buat Soal</button>
                    </form>
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