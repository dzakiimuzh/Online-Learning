<?php 

    session_start();
    include '../koneksi.php';

    date_default_timezone_set('Asia/Jakarta');

    if( !isset($_SESSION['login']) ) {

        header('location: ../login.php');
        exit;

    }

    $idTugas = $_GET['idTugas'];
    $kelas2 = $_GET['kelas'];

    $hapus = mysqli_query($conn, "DELETE FROM tbl_tugas WHERE id_tugas = '$idTugas'");

    if( $hapus ) {

        echo "
        
            <script>
                alert('Berhasil Menghapus Tugas');
                document.location.href = 'home.php?kelas=$kelas2';
            </script>
        
        ";

    } else {

        echo "
        
            <script>
                alert('GAGAL Menghapus tugas');
                document.location.href = 'home.php?kelas=$kelas2';
            </script>
    
         ";

    }

?>