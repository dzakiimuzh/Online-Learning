<?php 

    session_start();
    include '../koneksi.php';

    date_default_timezone_set('Asia/Jakarta');

    if( !isset($_SESSION['login']) ) {

        header('location: login.php');
        exit;

    }

    $id = $_GET['id'];
    $idUser2 = $_SESSION['idUser'];
    $imgP = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user = '$idUser2'")->fetch_assoc();
    $idSiswa = $_GET['idSiswa'];
    $kelas = $_GET['kelas'];
    $idTugas3 = $_GET['idTugas'];

    $ambilKelas = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user ='$idUser2'");

    $ambil = mysqli_fetch_assoc($ambilKelas);
    $kelas22 = $ambil['kelas'];
    $kelas3 = explode(',', $kelas22);

    $queryDetail = mysqli_query($conn, "SELECT * FROM tbl_tugas WHERE id_tugas = '$id'");
    $row = mysqli_fetch_assoc($queryDetail);

    $qSoal = mysqli_query($conn, "SELECT * FROM detail_tgs_essay INNER JOIN tbl_soal_essay ON detail_tgs_essay.id_tugas = tbl_soal_essay.id_tugas WHERE tbl_soal_essay.id_tugas = '$idTugas3' AND detail_tgs_essay.id_siswa = '$idSiswa'");

    $idTugas = mysqli_query($conn, "SELECT * FROM detail_tgs_essay INNER JOIN tbl_soal_essay ON detail_tgs_essay.id_tugas = tbl_soal_essay.id_tugas INNER JOIN tbl_jawaban_essay ON tbl_soal_essay.id_essay = tbl_jawaban_essay.id_essay")->fetch_assoc();

    $idTugas2 = $idTugas['id_tugas'];

    $jumlahSoal = mysqli_num_rows($qSoal);
    

    if( isset($_POST['selesai']) ) {

        $nomor = 1;
        $bobot = 0;

        
        while( $nomor <= $jumlahSoal ) {

            if( isset($_POST['benar' . $nomor]) ) {

                $benar = count($_POST['benar' . $nomor]);
                
            }
            if( !isset($_POST['bobot' . $nomor]) && !isset($_POST['benar' . $nomor]) ) {

                $bobot += 0;

            }
            if( isset($_POST['bobot' . $nomor]) && !isset($_POST['benar' . $nomor]) ) {
                
                // $benar = 0;
                $maxBobot = 100 / $jumlahSoal;

                if( $_POST['bobot' . $nomor] <= $maxBobot ) {

                    $bobot += intval($_POST['bobot' . $nomor]);

                } else {

                    echo "
                        <script>
                            alert('Bobot nilai melebihi batas');
                            document.location.href = 'koreksiEssay.php?id=$id&idSiswa=$idSiswa&kelas=$kelas&idTugas=$idTugas3';
                        </script>
                    ";
                    return false;

                }

            }
            
            $nomor++;
            
        }

        
        $salah = $jumlahSoal - $benar;
        $nilai = $benar * 100 / $jumlahSoal;
        $nilai += $bobot;

        $queryNilai = mysqli_query($conn, "UPDATE tbl_nilai SET salah = '$salah', benar = '$benar', nilai = '$nilai' WHERE id_tugas = '$idTugas3' AND id_user = '$idSiswa'");

        $queryStatus = mysqli_query($conn, "UPDATE detail_tgs_essay SET status = 'Sudah di koreksi' WHERE id_siswa = '$idSiswa'");

        if( $queryStatus ) {

            echo "
            
                <script>
                    alert('Berhasil Koreksi Tugas');
                    document.location.href = 'dataKoreksi.php?idTugas=$idTugas3&kelas=$kelas';
                </script>

            ";

        } else {

            echo "
            
            <script>
                alert('GAGAL Koreksi Tugas');
                document.location.href = 'koreksiEssay.php?id=$id&idSiswa=$idSiswa&kelas=$kelas';
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
                            <label><?= $_SESSION['mapel'] ?></label>
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
                <div class="card card2 card3">
                    <div class="detail d-flex w-100 align-items-center">
                        <a href="dataKoreksi.php?idTugas=<?= $idTugas3 ?>&kelas=<?= $kelas ?>">
                            <div class="bulat">
                                <i class="fas fa-arrow-left"></i>
                            </div>
                        </a>
                        <h2 class="text-center mx-auto tT">Koreksi essay</h2>
                    </div>
                    <form action="" method="POST">
                        <form action="" method="POST">
                            <?php $no = 1; ?>
                            <?php $no2 = 1; ?>
                            <?php $max = 100 / $jumlahSoal ?>
                            <?php while( $no <= $jumlahSoal ) : ?>
                            <?php
                                
                                $qSoal2 = mysqli_query($conn, "SELECT * FROM detail_tgs_essay INNER JOIN tbl_soal_essay ON detail_tgs_essay.id_tugas = tbl_soal_essay.id_tugas INNER JOIN tbl_jawaban_essay ON tbl_soal_essay.id_essay = tbl_jawaban_essay.id_essay WHERE tbl_jawaban_essay.id_siswa = '$idSiswa' AND tbl_soal_essay.no = '$no' AND tbl_soal_essay.id_tugas = '$idTugas3'");

                                $soal = mysqli_fetch_assoc($qSoal2); 
                                  
                            ?>
                            <div class="soal mt-5 ml-4">
                                <div class="detail-soal d-flex">
                                    <h6 class="no"><?= $no++; ?>.</h6>
                                    <h6 class="ml-2"><?= $soal['soal'] ?></h6>
                                </div>
                                <div class="jawaban ml-3 d-flex align-items-center flex-wrap">
                                    <div class="form-group ml-3" style="width: 50%;">
                                        <textarea name="jawaban<?= $no2; ?>" class="form-control input2" readonly
                                            id="exampleFormControlTextarea1" rows="3"
                                            required><?= $soal['jawaban'] ?></textarea>
                                    </div>
                                    <div class="form-check ml-4">
                                        <input class="form-check-input" type="checkbox" name="benar<?= $no2 ?>[]"
                                            value="Benar" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1">
                                            Benar
                                        </label>
                                    </div>
                                    <div class="form-group ml-3 mb-0">
                                        <input type="number" class="form-control input2" id="exampleFormControlInput1"
                                            placeholder="Masukan bobot nilai" name="bobot<?= $no2 ?>">
                                        <p class="mb-0 mt-2" style="font-size: 14px; color: #484848;">max(<?= $max ?>)
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php $no2++; ?>
                            <?php endwhile; ?>
                            <button type="submit" class="btn btn-kerjakan w-100" style="margin-top: 40px;"
                                name="selesai">Selesai</button>
                        </form>
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