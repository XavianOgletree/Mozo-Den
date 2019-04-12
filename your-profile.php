<?php 
session_start();
$pagename = "Your Profile";

include_once("includes/header.php");
require_once("includes/open_db.php");
require_once("includes/functions.php");

include_once("includes/check-user.php");
include_once("includes/check-new-mozos.php");
?>      
        <main class='flex-centered-column thick-border'>
            <h2>Your Username</h2>
            <p><?php echo $_SESSION['current_user'] ?></p>
            <h2>Your Purchases</h2>
            <table>
                <tbody>
                    <tr>
                        <td>Date</td>
                        <td>Total</td>
                    </tr>
                    <?php
                        $purchases = get_purchases_for_user($db, $_SESSION['current_user']);
                        foreach ($purchases as $purchase) {
                            $time_stamp = date_create_from_format ("Y-m-d H:i:s", $purchase['purchaseDate']);
                            echo "
                            <tr>
                                <td>" . $time_stamp->format("F jS, Y") . "</td>
                                <td>" . sprintf("%0.2f", $purchase['total']) . "</td>
                            </tr>
                            ";
                        }
                    ?>
                </tbody>
            </table>
            <h2>Your Mozos</h2>
            <table>
                <tbody>
                    <tr>
                        <td>Image</td>
                        <td>Mozo's Name</td>
                        <td>Mozo's Species</td>
                    </tr>
                    <?php
                        $mozos = get_mozos_for_user($db, $_SESSION['current_user']);
                        foreach ($mozos as $mozo) {
                            $mozo_name = $mozo['mozoName'] === '' ? $mozo['mozoSpecies'] : $mozo['mozoName'];
                            echo "
                            <tr>
                                <td>
                                    <button form='mozo-info' value='{$mozo['entryID']}' name='mozo-id'>
                                        <img width='64' height='64' src='imgs/mozos/{$mozo['mozoSpecies']}.png' alt='{$mozo['mozoSpecies']}'/>
                                    </button>
                                </td>
                                <td>" . ucfirst($mozo['mozoName']) . "</td>
                                <td>" . ucfirst($mozo['mozoSpecies']) . "</td>
                            </tr>
                            ";
                        }
                    ?>
                </tbody>   
            </table>
            <form id='mozo-info' action='mozo-info.php' method='post'>
                <input type='hidden' value='your-profile.php' name='return-to'/>
            </form>
            <nav>
                <a href='index.php'>Back to Den</a>
            </nav>
        </main>
        <?php include_once("includes/footer.php"); ?>
    </body>
</html>