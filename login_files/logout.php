<!DOCTYPE html>
<html>
  <head>    
    <title>logout - password_hash example</title>
    <meta charset="utf-8">
  </head>   
    
  <?php
   
    include ("functions.php");
    session_start();   

    //logout current user
    unset($_SESSION['current_user']);
    $_SESSION['message'] = 'You have been logged out.';
    header('Location: login_message.php');
    
  ?>   
   
 
</html>


