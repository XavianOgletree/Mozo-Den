<?php
session_start();

include_once('includes/functions.php');
include_once('includes/open_db.php');
if (!isset($_POST)) {
    header("Location: index.php");
} else if (!isset($_SESSION['new-mozos'])) {
    header("Location: index.php");
} else {
    foreach ($_POST as $index=>$name){
        echo "<p>$index $name</p>";
        add_mozo_to_user($db, $_SESSION['new-mozos'][$index], $name, $_SESSION['current_user']);
    }
    unset($_SESSION['new-mozos']);
    if (!isset($_SESSION['return-to'])) {
        header("Location: {$_SESSION['return-to']}");
        unset($_SESSION['return-to']);
    } else {
        header("Location: index.php");
    }
}
?>
    