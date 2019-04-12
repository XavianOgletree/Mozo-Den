<?php
session_start();
$pagename = 'New Mozo!';

include("includes/header.php"); 
include("includes/check-user.php");

if (!isset($_SESSION['new-mozos'])) { 
    $_SESSION['error-message'] = "Sorry, but no mozo have been give to you at this time...";
    header('Location: error.php');
}

require_once("includes/functions.php");
require_once("includes/open_db.php"); 
?>
    <main class='thick-border flex-centered-column'>
        <form id='name-mozos' method="post" action="give-mozos.php">
            <?php foreach ($_SESSION['new-mozos'] as $index=>$mozoSpecies) {
                echo "
                <label for='$index'>Name your mozo</label> <input type='text' name='$index' value='$mozoSpecies'/>
                ";
            }?>
            <input type="submit" value="Looks Good!"/>
        </form>
    </main>
    <?php include_once("includes/footer.php"); ?>
</body>