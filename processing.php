<?php 
session_start();
$pagename = "Processing Payment";

include_once("includes/header.php");

include_once("includes/check-new-mozos.php");
include_once("includes/check-user.php");

if (!isset($_SESSION['cart']) or sizeof($_SESSION['cart']) === 0) { 
    $_SESSION['error-message'] = "No purchase as been made...";
    header("Location: error.php");
}

require_once("includes/open_db.php");
require_once("includes/functions.php");
header("refresh:2; url=new-mozos.php");
$species = array_keys($_SESSION['cart']);
$_SESSION['new-mozos'] = array();
$total = 0;
foreach ($_SESSION['cart'] as $species=>$count) {
    $mozo = get_premium_mozo($db, $species);
    $total += floatval($mozo['mozoPrice']) * (1 - floatval($mozo['discount'])) * $count;
    update_premium_quantity($db, $species, intval($mozo['quantity'] - $count));
    for ($i = 0; $i < $count; $i++) {
        $_SESSION['new-mozos'][] = $species;
    }
}
add_purchase_to_user($db, $_SESSION['current_user'], $total);
unset($_SESSION['cart']);
?>      
        <main class='thick-border flex-centered-column'>
            <h1>Please wait while your payment is processed...</h1>
            <div id="spinners">
                <div class='waiting-1'>
                    <div class='thick-border'></div>
                </div>
                <div class='waiting-2'>
                    <div class='thick-border'></div>
                </div>
                <div class='waiting-3'>
                    <div class='thick-border'></div>
                </div>
            </div>
        </main>
        <?php include_once("includes/footer.php"); ?>
    </body>
</html>
