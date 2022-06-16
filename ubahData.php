<?php 

    session_start();
    include 'koneksi.php';

    if( !isset($_SESSION['login']) ) {

        header('location: login.php');
        exit;

    }

    function upload() {

        $namaFile = $_FILES['img']['name'];
        $ukuranFile = $_FILES['img']['size'];
        $error = $_FILES['img']['error'];
        $tmpName = $_FILES['img']['tmp_name'];

        if( $error == 4 ) {

            echo "
            
                <script>
                    alert('Pilih gambar terlebih dahulu');
                </script>
            
            ";

            return false;

        }

        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));

        if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {

            echo "
            
                <script>
                    alert('Yang anda upload bukan gambar');
                </script>
            
            ";

            return false;

        }

        if( $ukuranFile > 10000000 ) {

            echo "
            
                <script>
                    alert('Ukuran gambar terlalu besar');
                </script>
            
            ";

            return false;

        }

        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        move_uploaded_file($tmpName, 'assets/img_profile/' . $namaFileBaru);

        return $namaFileBaru;

    }

    $id = $_SESSION['idUser'];

    $imgP = mysqli_query($conn, "SELECT * FROM tbl_siswa WHERE id_user = '$id'")->fetch_assoc();

    $data = mysqli_query($conn, "SELECT * FROM tbl_siswa INNER JOIN users ON tbl_siswa.id_user = users.id_user WHERE tbl_siswa.id_user = '$id'")->fetch_assoc();

    if( isset($_POST['ubah']) ) {

        $username = $_POST['username'];
        $pw = $_POST['pw'];

        $cek = mysqli_query($conn, "SELECT password FROM users WHERE password = '$pw' AND role = 'siswa'");

        if( mysqli_num_rows($cek) == 0 ) {

            $pw = password_hash($pw, PASSWORD_DEFAULT);
            
        }

        $imgLama = $_POST['imgLama'];

        if( $_FILES['img']['error'] == 4 ) {

            $img = $imgLama;

        } else {

            $img = upload();
            
            if( !$imgLama = 'profile.svg' ) {

                unlink('assets/img_profile/' . $imgLama);

            }

        }

        $query = mysqli_query($conn, "UPDATE tbl_siswa SET img = '$img' WHERE id_user = '$id'");
        $query2 = mysqli_query($conn, "UPDATE users SET username = '$username', password = '$pw' WHERE id_user = '$id'");


        if( $query2 ) {

            echo "
            
                <script>
                    alert('Ubah data profile');
                    document.location.href = 'home.php';
                </script>

            ";

        } else {

            echo "
            
                <script>
                    alert('Ubah data profile gagal');
                    document.location.href = 'ubahData.php';
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
    <link rel="stylesheet" href="assets/css/nilai.css">
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
                    <a href="home.php" class="btn btn-nav"><i class="fas fa-book-open mr-2"></i>Pelajaran </a>
                    <a href="#" class="btn btn-nav"><i class="fas fa-file-signature mr-2"></i>Nilai Saya</a>
                    <a href="absen.php" class="btn btn-nav"><i class="far fa-clipboard mr-2"></i>Absen Saya</a>
                    <!-- <a href="leaderboard.php" class="btn btn-nav"><i class="fas fa-medal mr-2"></i>Leaderboard</a> -->
                    <a href="dataGuru.php" class="btn btn-nav"><i class="fas fa-user-tie mr-2"></i>Data Guru</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card2">
                    <div class="detail d-flex align-items-center">
                        <a href="home.php">
                            <div class="bulat">
                                <i class="fas fa-arrow-left"></i>
                            </div>
                        </a>
                        <h2 class="ml-4 tT">Ubah profile</h2>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="imgLama" value="<?= $data['img'] ?>">
                        <img id="preview" src="assets/img_profile/<?= $data['img']; ?>" width="90"
                            class="mx-auto d-block rounded-circle" style="height: 90px;">
                        <div class="form-group">
                            <label for="filename">Gambar profile</label>
                            <input type="file" class="form-control file2" id="file" placeholder="Masukkan gambar anda"
                                name="img" onchange="previewImage()">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Username</label>
                            <input type="text" class="form-control input2" id="exampleFormControlInput1"
                                placeholder="Masukkan username anda" name="username" value="<?= $data['username'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Password</label>
                            <input type="password" class="form-control input2" id="exampleFormControlInput1"
                                placeholder="Masukkan password anda" name="pw" value="<?= $data['password'] ?>">
                        </div>
                        <button type="submit" class="btn w-100 mt-4 text-white btn-buat" name="ubah">Ubah
                            profile</button>
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

    <script>
        function previewImage() {

            const file = document.getElementById('file').files;
            const preview = document.getElementById('preview');
            // const filename = document.getElementById('filename');

            if (file.length > 0) {

                const fileReader = new FileReader();
                fileReader.onload = function (event) {

                    preview.setAttribute('src', event.target.result);
                    // filename.innerHTML = file[0].name;

                }

                fileReader.readAsDataURL(file[0]);

            }

        }
    </script>

</body>

</html>