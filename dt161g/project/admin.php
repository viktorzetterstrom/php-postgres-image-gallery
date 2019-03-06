<?PHP
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: admin.php
 * Desc: Admin file for project
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 *****************************************************************************/

$title = 'DT161G - Projekt - Admin';
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

// If admin is not logged in, redirect to index.php
if (!$adminLoggedIn) {
  header("location:index.php");
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
      <?PHP if ($userLoggedIn) echo '<a href="images.php">Images</a>' ?>
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
        <li>
          <a>Uno</a>
        </li>
        <li>
          <a>Dos</a>
        </li>
        <li>
          <a>Tres</a>
        </li>
        <li>
          <a>Quattro</a>
        </li>
      </ul>
    </nav>
  </aside>

  <!-- Main area -->
  <section>
    <h2>Admin page</h2>

    <!-- Form for creating user -->
    <div id="createUser">
      <form id="createForm" action="createuser.php" method="POST">
        <h3>Create user</h3>
        <input type="text" placeholder="Username" name="uname" id="uname" required maxlength="10" autocomplete="off">
        <input type="password" placeholder="Password" name="psw" id="psw" required>
        <label for="admin">Admin</label>
        <input type="checkbox" name="admin" id="admin">
        <input type="submit" id="loginButton" value="Create">
      </form>
    </div>

    <!-- Form for deleting user -->
    <div id="deleteUser">
      <form id="deleteForm" action="deleteuser.php" method="POST">
        <h3>Delete user</h3>
        <input type="text" placeholder="Username" name="uname" id="uname" required maxlength="10" autocomplete="off">
        <input type="submit" id="loginButton" value="Delete">
      </form>
    </div>

  </section>
</main>

<!-- footer -->
<footer>
  Made by: <?PHP echo $author ?>,
  <a href="mailto:<?PHP echo $authorEmail ?>">Contact</a>
</footer>

</body>
</html>
