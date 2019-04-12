<!DOCTYPE html>
<html lang='en'>
    <head>    
        <?php echo "<title>$pagename - Mozo Den</title>" ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo (isset($prefix) ? "$prefix/css/normalize.css" : "css/normalize.css")?>">
        <link rel="stylesheet" href="<?php echo (isset($prefix) ? "$prefix/css/main.css" : "css/main.css")?>">
        <link rel="icon" href="favicon.png">
    </head>
    <body class='flex-centered-column'>
        <header>
            <h1><?php echo $pagename; ?></h1>
        </header>
        
    