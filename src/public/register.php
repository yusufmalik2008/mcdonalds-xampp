<?php
require '../includes/db.php';
require '../includes/auth.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $message = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters!";
    } else {
        // Check if username or email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->rowCount() > 0) {
            $message = "Username or email already taken!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("CALL CreateUser(?, ?, ?)");
            $stmt->execute([$username, $hashed, $email]);

            $message = "Registration successful! You can now <a href='login.php' class='text-mcdyellow underline'>login</a>.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - McDonald's</title>
    <link href="assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-mcdred">McDonald's</h1>
            <p class="text-gray-600 mt-2">Create your account</p>
        </div>

        <?php if ($message): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded mb-6" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Username</label>
                <input type="text" name="username" required class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-mcdred">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-mcdred">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" required minlength="6" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-mcdred">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
                <input type="password" name="confirm" required class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-mcdred">
            </div>
            <button type="submit" class="w-full bg-mcdred text-white font-bold py-4 rounded-lg hover:bg-red-700 transition">
                Register
            </button>
        </form>

        <p class="text-center mt-6 text-gray-600">
            Already have an account? <a href="login.php" class="text-mcdyellow font-bold hover:underline">Login here</a>
        </p>
    </div>
</body>
</html>