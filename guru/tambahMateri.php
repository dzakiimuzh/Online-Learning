<?php 

    session_start();
    include '../koneksi.php';

    date_default_timezone_set('Asia/Jakarta');

    if( !isset($_SESSION['login']) ) {

        header('location: ../login.php');
        exit;

    }

    $idUser2 = $_SESSION['idUser'];

    $imgP = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user = '$idUser2'")->fetch_assoc();
            
    $ambilKelas = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user ='$idUser2'");

    $ambil = mysqli_fetch_assoc($ambilKelas);
    $kelas22 = $ambil['kelas'];
    $kelas3 = explode(',', $kelas22);

    $kelas2 = $_GET['kelas'];
    $idUser2 = $_SESSION['idUser'];
    $nama2 = $_SESSION['name'];

    $queryUser2 = mysqli_query($conn, "SELECT * FROM tbl_guru WHERE id_user = '$idUser2'");
    $rowUser2 = mysqli_fetch_assoc($queryUser2);

    $mapel2 = $rowUser2['mapel'];

    if( isset($_POST['buat']) ) {

        $materi = $_POST['materi'];
        $desk = $_POST['desk'];
        $tgl = date('d M Y');

        $file = upload();

        if( !$file ) {

            return false;

        }

        $queryUpload = mysqli_query($conn, "INSERT INTO tbl_materi VALUES('', '$idUser2', '$nama2', '$mapel2', '$materi', '$desk', '$kelas2', '$file', '$tgl', 'belum')");

        if( $queryUpload ) {

            echo "
            
                <script>
                    alert('Berhasil Upload Materi');
                    document.location.href = 'home.php?kelas=$kelas2';
                </script>
            
            ";

        } else {

            echo "
            
                <script>
                    alert('GAGAL Upload Materi');
                    document.location.href = 'home.php?kelas=$kelas2';
                </script>
            
            ";

        }

    }

    function upload() {

        $namaFile = $_FILES['file']['name'];
        $ukuranFile = $_FILES['file']['size'];
        $error = $_FILES['file']['error'];
        $tmpName = $_FILES['file']['tmp_name'];

        if( $error == 4 ) {

            echo "
            
                <script>
                    alert('Pilih fiel terlebih dahulu');
                </script>
            
            ";

            return false;

        }

        $ekstensiFileValid = ['pdf', 'docx'];
        $ekstensiFile = explode('.', $namaFile);
        $ekstensiFile = strtolower(end($ekstensiFile));

        if( !in_array($ekstensiFile, $ekstensiFileValid) ) {

            echo "
            
                <script>
                    alert('Yang anda upload tidak sesuai');
                </script>
            
            ";

            return false;

        }

        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiFile;

        move_uploaded_file($tmpName, '../assets/materi/' . $namaFileBaru);

        return $namaFileBaru;

    }

    

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- My CSS -->
    <link rel="stylesheet" href="../assets/css/home2.css">
    <link rel="stylesheet" href="../assets/css/detail2.css">

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
                <div class="card card2 w-100 mx-auto py-4">
                    <div class="detail mb-4 mt-n2 d-flex align-items-center">
                        <a href="home.php?kelas=<?= $kelas2 ?>">
                            <div class="bulat">
                                <i class="fas fa-arrow-left"></i>
                            </div>
                        </a>
                        <h2 class="ml-4 tT">Tambah materi</h2>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Materi</label>
                            <input type="text" class="form-control input2" id="exampleFormControlInput1"
                                placeholder="Masukan materi" name="materi">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Deskripsi</label>
                            <textarea class="form-control input2" id="exampleFormControlTextarea1" rows="3"
                                name="desk"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">File</label>
                            <input type="file" class="form-control file2" id="exampleFormControlInput1"
                                placeholder="Masukan materi" name="file">
                        </div>
                        <button type="submit" class="btn w-100 mt-4 text-white btn-buat" name="buat">Buat
                            Materi</button>

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