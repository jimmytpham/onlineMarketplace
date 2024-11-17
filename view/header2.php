
<!DOCTYPE html>
<html>
<head>
    <Title>Local Marketplace</Title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <header>
        <div class="header-top">
            <h1>Local Marketplace</h1>
            <p>Online Marketplace for buying and selling</p>
        </div>
        <div class="header-bottom">
            <a href="index.php">Home</a>
            <form action="items/browse.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search for items">
                <input type="submit" value="Search">
            </form>
        </div>
    </header>

    <!--include database connection-->
    <?php include 'config/database.php'; ?>

    <?php
    if (isset($_SESSION['userID'])) {
        // Retrieve user information based on session ID
        $userID = $_SESSION['userID'];
        
        $sql = "SELECT * FROM users WHERE userID = '$userID'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "You are logged in as: {$row['userName']}";
        } else {
            echo "Error fetching user information.";
        }
    }
    ?>
<main>