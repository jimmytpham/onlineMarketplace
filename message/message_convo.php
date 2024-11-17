<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->

<?php include '../view/header.php';

// Redirect to login page if user is not logged in
if (!isset($_SESSION['userID'])) {
    header("Location: ../login_out/login.php");
    exit();
}

// Initialize 
$messageContent = '';
$senderID = '';
$receiverID = '';
$itemID = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $senderID = $_POST['senderID'];
    $receiverID = $_POST['receiverID'];
    $itemID = $_POST['itemID'];
    $messageContent = mysqli_real_escape_string($conn, $_POST['messageContent']);

    // Get today's date in Format: YYYY-MM-DD HH:MM:SS
    $messageDate = date("Y-m-d H:i:s"); 

    // Determine the type based on user and itemID
    // 0 = buyer, 1 = seller
    $type = 0; 
    if ($receiverID == $_SESSION['userID']) {
        $type = 1;
    }

    // insert data into database
    $sql = "INSERT INTO messages (itemID, receiverID, senderID, messageContent, messageDate, type)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "iiissi", $itemID, $receiverID, $senderID, $messageContent, $messageDate, $type);
        
        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Reset messageContent 
            $messageContent = '';
            // Construct the URL with userID parameters
            $redirect_url = "message_convo.php?senderID=$senderID&receiverID=$receiverID&itemID=$itemID";

            // Reload while keeping userID parameters
            header("Location: $redirect_url");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: Unable to prepare the SQL statement.";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}
// Check if URL parameters are set
if (isset($_GET['itemID'], $_GET['senderID'], $_GET['receiverID'])) {
    // Get URL parameters
    $itemID = $_GET['itemID'];
    $senderID = $_GET['senderID'];
    $receiverID = $_GET['receiverID'];

    // Get item title from itemID
    $sqlItem = "SELECT title FROM items WHERE itemID = $itemID";
    $resultItem = mysqli_query($conn, $sqlItem);
    if ($resultItem && mysqli_num_rows($resultItem) > 0) {
        $rowItem = mysqli_fetch_assoc($resultItem);
        $itemTitle = $rowItem['title'];
    }
}

?>

<head>
    <title>Conversation</title>
</head>
<body>

<h2>Conversation</h2>

<div id="conversation">
<?php
// Get conversation details
$sql = "SELECT m.*, u_sender.userName AS senderName, u_receiver.userName AS receiverName
        FROM messages m
        INNER JOIN users u_sender ON m.senderID = u_sender.userID
        INNER JOIN users u_receiver ON m.receiverID = u_receiver.userID
        WHERE m.itemID = $itemID
        ORDER BY m.messageDate ASC";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messageContent = $row['messageContent'];
        $messageDate = $row['messageDate'];
        $sender = $row['type'];

        //if type = 1, show the seller name, if type = 0, show the buyer name
        echo "<p><strong>" . ($row['type'] == 1 ? $row['receiverName'] : $row['senderName']) . ":</strong> $messageContent ($messageDate)</p>";
    }
} else {
    echo "<p>No messages found.</p>";
}
?>
</div>

<h3>Reply</h3>

<form id="conversation-container" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="senderID" value="<?php echo $senderID; ?>">
    <input type="hidden" name="receiverID" value="<?php echo $receiverID; ?>">
    <input type="hidden" name="itemID" value="<?php echo $itemID; ?>">
    <textarea name="messageContent" required><?php echo htmlspecialchars($messageContent); ?></textarea><br>
    <input type="submit" value="Send Reply"><br>
</form>

<a href="../profile/messages.php">Back To Messages</a>

</body>
<?php include '../view/footer.php'; ?>
