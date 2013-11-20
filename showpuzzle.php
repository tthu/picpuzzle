<?php
 
 session_start();

  //session_register('winX');
  //session_register('winY');
  //session_register('image_array');
  //session_register('number_of_puzzles');
  //session_register('xy_values');

 include('inc/functions.php'); 

$allowedExts = array("gif", "jpeg", "jpg", "png");
$boxPX = $_POST['boxsize'];
$_SESSION['winX'] = $_POST['w_width'];
$_SESSION['winY'] = $_POST['w_height'];
$_SESSION['image_array'] = array();
$_SESSION['number_of_puzzles'] = 0;
$_SESSION['current_puzzle'] = 1;


$uploadDir = "images/";
for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
  $ext = substr(strrchr($_FILES['file']['name'][$i], "."), 1); 
  if ((($_FILES['file']["type"][$i] == "image/gif")
  || ($_FILES['file']["type"][$i] == "image/jpeg")
  || ($_FILES['file']["type"][$i] == "image/jpg")
  || ($_FILES['file']["type"][$i] == "image/pjpeg")
  || ($_FILES['file']["type"][$i] == "image/x-png")
  || ($_FILES['file']["type"][$i] == "image/png"))
  && ($_FILES['file']["size"][$i] < 2000000)
  && in_array($ext, $allowedExts))
    {
    if ($_FILES['file']["error"][$i] > 0)
      {
      echo "Error: " . $_FILES['file']["error"][$i] . "<br>";
      }
    }
  else
    {
      echo "invalid";
  }
  //resize and save all images
  $original_image = $_FILES['file']['tmp_name'][$i];
  $size=GetImageSize( $original_image );
  $new_Name = strval(rand() * time()) . "." . $ext;
  //generate random filename
  $new_image = "images/" . $new_Name;
  $image = new Imagick($_FILES['file']['tmp_name'][$i]);
  $image->adaptiveResizeImage(0,$_SESSION['winY']);
  $image->setImageFilename($new_image);
  $image->writeImage();
  $_SESSION['image_array'][] = $new_image;
     
 }

 
$_SESSION['number_of_puzzles'] = sizeof($_SESSION['image_array']);
 
//set box configuration
$_SESSION['xy_values'] = pp_get_box_size($boxPX);
 
//get new image size
list($width, $height) = getimagesize($_SESSION['image_array'][($_SESSION['current_puzzle'] - 1)]);

//Set box sizes in pixels
$boxW = round($width / $_SESSION['xy_values'][0]);
$boxH = round($height / $_SESSION['xy_values'][1]);

$pagestart = pp_build_page($_SESSION['image_array'][0], $height, $width, $boxH, $boxW);

print $pagestart;
exit;

?>
