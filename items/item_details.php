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
        $sellerID = $row['userID']; // Get the seller's userID from the item details

        // Get seller's username from the user database based on sellerID
        $sqlSeller = "SELECT userName FROM users WHERE userID = $sellerID";
        $resultSeller = mysqli_query($conn, $sqlSeller);
        $rowSeller = mysqli_fetch_assoc($resultSeller);
        $seller = $rowSeller['userName'];
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
    <p>Seller: <a href="../profile/view_profile.php?itemOwner=<?php echo $seller; ?>"><?php echo $seller; ?></a></p>
    <?php
        if (!empty($pics)) {
            echo '<img src="' . $pics . '" alt="' . $title . '" class="item-image"><br>';
        } else {
            echo '<div class="blank-image"></div><br>'; // Display a blank area if $pics is empty
        }
    ?>

    <a href="../message/send_message.php?itemID=<?php echo $itemID; ?>">Send Message</a><br>
    <button onclick="goBack()">Back</button>
</body>
</html>

<?php include '../view/footer.php'; ?>

<script>
function goBack() {
  window.history.back();
}
</script>
