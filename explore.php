<?php 
session_start();
$pagename = "Explore for Mozos";

include_once("includes/check-new-mozos.php");
include_once("includes/check-user.php");
include_once("includes/header.php");
require_once("includes/functions.php");
require_once("includes/open_db.php");

if (isset($_POST['new-mozos'])) {
    switch ($_POST['new-mozos']) {
        case 'common':
            $_SESSION['new-mozos'] = array();
            $_SESSION['new-mozos'][] = get_random_mozo($db, 1)['mozoSpecies'];   
            header('Location: new-mozos.php');
            break;
        case 'random':
            $_SESSION['new-mozos'] = array();
            $_SESSION['new-mozos'][] = get_random_mozo($db, random_rarity())['mozoSpecies'];  
            header('Location: new-mozos.php');
            break;
        case 'scarce':
            $_SESSION['new-mozos'] = array();
            $_SESSION['new-mozos'][] = get_random_mozo($db, 3)['mozoSpecies'];
            header('Location: new-mozos.php');
            break;
        case 'illusive':
            $_SESSION['new-mozos'] = array();
            $_SESSION['new-mozos'][] = get_random_mozo($db, 5)['mozoSpecies']; 
            header('Location: new-mozos.php');
            break;
    }
    print_r($_SESSION['new-mozos']);
}

if (isset($_POST['explore'])) {
    $event = random_event();
} else {
    $event = [
        "message" => "Your exploration starts here!",
        "id" => 0,
    ];
}


?>
        <main class='thick-border flex-centered-column'>
            <figure>
                <?php 
                echo "
                <img src='imgs/explore/{$event['id']}.png' alt='{$event['message']}'>
                <figcaption>
                    <p>{$event['message']}</p>
                </figcaption>
                ";
                ?>
            </figure>
            <?php if (isset($event['rarity'])) { ?>
                <div>
                    <form method='post'>
                        <button type='submit' value='<?php echo $event['rarity'] ?>' name='new-mozos' formaction='#'>Collect Mozo!</button>
                    </form>
                </div>
            <?php } else { ?>
                <form method='post'>
                    <button type='submit' value='explore' name='explore' formaction='#'>Explore</button>
                </form>
                <nav class='flex-row-just-center'><a href='index.php'>Return to Den</a></nav>
            <?php } ?>
        </main>
        <?php include_once("includes/footer.php"); ?>
    </body>
</html>
