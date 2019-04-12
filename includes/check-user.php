<?php
if (!isset($_SESSION['current_user'])) {
    $_SESSION['error-message'] = "You must be logged in to be here.";
    header("Location: error.php");
} 
?>