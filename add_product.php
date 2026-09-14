<?php

session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $price = $_POST["price"] ?? "";
    $image = trim($_POST["image"] ?? "");

    if ($name === "" || $description === "" || $price === "" || $image === "") {
        $error = "All fields are required.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Price must be a number greater than zero.";
    } elseif (!preg_match('/^[a-zA-Z0-9._-]+$/', $image)) {
        $error = "Image filename contains invalid characters.";
    } else {

        $stmt = $conn->prepare(
            "INSERT INTO products (name, description, price, image)
             VALUES (?, ?, ?, ?)"
        );

        $price = (float)$price;

        $stmt->bind_param(
            "ssds",
            $name,
            $description,
            $price,
            $image
        );

        if ($stmt->execute()) {

            $stmt->close();
            $conn->close();

            header("Location: products.php");
            exit;

        } else {

            $error = "Unable to add the product. Please try again.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Product - Adelaide Artisan Bakery</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<header>

    <div class="logo">Adelaide Artisan Bakery</div>

    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="admin.php">Orders</a>
    </nav>

</header>

<section>

    <h1 class="section-title">Add New Product</h1>

    <form method="POST" class="order-form">

        <?php if ($error !== ""): ?>

            <div
                role="alert"
                aria-live="assertive"
                style="margin-bottom:15px;"
            >
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>

        <label for="name">Product Name</label>

        <input
            type="text"
            id="name"
            name="name"
            maxlength="100"
            required
        >

        <label for="description">Description</label>

        <textarea
            id="description"
            name="description"
            rows="4"
            required
        ></textarea>

        <label for="price">Price ($)</label>

        <input
            type="number"
            id="price"
            name="price"
            min="0.01"
            step="0.01"
            required
        >

        <label for="image">Image Filename</label>

        <input
            type="text"
            id="image"
            name="image"
            placeholder="e.g. bread.jpg"
            required
        >

        <button type="submit" class="button">
            Add Product
        </button>

        <a href="products.php" class="button">
            Cancel
        </a>

    </form>

</section>

<footer>

    <p>© 2026 Adelaide Artisan Bakery. All rights reserved.</p>

</footer>

</body>

</html>