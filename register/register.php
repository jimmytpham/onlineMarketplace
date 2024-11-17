<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->

<?php include '../view/header.php';

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $registration_date = date('Y-m-d'); // Current date for registration date

    // Check if username or email already exists
    $sql_check = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result_check = mysqli_query($conn, $sql_check);


    if (mysqli_num_rows($result_check) > 0) {
        // Error if Username or email already in use
        $_SESSION['error'] = "Username or email already in use.";
    } else {

        // Insert user data into the database
        $sql = "INSERT INTO users (username, email, password, phone, registrationDate) 
                VALUES ('$username', '$email', '$password', '$phone', '$registration_date')";

        if(mysqli_query($conn, $sql)){
            $_SESSION['userID'] = mysqli_insert_id($conn); // Get the last inserted user ID
            $_SESSION['username'] = $username;
            header("Location: register_success.php");
            exit(); 
        } else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Close database connection
mysqli_close($conn);
?>

<head>
    <title>Register</title>
</head>
<body>
    <h1>User Registration</h1>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color: red;'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']); 
    }
    ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required><br>

            <input type="submit" value="Register">
    </form>
</body>
</html>

<?php include '../view/footer.php'?>


