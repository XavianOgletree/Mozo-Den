<?php
require_once("includes/functions.php");
require_once("includes/open_db.php");
if ($_SESSION['type'] === 'new') {
    $_SESSION['type'] = 'existing';
    $_SESSION['return-to'] = "index.php";
    $_SESSION['new-mozos'] = array();
    $_SESSION['new-mozos'][] =  get_random_mozo($db, random_rarity())['mozoSpecies'];
    header("Location: new-mozos.php");
}
?>
        <main class='thick-border flex-centered-column' id="den">
            <div hidden='' id="mozo-images">
                <?php
                    $mozos = get_mozos_for_user($db, $_SESSION['current_user']);
                    load_mozo_images($mozos);
                ?>
                <img src='imgs/decor/grass-1.png' alt='grass-1'/>
                <img src='imgs/decor/grass-2.png' alt='grass-2'/>
                <img src='imgs/decor/rock-1.png' alt='rock-1'/>
                <img src='imgs/decor/rock-2.png' alt='rock-2'/>
            </div>
            <canvas width='900' height='640' id='mozo-world' class='thick-border'></canvas>
            <nav class='flex-row-just-center'>
                <a href="your-profile.php">Your Profile</a>
                <a href="bestiary.php">Bestiary</a>
                <a href="explore.php">Explore</a>
                <a href="store.php">Priemum Store</a>
                <?php if (check_admin($db, $_SESSION['current_user'])) {?>
                <a href="admin.php">Admin Tools</a>
                <?php } ?>
                <a href="login_files/logout.php">Log Out</a>
            </nav>
            <form id='get-mozo-info' action='mozo-info.php' method='post'>
                <input name='return-to' type='hidden' value='index.php'>
                <input id='mozo-id' name='mozo-id' type='hidden' value=''>
            </form>
            <script src='js/decor.js'></script>
            <script src='js/mozo.js'></script>
            <script src='js/den.js'></script>
            <script>
                let mozos = <?php echo json_encode($mozos) ?>;
                new Den(mozos);
            </script>
