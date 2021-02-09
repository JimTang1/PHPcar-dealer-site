<?php

//This is the accounts controller

session_start();
// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
require_once '../model/accounts-model.php';
require_once '../model/review-model.php';
require_once '../library/functions.php';

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
    case 'comment': 
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_STRING);
        $clientId = $_SESSION['clientData']['clientId'];
        $addComment = addComment($reviewText, $invId, $clientId);
        if(isset($addComment)){
            $message = "<h4>Thanks for the review, it is displayed below.</h4>";
        }
        include '../view/vehicle-detail.php';
        header("Refresh:0");
       
        break;

    case 'Login':
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientEmail = checkEmail($clientEmail);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        $passwordCheck = checkPassword($clientPassword);

        // Run basic checks, return if errors
        if (empty($clientEmail) || empty($passwordCheck)) {
            $message = '<p class="notice">Please provide a valid email address and password.</p>';
            include '../view/login.php';
            exit;
        }

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);

        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error
        // and return to the login view
        if(!$hashCheck) {
            $message = '<p class="notice">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }
        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        //array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        $_SESSION['oldEmail'] = $_SESSION['clientData']['clientEmail'];
        $_SESSION['clientFirstname'] = $_SESSION['clientData']['clientFirstname'];

        $clientId = $_SESSION['clientData']['clientId'];
        //$_SESSION['clientLastname'] = $_SESSION['clientData']['clientLastname'];
        $reviews = getReviewsById($clientId);
        if(count($reviews)){
            $adminReview = adminCommentPage($reviews);
        }
        // Send them to the admin view
        include '../view/admin.php';
        if ($_SESSION['clientFirstname']) {
            setcookie('firstname', $_SESSION['clientFirstname'], strtotime('+1 year'), '/');
            setcookie('firstname', "", time() - 3600,'/');
            exit;
        }
        break;
        exit;
    case 'Logout':
            session_unset();
            session_destroy();
            header("Location: /phpmotors/");
        break; 
    case 'Save':
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_STRING);
        if($clientFirstname == $_SESSION['clientData']['clientFirstname'] && 
            $clientLastname == $_SESSION['clientData']['clientLastname'] && 
            $clientEmail== $_SESSION['clientData']['clientEmail'])
        {
            $message = '<p class="notice">Your accound cant update with same information.</p>';
            include '../view/client-update.php';
            break;
        }
        else
        {
            updateClient($clientFirstname, $clientLastname, $clientEmail);
            $message = '<p class="notice">Your accound has been updated.</p>';
            include '../view/admin.php';
            break;
        }
        case 'adminPage':
            $clientId = $_SESSION['clientData']['clientId'];
            //$_SESSION['clientLastname'] = $_SESSION['clientData']['clientLastname'];
            $reviews = getReviewsById($clientId);
            if(count($reviews)){
                $adminReview = adminCommentPage($reviews);
            }
            include '../view/admin.php';
            break;
        case 'ReviewEdit':
            $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_STRING);
            $invModel = filter_input(INPUT_GET, 'invModel', FILTER_SANITIZE_STRING);
            $invMake = filter_input(INPUT_GET, 'invMake', FILTER_SANITIZE_STRING);
            $reviewDate = filter_input(INPUT_GET, 'reviewDate', FILTER_SANITIZE_STRING);
            $edits = searchReviewById($reviewId);
            if($edits){
                $editPage = editReviewPage($edits, $invModel, $invMake, $reviewDate);
            }
            
            include '../view/reviewEdit.php';
            break;
        case 'ReviewDelete':
            //$reviewId = $_GET('reviewId');
            $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_STRING);
            $invModel = filter_input(INPUT_GET, 'invModel', FILTER_SANITIZE_STRING);
            $invMake = filter_input(INPUT_GET, 'invMake', FILTER_SANITIZE_STRING);
            $reviewDate = filter_input(INPUT_GET, 'reviewDate', FILTER_SANITIZE_STRING);
            $removes = searchReviewById($reviewId);
        
            if($removes){
                $reviewDelete = deleteReview($removes, $invModel, $invMake, $reviewDate);
            }
            include '../view/reviewDelete.php';
            break;
        case "delete":
            $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_STRING);
            $reviews = getReviewsById($_SESSION['clientData']['clientId']);
            if(count($reviews)){
                deleteReviewById($reviewId);
                $reviews = getReviewsById($_SESSION['clientData']['clientId']);
                $adminReview = adminCommentPage($reviews);
                $message = "<p class = 'message'>The review was deleted successfully</p>";
            }
            include '../view/admin.php';
            break;
        case "edit":
            $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_STRING);
            $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
            $textes = editReviewById($reviewId, $reviewText);
            
            $reviews = getReviewsById($_SESSION['clientData']['clientId']);
            if(count($reviews)){
                $message = "<p class = 'message'>The review was edit successfully</p>";
                $adminReview = adminCommentPage($reviews);
            }
            include '../view/admin.php';
            break;
        default:
         include '../view/login.php';
       }