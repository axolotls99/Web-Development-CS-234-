<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 
    <title>Register</title>
</head>
<body class ="w3-container w3-light-grey">
    <h1 class = w3-xxlarge>Register</h1>
    <form action="serverRegister.php" method='post' class = 'w3-topbar'>
        <label for ="username"><p> Please enter a username </p> </label>
        <input type='text' name="username" id="username" class ='w3-input w3-border'>
        <br>
        <label for ="password"><p>Please enter a password</p></label>
        <input type='password' name="password" id="password"  class = 'w3-input w3-border'>
        <br>
        <input type="submit" value ="Create Account" class = 'w3-button w3-grey w3-round-xxlarge'>
    </form>
    <h2 class = 'w3-xlarge w3-topbar'>Already have an account?</h2>
    <button class = 'w3-button w3-grey w3-round-xxlarge'> <a href = "index.php" style = 'text-decoration:none'> Log in here </a> </button>
</body>
<footer class = 'w3-topbar w3-stretch w3-bottom'>
    <p class = 'w3-text-grey w3-tiny w3-container'> &copy; 2023 Adrienne Rose </p>
</footer>
</html>