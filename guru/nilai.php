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

    $jumlah_data = count(query("SELECT * FROM tbl_nilai INNER JOIN tbl_siswa ON tbl_siswa.id_user = tbl_nilai.id_user INNER JOIN kelas ON tbl_siswa.id_kelas = kelas.id_kelas INNER JOIN tbl_tugas ON tbl_nilai.id_tugas = tbl_tugas.id_tugas WHERE kelas.kelas = '$kelas2'"));
    $total_halaman = ceil($jumlah_data / $batas);

    $nomor = $halaman_awal+1;

    $queryNilai = mysqli_query($conn, "SELECT * FROM tbl_nilai INNER JOIN tbl_siswa ON tbl_siswa.id_user = tbl_nilai.id_user INNER JOIN kelas ON tbl_siswa.id_kelas = kelas.id_kelas INNER JOIN tbl_tugas ON tbl_nilai.id_tugas = tbl_tugas.id_tugas WHERE kelas.kelas = '$kelas2' ORDER BY tbl_nilai.id_nilai DESC LIMIT $halaman_awal, $batas");

    if( isset($_POST['cari']) ) {

        $keyword = $_POST['keyword'];

        $jumlah_data = count(query("SELECT * FROM tbl_nilai INNER JOIN tbl_siswa ON tbl_siswa.id_user = tbl_nilai.id_user INNER JOIN kelas ON tbl_siswa.id_kelas = kelas.id_kelas INNER JOIN tbl_tugas ON tbl_nilai.id_tugas = tbl_tugas.id_tugas WHERE tbl_siswa.nama LIKE '%$keyword%' AND kelas.kelas = '$kelas2' OR tbl_tugas.mapel LIKE '%$keyword%' AND kelas.kelas = '$kelas2' OR tbl_tugas.materi LIKE '%$keyword%' AND kelas.kelas = '$kelas2' OR tbl_nilai.tgl_pengerjaan LIKE '%$keyword%' AND kelas.kelas = '$kelas2'"));
        
        $total_halaman = ceil($jumlah_data / $batas);

        $queryNilai = mysqli_query($conn, "SELECT * FROM tbl_nilai INNER JOIN tbl_siswa ON tbl_siswa.id_user = tbl_nilai.id_user INNER JOIN kelas ON tbl_siswa.id_kelas = kelas.id_kelas INNER JOIN tbl_tugas ON tbl_nilai.id_tugas = tbl_tugas.id_tugas WHERE tbl_siswa.nama LIKE '%$keyword%' AND kelas.kelas = '$kelas2' OR tbl_tugas.mapel LIKE '%$keyword%' AND kelas.kelas = '$kelas2' OR tbl_tugas.materi LIKE '%$keyword%' AND kelas.kelas = '$kelas2' OR tbl_nilai.tgl_pengerjaan LIKE '%$keyword%' AND kelas.kelas = '$kelas2' ORDER BY tbl_nilai.id_nilai DESC LIMIT $halaman_awal, $batas");

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
    <link rel="stylesheet" href="../assets/css/nilai.css">
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
                            <a class="dropdown-item" href="ubahData.php">Ubah data</a>
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
                        <button class="btn btn-nav dropdown-toggle" type="button" id="dropdownMenuButton"
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
                        <button class="btn btn-nav active dropdown-toggle" type="button" id="dropdownMenuButton"
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
                    <div class="aksi mb-4 d-flex justify-content-between align-items-center">
                        <h3 class="tN">Nilai siswa <?= $kelas2 ?></h3>
                        <form action="" method="POST">
                            <div class="input-group">
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
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Mapel</th>
                                    <th scope="col">Materi</th>
                                    <th scope="col">Soal</th>
                                    <th scope="col">Salah</th>
                                    <th scope="col">Nilai</th>
                                    <th scope="col">Dikerjakan pada</th>
                                    <th scope="col">Jam</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php if( mysqli_num_rows($queryNilai) == 0 ) : ?>
                                <tr>
                                    <td colspan="8" class="text-center">Data kosong</td>
                                </tr>
                                <?php endif; ?>
                                <?php while( $n = mysqli_fetch_assoc($queryNilai) ) : ?>
                                <tr>
                                    <th scope="row"><?= $nomor++; ?></th>
                                    <td><?= $n['nama'] ?></td>
                                    <td><?= $n['mapel'] ?></td>
                                    <td><?= $n['materi'] ?></td>
                                    <td><?= $n['soal'] ?></td>
                                    <td><?= $n['salah'] ?></td>
                                    <td><?= $n['nilai'] ?></td>
                                    <td><?= $n['tgl_pengerjaan'] ?></td>
                                    <td><?= $n['jam'] ?></td>
                                </tr>
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