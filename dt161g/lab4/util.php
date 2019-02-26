<?php
/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: util.php
 * Desc: Util file for laboration 3
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/

/*******************************************************************************
 * autoload functions for Classes stored i directory classes
 * All classes must be saved i lower case to work and end whit class.php
 ******************************************************************************/
function my_autoloader($class) {
    $classfilename = strtolower($class);
    include 'classes/' . $classfilename . '.class.php';
}
spl_autoload_register('my_autoloader');

/*******************************************************************************
 * set debug true/false to change php.ini
 * To get more debug information when developing set to true,
 * for production set to false
 ******************************************************************************/

if (Config::Instance()->getDebug()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

/* Function that creates an alert window to inform the user of something.
 */
function alertUser(string $message): void {
  echo "<script type='text/javascript'>alert('$message');</script>";
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

/* Function that generates a html for a new post.
 */
function generatePostHtml(array $post): string {
  $name = $post['name'];
  $text = $post['text'];
  $ip = $post['ip'];
  $date = $post['date'];

  // Add name.
  $postHtml = '<tr><td>' . $name . '</td>';

  // Add text.
  $postHtml .= '<td>' . $text . '</td>';

  // Add IP and time.
  $postHtml .= '<td>IP: ' . $ip . '<br>';
  $postHtml .= 'TID: ' . $date . '</tr></td>';

  return $postHtml;
}
