<?php

function checkEmail($clientEmail){
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
    return preg_match($pattern, $clientPassword);
}

function buildNavigation($classifications){
    $navList = '<ul>';
    $navList .= "<li><a href='/phpmotors/index.php' 
                title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
     $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName="
     .urlencode($classification['classificationName'])."' title='View our 
     $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a>
     </li>";
    }
    $navList .= '</ul>';
    return $navList;
}

function checkClientLevel(){
    if(empty($_SESSION['clientData']['clientLevel'])||$_SESSION['clientData']['clientLevel'] == 1)
        header("Location: /phpmotors/");
}
// Build the classifications select list 
function buildClassificationList($classifications){ 
    $classificationList = '<select name="classificationId" id="classificationList">'; 
    $classificationList .= "<option>Choose a Classification</option>"; 
    foreach ($classifications as $classification) { 
     $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
    } 
    $classificationList .= '</select>'; 
    return $classificationList; 
}

//wrap vehicles by classification in a list
function buildVehiclesDisplay($vehicles){
    $dv = '<ul id="inv-display">';
    foreach ($vehicles as $vehicle) {
     $dv .= '<li>';
     $dv .= "<a href='/phpmotors/vehicles/?action=vehicle-detail&invId=$vehicle[invId]'>
            <img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com' 
            id= $vehicle[invId] class = 'car-image'>";
     $dv .= '<hr>';
     $dv .= "<h3>$vehicle[invMake] $vehicle[invModel]</h3></a>";
     $dv .= "<h3>$vehicle[invPrice]</h3>";
     $dv .= '</li>';
     
    }
    $dv .= '</ul>';
    
    return $dv;
}


/*******************************
 * Vehicle Detail page
 ********************************/
function buildVehiclePage($vehicles, $images, $comments){
    $dv = '<ul id="detail-display">';
    foreach ($vehicles as $vehicle) {
        $dv .= '<li>';
        $dv .= "<h1><img class='idImg' src='$vehicle[invThumbnail]' alt=''>$vehicle[invMake] $vehicle[invModel]</h1>";
        foreach($images as $image){
            $dv .= "<br><img class='Imgs' src='$image[imgPath]'> " ;
        }
        $dv .= "<img src='$vehicle[invImage]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com' 
            id= $vehicle[invId] class = 'car-detail-image'>";
        $dv .= "<h3>Price: $vehicle[invPrice]</h3>";
        $dv .= '<hr>';
        $dv .= "<h2>$vehicle[invMake] $vehicle[invModel] Details</h2>";
        $dv .= "<h3>$vehicle[invDescription]</h3>";
        $dv .= "<h3>Color: $vehicle[invColor]</h3>";
        $dv .= "<h3># in Stock: $vehicle[invStock]</h3>";
        $dv .= "<hr>";
        $dv .= "<h3>Customer Reviews</h3>";
        $dv .= '</li>';
    }
    $dv .= "</ul>";

    $dv .= "<div id='detail-display1'>";
    if(!empty($_SESSION['loggedin'])){
        $screenName = ucfirst(substr($_SESSION['clientFirstname'],0,1)).". ".$_SESSION['clientData']['clientLastname'];

        $dv .= "<h3>Review the Batmobile Custom</h3>";
        $dv .= "<form method = 'POST'>
                    <div class = 'comment-borad'>
                    <h4>Sceen name:</h4>
                    <h4 class ='screenName'>$screenName</h4>
                    <br>
                    <textarea name = 'reviewText' id='reviewText' class ='reviewText' required></textarea>
                    <br>

                    <button type= 'submit'>Submit</button>
                    <input type = 'hidden' name = 'action' value = 'comment'>
                    <input type = 'hidden' name = 'invId' value = $vehicle[invId]>
                    <br>
                    </div>
                </form>";
    }else{
        $dv .= "<h4>Please 
        <a href=/phpmotors/accounts>
        login</a> to leave your comment!</h4>";
    }
    //$dv .= showCommentPage($comments)
    if(empty($comments)){
        $dv .= "<h4>Be the first one to write comment</h4>";
    }else{
        foreach ($comments as $comment) {
            $dv .= "<div class = 'commentArea'>";
            $dv .= "<h3>$comment[clientFirstname] wrote on $comment[reviewDate]</h3>";
            $dv .= "<h4 class ='comment-reviewText'>$comment[reviewText]</h4>";
            $dv .= "<br>";
            $dv .= "</div>";
        }
    }
    $dv .= "</div>";
    return $dv;
}

/* * ********************************
*  Functions for review comment in admin page
* ********************************* */
function adminCommentPage($reviews){
    $dv = '<ul id = "detail-display">';
    foreach($reviews as $review){
        $date = substr($review['reviewDate'],0,10);
        $dv .= "<li>";
        $dv .= "<h4>$review[invMake] $review[invModel] ($review[reviewDate]): 
        <a href='/phpmotors/accounts/?action=ReviewEdit&reviewId=$review[reviewId]&invModel=$review[invModel]&invMake=$review[invMake]&reviewDate=$date '>Edit</a>. 
        <a href='/phpmotors/accounts/?action=ReviewDelete&reviewId=$review[reviewId]&invModel=$review[invModel]&invMake=$review[invMake]&reviewDate=$date '>Delete</a>.</h4>";
        $dv .= "</li>";
    }
    $dv .= "</ul>";
    return $dv;
}

/* * ********************************
*  Functions for delete page
* ********************************* */
function deleteReview($removes,$invModel, $invMake, $reviewDate){
    $dv = '<ul id = "detail-display">';
    foreach($removes as $remove){
        $dv .= "<li class = 'deleteTable'>";
        $dv .= "<form method='POST'>";
        $dv .= "<h1>Delete $invModel $invMake Review</h1>";
        $dv .= "<h4>Reviewed on $reviewDate</h4>";
        $dv .= "<p class = 'showText'>$remove[reviewText]<p>";
        $dv .= "<br>";
        $dv .= "<button type = 'submit'>Delete</button>";
        $dv .= "<input type = 'hidden' name = 'action' value = delete>";
        $dv .= "<input type = 'hidden' name = 'reviewId' value = $remove[reviewId]>";
        $dv .= "</form>";
        $dv .= "</li>";
    }
    $dv .= "</ul>";
    return $dv;
}

function editReviewPage($edits, $invModel, $invMake, $reviewDate){
    $dv = '<ul id = "detail-display">';
    foreach($edits as $edit){
        $dv .= "<li class = 'editTable'>";
        $dv .= "<form method='POST'>";
        $dv .= "<h1>$invModel $invMake Review</h1>";
        $dv .= "<h4>Reviewed on $reviewDate</h4>";
        $dv .= "<textarea name = 'reviewText' class ='reviewText'>$edit[reviewText]</textarea>";
        $dv .= "<br>";
        $dv .= "<button type = 'submit'>Edit</button>";
        $dv .= "<input type = 'hidden' name = 'action' value = 'edit'>";
        $dv .= "<input type = 'hidden' name = 'reviewId' value = $edit[reviewId]>";
        $dv .= "</form>";
        $dv .= "</li>";
    }
    $dv .= "</ul>";
    return $dv;
}
/* * ********************************
*  Functions for working with images
* ********************************* */
// Adds "-tn" designation to file name
function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
   }


   // Build images display for image management view
function buildImageDisplay($imageArray) {
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
     $id .= '<li>';
     $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] 
     image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com123'>";

     $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' 
     title='Delete the image'>Delete $image[imgName]</a></p>";
     $id .= '</li>';
   }
    $id .= '</ul>';
    return $id;
   }

   // Build the vehicles select list
function buildVehiclesSelect($vehicles) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
     $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
   }

   // Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
     // Gets the actual file name
     $filename = $_FILES[$name]['name'];
     if (empty($filename)) {
      return;
     }
    // Get the file from the temp folder on the server
    $source = $_FILES[$name]['tmp_name'];
    // Sets the new path - images folder in this directory
    $target = $image_dir_path . '/' . $filename;
    // Moves the file to the target folder
    move_uploaded_file($source, $target);
    // Send file for further processing
    processImage($image_dir_path, $filename);
    // Sets the path for the image for Database storage
    $filepath = $image_dir . '/' . $filename;
    // Returns the path where the file is stored
    return $filepath;
    }
   }


   // Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';
   
    // Set up the image path
    $image_path = $dir . $filename;
   
    // Set up the thumbnail image path
    $image_path_tn = $dir.makeThumbnailName($filename);
   
    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);
   
    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
   }

   // Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
     
    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];
   
    // Set up the function names
    switch ($image_type) {
    case IMAGETYPE_JPEG:
     $image_from_file = 'imagecreatefromjpeg';
     $image_to_file = 'imagejpeg';
    break;
    case IMAGETYPE_GIF:
     $image_from_file = 'imagecreatefromgif';
     $image_to_file = 'imagegif';
    break;
    case IMAGETYPE_PNG:
     $image_from_file = 'imagecreatefrompng';
     $image_to_file = 'imagepng';
    break;
    default:
     return;
   } // ends the swith
   
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
   
    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
   
    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {
   
     // Calculate height and width for the new image
     $ratio = max($width_ratio, $height_ratio);
     $new_height = round($old_height / $ratio);
     $new_width = round($old_width / $ratio);
   
     // Create the new image
     $new_image = imagecreatetruecolor($new_width, $new_height);
   
     // Set transparency according to image type
     if ($image_type == IMAGETYPE_GIF) {
      $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagecolortransparent($new_image, $alpha);
     }
   
     if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
      imagealphablending($new_image, false);
      imagesavealpha($new_image, true);
     }
   
     // Copy old image to new image - this resizes the image
     $new_x = 0;
     $new_y = 0;
     $old_x = 0;
     $old_y = 0;
     imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
   
     // Write the new image to a new file
     $image_to_file($new_image, $new_image_path);
     // Free any memory associated with the new image
     imagedestroy($new_image);
     } else {
     // Write the old image to a new file
     $image_to_file($old_image, $new_image_path);
     }
     // Free any memory associated with the old image
     imagedestroy($old_image);
   } // ends resizeImage function