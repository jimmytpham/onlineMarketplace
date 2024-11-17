<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->

<?php include '../view/header.php';

// Check if itemID is provided in the URL
if (isset($_GET['itemID'])) {
    $itemID = mysqli_real_escape_string($conn, $_GET['itemID']);

    // Get item details from the database based on itemID
    $sql = "SELECT * FROM items WHERE ItemID = $itemID";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
    } else{
        echo "Item not found.";
        exit();
    }
} else {
    echo "Invalid item ID.";
    exit(); 
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $newTitle = mysqli_real_escape_string($conn, $_POST['title']);
    $newDescription = mysqli_real_escape_string($conn, $_POST['description']);
    $newPrice = mysqli_real_escape_string($conn, $_POST['price']);

    // Update item details in the database
    $sqlUpdate = "UPDATE items SET title = '$newTitle', description = '$newDescription', price = '$newPrice' WHERE itemID = $itemID";
    if (mysqli_query($conn, $sqlUpdate)) {
        header("Location: seller_item_details.php?itemID=$itemID");
        exit();
    } else {
        echo "Error updating item details: " . mysqli_error($conn);
    }
}
?>

<head>
    <title>Edit Item</title>
</head>

<body>
    <h1>Edit Item</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?itemID=' . $itemID; ?>" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $title; ?>" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $description; ?></textarea><br><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo $price; ?>" step="0.01" required><br><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*"><br>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="">Select a category</option>
            <?php foreach ($categories as $categoryId => $categoryName) : ?>
                <option value="<?php echo $categoryId; ?>"><?php echo $categoryName; ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Update"><br>
    </form>
    
    <a href="../profile/dashboard.php">Go back to Dashboard</a>
</body>
</html>

<?php include '../view/footer.php'; ?>
