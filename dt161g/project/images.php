<?PHP
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: images.php
 * Desc: Page that displays images of different users.
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);
require_once("util.php");



$title = 'DT161G - Projekt - Images';
$author = 'Viktor Zetterström';
$authorEmail = 'vize1500@student.miun.se';

// Check what kind of user is logged in.
session_start();
$userLoggedIn = isset($_SESSION['userLoggedIn']);
$adminLoggedIn = isset($_SESSION['adminLoggedIn']);

// Get username.
$loggedInUser = "No user is set!";
if ($userLoggedIn) {
    $loggedInUser = $_SESSION['userLoggedIn'];
}

// Determine which user and/or category to show.
$userName = "";
$category = "";
if (isset($_GET['user'])) {
  $userName = $_GET['user'];
}
if (isset($_GET['category'])) {
  $category = $_GET['category'];
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
        <label for="logoutButton">Logged in as: <?PHP echo $loggedInUser ?></label>
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
    <h2>Images</h2>
    <?php
      $images = DbHandler::Instance()->getImages($userName, $category);

      // See if we could find any images.
      if (!empty($images)) {
        // Show heading
        $message = 'Showing pictures from user ' . $userName;
        if ($category != "" ) $message .= ' and category ' . $category;

        echo '<h3>' . $message . '</h3>';

        // Show images
        foreach ($images as $image) {
          echo $image->generateTag("regular-image");
        }
      } else {
        // Check if username/category was provided/correct
        if ($userName === "") {
          echo '<h3>No user specified, cannot show any pictures</h3>';
        } else if (DbHandler::Instance()->getUser($userName)->getUserName() == null) {
          echo '<h3>Specified user does not exist</h3>';
        } else if ($category === "") {
          echo '<h3>No pictures in database for user ' . $userName . '</h3>';
        } else {
          echo '<h3>No pictures in database for user ' . $userName . ' in the category ' . $category . '</h3>';
        }
      }


    ?>
  </section>
</main>

<!-- footer -->
<footer>
  Made by: <?PHP echo $author ?>,
  <a href="mailto:<?PHP echo $authorEmail ?>">Contact</a>
</footer>

</body>
</html>
