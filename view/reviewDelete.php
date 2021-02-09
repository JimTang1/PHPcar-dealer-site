
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


<?php
    if(isset($reviewDelete)){
        echo $reviewDelete;
    }
?>

    



<?php    
include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php'; 
?>