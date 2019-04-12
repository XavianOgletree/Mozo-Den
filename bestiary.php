<?php
session_start();
$pagename = "The Bestiary";

include("includes/header.php");
require_once("includes/open_db.php");
require_once("includes/functions.php");

include_once("includes/check-new-mozos.php");
include_once("includes/check-user.php");

$mozos = get_all_free_mozos($db);
$premium_mozos = get_all_premium_mozos($db);
$free_mozos = get_all_free_mozos($db);
$species_owned = get_species_owned($db, $_SESSION['current_user']);
?>
        <main class='thick-border flex-centered-column'>
            <section class='bestiary-section' id="normal-mozos">
                <h2>Mozos Found</h2>
                <div class='flex-row-just-center mozo-display'>
                    <?php
                        foreach ($free_mozos as $mozo) {
                            $rarity = rarity_to_word(intval($mozo['mozoRarity']));
                            if (isset($species_owned[$mozo['mozoSpecies']])) {
                                echo "
                                <figure>
                                    <img src='imgs/mozos/{$mozo['mozoSpecies']}.png'>
                                    <figcaption>
                                        <p>{$mozo['mozoSpecies']}</p>
                                        <p>Rarity: $rarity</p>
                                        <p>{$mozo['mozoInfo']}</p>
                                    </figcation>
                                </figure>
                                ";
                            } else {
                                echo "
                                <figure>
                                    <img src='imgs/question.png' alt='Question Mark'>
                                    <figcaption>
                                        <p>?????</p>
                                        <p>Rarity: $rarity</p>
                                        <p>{$mozo['mozoInfo']}</p>
                                    </figcaption>
                                </figure>
                                ";
                            }
                        }                        
                    ?>
                </div>
            </section>
            <section class='bestiary-section'>
                <h2>Premium Mozos</h2>
                <div class='flex-row-just-center mozo-display'>
                    <?php
                        foreach ($premium_mozos as $mozo) {
                            if (isset($species_owned[$mozo['mozoSpecies']])) {
                                echo "
                                <figure>
                                    <img src='imgs/mozos/{$mozo['mozoSpecies']}.png'>
                                    <figcaption>
                                        <p>{$mozo['mozoSpecies']}</p>
                                        <p>Rarity: Premium</p>
                                        <p>{$mozo['mozoInfo']}</p>
                                    </figcation>
                                </figure>
                                ";
                            } else {
                                echo "
                                <figure>
                                    <img src='imgs/question.png' alt='Question Mark'>
                                    <figcaption>
                                        <p>?????</p>
                                        <p>Rarity: Premium</p>
                                        <p>{$mozo['mozoInfo']}</p>
                                    </figcaption>
                                </figure>
                                ";
                            }
                        }
                    ?>
                </div>
            </section>
            <nav class='flex-row-just-center'>
                <a href="index.php">Return to Den</a> 
                <a href="store.php">Buy Premium Mozos</a>
            </nav>
        </main>
        <?php include_once("includes/footer.php"); ?>
    </body>
</html>