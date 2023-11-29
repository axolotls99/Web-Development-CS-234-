<?php
    session_start();
    echo("
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'> 
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Logout</title>
        </head>
        <body class ='w3-container w3-light-grey'>
    ");
    //if a logged in user visits this page they will be logged out and provided the opportunity to log in again
    if(isset($_SESSION['username'])){
        $name = $_SESSION['username'];
        echo("<h1 class='w3-xxlarge w3-bottombar'>Log out</h1>");
        echo ("<h2 class = w3-xlarge>$name, you have logged out of the system.</h2>");
        $_SESSION=array();

        session_destroy();

        echo("<button class = 'w3-button w3-grey w3-round-xxlarge'><a href = 'index.php' style = 'text-decoration:none'>Log in?</a></button>");
    }
    else{
        echo("<h1 class='w3-xxlarge w3-bottombar'>Unauthorized</h1>");
        echo("<p>Please log in to access this page<p> <br>");
        echo("<button class ='w3-button w3-grey w3-round-xxlarge'><a href = 'index.php' style = 'text-decoration:none'>Log in</a></button>");    
    }
    //put footer at bottom of every page
    echo("
        </body>
        <footer class = 'w3-topbar w3-stretch w3-bottom'>
            <p class = 'w3-text-grey w3-tiny w3-container'> &copy; 2023 Adrienne Rose </p>
        </footer>
        </html>
    ");
?>