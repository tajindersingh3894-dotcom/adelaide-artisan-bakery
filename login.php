<?php

session_start();

$error = "";

/* Load .env file */
$env_file = __DIR__ . "/.env";

if (file_exists($env_file)) {

    $lines = file(
        $env_file,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );

    foreach ($lines as $line) {

        $line = trim($line);

        if ($line === "" || str_starts_with($line, "#")) {
            continue;
        }

        $parts = explode("=", $line, 2);

        if (count($parts) === 2) {

            $key = trim($parts[0]);
            $value = trim($parts[1]);

            $_ENV[$key] = $value;
        }
    }
}

$admin_username = $_ENV["ADMIN_USERNAME"] ?? "";
$admin_password = $_ENV["ADMIN_PASSWORD"] ?? "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if (
        $username === $admin_username &&
        $password === $admin_password
    ) {

        $_SESSION["admin_logged_in"] = true;

        header("Location: admin.php");
        exit;

    } else {

        $error = "Invalid username or password.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login - Adelaide Artisan Bakery</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<section>

    <h1 class="section-title">Admin Login</h1>

    <form method="POST" class="order-form">

        <label for="username">Username</label>

        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>

        <input type="password" id="password" name="password" required>

        <?php if ($error): ?>

            <p><?php echo htmlspecialchars($error); ?></p>

        <?php endif; ?>

        <button type="submit" class="button">
            Login
        </button>

    </form>

</section>

</body>

</html>