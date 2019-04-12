<?php 
session_start();

if (!isset($_POST['mozo-id'])) {
    $_SESSION['error-message'] = "Sorry, but the Mozo Info page can't be access directly.";
    header("Location: error.php");
}

$pagename = "About Your Mozo";

include_once("includes/check-user.php");
include_once("includes/check-new-mozos.php");
include_once("includes/header.php");
require_once("includes/open_db.php");
require_once("includes/functions.php");



$mozo_info = get_active_mozo($db, $_POST['mozo-id']);
$rarity = rarity_to_word($mozo_info['mozoRarity']);
$time_stamp = date_create_from_format ("Y-m-d H:i:s", $mozo_info['collectedOn']);
?>      
        <main class='thick-border flex-centered-column'>
            <?php
                echo" 
                <h2>". ucfirst($mozo_info['mozoName']) . "</h2>
                <figure id='mozo-card' class='flex-row-just-center'>
                    <img src='imgs/mozos/{$mozo_info['mozoSpecies']}.png' height='128'/>
                    <figcaption>
                        <p>Species: " . ucfirst($mozo_info['mozoSpecies']) . "</p>
                        <p>Rarity: $rarity</p>
                        <p>Collected on: <time datetime='{$mozo_info['collectedOn']}'>" . $time_stamp->format("F jS, Y") . "</time></p>
                    </figcaption>
                </figure>
                <nav class='flex-row-just-center'>
                    <a href={$_POST['return-to']}> Go Back </a>
                </nav>
                ";
            ?>
        </main>
        <?php include_once("includes/footer.php"); ?>
    </body>
</html>