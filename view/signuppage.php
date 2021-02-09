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
        <?php if(isset($cookieFirstname)){
            echo "<span>Welcome $cookieFirstname</span>";
            } 
        ?>
        <p><a href = "/phpmotors/accounts">My account</a></p>
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
            <?php 
                if(isset($clientFirstname)){
                    echo "value='$clientFirstname'";
                }
            ?> require> 
        </div>
        <br>
        <div class = "txtb">
            <label for = "clientLastname">Last Name:</label>
            <input type = 'text' name = "clientLastname" id ="clientLastname"
            <?php 
                if(isset($clientLastname)){
                    echo "value='$clientLastname'";
                }
            ?> require>
        </div>
        <br>
        <div class = "txtb">
            <label for = "clientEmail">email:</label>
            <input type = 'email' name = "clientEmail" id ="clientEmail" 
             required placeholder="Enter a valid email address"
             <?php
                if(isset($clientEmail)){
                    echo "value='$clientEmail'";
                }
             ?>>
        </div>
        <br>
        <div class = "txtb">
            <label for = "clientPassword">Password:</label>
            <span>Passwords must be at least 8 characters and contain at least 1 number,
             1 capital letter and 1 special character</span> 
            <input type = 'password' name = "clientPassword" id ="clientPassword" 
            required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
        </div>
        <br>
        <button type = 'submit' name = "submit" id = "regbtn" value = "Register">submit</button>
        <input type = "hidden" name = "action" value = "register">
    </form>
</div>

<?php    
include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php'; 
?>