<?php
session_start();
$prefix = "..";
$pagename = "Edit Mozos";
include_once("../includes/header.php");
require_once("../includes/functions.php");
require_once("../includes/open_db.php");
include_once("../includes/check-admin.php");

$mozo = get_all_mozos($db);
$names = array();
foreach ($mozo as $mozo) {
    $names[] = $mozo['mozoSpecies'];
}

if (isset($_POST['update'])) {
    foreach ($names as $name) {
        $info = $_POST["$name-info"];
        if (isset($_POST["$name-quantity"])) {
            $quantity = $_POST["$name-quantity"];
            $discount = $_POST["$name-discount"];
            update_premium_info($db, $name, $quantity, $discount, $info);
        } else {
            $rarity = $_POST["$name-rarity"];
            update_mozo($db, $name, $rarity, $info);
        }

        if ($_FILES["$name-file"]['error'] === 0 and $_FILES["$name-file"]['type'] === 'image/png') {
            $upload_file = "../imgs/mozos/". strtolower(htmlspecialchars($name)) . ".png";
            move_uploaded_file($_FILES["$name-file"]['tmp_name'], $upload_file);
        }
    }
}

$free_mozos = get_all_free_mozos($db);
$premium_mozos = get_all_premium_mozos($db);

?>
        <main class='thick-border'>
            <form id='edit-mozos' method='post' enctype="multipart/form-data" action="#" class='flex-centered-column'>
                <fieldset class='flex-row-just-center'>
                    <legend>Free Mozos</legend>
                    <?php
                        foreach ($free_mozos as $mozo) {
                            echo "
                            <fieldset class='mozo-set flex-centered-column'>
                                <legend>{$mozo['mozoSpecies']}</legend>
                                <figure class='flex-centered-column'>
                                    <img name='{$mozo['mozoSpecies']}-img' id='{$mozo['mozoSpecies']}-img' src='../imgs/mozos/{$mozo['mozoSpecies']}.png' alt='Image of {$mozo['mozoSpecies']}' width='128'>
                                    <figcaption>
                                        <input name='{$mozo['mozoSpecies']}-file' id='{$mozo['mozoSpecies']}-file' type='file'/>
                                    </figcaption>
                                </figure>
                                <label for='{$mozo['mozoSpecies']}-info'>Mozo Info:</label>
                                <textarea name='{$mozo['mozoSpecies']}-info' id='{$mozo['mozoSpecies']}-info' maxlength='255' required>{$mozo['mozoInfo']}</textarea>
                                <label for='{$mozo['mozoRarity']}-rarity'>Mozo Rarity:</label>
                                <input type='number' name='{$mozo['mozoSpecies']}-rarity' id='{$mozo['mozoSpecies']}-rarity' value='{$mozo['mozoRarity']}' min='1' max='5' step='0.01' required/>
                            </fieldset>
                            ";
                        }
                    ?>
                </fieldset>
                <fieldset class='mozo-set flex-row-just-center'>
                    <legend>Premium Mozos</legend>
                    <?php
                        foreach ($premium_mozos as $mozo) {
                            echo "
                            <fieldset class='mozo-set flex-centered-column'>
                                <legend>{$mozo['mozoSpecies']}</legend>
                                <figure class='flex-centered-column'>
                                    <img name='{$mozo['mozoSpecies']}-img' id='{$mozo['mozoSpecies']}-img' src='../imgs/mozos/{$mozo['mozoSpecies']}.png' alt='Image of {$mozo['mozoSpecies']}' width='128'>
                                    <figcaption>
                                        <input name='{$mozo['mozoSpecies']}-file' id='{$mozo['mozoSpecies']}-file' type='file'/>
                                    </figcaption>
                                </figure>
                                <label for='{$mozo['mozoSpecies']}-info'>Mozo Info:</label>
                                <textarea name='{$mozo['mozoSpecies']}-info' id='{$mozo['mozoSpecies']}-info' maxlength='255' required>{$mozo['mozoInfo']}</textarea>
                                <label for='{$mozo['mozoSpecies']}-quantity'>Mozo Quantity:</label>
                                <input type='number' name='{$mozo['mozoSpecies']}-quantity' id='{$mozo['mozoSpecies']}-quantity' value='{$mozo['quantity']}' min='0' required/>
                                <label for='{$mozo['mozoSpecies']}-discount' >Mozo Discount</label>
                                <input type='number' id='{$mozo['mozoSpecies']}-discount' name='{$mozo['mozoSpecies']}-discount' value='{$mozo['discount']}' min='0' max='1' step='0.01' required/>
                            </fieldset>
                            ";
                        }
                    ?>
                </fieldset>
                <button type='submit' name='update' value=''>Update Mozos</button>
                <button type='reset'>Clear Changes</button>
            </form>
            <nav class='flex-row-just-center'>
                <a href='create-mozos.php'>Create Mozo</a>
                <a href='../admin.php'>Return to Admin Page</a>
                <a href='../index.php'>Return to Den</a>
            </nav>
        </main>
        <?php include_once("../includes/footer.php"); ?>
        <script src='../js/edit-store.js'></script>
        <script>
            let mozos = <?php echo json_encode($names); ?>;
            initialize(mozos);
        </script>

    </body>
    
</html>