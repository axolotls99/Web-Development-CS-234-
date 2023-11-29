<?php
    session_start();

    function echoAdmin(){
        echo("<h2 class = 'w3-xlarge w3-topbar'>Products Admin</h2>"); 
        //retrieve
        echo(" 
            <h3 class = 'w3-large'> Search Products </h3>
            <h3 class ='w3-large'> You can also find the product ID here </h3>
            <form action='productSearch.php' method='post' class = 'w3-padding w3-border-bottom'>
                <label for ='product'>Please enter part or all of the name of a product</label>
                <input type='text' name='product' id='product'>
                <input type='submit' value ='Search' class='w3-button w3-grey w3-round-xxlarge'>
            </form>     
        ");
        //add
        echo("
            <h3 class = 'w3-large'> Add Product </h3>
            <form action = 'addProduct.php' method = 'post' class = 'w3-padding w3-border-bottom'>
            <label for ='name_'>Name</label>
            <input type='text' name='name_' id='name_' required>
            <label for ='price'>Price</label>
            <input type='number' name='price' id='price' placeholder='1.00' step='0.01' min='0' required>
            <label for ='seller'>Seller (seller must already exist)</label>
            <input type='text' name='seller' id='seller' required>
            <input type='submit' value ='Add' class='w3-button w3-grey w3-round-xxlarge'>
            </form>
        
        ");
        //update
        echo("
            <h3 class = 'w3-large'> Update Product </h3>
            <form action = 'updateProduct.php' method = 'post' class = 'w3-padding w3-border-bottom'>
            <label for ='productId'>ID</label>
            <input type='text' name='productId' id='productId' required>
            <br>
            <p> What field would you like to update? </p>
            <label for = 'nameChoice' class = 'w3-margin-left'>Name</label>
            <input type = 'radio' name = 'choice' id = 'name' value = 'name'  required>
            <label for = 'priceChoice' class = 'w3-margin-left'>Price</label>
            <input type = 'radio' name = 'choice' id = 'price' value = 'price' required>
            <label for = 'sellerChoice' class = 'w3-margin-left'>Seller</label>
            <input type = 'radio' name = 'choice' id = 'seller' value = 'seller' required>
            <br>
            <p> Enter the updated text for the field you have selected </p>
            <label for ='newName'>Name</label>
            <input type='text' name='newName' id='newName'>
            <label for ='newPrice'>Price</label>
            <input type='text' name='newPrice' id='newPrice'>
            <label for ='newSeller'>Seller (seller must already exist)</label>
            <input type='text' name='newSeller' id='newSeller'>
            <br> <br>
            <input type='submit' value ='Update' class='w3-button w3-grey w3-round-xxlarge'>
            </form>
        ");
        //delete
        echo("
            <h3 class = 'w3-large'> Delete Product (Deletion is Permanent!) </h3>
            <form action = 'deleteProduct.php' method = 'post' class = 'w3-padding'>
            <label for ='productId'>Product ID</label>
            <input type='text' name='productId' id='productId' required>
            <input type='submit' value ='Delete' class='w3-button w3-grey w3-round-xxlarge'>
            </form>                
        ");


        echo("<h2 class = 'w3-xlarge w3-topbar'>Sellers Admin</h2>");    //selerId sales country state
        //retrieve
        echo(" 
            <h3 class = 'w3-large'> Search Sellers </h3>
            <form action='sellerSearch.php' method='post' class = 'w3-padding w3-border-bottom'>
                <label for ='seller'>Please enter part or all of the name of a seller</label>
                <input type='text' name='seller' id='seller'>
                <input type='submit' value ='Search' class='w3-button w3-grey w3-round-xxlarge'>
            </form>     
        ");
        //add
        echo("
            <h3 class = 'w3-large'> Add Seller </h3>
            <form action = 'addSeller.php' method = 'post' class = 'w3-padding w3-border-bottom'>
            <label for ='sellerId'>Name</label>
            <input type='text' name='sellerId' id='sellerId' required>
            <label for ='sales'>Sales</label>
            <input type='number' min='0' step = '1' name='sales' id='sales' required>
            <label for ='country'>Country</label>
            <input type='text' name='country' id='country' required>
            <label for ='state'>State (optional)</label>
            <input type='text' name='state' id='state'>
            <input type='submit' value ='Add' class='w3-button w3-grey w3-round-xxlarge'>
            </form>
        
        ");
        //update
        echo("
            <h3 class = 'w3-large'> Update Seller </h3>
            <form action = 'updateSeller.php' method = 'post' class = 'w3-padding w3-border-bottom'>
            <label for ='sellerId'>Name</label>
            <input type='text' name='sellerId' id='sellerId' required>
            <br>
            <p> What field would you like to update? </p>
            <label for = 'sales' class = 'w3-margin-left'>Sales</label>
            <input type = 'radio' name = 'choice' id = 'sales' value = 'sales' required>
            <label for = 'country' class = 'w3-margin-left'>Country</label>
            <input type = 'radio' name = 'choice' id = 'country' value = 'country' required>
            <label for = 'state' class = 'w3-margin-left'>State</label>
            <input type = 'radio' name = 'choice' id = 'state' value = 'state' required>
            <br>
            <p> Enter the updated text for the field you have selected </p>
            <label for ='sales'>Sales</label>
            <input type='number' min='0' step = '1' name='sales' id='sales'>
            <label for ='country'>Country</label>
            <input type='text' name='country' id='country'>
            <label for ='state'>State</label>
            <input type='text' name='state' id='state'>
            <br> <br>
            <input type='submit' value ='Update' class='w3-button w3-grey w3-round-xxlarge'>
            </form>
        ");
        //delete
        echo("
            <h3 class = 'w3-large'> Delete Seller (Deletion is Permanent!) </h3>
            <h3 class = 'w3-large'> Warning: Deletion of a Seller will delete all of the Seller's Products! </h3>
            <form action = 'deleteSeller.php' method = 'post' class = 'w3-padding'>
            <label for ='sellerId'>Name of Seller</label>
            <input type='text' name='sellerId' id='sellerId' required>
            <input type='submit' value ='Delete' class='w3-button w3-grey w3-round-xxlarge'>    
            </form>            
        ");
    }

    function echoUser(){
        echo("
        <h2 class = 'w3-xlarge w3-topbar'>Search products</h2>
        <form action='productSearch.php' method='post' class = 'w3-padding w3-border-bottom'>
            <label for ='product'>Please enter part or all of the name of a product</label>
            <input type='text' name='product' id='product'>
            <input type='submit' value ='Search' class='w3-button w3-grey w3-round-xxlarge'>
        </form>            
        ");
    }
    //include html info
    echo("
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'> 
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Home</title>
        </head>
        <body class ='w3-container w3-light-grey' style='margin-bottom:50px'>
        "); //the bottom margin prevents the 'search again' button from being covered by the footer when admin enabled. Otherwise the user would get stuck which is bad
    //if user logged in, provide form to search products and ability to log out
    if(isset($_SESSION['username'])){
        $name = $_SESSION['username'];
        echo("
            <h1 class='w3-xxlarge'>Home</h1>
            <p>Welcome, $name!</p>
            ");
            if($name == 'Admin'){
                echoAdmin();
            }
            else{
                echoUser();
            }
            echo("
                <h2 class='w3-topbar w3-large'> Would you like to log out? </h2>
                <button class = 'w3-button w3-grey w3-round-xxlarge'><a href = 'logout.php' style = 'text-decoration:none'>Log out</a></button>
                <p class = 'w3-padding'></p> 
            "); 
    }
    //provide user a way to log in
    else{
        echo("<h1 class='w3-xxlarge w3-bottombar'>Unauthorized</h1>");
        echo("<p>Please log in to access this page<p> <br>");
        echo("<button class = 'w3-button w3-grey w3-round-xxlarge'><a href = 'index.php' style = 'text-decoration:none'>Log in</a></button>");
    }

    //put footer at bottom of every page
    echo("
        <footer class = 'w3-topbar w3-stretch w3-bottom w3-light-grey'> 
            <p class = 'w3-text-grey w3-tiny w3-container'> &copy; 2023 Adrienne Rose </p>
        </footer>
        </html>
    ");
?>