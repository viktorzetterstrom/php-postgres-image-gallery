<?PHP
/*******************************************************************************
 * Laboration 1, Kurs: DT161G
 * File: guestbook.php
 * Desc: Guestbook page for laboration 1
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);
require_once("util.php");
$title = "Laboration 4";
$captchaLength = 5;
$invalidCaptcha = false;
session_start();
// Check if logged in.
$loggedIn = isset($_SESSION['loggedIn']);


// Check for post-request and create post if ok captcha.
if (isset($_POST['name']) && isset($_POST['text']) && isset($_POST['captcha'])) {
  // Sanitize inputs.
  $sanitizedCaptcha = htmlspecialchars($_POST['captcha']);
  $sanitizedName = htmlspecialchars($_POST['name']);
  $sanitizedText = htmlspecialchars($_POST['text']);

  if (isset($_COOKIE['hasPosted'])) {
    alertUser('Du har redan skrivit i gästboken.');
  }

  else if ($sanitizedCaptcha == $_SESSION['captcha']) {
    // Create post.
    $newPost = array('name' => $sanitizedName,
                     'text' => $sanitizedText,
                     'ip' => $_SERVER['REMOTE_ADDR'],
                     'date' => date('Y-m-d H:i'));

    // Store post
    DbHandler::Instance()->storePost($newPost);

    // Generate cookie and refresh page to prevent more posts.
    setcookie('hasPosted', 'true');
    header("Refresh:0");

  } else {
    // Inform user.
    alertUser('Felaktig captcha, försök igen.');
    $invalidCaptcha = true;
  }
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
  <link rel="stylesheet" href="css/style.css" />
  <script src="js/main.js"></script>
  <title>DT161G-Laboration3</title>
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

      <div id="login" <?php if ($loggedIn) echo 'style="display:none"'?>>
        <h2>LOGIN</h2>
        <form id="loginForm">
          <label><b>Username</b></label>
          <input type="text" placeholder="Enter Username" name="uname" id="uname" required maxlength="10" autocomplete="off">
          <label><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
          <button type="button" id="loginButton">Login</button>
        </form>
      </div>
      <div id="logout" <?php if (!$loggedIn) echo 'style="display:none"'?>>
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
      <h2>GÄSTBOK</h2>
      <table>

        <tr>
          <th class="th20">FRÅN
          </th>
          <th class="th40">INLÄGG
          </th>
          <th class="th40">LOGGNING
          </th>
        </tr>

        <?PHP
          $guestbookPosts = DbHandler::Instance()->getPosts();
          if (!empty($guestbookPosts)) {
            foreach ($guestbookPosts as $post) {
              echo generatePostHtml($post);
            }
          }

        ?>
      </table>

      <?PHP if (!isset($_COOKIE['hasPosted'])) : ?>
      <form action="guestbook.php" method="POST">
        <fieldset>
          <legend>Skriv i gästboken</legend>
          <label>Från: </label>
          <input type="text" placeholder="Skriv ditt namn" name="name" value="<?php if ($invalidCaptcha) { echo $_POST['name']; } ?>">
          <br>
          <label for="text">Inlägg</label>
          <textarea id="text" name="text" rows="10" cols="50" placeholder="Skriv meddelande här"><?php if ($invalidCaptcha) { echo $_POST['text']; } ?></textarea>
          <br>
          <label>Captcha: <span class="red">
              <?PHP echo generateCaptcha($captchaLength); ?></span></label>
          <input type="text" placeholder="Skriv captcha här" name="captcha" required>
          <button type="submit">Skicka</button>
        </fieldset>
      </form>
      <?PHP endif; ?>

    </section>
  </main>
  <footer>
    Footer
  </footer>
</body>
</html>
