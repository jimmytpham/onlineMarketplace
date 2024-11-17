<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->

<?php include '../view/header.php';

// Redirect to login page if user is not logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

// Get user information from the database
$userID = $_SESSION['userID'];
$sqlUser = "SELECT username, email, phone FROM users WHERE userID = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $userID);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser->num_rows > 0) {
    $rowUser = $resultUser->fetch_assoc();
    $username = $rowUser['username'];
    $email = $rowUser['email'];
    $phone = $rowUser['phone'];
}

// Get posted items
$sqlItems = "SELECT * FROM items WHERE userID = ?";
$stmtItems = $conn->prepare($sqlItems);
$stmtItems->bind_param("i", $userID);
$stmtItems->execute();
$resultItems = $stmtItems->get_result();

// Get messages 
$sqlMessages = "SELECT m.*, 
    i.itemID AS itemID,
    i.title AS itemTitle,
    i.userID AS itemOwnerID,
    u_owner.userName AS itemOwnerUsername
    FROM messages m
    INNER JOIN items i ON m.itemID = i.itemID
    INNER JOIN users u_owner ON i.userID = u_owner.userID
    WHERE m.senderID = ? OR m.receiverID = ?
    ORDER BY m.messageDate ASC";

$stmtMessages = $conn->prepare($sqlMessages);
$stmtMessages->bind_param("ii", $userID, $userID);
$stmtMessages->execute();
$resultMessages = $stmtMessages->get_result();

// Group by sender, receiver, and itemID
$groupedMessages = [];
if ($resultMessages->num_rows > 0) {
    while ($row = $resultMessages->fetch_assoc()) {
        $senderID = $row['senderID'];
        $receiverID = $row['receiverID'];
        $itemID = $row['itemID'];
        $itemOwnerID = $row['itemOwnerID'];

        // Get sender's name from the users table
        $sqlSender = "SELECT userName FROM users WHERE userID = $senderID";
        $resultSender = mysqli_query($conn, $sqlSender);
        $rowSender = mysqli_fetch_assoc($resultSender);
        $senderName = $rowSender['userName'];

        $groupKey = $senderID . '-' . $receiverID . '-' . $itemID;
        if (!isset($groupedMessages[$groupKey])) {
            $groupedMessages[$groupKey] = [];
        }

        $row['senderName'] = $senderName; 
        $groupedMessages[$groupKey][] = $row;
    }
}
?>

<main>
    <body>
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <p>Email: <?php echo $email; ?></p>
        <p>Phone Number: <?php echo $phone; ?></p>

        <h3>Overview of Your Posted Items</h3>
            <?php
            if ($resultItems->num_rows > 0) {
                while ($row = $resultItems->fetch_assoc()) {
                    echo "<p><a href='../items/seller_item_details.php?itemID={$row['itemID']}'>{$row['title']} - {$row['description']}</a></p>";
                }
            } else {
                echo "<p>No items posted yet.</p>";
            }
                echo "<p><a href='../items/new_item.php'>Post New Item</a></p>";
            ?>

        <h4>Messages</h4>
            <?php
            if (!empty($groupedMessages)) {
                foreach ($groupedMessages as $groupKey => $group) {
                    list($senderID, $receiverID, $itemID) = explode('-', $groupKey);
                    echo "<div class='message-divider'>";
                    echo "<p>Item: <a href='../items/seller_item_details.php?itemID={$itemID}'>{$group[0]['itemTitle']}</a></p>";
                    foreach ($group as $index => $message) {
                        if ($index === count($group) - 1) { // Show last message in the chat
                            echo "<p>Message: <a href='../message/message_convo.php?itemID={$itemID}&senderID={$senderID}&receiverID={$receiverID}'>{$message['messageContent']}</a></p>";
                        }
                    }
                    echo "</div>";
                }
            } else {
                echo "No messages found.<br>";
            }
            ?>
        <a href="../index.php">Back</a>
    </body>
</main>

<?php include '../view/footer.php'; ?>
