<?PHP
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: index.php
 * Desc: Start page for the site.
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);
require_once("util.php");

$title = 'DT161G - Projekt - Start';
$author = 'Viktor Zetterström';
$authorEmail = 'vize1500@student.miun.se';

// Check what kind of user is logged in.
session_start();
$userLoggedIn = isset($_SESSION['userLoggedIn']);
$adminLoggedIn = isset($_SESSION['adminLoggedIn']);

// Get username.
$username = "No user is set!";
if ($userLoggedIn) {
    $username = $_SESSION['userLoggedIn'];
}

/*******************************************************************************
 * HTML section starts here
 ******************************************************************************/
?>
<!DOCTYPE html>
<html lang="sv-SE">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?></title>
  <link rel="stylesheet" href="css/style.css"/>
  <script src="js/main.js"></script>
</head>
<body>

<!-- header with log in form -->
<header>

  <!-- Title and navigational links -->
  <div id="navigation">
    <h1><?php echo $title ?></h1>
    <div class="links">
      <a href="index.php">Start</a>
      <?PHP if ($userLoggedIn) echo '<a href="userpage.php">User</a>' ?>
      <?PHP if ($adminLoggedIn) echo '<a href="admin.php">Admin</a>' ?>
    </div>
  </div>


  <!-- login and logout forms -->
  <div class="login">
    <div id="login" <?php if ($userLoggedIn) echo 'style="display:none"' ?>>
      <form id="loginForm" action="login.php" method="POST">
        <input type="text" placeholder="Username" name="uname" id="uname" required maxlength="10" autocomplete="off">
        <input type="password" placeholder="Password" name="psw" id="psw" required>
        <input type="submit" id="loginButton" value="Log in">
      </form>
    </div>
    <div id="logout" <?php if (!$userLoggedIn) echo 'style="display:none"' ?>>
      <form id="logoutForm" action="logout.php" method="POST">
        <label for="logoutButton">Logged in as: <?PHP echo $username ?></label>
        <input type="submit" id="logoutButton" value="Log out">
      </form>
    </div>
  </div>
</header>

<!-- main content -->
<main>
  <!-- navigation sidebar -->
  <aside>
    <h2>Navigation</h2>
    <nav>
      <ul>
        <?PHP echo generateNavigationLinks() ?>
      </ul>
    </nav>
  </aside>

  <!-- area for showing pictures -->
  <section>
    <h2>Welcome!</h2>
    <p>This is a page where you can upload and categorize images. See the menu on the left for links to different users and their categories. </p>
    <p>After logging in you will have access to your userpage where you can create your own categories and add images to them.</p>
    <p>If you are an admin you will also have access to the admin page where you can add and remove users.</p>
  </section>
</main>

<!-- footer -->
<footer>
  Made by: <?PHP echo $author ?>,
  <a href="mailto:<?PHP echo $authorEmail ?>">Contact</a>
</footer>

</body>
</html>
