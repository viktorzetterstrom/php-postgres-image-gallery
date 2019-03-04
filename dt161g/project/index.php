<?PHP
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: index.php
 * Desc: Start page for Projekt
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/

$title = "DT161G - Projekt";
$author = "Viktor Zetterström";
$authorEmail = "vize1500@student.miun.se";

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
  <h1><?php echo $title ?></h1>

  <!-- login form -->
  <div class="login">
    <div id="login">
      <form id="loginForm">
      <input type="text" placeholder="Username" name="uname" id="uname" required maxlength="10" autocomplete="off">
      <input type="password" placeholder="Password" name="psw" id="psw" required>
      <button type="button" id="loginButton">Log in</button>
      </form>
    </div>
    <div id="logout">
      <button type="button" id="logoutButton">Log out</button>
    </div>
  </div>
</header>

<!-- main content -->
<main>
  <!-- navigation sidebar -->
  <aside>
    <h2>Navigation</h2>
    <nav>
      <ul class='sidebar-links'>
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

  <!-- area for showing pictures -->
  <section>
    <h2>Pictures</h2>
    <p>This is the main section</p>
  </section>
</main>

<!-- footer -->
<footer>
  Made by: <?PHP echo $author ?>,
  <a href="mailto:<?PHP echo $authorEmail ?>">Contact</a>
</footer>

</body>
</html>
