<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->

<?php include '../view/header.php'; 

// Check if userID or itemOwner is provided in the URL / for different pages
if (isset($_GET['userID']) || isset($_GET['itemOwner']))  {
    if (isset($_GET['userID'])) {
        $userID = mysqli_real_escape_string($conn, $_GET['userID']);
        // Get user's information from the database
        $sqlUser = "SELECT userName, email, phone FROM users WHERE userID = '$userID'";
        $resultUser = mysqli_query($conn, $sqlUser);
     
        if ($resultUser && mysqli_num_rows($resultUser) == 1) {
            $rowUser = mysqli_fetch_assoc($resultUser);
            $userName = $rowUser['userName'];
            $email = $rowUser['email'];
            $phone = $rowUser['phone'];
        } else {
            echo "User not found.";
            exit(); 
        }
    }
    
    if (isset($_GET['itemOwner'])) {
        $itemOwner = mysqli_real_escape_string($conn, $_GET['itemOwner']);
        // Get sender's information
        $sqlUser = "SELECT userName, email, phone FROM users WHERE userName = '$itemOwner'"; 
        $resultUser = mysqli_query($conn, $sqlUser);
        if ($resultUser && mysqli_num_rows($resultUser) == 1) {
            $rowUser = mysqli_fetch_assoc($resultUser);
            $userName = $rowUser['userName'];
            $email = $rowUser['email'];
            $phone = $rowUser['phone'];
        } else {
            echo "Sender not found.";
            exit();
        }
    }
} else {
    echo "Invalid UserID.";
    exit(); 
}
?>

<head>
    <title>View Profile</title>
</head>
<body>
    <h2>Sender's Profile</h2>
    <p>Name: <?php echo $userName; ?></p>
    <p>Email: <?php echo $email; ?></p>
    <p>Phone Number: <?php echo $phone; ?></p>
    <button onclick="goBack()">Back</button>
</body>
</html>

<script>
function goBack() {
  window.history.back();
}
</script>