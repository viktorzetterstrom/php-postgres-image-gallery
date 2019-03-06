<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: util.php
 * Desc: Util file for project
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);

// Autoload classes
function my_autoloader($class): void {
  $classfilename = strtolower($class);
  include 'classes/' . $classfilename . '.class.php';
}
spl_autoload_register('my_autoloader');

// Set debug
if (Config::Instance()->getDebug()) {
  error_reporting(E_ALL);
  ini_set('display_errors', 'On');
}

// Function to display alertmessage
function alertUser(string $message): void {
  echo "<script type='text/javascript'>alert('$message');</script>";
}

// Alerts user and then redirects.
function alertAndRedirectUser(string $message, string $redirect): void {
  echo "<script>javascript:
  var ask = alert('" . $message . "');
  window.location = '" . $redirect . "';
  </script>";
}