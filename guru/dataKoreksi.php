<?php 

    session_start();
    include '../koneksi.php';

    if( !isset($_SESSION['login']) ) {

        header('location: ../login.php');
        exit;

    }

    function query($query) {

        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while( $row = mysqli_fetch_assoc($result) ) {
 
         $rows[] = $row;
 
        }
 
        return $rows;
 
     }

    date_default_timezone_set('Asia/Jakarta');
    $idUser2 = $_SESSION['idUser'];
    $idTugas = $_GET['idTugas'];

    $imgP = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user = '$idUser2'")->fetch_assoc();

    $ambilKelas = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user ='$idUser2'");

    $ambil = mysqli_fetch_assoc($ambilKelas);
    $kelas22 = $ambil['kelas'];
    $kelas3 = explode(',', $kelas22);

    $idUser = $_SESSION['idUser'];

    $kelas2 = $_GET['kelas'];

    $batas = 5;
    $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;

    $previous = $halaman - 1;
    $next = $halaman + 1;

    $jumlah_data = count(query("SELECT * FROM detail_tgs_essay INNER JOIN tbl_siswa ON detail_tgs_essay.id_siswa = tbl_siswa.id_user INNER JOIN tbl_tugas ON detail_tgs_essay.id_tugas = tbl_tugas.id_tugas"));
    $total_halaman = ceil($jumlah_data / $batas);

    $nomor = $halaman_awal+1;

    $queryData = mysqli_query($conn, "SELECT * FROM detail_tgs_essay INNER JOIN tbl_siswa ON detail_tgs_essay.id_siswa = tbl_siswa.id_user INNER JOIN tbl_tugas ON detail_tgs_essay.id_tugas = tbl_tugas.id_tugas INNER JOIN tbl_nilai ON tbl_nilai.id_tugas = detail_tgs_essay.id_tugas WHERE detail_tgs_essay.status = 'Belum di koreksi' ORDER BY detail_tgs_essay.id_detail_essay DESC LIMIT $halaman_awal, $batas");



    

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
    <link rel="stylesheet" href="../assets/css/nilai.css">
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
                <div class="card card2">
                    <div class="aksi detail d-flex align-items-center mb-4">
                        <a href="detail.php?kelas=<?= $_GET['kelas'] ?>&idTugas=<?= $idTugas ?>">
                            <div class="bulat">
                                <i class="fas fa-arrow-left"></i>
                            </div>
                        </a>
                        <h3 class="ml-4 tN" style="margin-bottom: 0;">Koreksi Essay</h3>
                    </div>
                    <div class="over">
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Mapel</th>
                                    <th scope="col">Materi</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Jam</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php if( mysqli_num_rows($queryData) == 0 ) : ?>
                                <tr>
                                    <td class="text-center" colspan="7">Data kosong</td>
                                </tr>
                                <?php endif; ?>
                                <?php while( $d = mysqli_fetch_assoc($queryData) ) : ?>
                                <tr>
                                    <th scope="row"><?= $nomor++ ?></th>
                                    <td><?= $d['nama'] ?></td>
                                    <td><?= $d['kelas'] ?></td>
                                    <td><?= $d['mapel'] ?></td>
                                    <td><?= $d['materi'] ?></td>
                                    <td><?= $d['tgl_kerjakan'] ?></td>
                                    <td><?= $d['jam'] ?></td>
                                    <td><a href="koreksiEssay.php?id=<?= $d['id_detail_essay'] ?>&idSiswa=<?= $d['id_user'] ?>&kelas=<?= $d['kelas'] ?>&idTugas=<?= $idTugas ?>"
                                            class="btn btn-success">Koreksi</a></td>
                                    <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <nav class="ml-auto mt-2">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link previous"
                                    <?php if($halaman > 1){ echo "href='?halaman=$previous&kelas=$kelas2'"; } ?>>Previous</a>
                            </li>
                            <?php 
                                    for($x=1;$x<=$total_halaman;$x++){
                                ?>
                            <li class="page-item <?= ($halaman == $x) ? 'active' : '' ?>"><a class="page-link"
                                    href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                            <?php
                                    }
                                ?>
                            <li class="page-item">
                                <a class="page-link"
                                    <?php if($halaman < $total_halaman) { echo "href='?halaman=$next&kelas=$kelas2'"; } ?>>Next</a>
                            </li>
                        </ul>
                    </nav>
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