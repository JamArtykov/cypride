<?php
session_start();
include('connection.php');

if (isset($_POST['chat_id']) && isset($_POST['message'])) {
    $chatId = $_POST['chat_id'];
    $message = $_POST['message'];

    // Insert the new message into the database
    $userId = $_SESSION['user_id'];
    $sql = "INSERT INTO chat_messages (chat_id, user_id, message) VALUES ('$chatId', '$userId', '$message')";
    $result = mysqli_query($link, $sql);


    if ($result) {
        echo "Message saved successfully.";
    } else {
        $errorMessage = "Error saving message: " . mysqli_error($link);
        error_log($errorMessage, 3, "debug.log");
    }
}
?>
