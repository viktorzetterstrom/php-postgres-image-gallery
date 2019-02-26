<?php
/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: member.php
 * Desc: Member page for laboration 2
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/

// Här skall det ske kontroll om man har loggat in och är behörig att se denna sida.
// Annars omdirigeras man till startsidan
session_start();

$loggedIn = isset($_SESSION['loggedIn']) && isset($_SESSION['member']);
$isAdmin = isset($_SESSION['admin']);
if (!$loggedIn) {
  header("Location: index.php"); /* Redirect browser */
}
else {
  $title = "Laboration 4";
}
?>


<!DOCTYPE html>
<html lang="sv-SE">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DT161G-Laboration2-member</title>
  <link rel="stylesheet" href="css/style.css" />
  <script src="js/main.js"></script>
</head>

<body>
  <header>
    <img src="img/mittuniversitetet.jpg" alt="miun logga" class="logo" />
    <h1>
      <?php echo $title ?>
    </h1>
  </header>
  <main>
    <aside>

      <div id="login" <?php if ($loggedIn) echo 'style="display:none"' ?>>
        <h2>LOGIN</h2>
        <form id="loginForm">
          <label><b>Username</b></label>
          <input type="text" placeholder="Enter Username" name="uname" id="uname" required maxlength="10" autocomplete="off">
          <label><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
          <button type="button" id="loginButton">Login</button>
        </form>
      </div>
      <div id="logout" <?php if (!$loggedIn) echo 'style="display:none"' ?>>
        <h2>LOGOUT</h2>
        <button type="button" id="logoutButton">Logout</button>
      </div>
      <p id="message"></p>

      <h2>MENY</h2>
      <nav>
        <ul class='sidebar-links'>
          <li>
            <a href="index.php">HEM</a>
          </li>
          <li>
            <a href="guestbook.php">GÄSTBOK</a>
          </li>
          <?php if ($loggedIn): ?>
          <li>
            <a href="members.php">MEDLEMSSIDA</a>
          </li>
          <?PHP endif ?>

          <?php if ($isAdmin): ?>
          <li>
            <a href="admin.php">ADMINSIDA</a>
          </li>
          <?PHP endif ?>
        </ul>
      </nav>
    </aside>
    <section>
      <h2>Medlemssida</h2>
      <p>Denna sida skall bara kunna ses av inloggade medlemmar</p>
    </section>
  </main>
  <footer>
    Footer
  </footer>
</body>

</html>