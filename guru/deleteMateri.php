<?php 

    session_start();
    include '../koneksi.php';

    date_default_timezone_set('Asia/Jakarta');

    if( !isset($_SESSION['login']) ) {

        header('location: ../login.php');
        exit;

    }

    $idMateri = $_GET['idMateri'];
    $kelas2 = $_GET['kelas'];

    $hapus = mysqli_query($conn, "DELETE FROM tbl_materi WHERE id_materi = '$idMateri'");

    if( $hapus ) {

        echo "
        
            <script>
                alert('Berhasil Menghapus Materi');
                document.location.href = 'home.php?kelas=$kelas2';
            </script>
        
        ";

    } else {

        echo "
        
            <script>
                alert('GAGAL Menghapus Materi');
                document.location.href = 'home.php?kelas=$kelas2';
            </script>
    
         ";

    }

?>