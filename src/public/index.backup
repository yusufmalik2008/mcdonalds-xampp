<?php require '../includes/auth.php'; require '../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>McDonald's Order App</title>
    <link href="assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include 'partials/header.php'; ?>

    <main class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-mcdred mb-8 text-center">Menu</h1>
        <?php
        $stmt = $pdo->query("CALL GetMenuItems()");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $grouped = [];
        foreach ($items as $item) {
            $grouped[$item['category']][] = $item;
        }
        ?>

        <?php foreach ($grouped as $category => $items): ?>
            <section class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6"><?= htmlspecialchars($category) ?></h2>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php foreach ($items as $item): ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="bg-gray-200 h-48 flex items-center justify-center">
                                <span class="text-gray-500">Image: <?= htmlspecialchars($item['name']) ?></span>
                            </div>
                            <div class="p-4">
                                <h3 class="text-xl font-bold"><?= htmlspecialchars($item['name']) ?></h3>
                                <p class="text-gray-600 text-sm mt-1"><?= htmlspecialchars($item['description']) ?></p>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-2xl font-bold text-mcdred">$<?= number_format($item['price'], 2) ?></span>
                                    <button onclick="addToCart(<?= $item['id'] ?>, '<?= addslashes($item['name']) ?>', <?= $item['price'] ?>)"
                                            class="bg-mcdyellow text-black font-bold px-4 py-2 rounded hover:bg-yellow-400">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
    </main>

    <script src="js/cart.js"></script>
</body>
</html>