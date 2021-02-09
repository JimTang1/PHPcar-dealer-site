<?php
//This is the main controller
//Create or access a Session
session_start();

// Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';
require_once 'library/functions.php';


// Get the array of classifications
$classifications = getClassifications(1);
$navList = buildNavigation($classifications);

// Check if the firstname cookie exists, get its value
if(isset($_COOKIE['firstname'])){
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
   }
// var_dump($classifications);
// 	exit;


$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 }

 switch ($action){
    case 'template':
        include 'view/template.php';
        break;
    case 'account':
        include 'view/account';
        break;
    case 'Classic':
        include 'view/classic.php';
        break;
    case 'SUV':
        include 'view/suv.php';
        break;
    case 'Trucks':
        include 'view/trucks.php';
        break;
    case 'signuppage':
        include 'view/signuppage.php';
        break;
    case 'Sports':
        include 'view/sports.php';
        break;
    case 'Used':
        include 'view/used.php';
        break;
    case '500':
        include 'view/500.php';
        break;                                                                        
    default:
        include 'view/home.php';
   }