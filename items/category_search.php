<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->
<?php
// Get categories from database
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Dropdown menu
    echo '<div class="category-menu">';
    echo '<form action="" method="GET">';
    echo '<select name="category">';
    echo '<option value="">All Categories</option>'; //Default line

    // Display categories
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['categoryID'] . '">' . $row['categoryName'] . '</option>';
    }
    // End dropdown menu
    echo '</select>';
    echo '<input type="submit" value="Filter">';
    echo '</form>';
    echo '</div><br>';
} else {
    echo '<p>No categories available.</p>';
}

// Check if search query is provided
if(isset($_GET['search']) && !empty($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    
    // Query to search for items based on title or description
    $sql = "SELECT * FROM Items WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
    $result = $conn->query($sql);
} elseif (isset($_GET['category']) && !empty($_GET['category'])) {
    $categoryID = mysqli_real_escape_string($conn, $_GET['category']);
    $sql = "SELECT * FROM items WHERE categoryID = '$categoryID'";
} else {
    // Query to get items for the homepage
    $sql = "SELECT * FROM Items ORDER BY uploadDate DESC LIMIT 10";
    $result = $conn->query($sql);
}
// Execute the query
$result = $conn->query($sql);
?>