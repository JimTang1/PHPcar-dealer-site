<?php

/*
* Accounts Model
*/


//Register a new client
function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO clients (clientFirstname, clientLastname,clientEmail, clientPassword)
        VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
   }

   // Check for an existing email address
function checkExistingEmail($clientEmail) {
    $db =  phpmotorsConnect();
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();
    if(empty($matchEmail)){
        return 0;
        // echo 'Nothing found';
        // exit;
    } else {
        return 1;
        // echo 'Match found';
        // exit;
    }
}

function getClient($clientEmail){
    $db = phpmotorsConnect();
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientEmail = :clientEmail';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
}

function logOut(){
    if($_POST['submit']){
        session_star();
        session_unset();
        session_destroy();
        header("Location: ../index.php");
    }
}

function updateClient($clientFirstname, $clientLastname, $clientEmail){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    // $sql = 'INSERT INTO clients (clientFirstname, clientLastname,clientEmail, clientPassword)
    //     VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';

    $sql = 'UPDATE clients 
    SET 
    clientFirstname = :clientFirstname,
    clientLastname = :clientLastname,
    clientEmail = :clientEmail 
    WHERE clientEmail = :oldEmail'; 

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':oldEmail', $_SESSION['oldEmail'], PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    //update the new email
    $_SESSION['oldEmail'] = $clientEmail;   
    //update session containt
    $clientData = getClient($clientEmail);
    //array_pop($clientData);
    $_SESSION['clientData'] = $clientData;
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
   }

   function updatePassword($clientPassword){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    // $sql = 'INSERT INTO clients (clientFirstname, clientLastname,clientEmail, clientPassword)
    //     VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';

    $sql = 'UPDATE clients 
    SET 
    clientPassword = :clientPassword
    WHERE clientEmail = :oldEmail'; 

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
    $stmt->bindValue(':clientPassword', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindValue(':oldEmail', $_SESSION['oldEmail'], PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    //update session containt
    $clientData = getClient($_SESSION['clientData']['clientEmail']);
    $_SESSION['clientData'] = $clientData;
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
   }
