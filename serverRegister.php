<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');
    echo("
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'> 
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Register Attempt</title>
        </head>
        <body class ='w3-container w3-light-grey'>
        <h1 class='w3-xxlarge w3-bottombar'>Register</h1>
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
    
        //create registration table if it does not exist
        $sql="CREATE TABLE IF NOT EXISTS registration (
            username VARCHAR(100) NOT NULL,
            password VARCHAR(100) NOT NULL,
            PRIMARY KEY(username)
            )";
    
        $stmt=$pdo->prepare($sql);
    
        if ($stmt->execute()){
            echo "<p>Attempting to create account...<p>";
        }
        else {
            echo "<p>error in creating the table".$stmt->error."<p>";
        }
    }
    
    //check if the username exists in the database. 
    function check_user(){
        global $pdo;
        $username=$_POST['username'];
        if(isset($username)){
            $sql="SELECT password FROM registration WHERE username=?";
            $statement=$pdo->prepare($sql);
            $statement->execute([$username]);
    
            $info=$statement->fetch();
    
            if($info){
                return true;
            }
        }
        else{
            return false;
        }
    }
    
    //perform checks and notify user of results
    $doesUserExist=check_user();
    if($doesUserExist){
        echo("<p>Username already exists! Account creation unsuccessful. Return to register page?<p>");
        echo("<button class = 'w3-button w3-grey w3-round-xxlarge'><a href = 'register.php' style = 'text-decoration:none'>Return</a></button>");
    }
    //if the username does not already exist, add the new account
    else{
        $sql="INSERT INTO registration(username,password) VALUES(:username,:password)";
        $statement=$pdo->prepare($sql);
        
        $hashedPassword=password_hash($password,PASSWORD_BCRYPT);
        
        $statement->bindParam(':username',$username);
        $statement->bindParam(':password',$hashedPassword);
        
        $statement->execute();
        echo("<p>Account creation successful! Log in?</p>");
        echo("<button class = 'w3-button w3-grey w3-round-xxlarge'><a href = 'index.php' style = 'text-decoration:none'>Log in</a></button>");
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