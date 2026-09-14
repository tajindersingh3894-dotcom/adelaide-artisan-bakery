<?php

require_once "db.php";

$errors = [];

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$product = trim($_POST["product"] ?? "");
$quantity = $_POST["quantity"] ?? "";
$message = trim($_POST["message"] ?? "");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");
    exit;

}

/* Validate name */
if ($name === "") {

    $errors[] = "Full name is required.";

} elseif (strlen($name) > 100) {

    $errors[] = "Full name must be 100 characters or less.";

}

/* Validate email */
if ($email === "") {

    $errors[] = "Email address is required.";

} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    $errors[] = "Please enter a valid email address.";

}

/* Validate product */
if ($product === "") {

    $errors[] = "Please select a product.";

} else {

    $stmt = $conn->prepare(
        "SELECT id FROM products WHERE name = ?"
    );

    $stmt->bind_param("s", $product);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {

        $errors[] = "The selected product is not available.";

    }

    $stmt->close();
}

/* Validate quantity */
if (
    filter_var($quantity, FILTER_VALIDATE_INT) === false ||
    (int)$quantity < 1 ||
    (int)$quantity > 20
) {

    $errors[] = "Quantity must be a whole number between 1 and 20.";

} else {

    $quantity = (int)$quantity;

}

/* Validate message */
if (strlen($message) > 500) {

    $errors[] = "Additional notes must be 500 characters or less.";

}


/* If there are errors, show them */
if (!empty($errors)) {

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Error - Adelaide Artisan Bakery</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<section>

    <h1 class="section-title">Please Correct Your Order</h1>

    <div
        role="alert"
        aria-live="assertive"
        tabindex="-1"
    >

        <h2>There were some errors:</h2>

        <ul>

            <?php foreach ($errors as $error): ?>

                <li>
                    <?php echo htmlspecialchars($error); ?>
                </li>

            <?php endforeach; ?>

        </ul>

    </div>

    <p style="text-align:center; margin-top:25px;">

        <a href="index.php#contact" class="button">
            Return to Order Form
        </a>

    </p>

</section>

</body>

</html>

<?php

    exit;
}


/* Save valid order */
$stmt = $conn->prepare(
    "INSERT INTO orders
    (customer_name, email, product, quantity, message)
    VALUES (?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "sssis",
    $name,
    $email,
    $product,
    $quantity,
    $message
);

if (!$stmt->execute()) {

    die("Unable to save your order. Please try again.");

}

$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Submitted - Adelaide Artisan Bakery</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<section>

    <h1 class="section-title">Order Submitted Successfully</h1>

    <div class="order-form">

        <p>Thank you, <?php echo htmlspecialchars($name); ?>.</p>

        <p>Your order has been received successfully.</p>

        <p>
            <strong>Product:</strong>
            <?php echo htmlspecialchars($product); ?>
        </p>

        <p>
            <strong>Quantity:</strong>
            <?php echo htmlspecialchars($quantity); ?>
        </p>

        <p>
            <strong>Email:</strong>
            <?php echo htmlspecialchars($email); ?>
        </p>

        <?php if ($message !== ""): ?>

            <p>
                <strong>Additional Notes:</strong>
                <?php echo htmlspecialchars($message); ?>
            </p>

        <?php endif; ?>

        <p style="margin-top:20px;">

            <a href="index.php" class="button">
                Return to Home
            </a>

        </p>

    </div>

</section>

</body>

</html>