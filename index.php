<?php include 'view/header2.php';?>
<main>
<div class="container">
    <h1>Welcome to Our Online Marketplace</h1>
    <?php if (isset($_SESSION['userID'])) { ?>
        <!-- User is logged in, show dashboard, profile, and messages links -->
        <?php
        // Print "You are logged in as: username" if username is set in session
        if (isset($_SESSION['username'])) {
            echo "<p>You are logged in as: {$_SESSION['username']}</p>";
        }
        ?>
        <ul>
            <li><a href="items/browse.php">Browse Items</a></li>
            <li><a href="items/new_item.php">Post New Item</a></li>
            <li><a href="profile/dashboard.php">Dashboard</a></li>
            <li><a href="profile/profile.php">Profile</a></li>
            <li><a href="profile/messages.php">Messages</a></li>
            <li><a href="login_out/logout.php">Logout</a></li> 
        </ul>
    <?php } else { ?>
        <!-- User is not logged in, show general content -->
        <p>Please log in to access your dashboard, profile, and messages.</p>
        <li><a href="login_out/login.php">Login</a></li>
        <li><a href="register/register.php">Register</a></li>
        <li><a href="items/browse.php">Browse Items</a></li>
    <?php } ?>
</div>
<?php include 'view/footer.php'; ?>