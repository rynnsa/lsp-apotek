<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT c.*, o.nama_obat, o.harga FROM cart c 
          JOIN obat o ON c.obat_id = o.id 
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Your Cart</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                while ($row = $result->fetch_assoc()) {
                    $total = $row['quantity'] * $row['harga'];
                    $grand_total += $total;
                ?>
                    <tr>
                        <td><?php echo $row['nama_obat']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td>Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Grand Total:</strong></td>
                    <td>Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
