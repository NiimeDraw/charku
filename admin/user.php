<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Ambil semua data karakter
$query = "SELECT * FROM users";
$sql = mysqli_query($conn, $query);
$no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../DataTables/datatables.min.css" rel="stylesheet">
    <title>Charku</title>
    <style>
        /* Custom styling untuk dropdown pada hover */
        .navbar .nav-item {
            display: block; /* Munculkan dropdown saat hover */
            margin-top: 0; /* Hilangkan jarak antara nav item dan dropdown */
        }
    </style>
</head>
<body>
    <!-- Main Navbar -->
    <?php include "navbar_dashboard.php" ?>

    <div class="container mt-4">
        <h2 class="text-center">User List</h2>
        <a href="kelola_users.php" class="btn btn-primary mb-3">Add User</a>
        <div class="table-responsive">
            <table id="charList" class="table align-middle table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th><center>No.</center></th>
                        <th><center>Name</center></th>
                        <th><center>Email</center></th>
                        <th><center>Role</center></th>
                        <th><center>Action</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($result = mysqli_fetch_assoc($sql)) { ?>
                        <tr>
                            <td><center><?php echo $no++; ?>.</center></td>
                            <td><?php echo htmlspecialchars($result['name']); ?></td>
                            <td><?php echo htmlspecialchars($result['email']); ?></td>
                            <td><?php echo htmlspecialchars($result['role']); ?></td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="kelola_users.php?edit_user=<?php echo $result['id']; ?>" class="btn btn-warning mx-1">Edit</a>
                                    <a href="proses_users.php?hapus=<?php echo $result['id']; ?>" class="btn btn-danger btn-sm mx-1" onclick="return confirm('Yakin ingin hapus?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JS dan DataTables -->
    <script src="../js/bootstrap.bundle.min.js"></script>
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
