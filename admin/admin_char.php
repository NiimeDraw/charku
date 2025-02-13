<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Ambil semua data karakter
$query = "SELECT * FROM karakter";
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
      .navbar .nav-item.{
        display: block; /* Munculkan dropdown saat hover */
        margin-top: 0; /* Hilangkan jarak antara nav item dan dropdown */
      }
    </style>
</head>
<body>
<!-- Main Navbar -->
<?php include "navbar_dashboard.php" ?>

    <div class="container mt-4">
        <h2 class="text-center">Character List</h2>
        <a href="kelola.php" class="btn btn-primary mb-3">Add Character</a>
        <div class="table-responsive">
            <table id="charList" class="table align-middle table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th><center>No.</center></th>
                        <th><center>Name</center></th>
                        <th><center>Anime/Game</center></th>
                        <th><center>Source</center></th>
                        <th><center>Action</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($result = mysqli_fetch_assoc($sql)) { ?>
                        <tr>
                            <td><center><?php echo $no++; ?>.</center></td>
                            <td><?php echo htmlspecialchars($result['nama']); ?></td>
                            <td><?php echo htmlspecialchars($result['asal']); ?></td>
                            <td>
                                <?php
                                    $source = htmlspecialchars($result['link']);
                                    // Cek apakah URL valid (opsional)
                                    if (filter_var($source, FILTER_VALIDATE_URL)) {
                                        echo '<a href="' . $source . '" target="_blank">' . $source . '</a>';
                                    } else {
                                        echo $source; // Tampilkan teks biasa jika bukan URL yang valid
                                    }
                                ?>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-info btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#detail<?php echo $result['id']; ?>">Details</button>
                                    <a href="proses.php?delete=<?php echo $result['id']; ?>" class="btn btn-danger btn-sm mx-1" onclick="return confirm('Yakin ingin hapus?')">Delete</a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal untuk setiap karakter -->
                        <div class="modal fade" id="detail<?php echo $result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Detail Character</h4>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <?php
                                        // Ambil detail karakter berdasarkan ID
                                        $sqlDetail = mysqli_query($conn, "SELECT * FROM karakter WHERE id='" . $result['id'] . "'");
                                        $detail = mysqli_fetch_assoc($sqlDetail);

                                        if ($detail) {
                                            echo "<p><strong>Nama:</strong> " . htmlspecialchars($detail['nama']) . "</p>";
                                            echo "<p><strong>Asal:</strong> " . htmlspecialchars($detail['asal']) . "</p>";
                                            echo "<p><strong>Deskripsi:</strong> " . nl2br(htmlspecialchars($detail['deskripsi'])) . "</p>";
                                            echo '<img src="../img/' . htmlspecialchars($detail['foto']) . '" width="100%">';
                                        } else {
                                            echo "<p>Data tidak ditemukan.</p>";
                                        }
                                        ?>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <a href="kelola.php?edit=<?php echo $result['id']; ?>" class="btn btn-warning mx-1">Edit</a>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
