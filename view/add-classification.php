<?php
require_once '../library/functions.php';
checkClientLevel();
?>
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
<h1>add-classification</h1>

<form action ="/phpmotors/vehicles/" method ="POST">
    <div class = "txtb">
        <label for ="classificationName">Classification Name:</label>
        <input type = 'text' name = "classificationName" id = "classificationName" 
        required placeholder = "Enter a Classification Name" 
        <?php
                if(isset($classificationName)){
                    echo "value='$classificationName'";
                }
        ?>>
    </div>
    <br>
    <button type = 'submit' name = "submit" id = "csfbtn" value = "Add-Classification">Add Classification</button>
        <input type = "hidden" name = "action" value = "classifications">
</form>
</div>
<?php    
include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php'; 
?>