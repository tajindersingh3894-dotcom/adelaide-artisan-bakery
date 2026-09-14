<?php

session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    die("Invalid product ID.");
}

$error = "";

/* Get existing product */
$stmt = $conn->prepare(
    "SELECT * FROM products WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$product = $result->fetch_assoc();

$stmt->close();

if (!$product) {
    die("Product not found.");
}

/* Update product */
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

        $price = (float)$price;

        $stmt = $conn->prepare(
            "UPDATE products
             SET name = ?, description = ?, price = ?, image = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "ssdsi",
            $name,
            $description,
            $price,
            $image,
            $id
        );

        if ($stmt->execute()) {

            $stmt->close();
            $conn->close();

            header("Location: products.php");
            exit;

        } else {

            $error = "Unable to update the product.";
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

    <title>Edit Product - Adelaide Artisan Bakery</title>

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

    <h1 class="section-title">Edit Product</h1>

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
            value="<?php echo htmlspecialchars($product['name']); ?>"
            required
        >

        <label for="description">Description</label>

        <textarea
            id="description"
            name="description"
            rows="4"
            required
        ><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label for="price">Price ($)</label>

        <input
            type="number"
            id="price"
            name="price"
            min="0.01"
            step="0.01"
            value="<?php echo htmlspecialchars($product['price']); ?>"
            required
        >

        <label for="image">Image Filename</label>

        <input
            type="text"
            id="image"
            name="image"
            value="<?php echo htmlspecialchars($product['image']); ?>"
            required
        >

        <button type="submit" class="button">
            Update Product
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