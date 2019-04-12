<?php
session_start();    
$pagename = "Premium Item Store";

include("includes/header.php");
require_once("includes/open_db.php");
require_once("includes/functions.php");

include_once("includes/check-user.php");
include_once("includes/check-new-mozos.php");

$premium_mozos = get_all_premium_mozos($db);

if (isset($_POST['buy-mozo'])) {
    $mozo_wanted = $_POST['buy-mozo'];
    $mozo_info = get_premium_mozo($db, $_POST['buy-mozo']);
    // Create cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    // Create entry into cart
    if (!isset($_SESSION['cart'][$mozo_wanted])) {
        $_SESSION['cart'][$mozo_wanted] = 0;
    }
    // Check if we can add mozo to cart
    if ($_SESSION['cart'][$mozo_wanted] < $mozo_info['quantity']) {
        $_SESSION['cart'][$mozo_wanted] += 1;
        $message = "$mozo_wanted has been added to you cart!";
    } else {
        $message = "$mozo_wanted could not be added to your cart...";
    }
} else if (sizeof($_POST) === 0 and isset($_SESSION['cart']) and sizeof($_SESSION['cart']) !== 0) {
    $message = "You still have some items in you cart!";
} ?>
        <main class='thick-border flex-centered-column' id="store">
            <?php if (isset($message)) {
                echo "
                <h2>" . ucfirst($message) . "</h2>
                ";
            } ?>
            <div id='premium-mozos' class='flex-row-just-center'>
                <?php foreach ($premium_mozos as $premium_mozo) {
                        $mozo = $premium_mozo['mozoSpecies'];
                        $price = floatval($premium_mozo['mozoPrice']);
                        $discount = floatval($premium_mozo['discount']);
                        $quantity = floatval($premium_mozo['quantity']);
                        $price *= 1.0 - $discount;
                        $mozo_name = ucfirst($mozo); ?>
                        <figure class='flex-centered-column'>
                            <img src='imgs/mozos/<?php echo $mozo ?>.png' height='128'/>
                            <figcaption>
                                <p class='mozo-name'><?php echo "$mozo_name | <em class='mozo-price'>Price:" . sprintf("%0.2f", $price) . "\$" ?></em></p>
                    <?php if ($discount > 0 and $quantity  > 0) { ?>
                                <p><em class='sale'>On sale! <?php echo (100 * $discount) ?>% off!</em></p>
                    <?php } 
                        if ($quantity  > 0) { ?>
                                <p>Mozo left: <?php echo $quantity ?> </p>
                                <form method='post' action='#'>
                                    <input type='submit' value='add to cart'/>
                                    <input type='hidden' value='<?php echo $mozo ?>' name='buy-mozo'/>
                                </form>
                    <?php } else { ?>
                                <p><em>Sold Out</em></p>
                    <?php } ?>
                                <p class='mozo-description'><?php echo $premium_mozo['mozoInfo'] ?></p>
                            </figcaption>
                        </figure>
                <?php } ?>
            </div>
            <nav><a href="index.php">Back to Den</a> <a href="purchase.php">Make Purchase</a></nav>
        </main>
        <?php include_once("includes/footer.php"); ?>
    </body>
</html>