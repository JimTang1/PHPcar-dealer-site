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
        <p><a href = "/phpmotors/accounts">My account</a></p>
    </div>
    
<nav>
<?php
echo $navList;?>
</nav>

<h1>Sorry! our server seems to be experiencing some technical difficulties. 
Please check back later</h1>

<?php    
include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php'; 
?>