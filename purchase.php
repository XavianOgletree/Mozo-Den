<?php 
session_start();
$pagename = "Make Purchase";

include_once("includes/header.php");
require_once("includes/open_db.php");
require_once("includes/functions.php");

include_once("includes/check-user.php");
include_once("includes/check-new-mozos.php");

if (isset($_POST['empty-cart'])){
    $_SESSION['cart'] = array();
}

if (isset($_POST['remove-n']) and isset($_SESSION['cart'][$_POST['mozoSpecies']])) {
    $_SESSION['cart'][$_POST['mozoSpecies']] -= intval($_POST['remove-n']);
    if ($_SESSION['cart'][$_POST['mozoSpecies']] <= 0) {
        unset($_SESSION['cart'][$_POST['mozoSpecies']]);
    }
} ?>

<?php if (!(isset($_SESSION['cart']) and sizeof($_SESSION['cart']) !== 0)) { ?>
            <main class='thick-border flex-centered-column'>
                <p>Your cart is empty!</p>
                <nav class='flex-row-just-center'>
                    <a href='store.php'>Return to Store</a>
                    <a href='index.php'>Return to Den</a>
                </nav>
            </main>
            <?php include_once("includes/footer.php"); ?>
        </body>
    </html>
<?php } else { ?>
            <main class='thick-border flex-centered-column'>
                <table id="purhcase-info">
                    <thead>
                        <tr>
                            <th>Mozo Name</th>
                            <th>Number Bought</th>
                            <th>Cost</th>
                        <tr>
                    </thead>
                    <tbody>
                        <?php
                            $total = 0.0;
                            foreach ($_SESSION['cart'] as $mozoSpecies=>$count) {
                                $mozo = get_premium_mozo($db, $mozoSpecies);
                                $price = floatval($mozo['mozoPrice']);
                                $discount = 1 - floatval($mozo['discount']);
                                $cost = floatval($price * $discount * $count);
                                echo 
                                "<tr>
                                    <td>" . ucfirst($mozoSpecies) . "</td>
                                    <td>$count</td>
                                    <td>" . sprintf("%0.02f$", $cost) . "</td>
                                    <td><form method='post' id='remove-$mozoSpecies' class='remove-item'><input name='mozoSpecies' type='hidden' value='$mozoSpecies'><input name='remove-n' type='number' min='1' max='$count' value='1'/></form></td>
                                    <td><button type='submit' form='remove-$mozoSpecies'>Remove Item(s)</button></td>
                                </tr>
                                ";
                                $total += $cost;
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Final Total:</td>
                            <td><?php echo sprintf('%0.02f$', $total); ?></td>
                    </tfoot>
                </table>
                <form method='post' action='#'>
                    <button type='submit' name='empty-cart' value=''>Clear Cart</button>
                    <button type='submit' formaction='processing.php'>Buy Items</button>
                </form>
            </main>
            <?php include_once("includes/footer.php"); ?>
        </body>
    </html>
<?php } ?>
