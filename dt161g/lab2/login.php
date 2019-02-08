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


processLogin();

// Enum för loginstatus
interface LoginStatus {
    const OK = 0;
    const INVALID_USER = 1;
    const WRONG_PASSWORD = 2;
};


function processLogin(): void {
  // userArray holds username and password
  // There are two users: m with password m and a with password a
  $userArray = array(
    'm' => 'm',
    'a' => 'a'
  );

  // This array holds the links to be displayed when a user has logged in
  $linkArray = [
  'Hem' => 'index.php',
  'Gästbok' => 'guestbook.php',
  'Medlemssida' => 'members.php'
  ];

  session_start();

  if (!empty($_POST)) {
    $userName = $_POST['uname'];
    $password = $_POST['psw'];
    $loginStatus = login($userName, $password, $userArray);
    $response = [];

    if ($loginStatus == LoginStatus::OK) {
      $_SESSION[$userName] = 'loggedIn';
      $response['responseText'] = 'You are logged in.';
      $response['links']  = $linkArray;
    } elseif ($loginStatus == LoginStatus::INVALID_USER) {
      $response['responseText']  = 'User name does not exist.';
    } elseif ($loginStatus == LoginStatus::WRONG_PASSWORD) {
      $response['responseText']  = 'Wrong password.';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
  } 
}

function login(string $userName, string $password, array $userArray): int {
  $status = LoginStatus::INVALID_USER;
  foreach ($userArray as $storedUserName => $storedPassword) {
    if ($userName == $storedUserName) {
      if ($password == $storedPassword) {
        $status = LoginStatus::OK;
      } else {
        $status = LoginStatus::WRONG_PASSWORD;
      }
    }
  }
  return $status;
}
?>