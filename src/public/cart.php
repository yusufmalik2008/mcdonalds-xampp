<?php require '../includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link href="assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include 'partials/header.php'; ?>
    <main class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Your Cart</h1>
        <div id="cart-items"></div>
        <div class="text-right mt-8">
            <p class="text-2xl font-bold">Total: $<span id="cart-total">0.00</span></p>
            <a href="checkout.php" class="bg-mcdred text-white px-6 py-3 rounded text-xl mt-4 inline-block">Checkout</a>
        </div>
    </main>

    <script>
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const container = document.getElementById('cart-items');
        let total = 0;

        if (cart.length === 0) {
            container.innerHTML = '<p class="text-xl">Your cart is empty.</p>';
        } else {
            const table = `<table class="w-full border-collapse">
                <thead><tr class="bg-gray-200"><th class="p-4 text-left">Item</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead>
                <tbody>${cart.map(item => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;
                    return `<tr class="border-b"><td class="p-4">${item.name}</td><td>$${item.price.toFixed(2)}</td><td>${item.quantity}</td><td>$${itemTotal.toFixed(2)}</td></tr>`;
                }).join('')}</tbody>
            </table>`;
            container.innerHTML = table;
        }

        document.getElementById('cart-total').textContent = total.toFixed(2);
    </script>
</body>
</html>