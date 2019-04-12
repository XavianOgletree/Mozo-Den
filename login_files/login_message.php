<?php
   session_start();   
   $message = $_SESSION['message'];
   unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html>
  <head>    
    <title>Login message - password_hash example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
  </head>  
  
  
  <body>
    <main> 
        <?php          
          echo "<h1>$message</h1>"; 
          echo "You will be redirected to the home page in 2 seconds.";
          header( "refresh:2; url=../index.php" );
        ?>
    </main>        
   
  </body>
</html>


