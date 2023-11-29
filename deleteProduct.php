<?php
//formatting done, needs more testing
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
        <title>Delete Product</title>
    </head>
    <body class ='w3-container w3-light-grey' style = 'margin-bottom: 50px'> 
");

//if user logged in
if(isset($_SESSION['username'])){
    //if user is admin
    if($_SESSION['username'] == 'Admin'){
        echo("<h1 class = 'w3-xxlarge'>Delete product</h1>");

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

            //get info from form
            $productToDelete = $_POST['productId'];

            //prepare and execute statement to search for product
            $searchString = $productToDelete;
            $sql = "SELECT productId
                FROM products
                WHERE productId LIKE :search";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':search', $searchString);
            if(!$stmt->execute()){
                die("<p>error in searching the table".$stmt->error."</p>");
            }
            $result = $stmt->fetchAll();

            //if the product exists
            if(count($result) > 0){
                //prepare and execute delete statement
                $sql = "
                DELETE FROM products
                WHERE (productId = :Id)
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':Id', $productToDelete);
                if(!$stmt->execute()){
                    die("<p>unknown error in deleting the product".$stmt->error."</p>");
                }
                //if successful, notify user       
                else{
                    echo("<p>Product with ID $productToDelete successfully deleted!</p>");
                }
            }

            //if product does not exist, notify user
            else{
                echo("No product with that id number!");
            }     
        }
        
        //back button
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

//if not logged in
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