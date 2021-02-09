<?php
//Add comment
function addComment($reviewText, $invId, $clientId){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO reviews (reviewText, invId, clientId)
        VALUES (:reviewText, :invId, :clientId)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
   }

function getComments($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT a.*, b.clientFirstname FROM 
            reviews a LEFT JOIN clients b ON a.clientId = b.clientId 
            WHERE invId = :invId ORDER BY reviewDate';
    //$sql = 'SELECT * FROM reviews WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    $comment = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $comment;
}

/* Get comment for table by ClinentId */
function getReviewsById($clientId){
    $db = phpmotorsConnect();
    $sql = 'SELECT a.*, b.invMake, b.invModel FROM reviews a 
    LEFT JOIN inventory b ON a.invId = b.invId;
    WHERE a.clientId = :clientId ORDER BY reviewDate';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    $stmt->execute();
    $comment = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $comment;
}


function searchReviewById($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $result;
}


   // Delete review information from the reviews table
function deleteReviewById($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
}
/**Edit comments */
function editReviewById($reviewId, $reviewText){
    $db = phpmotorsConnect();
    //echo $reviewText. "123654789";
    $sql = 'UPDATE reviews SET reviewText = :reviewText
    WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
}







