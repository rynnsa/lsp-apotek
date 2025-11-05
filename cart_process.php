<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $obat_id = $_POST['obat_id'];
        $quantity = $_POST['quantity'];
        $user_id = $_SESSION['user_id']; // Assuming user is logged in

        // Get medicine details
        $query = "SELECT * FROM obat WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $obat_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obat = $result->fetch_assoc();

        if ($obat) {
            // Check if item already exists in cart
            $check_cart = "SELECT * FROM cart WHERE user_id = ? AND obat_id = ?";
            $stmt = $conn->prepare($check_cart);
            $stmt->bind_param("ii", $user_id, $obat_id);
            $stmt->execute();
            $cart_result = $stmt->get_result();

            if ($cart_result->num_rows > 0) {
                // Update existing cart item
                $update_query = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND obat_id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("iii", $quantity, $user_id, $obat_id);
                $stmt->execute();
            } else {
                // Add new cart item
                $insert_query = "INSERT INTO cart (user_id, obat_id, quantity) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param("iii", $user_id, $obat_id, $quantity);
                $stmt->execute();
            }
            
            header("Location: cart.php");
            exit();
        }
    }
}
?>
