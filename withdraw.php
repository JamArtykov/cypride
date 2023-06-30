<?php
session_start();
include('connection.php');
if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}

$user_id = $_SESSION['user_id'];
$withdraw = $_POST['withdraw-amount'];

// Update the wallet balance
$sql_update_wallet = "UPDATE wallet SET balance = balance - $withdraw WHERE user_id = $user_id";
$result_update_wallet = mysqli_query($link, $sql_update_wallet);

if ($result_update_wallet) {
    // Insert a new record in the transactions table for the withdrawal
    $sql_insert_transaction = "INSERT INTO transactions (user_id, type, amount) VALUES ($user_id, 'withdrawal', $withdraw)";
    $result_insert_transaction = mysqli_query($link, $sql_insert_transaction);

    if ($result_insert_transaction) {
        echo "Withdrawal recorded successfully!";
    } else {
        echo "Error recording withdrawal: " . mysqli_error($link);
    }
} else {
    echo "Error updating wallet balance: " . mysqli_error($link);
}
?>
