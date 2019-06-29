<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: createcategory.php
 * Desc: Creating categories for user
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
$success = DbHandler::Instance()->createCategory($categoryName, $userName);

if ($success) {
  alertAndRedirectUser('Category added', 'userpage.php');
} else {
  alertAndRedirectUser('Category could not be created', 'userpage.php');
}
