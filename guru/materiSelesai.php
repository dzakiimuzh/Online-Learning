<?php 

    include '../koneksi.php';

    $kelas = $_GET['kelas'];
    $idMateri = $_GET['idMateri'];

    $query = mysqli_query($conn, "UPDATE tbl_materi SET status = 'selesai' WHERE id_materi = '$idMateri' AND kelas = '$kelas'");
    
    if( $query ) {

        echo "
            
                <script>
                    alert('Materi Selesai');
                    document.location.href = 'home.php?kelas=$kelas';
                </script>

            ";

    }



?>