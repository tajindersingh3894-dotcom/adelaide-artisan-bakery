<?php

session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $order_id = $_POST["order_id"];
    $status = $_POST["status"];

    $stmt = $conn->prepare(
        "UPDATE orders SET status = ? WHERE id = ?"
    );

    $stmt->bind_param("si", $status, $order_id);

    $stmt->execute();

    $stmt->close();
}

$result = $conn->query(
    "SELECT * FROM orders ORDER BY order_date DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Orders - Adelaide Artisan Bakery</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<header>

    <div class="logo">Adelaide Artisan Bakery</div>

    <nav>
        <a href="index.php">Home</a>
        <a href="admin.php">Orders</a>
        <a href="products.php">Products</a>
        <a href="logout.php">Logout</a>
    </nav>

</header>

<section>

    <h1 class="section-title">Customer Orders</h1>

    <div class="orders-container">

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Notes</th>
                    <th>Date</th>
                    <th>status</th>
                </tr>

            </thead>

            <tbody>

                <?php while ($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td><?php echo htmlspecialchars($row['id']); ?></td>

                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>

                        <td><?php echo htmlspecialchars($row['email']); ?></td>

                        <td><?php echo htmlspecialchars($row['product']); ?></td>

                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>

                        <td><?php echo htmlspecialchars($row['message']); ?></td>

                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>

                        <td>

    <form method="POST">

        <input
            type="hidden"
            name="order_id"
            value="<?php echo $row['id']; ?>"
        >

        <select name="status">

            <option value="Pending"
                <?php if ($row['status'] === 'Pending') echo 'selected'; ?>>
                Pending
            </option>

            <option value="Preparing"
                <?php if ($row['status'] === 'Preparing') echo 'selected'; ?>>
                Preparing
            </option>

            <option value="Completed"
                <?php if ($row['status'] === 'Completed') echo 'selected'; ?>>
                Completed
            </option>

        </select>

        <button type="submit">Update</button>

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