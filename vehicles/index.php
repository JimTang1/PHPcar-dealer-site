<?php

//This is the accounts controller

session_start();
// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
require_once '../model/accounts-model.php';
require_once '../model/vehicle-model.php';
require_once '../library/functions.php';
require_once '../model/review-model.php';

// Get the array of classifications

$classifications = getClassifications(1);
$navList = buildNavigation($classifications);



// var_dump($classifications);
// 	exit;


$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 }

 switch ($action){
    case 'getInventoryItems': 
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId); 
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray); 
        break;

    case 'classifications':
        $classificationName = filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_STRING);
        if(empty($classificationName)){
            $message = '<p>Please provide a classification name.</p>';
            include '../view/add-classification.php';
            exit; 
        }    
        $regOutcome = addClasssification($classificationName);
        if($regOutcome === 1){
            $message = "<p>Thanks adding a classification $classificationName.</p>";
            include '../view/add-classification.php';
            exit;
        } else {
            $message = "<p>Sorry. Please try again.</p>";
            include '../view/add-classification.php';
            exit;
        } 
        break;

    case 'vehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_STRING);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_STRING);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_STRING);

        if(empty($invMake)||empty($invModel)||empty($invDescription)||empty($invImage)||
        empty($invThumbnail)||empty($invPrice)||empty($invStock)||empty($invColor)||empty($classificationId)){
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/add-vehicle.php';
            exit; 
        }

        $regOutcome = addVehicle($invMake, $invModel, $invDescription, $invImage, 
        $invThumbnail, $invPrice, $invStock,$invColor,$classificationId);
    
        // Check and report the result
        if($regOutcome === 1){
            $message = "<p>Thanks for adding a vehicle.</p>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<p>Sorry. Please try again.</p>";
            include '../view/add-vehicle.php';
            exit;
        }
        break; 
    case 'add-classification':
        include '../view/add-new-classification.php';
        break;
    case 'add-vehicle':
        include '../view/add-new-vehicle.php';
        break;
    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
        $vehicles = getVehiclesByClassification($classificationName);
        if(!count($vehicles)){
         $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
        } else {
         $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
        include '../view/classification.php';
        break;
    case 'vehicle-detail':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_STRING);
        $vehicles = getVehiclesById($invId);
        $images = getVehiclesDetail($vehicles);
        $comments = getComments($invId);
        if(!count($vehicles)){
            $message = "<p class='notice'>Sorry, no car could be found.</p>";
           } else {
                $vehiclePage = buildVehiclePage($vehicles, $images, $comments);
        }
        include '../view/vehicle-detail.php';
        break;
    case '500':
        include '../view/500.php';
        break;   
    case 'comment': 
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_STRING);
        $clientId = $_SESSION['clientData']['clientId'];
        $addComment = addComment($reviewText, $invId, $clientId);
        include '../view/vehicle-detail.php';
        header("Refresh:0");
        break;
    default:
        include '../view/vehicle-man.php';
        exit;
        break;
   }