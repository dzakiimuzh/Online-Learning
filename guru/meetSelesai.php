<?php 

    include '../koneksi.php';

    $kelas = $_GET['kelas'];
    $idMeet = $_GET['idMeet'];

    $query = mysqli_query($conn, "UPDATE tbl_meet SET status = 'selesai' WHERE id_meet = '$idMeet' AND kelas = '$kelas'");
    
    if( $query ) {

        echo "
            
                <script>
                    alert('Meet Selesai');
                    document.location.href = 'home.php?kelas=$kelas';
                </script>

            ";

    }



?>