<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->
<?php include('../view/header.php');

// Check if itemID is provided in the URL
if (isset($_GET['itemID'])) {
    $itemID = mysqli_real_escape_string($conn, $_GET['itemID']);

    // Get item details from the database based on itemID
    $sql = "SELECT * FROM items WHERE itemID = $itemID";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $date = $row['uploadDate'];
        $pics = $row['imageURL'];

    } else {
        echo "Item not found.";
        exit(); 
    }
} else {
    echo "Invalid item ID.";
    exit(); 
}
?>

<head>
    <title><?php echo $title; ?> Details</title>
</head>

<body>
    <h1><?php echo $title; ?></h1>
    <p>Description: <?php echo $description; ?></p>
    <p>Price: <?php echo $price; ?></p>
    <p>Upload Date: <?php echo $date; ?></p>
    <?php
        if (!empty($pics)) {
            echo '<img src="' . $pics . '" alt="' . $title . '" class="item-image"><br>';
        } else {
            echo '<div class="blank-image"></div><br>'; // Display a blank area if picture is empty
        }
    ?>
    <a href="edit_post.php?itemID=<?php echo $itemID; ?>">Edit Post</a><br>
    <a href="../profile/dashboard.php">Go back to Dashboard</a>
</body>
</html>

<?php include '../view/footer.php'; ?>
