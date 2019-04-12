<?php 
session_start();
$pagename = "Create New Mozo";
include_once("includes/header.php");
require_once("includes/functions.php");
require_once("includes/open_db.php");
$error_message = "Something went wrong?";
if (isset($_SESSION['error-message'])) {
    $error_message = $_SESSION['error-message'];
    unset($_SESSION['error-message']);
}  
?>
        <main class='thick-border flex-centered-column'>
            <p><?php echo $error_message ?></p>
            <p><a href='index.php'>Return to Homepage</a></p>
        </main>
        <?php include_once("includes/footer.php"); ?>
    </body>
    
</html>