<?php 

    include '../../koneksi.php';

    $id = $_GET['id'];
    $idUser = $_GET['idUser'];

    $query = mysqli_query($conn, "DELETE FROM tbl_guru WHERE id_guru = '$id'");
    mysqli_query($conn, "DELETE FROM users WHERE id_user = '$idUser'");

    if( $query ) {

        echo "
        
            <script>
                alert('Hapus guru berhasil');
                document.location.href = 'guru.php';
            </script>
        
        ";
        
    } else {

        
        echo "
        
            <script>
                alert('Hapus guru gagal');
                document.location.href = 'guru.php';
            </script>
        
        ";

    }

?>