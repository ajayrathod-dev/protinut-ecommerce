<?php
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int) $_SESSION['user_id'];

    // Check if cart has items
    if (empty($_SESSION['cart'])) {
        header('Location: cart.php');
        exit();
    }

    // Capture billing fields
    $first_name = mysqli_real_escape_string($link, trim($_POST['billing_first_name'] ?? ''));
    $last_name = mysqli_real_escape_string($link, trim($_POST['billing_last_name'] ?? ''));
    $email = mysqli_real_escape_string($link, trim($_POST['billing_email'] ?? ''));
    $phone = mysqli_real_escape_string($link, trim($_POST['billing_phone'] ?? ''));
    $country = mysqli_real_escape_string($link, trim($_POST['billing_country'] ?? ''));
    $address = mysqli_real_escape_string($link, trim($_POST['billing_address_1'] ?? ''));
    $city = mysqli_real_escape_string($link, trim($_POST['billing_city'] ?? ''));
    $postcode = mysqli_real_escape_string($link, trim($_POST['billing_postcode'] ?? ''));

    // Capture new payment fields
    $payment_method = mysqli_real_escape_string($link, trim($_POST['payment_method'] ?? 'cod'));
    $utr_number = mysqli_real_escape_string($link, trim($_POST['utr_number'] ?? ''));
    $payment_status = ($payment_method == 'qr_payment') ? 'unpaid' : 'pending'; // Initially unpaid until admin verifies

    // Calculate total price
    $total_price = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Insert order
    $sql = "INSERT INTO orders (user_id, total_amount, first_name, last_name, email, phone, country, address, city, postcode, status, payment_method, utr_number, payment_status, created_at) 
            VALUES ($user_id, $total_price, '$first_name', '$last_name', '$email', '$phone', '$country', '$address', '$city', '$postcode', 'Pending', '$payment_method', '$utr_number', '$payment_status', NOW())";

    if (mysqli_query($link, $sql)) {
        $order_id = mysqli_insert_id($link);

        // Insert order items
        foreach ($_SESSION['cart'] as $item) {
            $pid = (int) $item['id'];
            $pname = mysqli_real_escape_string($link, $item['name']);
            $pprice = (float) $item['price'];
            $pqty = (int) $item['quantity'];
            mysqli_query($link, "INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES ($order_id, $pid, '$pname', $pprice, $pqty)");
        }
    }

    // Empty cart
    $_SESSION['cart'] = [];

    echo "<script>alert('Order placed successfully!'); window.location.href='my_orders.php';</script>";
    exit();
} else {
    header('Location: checkout.php');
    exit();
}
?>