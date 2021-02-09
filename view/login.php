<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors</title>
    <link rel ="stylesheet" href ="../css/main.css">
    <link rel ="stylesheet" href ="../css/home.css">
</head> 

<body>
    
    

<div class = "content">
    <div class= "logo">
        <img src="../images/site/logo.png" alt ="">
        <?php 
        if(isset($_SESSION['loggedin'])){
            echo "<p><a href = '/phpmotors/accounts?action=Logout'>Logout</a></p>";
           
            if(isset($_SESSION['clientFirstname'])){
                echo "<span><a href = '/phpmotors/accounts?action=adminPage'>Welcome $_SESSION[clientFirstname]</a></span>";
            }
        }else{
            echo '<p><a href = "/phpmotors/accounts">My account</a></p>';
        }
        ?>
    </div>
    
    
<nav>
<?php
echo $navList;?>
</nav>

<?php
if(isset($message)){
    echo $message;
}
?>

<div class = "signup">
    <h1>account</h1>
    <form action ="/phpmotors/accounts/" method ="POST">
    <div class = "txtb">
        <label for ="email">Your Email:</label>
        <input type = 'text' name = "clientEmail" id = "email" placeholder="please enter your Email" 
        required
             <?php
                if(isset($clientEmail)){
                    echo "value='$clientEmail'";
                }
             ?>>
    </div>
    <br>
    <div class = "txtb">
        <label for ="password">Password:</label>
        <input type = 'password' name = "clientPassword" id='password'
        required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
    </div>
    <br>
    <input type="submit" value = "Sign-in">
    <input type="hidden" name="action" value="Login">
    </form>
</div>
<p><a href = "?action=signuppage">Create an account</a></p>


<?php    
include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php'; 
?>