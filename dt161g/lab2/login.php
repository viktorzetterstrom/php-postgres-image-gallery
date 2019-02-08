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
  $responseText = '';
  if (!empty($_POST)) {
    $userName = $_POST['uname'];
    $password = $_POST['psw'];
    $loginOk = login($userName, $password, $userArray);
    
    if ($loginOk) {
      $responseText .= 'LoginOK!';
    } else {
      $responseText .= 'myeeeh!';
    }

  echo $responseText;
  } 
}

function login(string $userName, string $password, array $userArray): bool {
  foreach ($userArray as $storedUserName => $storedPassword) {
    if ($userName == $storedUserName && $password == $storedPassword) {
      return true;
    }
  }
  return false;
}
?>