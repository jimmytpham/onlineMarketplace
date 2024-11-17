<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->

<?php
include('../view/header.php');


// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

// Get user information from the database
$userID = $_SESSION['userID'];
$sql = "SELECT * FROM users WHERE UserID = $userID";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['userName'];
    $email = $row['email'];
    $phone = $row['phone'];
} else {
    echo "User not found.";
    exit();
}
?>

<head>
    <title>Profile</title>
</head>

<body>
    <h1>Profile</h1>
    <p>Username: <?php echo $username; ?></p>
    <p>Email: <?php echo $email; ?></p>
    <p>Phone Number: <?php echo $phone; ?></p>

    <!-- Edit Profile button -->
    <a href="edit_profile.php">Edit Profile</a><br>
    <a href="../index.php">Back</a>
</body>
</html>

<?php include '../view/footer.php'; ?>
