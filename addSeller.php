<?php
//done with format, needs more testing
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
session_start();

//include html info
echo("
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'> 
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Add Seller</title>
    </head>
    <body class ='w3-container w3-light-grey' style = 'margin-bottom: 50px'> 
    ");

// if logged in
if(isset($_SESSION['username'])){
    //if logged in as admin
    if($_SESSION['username'] == 'Admin'){
        echo("<h1 class = 'w3-xxlarge'>Add Seller</h1>");

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            //set up pdo
            $dsn='mysql:host=localhost;port=8889;dbname=project';
            $username_db="root";
            $password_db="root";
            try{
                $pdo= new PDO($dsn,$username_db,$password_db);
            }
            catch(PDOException $e){
                die("connection error".$e->getMessage());
            }

            //create sellers table if not exists
            $sql="CREATE TABLE IF NOT EXISTS sellers (
                sellerId VARCHAR(100) NOT NULL,
                sales INT NOT NULL DEFAULT 0,
                country VARCHAR(100) NOT NULL,
                state_ VARCHAR(100),
                PRIMARY KEY(sellerId)
            )";
            $stmt=$pdo->prepare($sql);
            if (!$stmt->execute()){
                die("error in creating the sellers table".$stmt->error);
            }

            //create products table if not exists. set up one to many relationship
            $sql="CREATE TABLE IF NOT EXISTS products(
                productId INT NOT NULL AUTO_INCREMENT,
                name_ VARCHAR(100) NOT NULL,
                price VARCHAR(100) NOT NULL,
                seller VARCHAR(100) NOT NULL,
                FOREIGN KEY(seller) REFERENCES sellers(sellerId),
                PRIMARY KEY(productId)
            )";        
            $stmt=$pdo->prepare($sql);        
            if (!$stmt->execute()){
                die("error in creating the products table".$stmt->error);
            }      

            //get values from form
            $idToInsert = $_POST['sellerId'];
            $countryToInsert = $_POST['country'];
            $salesToInsert = $_POST['sales'];
            $stateToInsert = $_POST['state'];

            //if there is a state provided
            if($stateToInsert != ''){
                //prepare and execute insert statement
                $sql = "
                INSERT INTO sellers (sellerId, sales, country, state_)
                VALUES (:sellerId, :sales, :country, :state)
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':sellerId', $idToInsert);
                $stmt->bindParam(':sales', $salesToInsert);
                $stmt->bindParam(':country', $countryToInsert);
                $stmt->bindParam(':state', $stateToInsert);
                if(!$stmt->execute()){
                    die("<p>unknown error in adding the seller".$stmt->error."</p>");
                }
                //notify the user
                echo("<p>Seller added with name $idToInsert, country $countryToInsert,  state $stateToInsert, sales $salesToInsert</p>");
            }

            //if no state provided
            else{
                $sql = "
                INSERT INTO sellers (sellerId, sales, country)
                VALUES (:sellerId, :sales, :country)
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':sellerId', $idToInsert);
                $stmt->bindParam(':sales', $salesToInsert);
                $stmt->bindParam(':country', $countryToInsert);
                //$stmt->execute();
                if(!$stmt->execute()){
                    die("<p>unknown error in adding the seller".$stmt->error."</p>");
                }
                //notify the user
                echo("<p>Seller added with name $idToInsert, country $countryToInsert, sales $salesToInsert</p>");
            }
        }    

        //back button         
        echo("
        <button class='w3-button w3-grey w3-round-xxlarge'><a href = 'userHome.php' style = 'text-decoration:none'>Go Back</a></button>
        ");
    }

    //if user is not admin
    else{
        echo("<h1 class='w3-xxlarge w3-bottombar'>Unauthorized</h1>");
        echo("<p>Only Admin can access this page<p> <br>");
        echo("<button class = 'w3-button w3-grey w3-round-xxlarge'><a href = 'index.php' style = 'text-decoration:none'>Go Home</a></button>");
    }
}

//if user is not logged in
else{
    echo("<h1 class='w3-xxlarge w3-bottombar'>Unauthorized</h1>");
    echo("<p>Please log in to access this page<p> <br>");
    echo("<button class = 'w3-button w3-grey w3-round-xxlarge'><a href = 'index.php' style = 'text-decoration:none'>Log in</a></button>");
}

//footer
echo("
    </body>
    <footer class = 'w3-topbar w3-stretch w3-bottom w3-light-grey'> 
        <p class = 'w3-text-grey w3-tiny w3-container'> &copy; 2023 Adrienne Rose </p>
    </footer>
    </html>
");
?>