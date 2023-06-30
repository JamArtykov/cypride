<?php
session_start();
include('connection.php');

$chatId = $_GET['trip_id'];

$sql = "SELECT chat_id FROM chats WHERE chat_id = $chatId";
$result = mysqli_query($link, $sql);

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

?>  

<!DOCTYPE html>
<html>
<head>
    <title>Chat Window</title>
    <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/sunny/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css"></link>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css"></link>
    <link rel="shortcut icon" type="image/png" href="/images/favicon2.ico">
    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
    <meta property="og:image" content="/images/favicon.png" />
    <style>
body{
  background:transparent;
}

::-webkit-scrollbar {
    width: 10px
}

::-webkit-scrollbar-track {
    background: #eee
}

::-webkit-scrollbar-thumb {
    background: #888
}

::-webkit-scrollbar-thumb:hover {
    background: #555
}

.wrapper {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #651FFF
}

.main {
    background-color: #eee;
    width: 324px;
    position: relative;
    
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    padding: 6px 0px 0px 0px
}

.scroll {
    overflow-y: scroll;
    scroll-behavior: smooth;
    height: 325px
}

.img1 {
    border-radius: 50%;
    background-color: #66BB6A
}

.name {
    font-size: 8px
}

.msg {
    background-color: #fff;
    font-size: 11px;
    padding: 5px;
    border-radius: 5px;
    font-weight: 500;
    color: #3e3c3c
}

.between {
    font-size: 8px;
    font-weight: 500;
    color: #a09e9e
}

.navbar {
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
}

.form-control {
    font-size: 12px;
    font-weight: 400;
    width: 230px;
    height: 30px;
    border: none
}

form-control: focus {
    box-shadow: none;
    overflow: hidden;
    border: none
}

.form-control:focus {
    box-shadow: none !important
}

.icon1 {
    color: #7C4DFF !important;
    font-size: 18px !important;
    cursor: pointer
}

.icon2 {
    color: #512DA8 !important;
    font-size: 18px !important;
    position: relative;
    left: 8px;
    padding: 0px;
    cursor: pointer
}

.icondiv {
    border-radius: 50%;
    width: 15px;
    height: 15px;
    padding: 2px;
    position: relative;
    bottom: 1px
}

#wrapper {
            background: none !important;
            padding: 0;
            margin: 0;
            box-shadow: none;
}
.chatnavbar {
            height: 20px;
            width: 320px;
            background-color: gray;
            color: black;
            cursor: pointer;
            position: fixed;
            top: 0;
            transition: top 0.3s ease;
            }

    </style>

</head>
<body>
<script src='https://kit.fontawesome.com/49abe375a7.js' crossorigin='anonymous'></script>


        <div class="main">
            <div id="chat-messages" class="px-2 scroll">
                <?php foreach ($messages as $message) : ?>
                    <div class="d-flex align-items-center <?php echo ($_SESSION['user_id'] == $message['user_id']) ? 'justify-content-end' : ''; ?>">
                        <div class="text-left pr-1">
                            <img src="<?php echo $message['profilepicture']; ?>" width="30" class="img1">
                        </div>
                        <div class="pr-2 pl-1">
                            <span class="name"><?php echo $message['full_name']; ?></span>
                            <p class="msg"><?php echo $message['message']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <nav class="navbar bg-white navbar-expand-sm d-flex justify-content-between">
                <input type="text" id="message-input" class="form-control" placeholder="Type a message...">
                <button id="geolocation-button" class="btn btn-primary" style="margin-right:2px;">
                    <i class="fas fa-location-arrow"></i>
                </button>
                <button id="send-button" class="btn btn-primary" style="margin-right:2px;">→</button>
            </nav>
        </div>
    








    <script>
        $(document).ready(function () {
            var chatMessages = $('#chat-messages');
            var chatId = <?php echo $chatId; ?>;
            var messages = <?php echo json_encode($messages); ?>;

            
            


            // Function to render messages in the chat window
            function renderMessages() {
                chatMessages.empty();

                $.each(messages, function (index, message) {
                    var alignmentClass = (message.user_id == <?php echo $_SESSION['user_id']; ?>) ? 'justify-content-end' : '';
                    var messageElement = $('<div class="d-flex align-items-center ' + alignmentClass + '">' +
                        '<div class="text-left pr-1">' +
                        '<img src="' + message.profilepicture + '" width="30" class="img1">' +
                        '</div>' +
                        '<div class="pr-2 pl-1">' +
                        '<span class="name">' + message.full_name + '</span>' +
                        '<p class="msg">' + message.message + '</p>' +
                        '</div>' +
                        '</div>');

                    chatMessages.append(messageElement);
                });

                chatMessages.scrollTop(chatMessages.prop('scrollHeight'));
            }

            // Function to load messages from the server
            function loadMessages() {
                $.ajax({
                    url: 'loadnewmessages.php',
                    type: 'GET', // Send the request via GET method
                    data: { chat_id: chatId },
                    dataType: 'json',
                    success: function (response) {
                        messages = response.messages; 
                        renderMessages();
                        console.log(messages);
                        console.log("xsd");
                    }
                });
            }

            // Function to send a new message
            function sendMessage() {
                var messageInput = $('#message-input');
                var message = messageInput.val().trim();

                if (message === '') {
                    alert('Please enter a message.');
                    return;
                }

                $.ajax({
                    url: 'createmessages.php',
                    type: 'POST',
                    data: { chat_id: chatId, message: message },
                    success: function (response) {
                        console.log("Message sent");
                        messageInput.val('');
                        loadMessages();
                    }
                });
                
                
            }

            // Send button click event listener
            $('#send-button').click(function () {
                console.log("Send button clicked");
                sendMessage();
            });

            // Enter key press event listener for sending messages
            $('#message-input').keypress(function (e) {
                if (e.which === 13) {
                    sendMessage();
                    return false;
                }
            });

            // Polling interval
            var pollingInterval = 3000;
            setInterval(loadMessages, pollingInterval);

            // Initial load of messages
            loadMessages();

            $('#geolocation-button').click(function () {
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;
                        var mapLink = 'https://www.google.com/maps?q=' + latitude + ',' + longitude;
                        var message = 'Here is my current location: <a href="' + mapLink + '" target="_blank">Open in Google Maps</a>';
                        console.log(message);
                        sendGeoMessage(message); // Call the sendMessage function with the location message
                    }, function (error) {
                        console.log("Geolocation error:", error);
                    });
                } else {
                    console.log("Geolocation is not supported by this browser.");
                }
            });

            function sendGeoMessage(message) {
                $.ajax({
                    url: 'createmessages.php',
                    type: 'POST',
                    data: { chat_id: chatId, message: message },
                    success: function (response) {
                        console.log("Message sent");
                        loadMessages();
                    }
                });
            }
        });
        
        
    </script>






</body>
</html>


