<?php 

    include '../../koneksi.php';

    $id = $_GET['id'];
    $idUser = $_GET['idUser'];

    $query = mysqli_query($conn, "DELETE FROM tbl_siswa WHERE id_siswa = '$id'");
    mysqli_query($conn, "DELETE FROM users WHERE id_user = '$idUser'");

    if( $query ) {

        echo "
        
            <script>
                alert('Hapus siswa berhasil');
                document.location.href = 'siswa.php';
            </script>
        
        ";
        
    } else {

        
        echo "
        
            <script>
                alert('Hapus siswa gagal');
                document.location.href = 'siswa.php';
            </script>
        
        ";

    }

?>