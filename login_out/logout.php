<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->
<?php
// Start or resume the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect after logout
header("Location: ../index.php");
exit();
?>
