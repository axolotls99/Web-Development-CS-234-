<?php
//done with formatting, needs more testing

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
        <title>Add Product</title>
    </head>
    <body class ='w3-container w3-light-grey' style = 'margin-bottom: 50px'> 
");

//if logged in
if(isset($_SESSION['username'])){
    //if logged in as admin
    if($_SESSION['username'] == 'Admin'){
        echo("<h1 class = 'w3-xxlarge'>Add product</h1>");
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
            if (!$stmt->execute()){ //executes statement while checking for failure
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

            //get info from form
            $nameToInsert = $_POST['name_'];
            $priceToInsert = $_POST['price'];
            $sellerFromUser = $_POST['seller'];

            //seller must exist already
            $searchString = $sellerFromUser;
            $sql = "SELECT sellerId 
                FROM sellers
                WHERE sellerId LIKE :search";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':search', $searchString);
            if(!$stmt->execute()){
                die("<p>error in searching the table".$stmt->error."</p>");
            }
            $result = $stmt->fetchAll();

            //if the seller was found
            if(count($result) > 0){
                //create and execute add statement
                $sellerToInsert = $sellerFromUser;
                $sql = "
                INSERT INTO products (name_, price, seller)
                VALUES (:nameInsert, :priceInsert, :sellerInsert)
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nameInsert', $nameToInsert);
                $stmt->bindParam(':priceInsert', $priceToInsert);
                $stmt->bindParam(':sellerInsert', $sellerToInsert);
                if(!$stmt->execute()){
                    die("<p>unknown error in adding the product".$stmt->error."</p>");
                }
                //notify the user of their actions
                echo("<p>Product added with name $nameToInsert, price $priceToInsert, seller $sellerToInsert</p>");
            }
            //if not found notify user
            else{
                echo("Error: Seller not found in database.");
            }
        } 
        //have back button 
        echo("
            <button class='w3-button w3-grey w3-round-xxlarge'><a href = 'userHome.php' style = 'text-decoration:none'>Go Back</a></button>
        ");
        }

        //if logged in but not admin
        else{
            echo("<h1 class='w3-xxlarge w3-bottombar'>Unauthorized</h1>");
            echo("<p>Only Admin can access this page<p> <br>");
            echo("<button class = 'w3-button w3-grey w3-round-xxlarge'><a href = 'index.php' style = 'text-decoration:none'>Go Home</a></button>");
        }
    }

    //if not logged in at all
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