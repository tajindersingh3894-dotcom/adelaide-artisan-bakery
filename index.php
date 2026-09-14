<?php

require_once "db.php";

$products = $conn->query(
    "SELECT id, name, description, price, image
     FROM products
     ORDER BY id ASC"
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Adelaide Artisan Bakery</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <div class="logo">Adelaide Artisan Bakery</div>

    <nav>
        <a href="#">Home</a>
        <a href="#products">Products</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
        <a href="login.php">Admin Login</a>
    </nav>
</header>

<section class="hero">

    <div class="hero-content">

        <h1>Freshly Baked, Made With Love</h1>

        <p>
            Enjoy delicious artisan bread, pastries and cakes
            freshly baked every day in Adelaide.
        </p>

        <a href="#products" class="button">View Our Products</a>

    </div>

</section>

<section id="products">

    <h2 class="section-title">Our Popular Products</h2>

    <div class="products">

        <?php while ($product = $products->fetch_assoc()): ?>

            <div class="product">

                <img
                    src="images/<?php echo htmlspecialchars($product['image']); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                >

                <h3>
                    <?php echo htmlspecialchars($product['name']); ?>
                </h3>

                <p>
                    <?php echo htmlspecialchars($product['description']); ?>
                </p>

                <p>
                    <strong>
                        $<?php echo number_format($product['price'], 2); ?>
                    </strong>
                </p>

            </div>

        <?php endwhile; ?>

    </div>

</section>

<section id="about">

    <h2 class="section-title">About Us</h2>

    <p>
        Adelaide Artisan Bakery is a local bakery focused on providing
        fresh and high-quality baked products to the Adelaide community.
        Our products are prepared with care using quality ingredients.
    </p>

</section>

<section id="contact">

    <h2 class="section-title">Place an Order</h2>

    <form action="order.php" method="POST" class="order-form">

        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required>

        <label for="product">Select Product</label>
        <select id="product" name="product" required>

    <option value="">-- Select a product --</option>

    <?php

    $order_products = $conn->query(
        "SELECT name, price
         FROM products
         ORDER BY name ASC"
    );

    while ($product = $order_products->fetch_assoc()):

    ?>

        <option value="<?php echo htmlspecialchars($product['name']); ?>">

            <?php echo htmlspecialchars($product['name']); ?>
            -
            $<?php echo number_format($product['price'], 2); ?>

        </option>

    <?php endwhile; ?>

</select>

        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity" min="1" max="20" required>

        <label for="message">Additional Notes</label>
        <textarea id="message" name="message" rows="4"></textarea>

        <button type="submit" class="button">Submit Order</button>

    </form>

</section>
<footer>

    <p>© 2026 Adelaide Artisan Bakery. All rights reserved.</p>

</footer>

<?php

$conn->close();

?>

</body>
</html>