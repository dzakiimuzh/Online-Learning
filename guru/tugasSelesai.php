<?php 

    include '../koneksi.php';

    $kelas = $_GET['kelas'];
    $idTugas = $_GET['idTugas'];

    $query = mysqli_query($conn, "UPDATE tbl_tugas SET status = 'selesai' WHERE id_tugas = '$idTugas' AND kelas = '$kelas'");
    
    if( $query ) {

        echo "
            
                <script>
                    alert('Tugas Selesai');
                    document.location.href = 'home.php?kelas=$kelas';
                </script>

            ";

    }



?>