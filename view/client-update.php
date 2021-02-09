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
    <form action ="/phpmotors/accounts/" method ="POST">
        <br>
        <div class = "txtb">
            <label for = "clientFirstname">First Name:</label>
            <input type = 'text' name = "clientFirstname" id ="clientFirstname"
            required pattern="[a-zA-Z]+"
            <?php 
                if(isset($_SESSION['clientData']['clientFirstname'])){
                    echo "value=" .$_SESSION['clientData']['clientFirstname'];
                }
            ?>> 
        </div>
        <br>
        <div class = "txtb">
            <label for = "clientLastname">Last Name:</label>
            <input type = 'text' name = "clientLastname" id ="clientLastname"
            required pattern="[a-zA-Z]+"
            <?php 
                if(isset($_SESSION['clientData']['clientLastname'])){
                    echo "value=".$_SESSION['clientData']['clientLastname'];
                }   
            ?>>
        </div>
        <br>
        <div class = "txtb">
            <label for = "clientEmail">email:</label>
            <input type = 'email' name = "clientEmail" id ="clientEmail" 
             required placeholder="Enter a valid email address"
             <?php
                if(isset($_SESSION['clientData']['clientEmail'])){
                    echo "value=".$_SESSION['clientData']['clientEmail'];
                }
             ?>>
        </div>
        <br>
        <button type = 'submit' name = "submit" id = "Save" value = "Save">Save</button>
        <input type = "hidden" name = "action" value = "Save">
        <br>
        <br>
    </form>
</div>

<br>
<div class = "signup">
    <form action ="/phpmotors/accounts/" method ="POST">
    <div class = "txtb">
        <label for = "clientPassword">Password Change:</label>
            <span>Passwords must be at least 8 characters and contain at least 1 number,
             1 capital letter and 1 special character</span> 
             <br>
            <input type = 'password' name = "clientPassword" id ="clientPassword"
            required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
        </div>
        <br>
        <button type = 'submit' name = "submit" id = "Password" value = "Password">Change password</button>
        <input type = "hidden" name = "action" value = "Password">
        <h3>Your password will change if you update your password</h3>
        </form>
</div>

<?php    
include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php'; 
?>