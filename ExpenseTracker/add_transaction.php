<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Fixed the typo
    $date = $_POST['date'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];

    // Fixed missing comma between values
    $sql = "INSERT INTO transactions (user_id, date, description, category, type, amount)
            VALUES ('$user_id', '$date', '$description', '$category', '$type', '$amount')";

    if ($connection->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<div class='alert alert-danger text-center'>Error Adding Transactions</div>";
    }
}
?>
