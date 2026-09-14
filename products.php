<?php

session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";

$result = $conn->query(
    "SELECT * FROM products ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Products - Adelaide Artisan Bakery</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<header>

    <div class="logo">Adelaide Artisan Bakery</div>

    <nav>
        <a href="index.php">Home</a>
        <a href="admin.php">Orders</a>
        <a href="products.php">Products</a>
    </nav>

</header>

<section>

    <h1 class="section-title">Manage Products</h1>

    <p style="text-align:center; margin-bottom:25px;">
        <a href="add_product.php" class="button">
            Add New Product
        </a>
    </p>

    <div class="orders-container">

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>

                <?php while ($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo htmlspecialchars($row['id']); ?>
                        </td>

                        <td>
                            <img
                                src="images/<?php echo htmlspecialchars($row['image']); ?>"
                                alt="<?php echo htmlspecialchars($row['name']); ?>"
                                width="100"
                            >
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['description']); ?>
                        </td>

                        <td>
                            $<?php echo number_format($row['price'], 2); ?>
                        </td>

                        <td>

                            <a
                                href="edit_product.php?id=<?php echo $row['id']; ?>"
                                class="button"
                            >
                                Edit
                            </a>

                           <form
    method="POST"
    action="delete_product.php"
    style="display:inline;"
    onsubmit="return confirm('Are you sure you want to delete this product?');"
>
    <input
        type="hidden"
        name="id"
        value="<?php echo $row['id']; ?>"
    >

    <button
        type="submit"
        class="delete-button"
    >
        Delete
    </button>
</form>

                        </td>

                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</section>

<footer>

    <p>© 2026 Adelaide Artisan Bakery. All rights reserved.</p>

</footer>

</body>

</html>

<?php

$conn->close();

?>