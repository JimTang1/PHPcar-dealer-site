
<?php
include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/header.php'; 
?>


<div class = "content">
    <div class= "logo">
        <img src="images/site/logo.png" alt ="">
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
echo $navList;
?>
</nav>

<div class = introduction>
    <h1>Welcome to PHP Motors!</h1>
    <div class = "ownCar">
        <img src = "images/delorean.jpg" alt="">
        <div class ="top-left">
            <h3>DMC Delorean</h3>
            <p>3 Cup holders</p>
            <p>Superman doors</p>
            <p>Fuzzy dice!</p>
            <img src = "images/site/own_today.png" alt ="" style ="width: 150px">
        </div>
    </div>

    <div class ="top-left1">
            <img src = "images/site/own_today.png" alt ="">
    </div>
    <div class ="container">
    <div class = "img-info">
        <h2>Delorean Upgrades</h2>
            <div class = "fRoll">
                <div class = "flame">
                    <a href = "">
                        <img src ="images/upgrades/flame.jpg" alt ="" width="50" height="50">
                        <p style = "line-height: 0px">Falme Decals</p>
                    </a>
                </div>
                <div class ="flux">
                    <a href = "">
                        <img src ="images/upgrades/flux-cap.png" alt ="" width="50" height="50">
                        <p style = "line-height: 0px">flux cap</p>
                    </a>
                </div>
            </div>


            <div class = "sRoll">
                <div class = "hub">
                    <a href = "">
                        <img src ="images/upgrades/hub-cap.jpg" alt ="" width="50" height="50">
                        <p style = "line-height: 0px">hub cap</p>
                    </a>   
                </div>

                <div class = "bumper">
                    <a href = "">
                        <img src ="images/upgrades/bumper_sticker.jpg" alt ="" width="50" height="50">
                        <p style = "line-height: 0px">Bumper</p>
                    </a> 
                </div>
            </div>
    </div>

    <div class = "car-info">
        <h2>DMC Delorean Reviews</h2>
        <ul>
            <li>"So fast its almost like trveling in time." [4/5]</li>
            <li>"Coolest ride on the road." [4/5]</li>
            <li>"I'm feeling marty McFly!" [5/5]</li>
            <li>"I'm most futuristic ride of our day" [4.5/5]</li>
            <li>"80/s livin and I love it!" [5/5]</li>
        </ul>  
    </div>   
</div>  
</div>


<?php    
include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php'; 
?>