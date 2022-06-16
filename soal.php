<?php 

    session_start();
    include 'koneksi.php';

    date_default_timezone_set('Asia/Jakarta');

    if( !isset($_SESSION['login']) ) {

        header('location: login.php');
        exit;

    }

    $idTugas = $_GET['idTugas'];

    //set session dulu dengan nama $_SESSION["mulai"]
    if (isset($_SESSION["mulai"])) { 
        //jika session sudah ada
        $telah_berlalu = time() - $_SESSION["mulai"];
    } else { 
        //jika session belum ada
        $_SESSION["mulai"]  = time();
        $telah_berlalu      = 0;
    } 

    $countdown = mysqli_query($conn, "SELECT * FROM tbl_tugas WHERE id_tugas = '$idTugas'")->fetch_assoc();

    $temp_waktu = ($countdown['countdown']*60) - $telah_berlalu; //dijadikan detik dan dikurangi waktu yang berlalu
    $temp_menit = (int)($temp_waktu/60);                //dijadikan menit lagi
    $temp_detik = $temp_waktu%60;                       //sisa bagi untuk detik
     
    if ($temp_menit < 60) { 
        /* Apabila $temp_menit yang kurang dari 60 meni */
        $jam    = 0; 
        $menit  = $temp_menit; 
        $detik  = $temp_detik; 
    } else { 
        /* Apabila $temp_menit lebih dari 60 menit */           
        $jam    = (int)($temp_menit/60);    //$temp_menit dijadikan jam dengan dibagi 60 dan dibulatkan menjadi integer 
        $menit  = $temp_menit%60;           //$temp_menit diambil sisa bagi ($temp_menit%60) untuk menjadi menit
        $detik  = $temp_detik;
    }  



    
    $idUser = $_SESSION['idUser'];

    $imgP = mysqli_query($conn, "SELECT * FROM tbl_siswa WHERE id_user = '$idUser'")->fetch_assoc();

    $queryDetail = mysqli_query($conn, "SELECT * FROM tbl_tugas WHERE id_tugas = '$idTugas'");
    $row = mysqli_fetch_assoc($queryDetail);

    $qSoal = mysqli_query($conn, "SELECT * FROM tbl_soal WHERE id_tugas = '$idTugas'");

    $jumlahSoal = mysqli_num_rows($qSoal);

    if( isset($_POST['selesai']) ) {

        $nomor = 1;
        $benar = 1;
        while( $nomor <= $jumlahSoal ) {
            
            $jawaban = $_POST['jawaban' . $nomor];
            
            $cekJwbn = mysqli_query($conn, "SELECT jawaban_benar FROM tbl_soal WHERE id_tugas = '$idTugas' AND no = '$nomor'");

            $jwbnBenar = mysqli_fetch_assoc($cekJwbn);

            if( $jawaban == $jwbnBenar['jawaban_benar'] ) {

                $jwbnBenar2 = 0 + $benar;
                $benar++;
                
                
            }

            $nomor++;

        }

        if( !isset($jwbnBenar2) ) {

            $jwbnBenar2 = 0;

        }

        $jwbnSalah = $jumlahSoal - $jwbnBenar2;

        $nilai = $jwbnBenar2 * 100 / $jumlahSoal;

        $date = date('d/m/Y');
        $jam = date('H:i');

        $queryInsert = mysqli_query($conn, "INSERT INTO tbl_nilai VALUES('', '$idUser', '$idTugas', '$jumlahSoal', '$jwbnSalah', '$jwbnBenar2', '$nilai', '$date', '$jam')");

        $cekPoin = mysqli_query($conn, "SELECT * FROM leaderboard WHERE id_user = '$idUser'");

        if( mysqli_num_rows($cekPoin) == 1 ) {
            
            $poin = mysqli_fetch_assoc($cekPoin);
            $idLeaderboard = $poin['id_leaderboard'];
            $poinBaru = $nilai + $poin['poin'];

            $queryPoin = mysqli_query($conn, "UPDATE leaderboard SET poin = '$poinBaru' WHERE id_leaderboard = '$idLeaderboard'");


        } elseif( mysqli_num_rows($cekPoin) == 0 ) {

            $queryPoin = mysqli_query($conn, "INSERT INTO leaderboard VALUES('', '$idUser', '$nilai')");

        }

        if( $queryInsert ) {

            echo "
            
                <script>
                    alert('Berhasil Menegerjakan Tugas');
                    document.location.href = 'nilai.php';
                </script>

            ";

        } else {

            echo "
            
            <script>
                alert('GAGAL Menegerjakan Tugas');
                document.location.href = 'home.php';
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
    <link rel="stylesheet" href="assets/css/home2.css">
    <link rel="stylesheet" href="assets/css/detail2.css">
    <link rel="stylesheet" href="assets/css/soal2.css">

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
                            <img src="assets/img_profile/<?= $imgP['img'] ?>" class="rounded-circle"
                                style="width: 45px; height: 45px;">
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
                <div class="card card2 card3">
                    <div class="card4">
                        <div class="detail d-flex w-100 align-items-center">
                            <a href="detail.php?idTugas=<?= $idTugas ?>">
                                <div class="bulat">
                                    <i class="fas fa-arrow-left"></i>
                                </div>
                            </a>
                            <h2 class="text-center mx-auto tT">Selamat Mengerjakan</h2>
                            <div class="badge mr-4 py-3 px-4"
                                style="border-radius: 12px; font-size: 16px; color: #353840; background: rgb(248 180 37 / 60%)"
                                id="timer">00:01:00</div>
                        </div>
                        <form action="" method="POST" id="frmsoal">
                            <form action="" method="POST">
                                <?php $no = 1; ?>
                                <?php $no2 = 1; ?>
                                <?php while( $soal = mysqli_fetch_assoc($qSoal) ) : ?>
                                <div class="soal mt-5 ml-4">
                                    <div class="detail-soal d-flex">
                                        <h6 class="no"><?= $no++; ?>.</h6>
                                        <h6 class="ml-2"><?= $soal['soal'] ?></h6>
                                    </div>
                                    <?php 
                        
                            $idSoal = $soal['id_soal'];
                            $qJwbn = mysqli_query($conn, "SELECT * FROM tbl_jawaban WHERE id_soal = '$idSoal'");
                            
                            ?>
                                    <?php 
                            
                            $no1 = 0 + $no2++;
    
                            
                        ?>
                                    <?php while($jwbn = mysqli_fetch_assoc($qJwbn)) : ?>
                                    <div class="jawaban ml-3">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="jawaban<?= $no1; ?>"
                                                id="exampleRadios1" value="<?= $jwbn['pg'] ?>" required>
                                            <label class="form-check-label" for="exampleRadios1">
                                                <div class="desk"><?= $jwbn['pg'] ?>. <?= $jwbn['desk'] ?></div>
                                            </label>
                                        </div>
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                                <?php endwhile; ?>
                                <button type="submit" class="btn btn-kerjakan" name="selesai" id="selesai">Kirim
                                    Jawaban</button>
                            </form>
                        </form>
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

    <!-- Script Timer -->
    <script type="text/javascript">
        $(document).ready(function () {
            /** Membuat Waktu Mulai Hitung Mundur Dengan 
             * var detik;
             * var menit;
             * var jam;
             */
            var detik = <?= $detik; ?>;
            var menit = <?= $menit; ?>;
            var jam = <?= $jam; ?>;

            /**
             * Membuat function hitung() sebagai Penghitungan Waktu
             */
            function hitung() {
                /** setTimout(hitung, 1000) digunakan untuk 
                 * mengulang atau merefresh halaman selama 1000 (1 detik) 
                 */
                setTimeout(hitung, 1000);

                /** Jika waktu kurang dari 10 menit maka Timer akan berubah menjadi warna merah */
                // if (menit < 10 && jam == 0) {
                //     var peringatan = 'style="color:red"';
                // };

                /** Menampilkan Waktu Timer pada Tag #Timer di HTML yang tersedia */

                if (jam == 0 && menit < 10 && detik > 10) {

                    $('#timer').html(
                        // '<h1 align="center"' + peringatan + '>Sisa waktu anda <br />' + jam + ' jam : ' +
                        // menit + ' menit : ' + detik + ' detik</h1><hr>'
                        '0' + jam + ':' + '0' + menit + ':' + detik

                    );

                } else if (jam > 0 && menit > 10 && detik > 10) {

                    $('#timer').html(
                        // '<h1 align="center"' + peringatan + '>Sisa waktu anda <br />' + jam + ' jam : ' +
                        // menit + ' menit : ' + detik + ' detik</h1><hr>'
                        '0' + jam + ':' + menit + ':' + detik
                    );

                } else if (jam > 0 && menit > 10 && detik < 10) {

                    $('#timer').html(
                        // '<h1 align="center"' + peringatan + '>Sisa waktu anda <br />' + jam + ' jam : ' +
                        // menit + ' menit : ' + detik + ' detik</h1><hr>'
                        '0' + jam + ':' + menit + ':' + detik
                    );

                } else if (jam > 0 && menit < 10 && detik > 10) {

                    $('#timer').html(
                        // '<h1 align="center"' + peringatan + '>Sisa waktu anda <br />' + jam + ' jam : ' +
                        // menit + ' menit : ' + detik + ' detik</h1><hr>'
                        '0' + jam + ':' + '0' + menit + ':' + detik
                    );

                } else if (jam > 0 && menit < 10 && detik < 10) {

                    $('#timer').html(
                        // '<h1 align="center"' + peringatan + '>Sisa waktu anda <br />' + jam + ' jam : ' +
                        // menit + ' menit : ' + detik + ' detik</h1><hr>'
                        '0' + jam + ':' + '0' + menit + ':' + '0' + detik
                    );

                } else if (jam == 0 && menit >= 10 && detik >= 10) {

                    $('#timer').html(
                        // '<h1 align="center"' + peringatan + '>Sisa waktu anda <br />' + jam + ' jam : ' +
                        // menit + ' menit : ' + detik + ' detik</h1><hr>'
                        '0' + jam + ':' + menit + ':' + detik

                    );

                } else if (jam > 0 && detik < 10) {

                    $('#timer').html(
                        // '<h1 align="center"' + peringatan + '>Sisa waktu anda <br />' + jam + ' jam : ' +
                        // menit + ' menit : ' + detik + ' detik</h1><hr>'
                        '0' + jam + ':' + menit + ':' + '0' + detik
                    );

                } else if (jam > 0 && menit < 10 && detik < 10) {

                    $('#timer').html(
                        // '<h1 align="center"' + peringatan + '>Sisa waktu anda <br />' + jam + ' jam : ' +
                        // menit + ' menit : ' + detik + ' detik</h1><hr>'
                        '0' + jam + ':' + '0' + menit + ':' + '0' + detik
                    );

                } else if (jam == 0 && menit < 10 && detik < 10) {

                    $('#timer').html(
                        // '<h1 align="center"' + peringatan + '>Sisa waktu anda <br />' + jam + ' jam : ' +
                        // menit + ' menit : ' + detik + ' detik</h1><hr>'
                        '0' + jam + ':' + '0' + menit + ':' + '0' + detik
                    );

                } else if (menit == 10) {

                    $('#timer').html(
                        // '<h1 align="center"' + peringatan + '>Sisa waktu anda <br />' + jam + ' jam : ' +
                        // menit + ' menit : ' + detik + ' detik</h1><hr>'
                        '0' + jam + ':' + menit + ':' + detik

                    );

                } else if (jam == 0 && detik < 10) {

                    $('#timer').html(
                        // '<h1 align="center"' + peringatan + '>Sisa waktu anda <br />' + jam + ' jam : ' +
                        // menit + ' menit : ' + detik + ' detik</h1><hr>'
                        '0' + jam + ':' + menit + ':' + '0' + detik
                    );

                }


                /** Melakukan Hitung Mundur dengan Mengurangi variabel detik - 1 */
                detik--;

                /** Jika var detik < 0
                 * var detik akan dikembalikan ke 59
                 * Menit akan Berkurang 1
                 */
                if (detik < 0) {
                    detik = 59;
                    menit--;

                    /** Jika menit < 0
                     * Maka menit akan dikembali ke 59
                     * Jam akan Berkurang 1
                     */
                    if (menit < 0) {
                        menit = 59;
                        jam--;

                        /** Jika var jam < 0
                         * clearInterval() Memberhentikan Interval dan submit secara otomatis
                         */

                        if (jam < 0) {
                            clearInterval(hitung);
                            /** Variable yang digunakan untuk submit secara otomatis di Form */
                            var frmSoal = document.getElementById("selesai");
                            alert('Waktu Anda telah habis');
                            frmSoal.click();
                        }
                    }
                }
            }
            /** Menjalankan Function Hitung Waktu Mundur */
            hitung();
        });
    </script>

</body>

</html>