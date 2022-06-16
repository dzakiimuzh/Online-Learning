<?php 

    session_start();
    include 'koneksi.php';

    date_default_timezone_set('Asia/Jakarta');

    if( isset($_SESSION['login']) && $_SESSION['role'] == 'siswa' ) {

        header('location: home.php');
        exit;

    } else if( isset($_SESSION['login']) && $_SESSION['role'] == 'guru' )  {

        header('location: guru/home.php');
        exit;

    } else if( isset($_SESSION['login']) && $_SESSION['role'] == 'admin' ) {

        header('location: admin/dashboard.php');
        exit;


    }

    $hari = date("D");
    
    switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
    
    if( isset($_POST['login']) ) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

        if( mysqli_num_rows($cek) == 1 ) {

            $row = mysqli_fetch_assoc($cek);

            if( password_verify($password, $row['password']) ) {

                if( $row['role'] == 'siswa' ) {

                    $_SESSION['login'] = true;
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['idUser'] = $row['id_user'];

                    $id = $_SESSION['idUser'];

                    $tgl = date('d M Y');
                    $jam = date('H:i');
                    
                    $queryCek = mysqli_query($conn, "SELECT * FROM tbl_absen WHERE id_user = '$id' AND tanggal = '$tgl'");

                    if( mysqli_num_rows($queryCek) == 1 ) {

                        header('location: home.php');
                        exit;

                    } else {

                        $absen = mysqli_query($conn, "INSERT INTO tbl_absen VALUES('', '$id', '$hari_ini', '$tgl', '$jam')");
    
                        header('location: home.php');
                        exit;

                    }


                } else if( $row['role'] == 'guru' ) {

                    $_SESSION['login'] = true;
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['idUser'] = $row['id_user'];

                    header('location: guru/home.php');
                    exit;

                } else if( $row['role'] == 'admin' ) {

                    $_SESSION['login'] = true;
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['idUser'] = $row['id_user'];

                    header('location: admin/dashboard.php');
                    exit;

                }

            }

        }

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
    <link rel="stylesheet" href="assets/css/login.css">

    <title>Login</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="login-card">
                    <h3>Welcome back <br> to <span style="color: #2081E2;">SmkBm3</span></h3>
                    <p class="mt-3 mb-n2">Sign in to your account below.</p>
                    <form action="" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" id="exampleFormControlInput1"
                                placeholder="Username" name="username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="exampleFormControlInput1"
                                placeholder="Password" name="password" required>
                        </div>
                        <button type="submit" name="login" class="btn">Sign In</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">

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