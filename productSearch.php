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
        <title>Search Results</title>
    </head>
    <body class ='w3-container w3-light-grey' style = 'margin-bottom: 50px'> 
"); //the bottom margin prevents the 'search again' button from being covered by the footer when all products are shown. Otherwise the user would get stuck which is bad

//first check if user is logged in
//does not check for admin as any user can perform this function
if(isset($_SESSION['username'])){
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        //set up pdo
        $search=$_POST['product'];
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
    }    

    echo("<h1 class = 'w3-xxlarge w3-bottombar'>Search Results For \"$search\"</h1>");
    //this part was very difficult for me because I thought when the . turned the name white 
    //that meant it was not going to act as part of the string. Turns out the issue was something
    //entirely different. I also am not sure why adding the wildcards outside of the sql statement
    //is the only thing that works. I guess it's because a string can't be concatenated with a variable
    //using bindParam?
    //Anyway, this searches the table and then outputs results in a table format.
    $searchString = "%$search%";
    $sql = "SELECT 
        name_, 
        price, 
        productId,
        sellers.sellerId, 
        sellers.country
        FROM products
        JOIN sellers 
        ON products.seller = sellers.sellerId 
        WHERE LOWER(name_) LIKE LOWER(:search)"; //case insensitive search for my mom
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':search', $searchString);
    if(!$stmt->execute()){ //executes while checking for failure
        die("<p>error in searching the table".$stmt->error."</p>");
    }
    $result = $stmt->fetchAll();

    //if something was found, output the results
    if(count($result) > 0){ 
        //unfortunately I appear to have chosen the exact background color that causes my tables to not be striped by w3...
        //first output a header
        echo("
        <table class='w3-table w3-bottombar'>
        <thead>
        <tr>
        <td class='w3-panel w3-border-left w3-border-right w3-border-bottom'> Product </td>
        <td class='w3-panel w3-border-bottom w3-border-right'> Price </td>
        <td class = 'w3-panel w3-border-bottom w3-border-right'> Seller </td>
        <td class = 'w3-panel w3-border-bottom w3-border-right'> Country </td>
        ");

        //added admin functionality to view ID. This allows admin to update/delete products
        if($_SESSION['username']=='Admin'){
            echo("<td class = 'w3-panel w3-border-bottom w3-border-right'> ID </td>");
        }
        //close table head
        echo("
        </tr>
        </thead>
        <tbody>
        ");

        //now output the search results
        foreach($result as $line){
            echo("
            <tr>
            <td class='w3-panel w3-border-left w3-border-right'>".$line['name_']."</td>
            <td class='w3-panel w3-border-right'>".$line['price']."</td>
            <td class='w3-panel w3-border-right'>".$line['sellerId']."</td>
            <td class='w3-panel w3-border-right'>".$line['country']."</td>
            ");

            //admin 
            if($_SESSION['username']=='Admin'){
                echo("<td class = 'w3-panel w3-border-right'>".$line['productId']." </td>");
            }

            echo("</tr>");
        }
        //close table
        echo("
        </tbody>
        </table>
        <br>
        ");
    }

    else{ //if something wasn't found, notify
        echo("<p>No results found for your search.<p>");
    }
    
    //prevent page from being a dead end
    echo("<button class='w3-button w3-grey w3-round-xxlarge'><a href = 'userHome.php' style = 'text-decoration:none'>Go Back</a></button>");

}

//if not logged in
else{
    echo("<h1 class='w3-xxlarge w3-bottombar'>Unauthorized</h1>");
    echo("<p>Please log in to access this page<p> <br>");
    echo("<button class = 'w3-button w3-grey w3-round-xxlarge'><a href = 'index.php' style = 'text-decoration:none'>Log in</a></button>");
}

//put footer at bottom of every page
echo("
    </body>
    <footer class = 'w3-topbar w3-stretch w3-bottom w3-light-grey'> 
        <p class = 'w3-text-grey w3-tiny w3-container'> &copy; 2023 Adrienne Rose </p>
    </footer>
    </html>
");
//adding w3-light-grey to the footer prevents it from doing the strange transparency effect where the footer text overlaps body text. Keep in mind for later
?>