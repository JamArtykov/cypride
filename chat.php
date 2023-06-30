<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the chat ID from the request
    $chatId = $_POST['chat_id'];

    // Fetch the messages for the chat ID
    $sql = "SELECT m.message_id, m.message, m.timestamp, u.profilepicture, CONCAT(u.first_name, ' ', u.last_name) AS full_name
            FROM chat_messages m
            INNER JOIN users u ON m.user_id = u.user_id
            WHERE m.chat_id = $chatId
            ORDER BY m.timestamp ASC";

    $resultMessages = mysqli_query($link, $sql);

    $messages = array();

    while ($row = mysqli_fetch_assoc($resultMessages)) {
        $message = array(
            'message_id' => $row['message_id'],
            'message' => $row['message'],
            'timestamp' => $row['timestamp'],
            'profilepicture' => $row['profilepicture'],
            'full_name' => $row['full_name']
        );
        $messages[] = $message;
    }

    // Return the messages as JSON
    header('Content-Type: application/json');
    echo json_encode($messages);
}
?>
