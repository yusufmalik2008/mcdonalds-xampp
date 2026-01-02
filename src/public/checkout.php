<?php
require '../includes/auth.php';
requireLogin();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart = json_decode($_POST['cart'], true);
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("CALL PlaceOrder(?, ?, @order_id)");
        $stmt->execute([$_SESSION['user_id'], $total]);
        $stmt = $pdo->query("SELECT @order_id AS order_id");
        $order_id = $stmt->fetch()['order_id'];

        $addStmt = $pdo->prepare("CALL AddOrderItem(?, ?, ?, ?)");
        foreach ($cart as $item) {
            $addStmt->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
        }

        $pdo->commit();
        echo "<script>localStorage.removeItem('cart'); alert('Order placed!'); location.href='orders.php';</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html><head><title>Checkout</title><link href="assets/css/output.css" rel="stylesheet"></head>
<body class="bg-gray-100">
    <?php include 'partials/header.php'; ?>
    <main class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold">Checkout</h1>
        <form method="POST">
            <input type="hidden" name="cart" id="cart-input">
            <button type="submit" class="bg-mcdred text-white px-8 py-4 text-xl mt-8">Confirm Order</button>
        </form>
    </main>
    <script>
        document.getElementById('cart-input').value = localStorage.getItem('cart');
    </script>
</body></html>