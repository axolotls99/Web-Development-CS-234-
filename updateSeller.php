<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

//include html info
echo("
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'> 
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Update Seller</title>
    </head>
    <body class ='w3-container w3-light-grey' style = 'margin-bottom: 50px'> 
    ");

//if logged in
if(isset($_SESSION['username'])){
    //if admin
    if($_SESSION['username'] == 'Admin'){
        echo("<h1 class = 'w3-xxlarge'>Update seller</h1>");

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            //get info from form
            $seller=$_POST['sellerId'];
            $selectedOption=$_POST['choice'];
            $salesToUpdate=$_POST['sales'];
            $stateToUpdate=$_POST['state'];
            $countryToUpdate=$_POST['country'];

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

            //search for the seller
            $sql = "SELECT sellerId
                FROM sellers
                WHERE sellerId LIKE :search";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':search', $seller);
            if(!$stmt->execute()){
                die("<p>error in searching the table".$stmt->error."</p>");
            }    
            $result = $stmt->fetchAll();

            //if the seller exists
            if(count($result) > 0){ 
                //if the user wants to update the country
                if($selectedOption == 'country'){
                    //make sure they actually entered a country
                    if($countryToUpdate!==''){
                        //prepare and execute statement
                        $sql = "
                        UPDATE sellers
                        SET country = :country
                        WHERE sellerId LIKE :search";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':country', $countryToUpdate);
                        $stmt->bindParam(':search', $seller);
                        if(!$stmt->execute()){
                            die("<p>error in searching the table".$stmt->error."</p>");
                        }   
                        else{
                            echo("<p>You have successfully changed seller country to $countryToUpdate </p>");
                        }
                    }
                    //notify if country is empty
                    else{
                        echo("<p>You chose to update Country, but Country field is empty!</p>");
                    }
                }

                //if the user wants to update the state
                else if($selectedOption =='state'){
                    //make sure they actually entered a state
                    if($stateToUpdate!==''){
                        //prepare and execute statement
                        $sql = "
                        UPDATE sellers
                        SET state_ = :state
                        WHERE sellerId LIKE :search";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':state', $stateToUpdate);
                        $stmt->bindParam(':search', $seller);
                        if(!$stmt->execute()){
                            die("<p>error in searching the table".$stmt->error."</p>");
                        }   
                        else{
                            echo("<p>You have successfully changed seller state to $stateToUpdate </p>");
                        }
                    }
                    //notify if price is empty
                    else{
                        echo("<p>You chose to update state, but state field is empty!</p>");
                    }
                }

                //if the user wants to update the sales
                else if ($selectedOption == 'sales'){
                    if($salesToUpdate!=''){
                        $sql = "
                        UPDATE sellers
                        SET sales = :sales
                        WHERE sellerId LIKE :search";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':sales', $salesToUpdate);
                        $stmt->bindParam(':search', $seller);
                        if(!$stmt->execute()){
                            die("<p>error in searching the table".$stmt->error."</p>");
                        }   
                        else{
                            echo("<p>You have successfully changed seller sales to $salesToUpdate </p>");
                    }   
                    }                     
                    //notify user if field is empty
                    else{
                        echo("<p>You chose to update Sales, but Sales field is empty!</p>");
                    }
                }

                //if they somehow did not choose any option or a secret fourth option
                else{
                    echo("<p>Error with option selection</p>");
                }
            }

            //if seller id does not exist
            else{
                echo("<p>No sellers with ID $seller were found</p>");
            }
        }   
        
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