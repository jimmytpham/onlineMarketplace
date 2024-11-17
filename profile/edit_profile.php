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

// Get user information
$userID = $_SESSION['userID'];
$sql = "SELECT * FROM users WHERE UserID = $userID";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['userName'];
    $email = $row['email'];
    $phone = $row['phone'];
    $password = $row['password'];
} else {
    echo "User not found.";
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data 
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $newPhone = mysqli_real_escape_string($conn, $_POST['phone']);
    $newPassword =  mysqli_real_escape_string($conn, $_POST['password']);

    // Update user details in the database
    $sqlUpdate = "UPDATE users SET username = '$newUsername', password = '$newPassword' , email = '$newEmail', phone = '$newPhone' WHERE UserID = $userID";
    if (mysqli_query($conn, $sqlUpdate)) {
        echo "Profile updated successfully.";
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>


<head>
    <title>Edit Profile</title>
</head>

<body>
    <h1>Edit Profile</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required><br><br>

        <label for="password">Password:</label>
        <input type="text" id="password" name="password" value="<?php echo $password; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br><br>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required><br><br>

        <input type="submit" value="Update"><br>
    </form>
    <a href="profile.php">Cancel</a>
</body>
</html>

<?php include '../view/footer.php'; ?>