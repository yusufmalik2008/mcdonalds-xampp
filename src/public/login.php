<?php
require '../includes/db.php';
require '../includes/auth.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (login($username, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - McDonald's</title>
    <link href="assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-mcdred">McDonald's</h1>
            <p class="text-gray-600 mt-2">Welcome back!</p>
        </div>

        <?php if ($message): ?>
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-6" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Username</label>
                <input type="text" name="username" required class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-mcdred">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-mcdred">
            </div>
            <button type="submit" class="w-full bg-mcdred text-white font-bold py-4 rounded-lg hover:bg-red-700 transition">
                Login
            </button>
        </form>

        <p class="text-center mt-6 text-gray-600">
            No account? <a href="register.php" class="text-mcdyellow font-bold hover:underline">Register here</a>
        </p>
    </div>
</body>
</html>