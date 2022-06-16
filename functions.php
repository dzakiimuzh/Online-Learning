<?php 

    // include '../koneksi.php';

    // session_start();

    // if( !isset($_SESSION['loginAdmin']) ) {

    //     header("Location: login.php");
    //     exit;

    // }

    // function query($query) {

    //     global $conn;
    //     $result = mysqli_query($conn, $query);
    //     $rows = [];
    //     while( $row = mysqli_fetch_assoc($result) ) {
 
    //      $rows[] = $row;
 
    //     }
 
    //     return $rows;
 
    //  }

    // function tambahMenu($data) {

    //     global $conn;

    //     $namaMakanan = $data['nama'];
    //     $harga = $data['harga'];
    //     $kategori = $data['kategori'];

    //     $gambar = upload();

    //     if( !$gambar ) {

    //         return false;

    //     }

    //     $query = "INSERT INTO tbl_menu VALUES('', '$namaMakanan', '$harga', '$gambar', '$kategori')";
    //     mysqli_query($conn, $query);

    //     return mysqli_affected_rows($conn);

    // }

    // function editMenu($data) {

    //     global $conn;

    //     $id = $data['id'];

    //     $namaMakanan = $data['nama'];
    //     $harga = $data['harga'];
    //     $kategori = $data['kategori'];
    //     $gambarLama = $data['gambarLama'];

    //     if( $_FILES['gambar']['error'] === 4 ) {

    //         $gambar = $gambarLama;

    //     } else {

    //         $gambar = upload();
    //         unlink('../assets/img_menu/' . $gambarLama);

    //     }

    //     $query = "UPDATE tbl_menu 
    //                     SET
    //                 nama = '$namaMakanan',
    //                 harga = '$harga',
    //                 img = '$gambar',
    //                 id_kategori = '$kategori'
    //             WHERE id = '$id'                       
    //             ";

    //     mysqli_query($conn, $query);

    //     return mysqli_affected_rows($conn);

    // }

    // function upload() {

    //     $namaFile = $_FILES['gambar']['name'];
    //     $ukuranFile = $_FILES['gambar']['size'];
    //     $error = $_FILES['gambar']['error'];
    //     $tmpName = $_FILES['gambar']['tmp_name'];

    //     if( $error == 4 ) {

    //         echo "
            
    //             <script>
    //                 alert('Pilih gambar terlebih dahulu');
    //             </script>
            
    //         ";

    //         return false;

    //     }

    //     $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    //     $ekstensiGambar = explode('.', $namaFile);
    //     $ekstensiGambar = strtolower(end($ekstensiGambar));

    //     if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {

    //         echo "
            
    //             <script>
    //                 alert('Yang anda upload bukan gambar');
    //             </script>
            
    //         ";

    //         return false;

    //     }

    //     if( $ukuranFile > 10000000 ) {

    //         echo "
            
    //             <script>
    //                 alert('Ukuran gambar terlalu besar');
    //             </script>
            
    //         ";

    //         return false;

    //     }

    //     $namaFileBaru = uniqid();
    //     $namaFileBaru .= '.';
    //     $namaFileBaru .= $ekstensiGambar;

    //     move_uploaded_file($tmpName, '../assets/img_menu/' . $namaFileBaru);

    //     return $namaFileBaru;

    // }

?>