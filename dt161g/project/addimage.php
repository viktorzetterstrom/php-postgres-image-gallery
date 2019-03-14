<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: addimage.php
 * Desc: file that adds an image.
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);
require_once("util.php");

// If user is not logged in, redirect to index.php
session_start();
$userLoggedIn = isset($_SESSION['userLoggedIn']);
if (!$userLoggedIn) {
  header("location:index.php");
}


// Get file from $_FILES
$file = $_FILES['aimage']['tmp_name'];

// Get supported mimes and check mime-type
$supportedMimes = Config::Instance()->getSupportedMimes();
$mimeType = mime_content_type($file);

// If good mime
if (in_array($mimeType, $supportedMimes, true)) {

  // Get image data
  $userName = $_SESSION['userLoggedIn'];
  $category = $_POST['cname'];
  $imageData = base64_encode(file_get_contents($file));
  $checksum = md5_file($file);

  // Get date from exif
  $exif = @exif_read_data($file);
  if (isset($exif['DateTimeOriginal'])) {
    $date =  date('Y-m-d H:i:s', strtotime($exif['DateTimeOriginal']));
  } else {
    $date = date('Y-m-d H:i:s', 0);
  }

  // Create new image
  $image = new Image($userName, $category, $imageData, $checksum, $mimeType, $date);

  // Try to add image to database
  $success = DbHandler::Instance()->addImage($image);

  var_dump($success);
  // if ($success) {

  // } else {

  // }

}