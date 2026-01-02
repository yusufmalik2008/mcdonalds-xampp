<header class="bg-mcdred text-white shadow-lg">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-3xl font-bold">McDonald's</h1>
        <nav class="space-x-6">
            <a href="index.php" class="hover:underline">Menu</a>
            <a href="cart.php" class="hover:underline">Cart (<span id="cart-count">0</span>)</a>
            <?php if (isLoggedIn()): ?>
                <a href="orders.php" class="hover:underline">My Orders</a>
                <?php if (isAdmin()): ?>
                    <a href="admin/orders.php" class="hover:underline">Admin</a>
                <?php endif; ?>
                <a href="logout.php" class="hover:underline">Logout (<?= $_SESSION['username'] ?>)</a>
            <?php else: ?>
                <a href="login.php" class="hover:underline">Login</a>
                <a href="register.php" class="hover:underline">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>