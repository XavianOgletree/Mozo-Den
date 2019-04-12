<!DOCTYPE html>
<html>
  <head>    
    <title>Log In - password hash example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
  </head>   
    
  <?php
   
    include ("functions.php");
    session_start();
    require_once("../includes/open_db.php");
    
       
    //need to save whether log in is new or existing
    if (isset($_POST['type'])) {  
      $_SESSION['type'] = $_POST['type'];
      unset($_POST['type']);
    }
    
     //want to keep username if it has been entered
    if (isset($_POST['username'])) {
      $username_check = htmlspecialchars($_POST['username']);
    }
    else {
      $username_check = "";
    }
    
    //check username availability
    if (isset($_POST['check_username']) && isset($_POST['username'])) {
      $check = true;  //will need to know if username needs to be put back
      if (existing_username($db, $username_check)) {
        echo "<script type='text/javascript'>alert('Username unavailable.');</script>";
      } 
      else {
        echo "<script type='text/javascript'>alert('Username is available.');</script>";
      }
      unset($_POST['check_username']);
      unset($_POST['username']);
    }
    else {
      $check = false; //no name in the input box
    }
    
    //log in existing user
    if ($_SESSION['type'] == 'existing') {
      if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        if (verify_login($db, $username, $password)) {
          $_SESSION['message'] = 'You have successfully logged in';
          $_SESSION['current_user'] = $_POST['username'];
          header('Location: login_message.php');
        }
        else {
          $_SESSION['message'] = 'Login failed';
          header('Location: login_message.php');
        }
      }
    }
    else {  //create new user
     if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);   
        if (validPassword($password)) {
          $password2 = htmlspecialchars($_POST['password2']);
          if ($password !== $password2) {
            echo "<script type='text/javascript'>alert('Passwords do not match.');</script>";
          }
          else  //passwords match
          {
            if (existing_username($db, $username)) {
              echo "<script type='text/javascript'>alert('username unavailable');</script>";
            }
            else {  //username available
              $encrypt_password = password_hash($password, PASSWORD_DEFAULT);
              if (addUser($db, $username, $encrypt_password)){
                $_SESSION['message'] = 'Your account has been created and you are logged in';
                $_SESSION['current_user'] = $_POST['username'];
                header('Location: login_message.php');
              }
            else {
              echo "<script type='text/javascript'>alert('Unable to create account.');</script>";
            }
          }//!existing_username
        }//passwords match
      }//valid password
      else {    //invalid password
        echo "<script type='text/javascript'>alert('Password must be at least 8 characters and "
        . "contain at least one number, one uppercase letter, and one lowercase letter');</script>";
      }      
    }//isset
  }//else (new user)
?>
  <body>      
    <header>
        <?php 
          if ($_SESSION['type'] == "existing"){
            echo "<h1>User Log-In</h1>";
          }
          else {
            echo "<h1>Enter new account information</h1>";
          }
        ?>
        
    </header>
    <main>              
        <form action="" method="post">
          <label for="username" class="login_label">Username</label>
          <?php
              echo "<input type='text' name='username' value=$username_check>\n"; 
              if ($_SESSION['type'] == "new") {
                echo '<input type="submit" name="check_username" value="Check Username Availability" id="check_button">';
              }
              echo '<br/>';
          ?>          
          <label for="password" class="login_label">Password</label>
          <!-- would normally make the input type="password", but want to see what we type -->               
          <input type="text" name="password" value=""><br />
          <?php
             if ($_SESSION['type'] == "new"){
                echo "<label for='password2' class='login_label'>Retype password</label>\n";
                //would normally make the input type="password", but want to see what we type
                echo "<input type='text' name='password2' value=''><br />";
             }
           ?>
          <input type="submit" value="Log-in">      
        </form>        
    </main>  
  </body>
</html>


