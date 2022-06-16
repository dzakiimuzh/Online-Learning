<?php 

    session_start();
    include '../koneksi.php';

    date_default_timezone_set('Asia/Jakarta');

    if( !isset($_SESSION['login']) ) {

        header('location: ../login.php');
        exit;

    }

    $idMeet = $_GET['idMeet'];
    $kelas2 = $_GET['kelas'];

    $hapus = mysqli_query($conn, "DELETE FROM tbl_meet WHERE id_meet = '$idMeet'");

    if( $hapus ) {

        echo "
        
            <script>
                alert('Berhasil Menghapus meet');
                document.location.href = 'home.php?kelas=$kelas2';
            </script>
        
        ";

    } else {

        echo "
        
            <script>
                alert('GAGAL Menghapus meet');
                document.location.href = 'home.php?kelas=$kelas2';
            </script>
    
         ";

    }

?>