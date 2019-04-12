<?php 
session_start();
$pagename = "Create New Mozo";
$prefix = "..";
$upload_prefix = "../imgs/mozos/";

include_once("../includes/header.php");
require_once("../includes/functions.php");
require_once("../includes/open_db.php");
include_once("../includes/check-admin.php");
if (isset($_POST['mozo-species'])) {
    if (is_species_avalible($db, $_POST['mozo-species'])) {
        $upload_file = $upload_prefix . strtolower(htmlspecialchars($_POST['mozo-species'])) . ".png";
        move_uploaded_file($_FILES['mozo-image']['tmp_name'], $upload_file);
        add_mozo($db, $_POST['mozo-species'], $_POST['mozo-value'], $_POST['mozo-rare'], $_POST['mozo-info']);
        if (isset($_POST['mozo-premium'])) {
            add_premium_info($db, $_POST['mozo-species'], $_POST['mozo-price'], $_POST['mozo-quantity']);
        }
    }
}
?>
        <main class='thick-border flex-centered-column'>
            <form id='new-mozo' method='post' enctype="multipart/form-data" action="#">
                <fieldset>
                    <legend>General Mozo Info</legend>
                    <label for='mozo-image'>Image for New Mozo:</label> <input required type="file" class='mozo-input' name='mozo-image' id='mozo-image' accept='image/png'>
                    <label for='mozo-species'>Species Name:</label> <input required type='text' class='mozo-input' name='mozo-species' id='mozo-species' maxlength=25 size=40/>
                    <label for='mozo-info'>Description:</label> <textarea required class='mozo-input' name='mozo-info' id='mozo-info' maxlength='255'></textarea>
                    <label for='mozo-value'>Value:</label> <input required type='number' class='mozo-input' name='mozo-value' id='mozo-value' min=0 max=9999 value='10'/>
                    <label for='mozo-premium'>Premium:</label> <input type='checkbox' class='mozo-input' name='mozo-premium' id='mozo-premium'/> 
                    <label for='mozo-rarity'>Rarity:</label> <input required type='number' class='mozo-input' name='mozo-rarity' id='mozo-rarity' min='1' max='5' value='1'/>
                </fieldset>
                <fieldset name='premium-info' id='premium-info' disabled>
                    <legend>Premium Mozo Info</legend>
                    <label for='mozo-price'>Price:</label> <input required type='number' name='mozo-price' id='mozo-price' min='0.50' step='0.01' value='0.50'/>
                    <label for='mozo-quantity'>Initial Quanity:</label> <input required type='number' name='mozo-quanity' id='mozo-quantity' min='1' value='1'/>
                </fieldset>
                <input class='mozo-input' type='submit' value='Add Mozo'/>
            </form>
            <nav class='flex-row-just-center'>
                <a href='edit-mozos.php'>Edit Mozo</a>
                <a href='../admin.php'>Return to Admin Page</a>
                <a href='../index.php'>Return to Den</a>
            </nav>
        </main>
        <script src='../js/new-mozo.js'></script>
    </body>
    <?php include_once("../includes/footer.php"); ?>
</html>