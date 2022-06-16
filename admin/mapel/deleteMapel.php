<?php 

    include '../../koneksi.php';

    $id = $_GET['id'];

    $query = mysqli_query($conn, "DELETE FROM mapel WHERE id_mapel = '$id'");

    if( $query ) {

        echo "
        
            <script>
                alert('Hapus mapel berhasil');
                document.location.href = 'mapel.php';
            </script>
        
        ";
        
    } else {

        
        echo "
        
            <script>
                alert('Hapus mapel gagal');
                document.location.href = 'mapel.php';
            </script>
        
        ";

    }

?>