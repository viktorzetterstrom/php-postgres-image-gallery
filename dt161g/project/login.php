<?PHP
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: login.php
 * Desc: Login page for project
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);
require_once('util.php');


if (isset($_POST['uname'])) {
  echo $_POST['uname'];
}

session_start();

$_SESSION['userLoggedIn'] = 'true';

header('location:index.php');