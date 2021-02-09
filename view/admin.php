
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
    echo "<h1>Hi!". $_SESSION['clientData']['clientFirstname']." ".$_SESSION['clientData']['clientLastname'].'<br></h1>';
    echo ":".'<br>';
    echo "<h3>First Name: ". $_SESSION['clientData']['clientFirstname'].'<br></h3>';
    echo "<h3>Last Name: ". $_SESSION['clientData']['clientLastname'].'<br></h3>';
    echo "<h3>Login Email: ". $_SESSION['clientData']['clientEmail'].'<br></h3>';
    if($_SESSION['clientData']['clientLevel'] > 1 )
        echo '<p><a href = "/phpmotors/vehicles">Vehicle Management</a></p>';

    echo '<p><a href = "/phpmotors/accounts?action=Update">Client update</a></p>';
    echo '<h4>Manage Your Product Reviews:</h4>';
    
    if(isset($adminReview)){
        echo $adminReview;
    }

?>

    



<?php    
include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php'; 
?>