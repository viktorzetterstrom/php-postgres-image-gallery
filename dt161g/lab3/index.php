<?PHP
/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: index.php
 * Desc: Start page for laboration 2
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
$title = "Laboration 2";

// Check if logged in.
session_start();
$loggedIn = isset($_SESSION['loggedIn']);

/*******************************************************************************
 * HTML section starts here
 ******************************************************************************/
?>
<!DOCTYPE html>
<html lang="sv-SE">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DT161G-
    <?php echo $title ?>
  </title>
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
        </ul>
      </nav>
    </aside>
    <section>
      <h2>VÄLKOMMEN
      </h2>
      <p>Detta är andra laborationen</p>
    </section>
  </main>
  <footer>
    Footer
  </footer>
</body>

</html>