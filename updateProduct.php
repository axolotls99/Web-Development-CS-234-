<?php
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
        <title>Update Product</title>
    </head>
    <body class ='w3-container w3-light-grey' style = 'margin-bottom: 50px'> 
    ");

//if logged in
if(isset($_SESSION['username'])){
    //if admin
    if($_SESSION['username'] == 'Admin'){
        echo("<h1 class = 'w3-xxlarge'>Update product</h1>");

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            //get info from form
            $product=$_POST['productId'];
            $selectedOption=$_POST['choice'];
            $nameToUpdate=$_POST['newName'];
            $priceToUpdate=$_POST['newPrice'];
            $sellerToUpdate=$_POST['newSeller'];

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

            //search for the product
            $sql = "SELECT productId
                FROM products 
                WHERE productId LIKE :search";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':search', $product);
            if(!$stmt->execute()){
                die("<p>error in searching the table".$stmt->error."</p>");
            }    
            $result = $stmt->fetchAll();

            //if the product exists
            if(count($result) > 0){ 

                //if the user wants to update the seller, we should know if it exists
                $sql = "SELECT sellerId
                FROM sellers
                WHERE sellerId LIKE :search";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':search', $sellerToUpdate);
                if(!$stmt->execute()){
                    die("<p>error in searching the table".$stmt->error."</p>");
                }    
                $result = $stmt->fetchAll();
                $sellerExists = FALSE;
                if(count($result)>0){
                    $sellerExists = TRUE;
                }

                //if the user wants to update the name
                if($selectedOption == 'name'){
                    //make sure they actually entered a name
                    if($nameToUpdate!==''){
                        //prepare and execute statement
                        $sql = "
                        UPDATE products
                        SET name_ = :name
                        WHERE productId LIKE :search";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':name', $nameToUpdate);
                        $stmt->bindParam(':search', $product);
                        if(!$stmt->execute()){
                            die("<p>error in searching the table".$stmt->error."</p>");
                        }   
                        else{
                            echo("<p>You have successfully changed product name to $nameToUpdate </p>");
                        }
                    }
                    //notify if name is empty
                    else{
                        echo("<p>You chose to update Name, but Name field is empty!</p>");
                    }
                }

                //if the user wants to update the price
                else if($selectedOption =='price'){
                    //make sure they actually entered a price
                    if($priceToUpdate!==''){
                        //prepare and execute statement
                        $sql = "
                        UPDATE products
                        SET price = :price
                        WHERE productId LIKE :search";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':price', $priceToUpdate);
                        $stmt->bindParam(':search', $product);
                        if(!$stmt->execute()){
                            die("<p>error in searching the table".$stmt->error."</p>");
                        }   
                        else{
                            echo("<p>You have successfully changed product price to $priceToUpdate </p>");
                        }
                    }
                    //notify if price is empty
                    else{
                        echo("<p>You chose to update Price, but Price field is empty!</p>");
                    }
                }

                //if the user wants to update the seller
                else if ($selectedOption == 'seller'){
                    //use the sellerExists variable. This also takes care of empty seller case
                    if($sellerExists){
                        //prepare and execute statement
                        $sql = "
                        UPDATE products
                        SET seller = :seller
                        WHERE productId LIKE :search";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':seller', $sellerToUpdate);
                        $stmt->bindParam(':search', $product);
                        if(!$stmt->execute()){
                            die("<p>error in searching the table".$stmt->error."</p>");
                        }   
                        else{
                            echo("<p>You have successfully changed product seller to $sellerToUpdate </p>");
                        }                        
                    }
                    //have seperate error for empty field. Sometimes users don't notice
                    else if ($sellerToUpdate == ''){
                        echo("<p>You chose to update Seller, but Seller field is empty!</p>");
                    }
                    //if seller not found
                    else{
                        echo("<p>Seller not found in database!</p>");
                    }
                }

                //if they somehow did not choose any option or a secret fourth option
                else{
                    echo("<p>Error with option selection</p>");
                }
            }

            //if product id does not exist
            else{
                echo("<p>No products with ID $product were found</p>");
            }
        }   
        
        //that was a lot of cases. I'm so glad we won't have to write a function update anything else ever again. Because there's only one table. Yes?
        //back button
        echo("
        <button class='w3-button w3-grey w3-round-xxlarge'><a href = 'userHome.php' style = 'text-decoration:none'>Go Back</a></button>
        ");
    }

    //logged in but not admin
    else{
        echo("<h1 class='w3-xxlarge w3-bottombar'>Unauthorized</h1>");
        echo("<p>Only Admin can access this page<p> <br>");
        echo("<button class = 'w3-button w3-grey w3-round-xxlarge'><a href = 'index.php' style = 'text-decoration:none'>Go Home</a></button>");
    }
}

//not logged in
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