<?php
include 'config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM karakter WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $detail = mysqli_fetch_assoc($result);

    if ($detail) {
        echo "<p><strong>Nama:</strong> " . htmlspecialchars($detail['nama']) . "</p>";
        echo "<p><strong>Asal:</strong> " . htmlspecialchars($detail['asal']) . "</p>";
        echo "<p><strong>Deskripsi:</strong> " . nl2br(htmlspecialchars($detail['deskripsi'])) . "</p>";
        echo '<img src="img/' . htmlspecialchars($detail['foto']) . '" width="100%" class="img-fluid rounded">';
    } else {
        echo "<p>Data tidak ditemukan.</p>";
    }
} else {
    echo "<p>ID tidak valid.</p>";
}
?>
