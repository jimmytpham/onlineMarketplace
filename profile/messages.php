<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->

<?php include('../view/header.php');

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

// Get user's messages from the database
$userID = $_SESSION['userID'];
$sql = "SELECT m.*, i.itemID AS itemID, i.title AS itemTitle
        FROM messages m
        INNER JOIN items i ON m.itemID = i.itemID
        WHERE (m.senderID = $userID OR m.receiverID = $userID)
        GROUP BY m.senderID, m.receiverID, m.itemID
        ORDER BY m.messageDate DESC";

$result = mysqli_query($conn, $sql);
?>

<head>
    <title>Messages</title>
</head>

<body>
    <h1>Messages</h1>
    <div class="message-container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $itemID = $row['itemID'];
                $itemTitle = $row['itemTitle'];
                $messageID = $row['messageID'];
                $senderID = $row['senderID']; 
                $receiverID = $row['receiverID'];
                $messageContent = $row['messageContent'];
                $messageDate = $row['messageDate'];

                // other user's ID and username 
                $otherUserID = ($senderID == $userID) ? $receiverID : $senderID;
                $sqlUser = "SELECT userName FROM users WHERE userID = $otherUserID";
                $resultUser = mysqli_query($conn, $sqlUser);
                $rowUser = mysqli_fetch_assoc($resultUser);
                $otherUsername = $rowUser['userName'];

                // Display the message
                echo "<div class='message'>";
                echo "<p><strong>Item: </strong>$itemTitle</p>";
                echo "<p><strong>From: </strong>$otherUsername</p>";
                echo "<p><strong>Date: </strong>$messageDate</p>";
                echo "<p><strong>Message: </strong>$messageContent</p>";
                echo "<a href='../message/message_convo.php?itemID=$itemID&senderID=$senderID&receiverID=$receiverID'>View Conversation</a>";
                echo "</div>";
            }
        } else {
            echo "No messages found.";
        }
        ?>
    </div>

    <a href="../index.php">Go back to Main page</a>
</body>
</html>

<?php include '../view/footer.php'; ?>
