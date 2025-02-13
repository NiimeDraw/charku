<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Login/login.php");
    exit();
}

include '../config/db.php';

// 1. Hitung Total Characters
$queryTotal = "SELECT COUNT(*) AS total FROM karakter";
$sqlTotal = mysqli_query($conn, $queryTotal);
$rowTotal = mysqli_fetch_assoc($sqlTotal);
$totalCharacters = $rowTotal['total'];

// 2. Hitung Total Anime Characters (JOIN dengan tabel categories)
$queryAnime = "SELECT COUNT(*) AS total_anime 
               FROM karakter 
               JOIN categories ON karakter.category_id = categories.id 
               WHERE categories.name = 'Anime'";
$sqlAnime = mysqli_query($conn, $queryAnime);
$rowAnime = mysqli_fetch_assoc($sqlAnime);
$totalAnime = $rowAnime['total_anime'];

// 3. Hitung Total Game Characters
$queryGame = "SELECT COUNT(*) AS total_game 
              FROM karakter 
              JOIN categories ON karakter.category_id = categories.id 
              WHERE categories.name = 'Game'";
$sqlGame = mysqli_query($conn, $queryGame);
$rowGame = mysqli_fetch_assoc($sqlGame);
$totalGame = $rowGame['total_game'];

// 4. Ambil data karakter yang terakhir ditambahkan (misalnya 5 data terbaru)
// Disini kita menggunakan JOIN agar langsung mendapatkan nama kategori
$queryLatest = "SELECT karakter.*, categories.name AS category_name 
                FROM karakter 
                JOIN categories ON karakter.category_id = categories.id 
                ORDER BY karakter.id DESC LIMIT 5";
$sqlLatest = mysqli_query($conn, $queryLatest);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charku</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../DataTables/datatables.min.css" rel="stylesheet">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <style>
      /* Custom styling untuk dropdown pada hover */
      .navbar .nav-item.dropdown:hover .dropdown-menu {
        display: block; /* Munculkan dropdown saat hover */
        margin-top: 0; /* Hilangkan jarak antara nav item dan dropdown */
      }
      .navbar .dropdown-menu {
        border: none; /* Hilangkan border */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Tambahkan shadow */
      }
      .navbar .dropdown-item:hover {
        background-color: #f8f9fa; /* Warna background saat hover */
        color: #007bff; /* Warna teks saat hover */
      }
      .card {
        margin-bottom: 20px;
      }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar_dashboard.php'; ?>

    <div class="container mt-4">
        <h1>Dashboard</h1>
        <!-- Card Summary -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Characters</h5>
                        <p class="card-text" style="font-size: 2rem;"><?php echo $totalCharacters; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Anime Characters</h5>
                        <p class="card-text" style="font-size: 2rem;"><?php echo $totalAnime; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Game Characters</h5>
                        <p class="card-text" style="font-size: 2rem;"><?php echo $totalGame; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Karakter Terakhir -->
        <h2 class="mt-5">Latest Added Characters</h2>
        <div class="table-responsive">
            <table id="charList" class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Origin</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($sqlLatest)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['asal']); ?></td>
                        <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="../DataTables/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#charList').DataTable();
        });
    </script>
</body>
</html>
