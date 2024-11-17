<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->

<?php
include '../view/header.php';

//category and search bar function
include 'category_search.php';

// Check if there are items available
if ($result->num_rows > 0) {
    // grid container for layout
    echo '<div class="grid-container">';
    // Display items
    while ($row = $result->fetch_assoc()) {
        
        // Display item information
        echo '<div class="item-card">';

        // Thumbnail of image 
        echo '<div class="thumbnail">';
        echo '<a href="../items/item_details.php?itemID=' . $row['itemID'] . '">';
        if (!empty($row['imageURL'])) {
            echo '<img src="' . $row['imageURL'] . '" alt="' . $row['title'] . '" class="thumbnail-image">';
        } else {
            echo '<div class="blank-image"></div>'; // Display a blank area if imageURL is empty
        }
        echo '</a>';
        echo '</div>';

        // Item details
        echo '<h3>' . $row['title'] . '</h3>';
        echo '<p>Description: ' . $row['description'] . '</p>';
        echo '<p>Price: $' . $row['price'] . '</p>';
        echo "<p><a href='../items/item_details.php?itemID={$row['itemID']}'>View Details</a></p>";
        echo '</div>';
    }
    // End grid container
    echo '</div>';
    echo '<a href="../index.php">Back</a>';
} else {
    echo '<p>No items available at the moment.</p>';
}

// Close database connection
$conn->close();

include '../view/footer.php'?>



