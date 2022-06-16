<?php 

    include '../../koneksi.php';

    $id = $_GET['id'];

    $query = mysqli_query($conn, "DELETE FROM kelas WHERE id_kelas = '$id'");

    if( $query ) {

        echo "
        
            <script>
                alert('Hapus kelas berhasil');
                document.location.href = 'kelas.php';
            </script>
        
        ";
        
    } else {

        
        echo "
        
            <script>
                alert('Hapus kelas gagal');
                document.location.href = 'kelas.php';
            </script>
        
        ";

    }

?>