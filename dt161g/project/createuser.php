<?PHP
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: createuser.php
 * Desc: Creating users for project. See DbHandler for implementation.
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);
require_once('util.php');

$userName = $_POST['uname'];
$password = $_POST['psw'];
$isAdmin = isset($_POST['admin']) ? true : false;

$success = DbHandler::Instance()->createUser($userName, $password, $isAdmin);

if ($success) {
  alertAndRedirectUser('User created', 'admin.php');
} else {
  alertAndRedirectUser('User could not be created', 'admin.php');
}
