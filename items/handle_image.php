<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->
<?php
    // Handle image upload if a file was provided
    $imageURL = null; // Default value if no image is uploaded

    if ($_FILES["image"]["size"] > 0) {
        $targetDirectory = "../images/"; // Specify your upload directory
        $imageFileName = basename($_FILES["image"]["name"]);
        $targetFile = $targetDirectory . $imageFileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 5000000) { 
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" &&
            $imageFileType != "jpeg"
        ) {
            echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file and set image URL
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $imageURL = "../images/" . $imageFileName;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Get the userID of the session
    $userID = $_SESSION['userID'];

    // Get the current date for uploadDate
    $uploadDate = date('Y-m-d');

    // Insert item data into the database
    $sql = "INSERT INTO Items (userID, title, description, price, categoryID, uploadDate, imageURL) 
    VALUES ('$userID', '$title', '$description', '$price', '$categoryID', '$uploadDate', ";

    if ($imageURL !== null) {
        $sql .= "'$imageURL')";
    } else {
        $sql .= "NULL)";
    }

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        header("Location: browse.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

?>
