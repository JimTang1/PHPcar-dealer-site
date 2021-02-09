<?php
require_once '../library/connections.php';
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
<h1>add-vehicle</h1>
    <form action ="/phpmotors/vehicles/" method ="POST">
        <br>

        <div class = "txtb">
            <label for = "classificationId">classification:</label>
            <select name = "classificationId" id ="classificationId">
            <?php
                $db = phpmotorsConnect();
                $sql = "SELECT * FROM carclassification ORDER BY classificationId";
                $opt = "";
                foreach($db->query($sql) as $row){
                    $opt = $opt.'<option value ="'.$row['classificationId'].'">';
                    $opt = $opt.$row['classificationName'].'</option>';
                }
                echo $opt;
                $db = null;
            ?>
                <!-- <option>Classic</option>
                <option>Sports</option>
                <option>SUV</option>
                <option>Trucks</option>
                <option>Used</option> -->
            </select>
        </div>

        <br>
        <div class = "txtb">
            <label for = "invMake">Make:</label>
            <input type = 'text' name = "invMake" id ="invMake" 
            required pattern="[0-9a-zA-Z]+" placeholder="Please Enter Make."
            <?php
                if(isset($invMake)){
                    echo "value='$invMake'";
                }
             ?>>
        </div>
        <br>
        <div class = "txtb">
            <label for = "invModel">Model:</label>
            <input type = 'text' name = "invModel" id ="invModel"
            required pattern="[0-9a-zA-Z]+" placeholder="Please Enter a Model."
            <?php
                if(isset($invModel)){
                    echo "value='$invModel'";
                }
             ?>>
        </div>
        <br>
        <div class = "txtb">
            <label for = "invDescription">Description:</label>
            <textarea name = "invDescription" id ="invDescription" rows="4" cols="50"
            required placeholder="Please Enter something" 
            <?php
                if(isset($invDescription)){
                    echo "value='$invDescription'";
                }
             ?>></textarea>
        </div>
        <br>
        <div class = "txtb">
            <label for = "invImage">lmage Path:</label>
            <input type = 'text' name = "invImage" id ="invImage" value = "/phpmotors/images/no-image.png">
        </div>
        <br>
        <div class = "txtb">
            <label for = "invThumbnail">Thumbnail Path:</label>
            <input type = 'text' name = "invThumbnail" id ="invThumbnail" value = "/phpmotors/images/no-image.png">
        </div>
        <br>
        <div class = "txtb">
            <label for = "invPrice">Price:</label>
            <input type = 'text' name = "invPrice" id ="invPrice"
            required pattern="[0-9]+" placeholder="Please Enter the price.'number'"
            <?php
                if(isset($invPrice)){
                    echo "value='$invPrice'";
                }
             ?>>
        </div>
        <br>
        <div class = "txtb">
            <label for = "invStock">Stock:</label>
            <input type = 'text' name = "invStock" id ="invStock"
            required pattern="[0-9]+" placeholder="Please Enter the stock.'number'"
            <?php
                if(isset($invStock)){
                    echo "value='$invStock'";
                }
             ?>>
        </div>
        <br>
        <div class = "txtb">
            <label for = "invColor">Color:</label>
            <input type = 'text' name = "invColor" id ="invColor"
            required pattern="[a-zA-Z]+" placeholder="Please Enter the color."
            <?php
                if(isset($invColor)){
                    echo "value='$invColor'";
                }
             ?>>
        </div>
        <br>

        <button type = 'submit' name = "submit" id = "vehbtn" value = "add-vehicle">Add Vehicle</button>
        <input type = "hidden" name = "action" value = "vehicle">
    </form>
</div>

<?php    
include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php'; 
?>