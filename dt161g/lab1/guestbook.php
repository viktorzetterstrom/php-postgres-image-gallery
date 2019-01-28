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
$title = "Laboration 1";
$captchaLength = 5;
$invalidCaptcha = false;
session_start();

if (isset($_POST['name']) && isset($_POST['text']) && isset($_POST['captcha'])) {
  if ($_POST['captcha'] == $_SESSION['captcha']) {
    echo generateGuestBookPost($_POST['name'], $_POST['text']);
    // Upload post.
  } else {
    // Inform user.
    alertUser('Invalid captcha, please try again.');
    $invalidCaptcha = true;
  }
}

/*******************************************************************************
 * Function declarations.
 ******************************************************************************/

/* Function that generates a new post based on a given name and text.
 * 
 */
function generateGuestBookPost(string $name, string $text): string {
  $guestBookPost = '<tr>';

  // Add name.
  $guestBookPost .= '<td>' . $name . '</td>';

  // Add text.
  $guestBookPost .= '<td>' . $text . '</td>';

  // Add IP and time.
  $ipAddress = $_SERVER['REMOTE_ADDR'];
  $guestBookPost .= '<td>IP: ' . $ipAddress . '\n';
  $date = date('Y-m-d H:i');
  $guestBookPost .= 'TID: ' . $date . '</tr></td>';

  return $guestBookPost;
}

/* Function that generates a captcha of specified length. Uses upper and lower case as
 * well as numbers.
 */
function generateCaptcha(int $length): string {
  // Define chars for captcha
  $chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

  // Shuffle charstring
  $chars = str_shuffle($chars);

  // Extract captcha as the (length) first chars of the array.
  $captcha = substr($chars, 0, $length);

  // Store captcha in session storage.
  $_SESSION['captcha'] = $captcha;

  // Return captcha.
  return $captcha;
}

/* Function that creates an alert window to inform the user of something.
 */
function alertUser(string $message): void {
  echo "<script type='text/javascript'>alert('$message');</script>";
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
    <link rel="stylesheet" href="css/style.css"/>
    <title>DT161G-Laboration1</title>
</head>
<body>
<header>
    <img src="img/mittuniversitetet.jpg" alt="miun logga" class="logo"/>
    <h1><?php echo $title ?></h1>
</header>
<main>
    <aside>
        <h2>LOGIN</h2>
        <form action="index.php">
            <label><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname"
                   required maxlength="10">
            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw"
                   required>
            <button type="submit">Login</button>
        </form>
        <h2>MENY</h2>
        <nav>
            <ul>
                <li>
                    <a href="index.php">HEM</a>
                </li>

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
            <tr>
                <td>Johan
                </td>
                <td>Mitt första inlägg
                </td>
                <td>IP: 10.55.102.80<br>
                    TID: 2011-01-13 12:34
                </td>
            </tr>
            <tr>
                <td>Johan
                </td>
                <td>Mitt andra, OBS fick byta dator för att kunna göra detta
                </td>
                <td>IP: 10.55.102.83<br>
                    TID: 2011-01-13 12:35
                </td>
            </tr>
        </table>

        <form action="guestbook.php" method="POST">
            <fieldset>
                <legend>Skriv i gästboken</legend>
                <label>Från: </label>
                <input type="text" placeholder="Skriv ditt namn"
                       name="name">
                <br>
                <label for="text">Inlägg</label>
                <textarea id="text" name="text"
                          rows="10" cols="50"
                          placeholder="Skriva meddelande här"></textarea>
                <br>
                <label>Captcha: <span class="red"><?PHP echo generateCaptcha($captchaLength); ?></span></label>
                <input type="text" placeholder="Skriva captcha här"
                       name="captcha"
                       required>
                <button type="submit">Skicka</button>
            </fieldset>
        </form>


    </section>
</main>
<footer>
    Footer
</footer>
</body>
</html>
