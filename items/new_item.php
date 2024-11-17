<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->
<?php include '../view/header.php';

// Get categories from the database
$sqlCategories = "SELECT categoryID, categoryName FROM categories";
$resultCategories = mysqli_query($conn, $sqlCategories);
$categories = [];
while ($rowCategory = mysqli_fetch_assoc($resultCategories)) {
    $categories[$rowCategory['categoryID']] = $rowCategory['categoryName'];
}

// Processing form when submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $categoryID = $_POST['category'];

    include 'handle_image.php';

    // Close database connection
    mysqli_close($conn);
}
?>


<head>
    <title>Add New Item</title>
</head>
<body>
<h1>Add New Item</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*"><br>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="">Select a category</option>
            <?php foreach ($categories as $categoryId => $categoryName) : ?>
                <option value="<?php echo $categoryId; ?>"><?php echo $categoryName; ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Submit"><br>
        <a href="../index.php">Cancel</a>
    </form>
</body>

<?php include '../view/footer.php'; ?>
