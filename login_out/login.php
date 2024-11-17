<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->
<?php include '../view/header.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];


    // Check if the username and password match in the database
    $sql = "SELECT * FROM users WHERE Username = '$username' AND Password = '$password'";
    $result = mysqli_query($conn, $sql);
    
    // Check if username and password are correct
    if (mysqli_num_rows($result) == 1) {
        // Set session variables for logged-in user
        $row = mysqli_fetch_assoc($result);
        $_SESSION['userID'] = $row['userID'];
        $_SESSION['username'] = $row['username'];

        // Redirect upon successful login
        header("Location: ../index.php");
        exit(); 
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php
    // Display error message in red
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>

<?php include '../view/footer.php';?>
