<?php

session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header("Location: products.php?error=invalid_id");
    exit;
}

$stmt = $conn->prepare(
    "DELETE FROM products WHERE id = ?"
);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    $stmt->close();
    $conn->close();

    header("Location: products.php?success=deleted");
    exit;

} else {

    $stmt->close();
    $conn->close();

    header("Location: products.php?error=delete_failed");
    exit;
}

?>