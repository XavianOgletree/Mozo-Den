<?php
session_start();
if (isset($_SESSION['current_user'])) {
    $pagename = "Your Den";
} else {
    $pagename = "Welcome";
}

include_once("includes/check-new-mozos.php");
include("includes/header.php");
?>      
            <?php if (isset($_SESSION['current_user'])) { 
                include("game.php");
            } else {
                echo"
                <main class='thick-border flex-centered-column'>
                    <div class='flex-centered-column' id='welcome'>
                        <p>
                            Wecome to Mozo Den.  A game about collecting rare
                            creatures. Explore the world with them collect more.
                        </p>
                        <form method='post' action='login_files/login.php'>
                            <input type='hidden' value='existing' name='type'/>
                            <input type='submit'value='Login'/>
                        </form>
                        <form method='post' action='login_files/login.php'>
                            <input type='hidden' value='new' name='type'/>
                            <input type='submit' value='Sign-Up'/>
                        </form>
                    </div>
                ";
            } ?>
        </main>
        <?php include_once("includes/footer.php"); ?>
    </body>
</html>