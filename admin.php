<?php 
session_start();
$pagename = "Admin Page";

include_once("includes/header.php");
require_once("includes/functions.php");
require_once("includes/open_db.php");
include_once("includes/check-admin.php");
?>
        <main class='thick-border flex-centered-column'>
            <h2>Tools Avalible</h2>
            <nav class='flex-row-just-center'>
                <a href='admin/create-mozos.php'>Create New Mozo</a>
                <a href='admin/edit-mozos.php'>Edit Store Items</a>
                <a href='index.php'>Return to Den</a>
            </nav>
        </main>
        <?php include_once("includes/footer.php"); ?>
    </body>
</html>