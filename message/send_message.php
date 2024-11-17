<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->

<?php include '../view/header.php';

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: ../login_out/login.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['itemID'])) {
    // Get logged-in userID as senderID
    $senderID = $_SESSION['userID'];

    // Get itemID from the form
    $itemID = $_POST['itemID'];

    // Get receiverID from the database based on itemID
    $query = "SELECT userID FROM items WHERE itemID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $itemID); // "i" indicates that itemID is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $receiverID = $row['userID']; // Set receiverID to the item owner's userID

        $messageContent = $_POST['messageContent'];

        // Get today's date in Format: YYYY-MM-DD HH:MM:SS
        $messageDate = date("Y-m-d H:i:s");

        // Insert message into messages table
        $sql = "INSERT INTO messages (itemID, senderID, receiverID, messageContent, messageDate) 
            VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiss", $itemID, $senderID, $receiverID, $messageContent, $messageDate);

        if ($stmt->execute()) {
            // Reset messageContent 
            $messageContent = '';
            // Construct the URL with same parameters
            $redirect_url = "message_convo.php?senderID=$senderID&receiverID=$receiverID&itemID=$itemID";

            // Reload page with same parameters
            header("Location: $redirect_url");
            exit();
        } else {
            echo "Error sending message.";
        }
    } else {
        echo "Error: Item not found.";
    }
}
?>

<head>
    <title>Send Message</title>
</head>

<body>
    <h1>Send Message</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="messageContent">Message:</label>
        <textarea id="messageContent" name="messageContent" rows="4" required></textarea><br><br>
        <input type="hidden" name="itemID" value="<?php echo htmlspecialchars($_GET['itemID']); ?>">
        <input type="submit" value="Send"><br>
    </form>
    <button onclick="goBack()">Back</button>
</body>
</html>

<?php include '../view/footer.php'; ?>

<script>
function goBack() {
  window.history.back();
}
</script>
