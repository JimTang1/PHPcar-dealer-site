<?php

function getClassifications($p_level){
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect(); 

    // The SQL statement to be used with the database 
    if ($p_level == 3)
        $sql = 'SELECT classificationName FROM carclassification ORDER BY classificationName ASC'; 
    else
        $sql = 'SELECT classificationName FROM carclassification where classificationName != "vehicles" ORDER BY classificationName ASC';             
    
    // The next line creates the prepared statement using the phpmotors connection      
    $stmt = $db->prepare($sql);
    
    // The next line runs the prepared statement 
    $stmt->execute(); 
    
    // The next line gets the data from the database and 
    // stores it as an array in the $classifications variable 
    $classifications = $stmt->fetchAll(); 
    
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 
    
    // The next line sends the array of data back to where the function 
    // was called (this should be the controller) 
    return $classifications;
   }