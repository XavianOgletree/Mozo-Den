<?php 
include_once("check-user.php");
if (!check_admin($db, $_SESSION['current_user'])) {
    $_SESSION['error-message'] = "You must be an admin to be here.";
    header("Location: error.php");
}
?>