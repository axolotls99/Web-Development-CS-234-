<!--
This website allows users to
-log in
-register account
-search for products in a database
Based on code taught by Manas Das in CS 234 - Fall 2023 - SIUE

Requirments:
MySQL database with a registered users table and two other tables in a one-to-many relationship
Login form
Register form
Home page
User should not be allowed to access homepage or other pages if they are not logged in
W3.CSS framework use
-->
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body class="w3-container w3-light-grey">
    <h1 class = w3-xxlarge>Log In</h1>
    <form action="serverLogin.php" method='post' class = "w3-topbar">
        <label for ="username"><p>Please enter your username<p></label>
        <input type='text' name="username" id="username" class='w3-input w3-border'>
        <br>
        <label for ="password"><p>Please enter your password<p></label>
        <input type='password' name="password" id="password" class = 'w3-input w3-border'>
        <br>
        <input type="submit" value ="Log In" class='w3-button w3-grey w3-round-xxlarge'>
</form>
<h2 class = 'w3-xlarge w3-topbar'> Want to create an account instead? </h2>
    <button class='w3-button w3-grey w3-round-xxlarge'> <a href = "register.php" style = 'text-decoration:none'> Register Here </a> </button>
</body>
<footer class = 'w3-topbar w3-stretch w3-bottom'>
    <p class = 'w3-text-grey w3-tiny w3-container'> &copy; 2023 Adrienne Rose </p>
</footer>
</html>