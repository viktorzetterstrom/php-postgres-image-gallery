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

processLogin();

// Processes attempt to log in.
function processLogin(): void {
  if (!empty($_POST)) {
    $userName = $_POST['uname'];
    $password = $_POST['psw'];

    // Get user from database.
    $user = DbHandler::Instance()->getUser($userName);

    // Test the password.
    $loginOk =  $user->testPassword($password);

    // If login ok, check user roles and store in session.
    if ($loginOk) {
      session_start();
      foreach ($user->getRoles() as $role) {
        if ($role->getRole() == 'user') {
          $_SESSION['userLoggedIn'] = $userName;
        } else if ($role->getRole() == 'admin') {
          $_SESSION['adminLoggedIn'] = $userName;
        }
      }

      // Redirect to userpage.php
      header('location:userpage.php');
    } else {
      // If login not ok, redirect to error page.
      alertAndRedirectUser('Could not log in, check username or password.', 'index.php');
    }
  }
}