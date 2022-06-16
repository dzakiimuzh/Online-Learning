<?php 

    include '../koneksi.php';
    session_start();

    if( !isset($_SESSION['login']) ) {

        header("location: ../login.php");
        exit;

    }

    function query($query) {

        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while( $row = mysqli_fetch_assoc($result) ) {
 
         $rows[] = $row;
 
        }
 
        return $rows;
 
    }

    $batas = 5;
    $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;

    $previous = $halaman - 1;
    $next = $halaman + 1;

    $jumlah_data = count(query("SELECT * FROM buku"));
    $total_halaman = ceil($jumlah_data / $batas);

    $buku = mysqli_query($conn, "SELECT * FROM buku LIMIT $halaman_awal, $batas");

    $nomor = $halaman_awal+1;

    if( isset($_GET['cari']) ) {

        $keyword = $_GET['keyword'];

        $buku = mysqli_query($conn, "SELECT * FROM buku WHERE judul LIKE '%$keyword%' OR stok LIKE '%$keyword%' OR penulis LIKE '%$keyword%' OR penerbit LIKE '%$keyword%'");

    }

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <!-- My CSS -->
    <link rel="stylesheet" href="../assets/css/admin/home.css">

    <title>Data Buku | Admin</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <a class="navbar-brand" href="#">Perpus</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    <div class="dropdown">
                        <button class="btn text-white dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-expanded="false">
                            Admin
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="nav2">
        <div class="container container2">
            <div class="col-md-12">
                <a href="home.php" class=""><i class="fas fa-desktop mr-2"></i>Dashboard</a>
                <div class="dropdown">
                    <button class="btn active dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-table mr-2"></i>Data
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="buku.php">Buku</a>
                        <a class="dropdown-item" href="siswa.php">Siswa</a>
                        <a class="dropdown-item" href="kelas.php">Kelas</a>
                        <a class="dropdown-item" href="denda.php">Denda</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-book-open mr-2"></i>Transaksi
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="peminjaman.php">Peminjaman</a>
                        <a class="dropdown-item" href="pengembalian.php">Pengembalian</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container container3 p-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="buku">Data Buku</h2>
                <div class="grub-btn d-flex mt-3 justify-content-between">
                    <a href="tambahBuku.php" class="btn btn-tambah">Tambah Data</a>
                    <form action="" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search"
                                aria-label="Recipient's username" name="keyword" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"
                                    name="cari">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Penulis</th>
                            <th scope="col">Penerbit</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if( mysqli_num_rows($buku) == 0 ) : ?>
                        <tr>
                            <td colspan="5" class="text-center">Data Kosong</td>
                        </tr>
                        <?php endif; ?>
                        <?php $no = 1; ?>
                        <?php while( $b = mysqli_fetch_assoc($buku) ) : ?>
                        <tr>
                            <th scope="row"><?= $nomor++ ?></th>
                            <td><?= $b['judul'] ?></td>
                            <td><?= $b['penulis'] ?></td>
                            <td><?= $b['penerbit'] ?></td>
                            <td><?= $b['stok'] ?></td>
                            <td>
                                <a href="editBuku.php?id=<?= $b['id_buku'] ?>" class="btn btn-success">Edit</a>
                                <a href="deleteBuku.php?id=<?= $b['id_buku'] ?>" class="btn btn-danger"
                                    onclick="return confirm('Yakin hapus?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <nav class="mt-4 float-right">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link previous"
                                <?php if($halaman > 1){ echo "href='?halaman=$previous'"; } ?>>Previous</a>
                        </li>
                        <?php 
                                    for($x=1;$x<=$total_halaman;$x++){
                                ?>
                        <li class="page-item <?= ($halaman == $x) ? 'active' : '' ?>"><a class="page-link"
                                href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                        <?php
                                    }
                                ?>
                        <li class="page-item">
                            <a class="page-link"
                                <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>


</body>

</html>