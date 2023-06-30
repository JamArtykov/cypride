<?php
session_start();
include('connection.php');

if (isset($_GET['chat_id'])) {
    $chatId = $_GET['chat_id'];

    // Retrieve messages for the given chat ID
    $sqlMessages = "SELECT m.message_id, m.message, m.timestamp, u.profilepicture, CONCAT(u.first_name, ' ', u.last_name) AS full_name, u.user_id
                    FROM chat_messages m
                    INNER JOIN users u ON m.user_id = u.user_id
                    WHERE m.chat_id = $chatId
                    ORDER BY m.timestamp ASC";

    $resultMessages = mysqli_query($link, $sqlMessages);

    $messages = array();

    while ($row = mysqli_fetch_assoc($resultMessages)) {
        $message = array(
            'message_id' => $row['message_id'],
            'message' => $row['message'],
            'timestamp' => $row['timestamp'],
            'profilepicture' => $row['profilepicture'],
            'full_name' => $row['full_name'],
            'initial_profilepicture' => $row['profilepicture'],
            'initial_full_name' => $row['full_name'],
            'user_id' => $row['user_id']
        );
        $messages[] = $message;
}

    // Return the messages as JSON
    echo json_encode(array('messages' => $messages));
}
?>