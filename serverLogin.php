<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');
    session_start();
    echo("
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'> 
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Log In Attempt</title>
        </head>
        <body class ='w3-container w3-light-grey'>
        <h1 class='w3-xxlarge w3-bottombar'>Log In</h1>
    ");
    //set up pdo
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username=$_POST['username'];
        $password=$_POST['password'];
        $dsn='mysql:host=localhost;port=8889;dbname=project';
        $username_db="root";
        $password_db="root";

        try{
            $pdo= new PDO($dsn,$username_db,$password_db);
        }
        catch(PDOException $e){
            die("connection error".$e->getMessage());
        }

        //create table of users if it does not exist. Username will be the primary key, ensuring unique usernames
        $sql="CREATE TABLE IF NOT EXISTS registration (
        username VARCHAR(100) NOT NULL,
        password VARCHAR(100) NOT NULL,
        PRIMARY KEY(username)
        )";

        $stmt=$pdo->prepare($sql);

        if ($stmt->execute()){
            echo("Attempting to log in...");
        }
        else {
            echo "error in creating the table".$stmt->error;
        }
    }

    $usernameBool=false; //used to provide custom message when user fails to log in
    
    //are the username and password correct?
    function check_user(&$usernameBool){
        global $pdo;
        $username=$_POST['username'];
        $password=$_POST['password'];
        if(isset($username)){
            $sql="SELECT password FROM registration WHERE username=?";
            $statement=$pdo->prepare($sql);
            $statement->execute([$username]);
    
            $info=$statement->fetch();
    
            if($info){
                    $usernameBool=true; //if the username exists
                    $hashedPassword=$info['password'];
    
                    if(password_verify($password,$hashedPassword))
                    {
                        return true;
                    }
                    else {return false;}
            }
        }
        else{
            return false;
        }
    }

    //perform checks and notify user of results
    echo("<br>");
    $doesUserExist=check_user($usernameBool);
    if($doesUserExist){
        //if login successful, set the username session variable, allowing user to access website
        $username = $_POST['username'];
        $_SESSION['username']=$username;
        header("Location: userHome.php");
        die;
    }
    else{
        if(!$usernameBool){
            echo("<p>Username not recognized. Return to log in page?<p>");
            echo("<button class = 'w3-button w3-grey w3-round-xxlarge'><a href = 'index.php' style = 'text-decoration:none'>Return</a></button>");
        }
        else{
            echo("<p>Password not recognized. Return to log in page?<p>");
            echo("<button class = 'w3-button w3-grey w3-round-xxlarge'><a href = 'index.php' style = 'text-decoration:none'>Return</a></button>");            
        }

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