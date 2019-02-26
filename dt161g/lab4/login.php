<?PHP
/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: login.php
 * Desc: Login page for laboration 2
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
require_once('util.php');


processLogin();

// Enum för loginstatus
interface LoginStatus {
    const OK = 0;
    const INVALID_USER = 1;
    const WRONG_PASSWORD = 2;
};


function processLogin(): void {
  // This array holds the links to be displayed when a user has logged in
  $linkArray = [
  'HEM' => 'index.php',
  'GÄSTBOK' => 'guestbook.php',
  'MEDLEMSSIDA' => 'members.php'
  ];

  if (!empty($_POST)) {
    $userName = $_POST['uname'];
    $password = $_POST['psw'];

    // Get user from database.
    $user = DbHandler::Instance()->getMember($userName);

    // If no such user exists return INVALID_USER.
    if ($user->isNull()) {
      $loginStatus = LoginStatus::INVALID_USER;
    } // Test password, return OK or WRONG_PASSWORD depending on result.
    else if ($user->testPassword($password)) {
      $loginStatus = LoginStatus::OK;
    } else {
      $loginStatus = LoginStatus::WRONG_PASSWORD;
    }

    $response = [];
    if ($loginStatus == LoginStatus::OK) {
      session_start();
      $_SESSION['loggedIn'] = $userName;
      $response['responseText'] = 'You are logged in.';
      $response['links']  = $linkArray;
      $response['success'] = true;
      $response['roles'] = $user->getRoles();
    } elseif ($loginStatus == LoginStatus::INVALID_USER) {
      $response['responseText']  = 'User name does not exist.';
      $response['success'] = false;
    } elseif ($loginStatus == LoginStatus::WRONG_PASSWORD) {
      $response['responseText']  = 'Wrong password.';
      $response['success'] = false;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
  } 
}