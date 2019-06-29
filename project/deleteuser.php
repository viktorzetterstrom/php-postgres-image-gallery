<?PHP
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: deleteuser.php
 * Desc: Deleting users for project. See DbHandler for exact implemnetation of
 * deleting function.
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);
require_once('util.php');

// If admin is not logged in, redirect to index.php
session_start();
$adminLoggedIn = isset($_SESSION['adminLoggedIn']);
if (!$adminLoggedIn) {
  header("location:index.php");
}

$userName = $_POST['uname'];

$success = DbHandler::Instance()->deleteUser($userName);

if ($success) {
  alertAndRedirectUser('User deleted', 'admin.php');
} else {
  alertAndRedirectUser('User could not be deleted', 'admin.php');
}
