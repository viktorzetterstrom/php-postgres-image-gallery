<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: deletecategory.php
 * Desc: Deleting categories for user
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

$categoryName = $_POST['cname'];
$userName = $_SESSION['userLoggedIn'];
$success = DbHandler::Instance()->deleteCategory($categoryName, $userName);

if ($success) {
  alertAndRedirectUser('Category deleted', 'userpage.php');
} else {
  alertAndRedirectUser('Category could not be deleted', 'userpage.php');
}
