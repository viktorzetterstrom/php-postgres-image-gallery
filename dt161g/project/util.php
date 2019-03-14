<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: util.php
 * Desc: Contains utility functions used on many places in the project. Also
 * does the importing of all the classes.
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

// Generates the navigational links to the left.
function generateNavigationLinks(): string {
  $usersAndCategories = DbHandler::Instance()->getUsersAndCategories();

  $navigationLinks = "";
  foreach ($usersAndCategories as $userAndCat) {
    // Enclose it all with a div
    $navigationLinks .= '<div class="user-links">';

    // Append user name tag
    $userName =  $userAndCat[0];
    $userTag = '<li><a href="images.php?user=' . $userName .'" class="user-link">' . $userName . '</a></li>';
    $navigationLinks .= $userTag;

    // Append categories
    $categories = $userAndCat[1];
    // Append closing ul around categories
    $navigationLinks .= '<ul>';
    foreach ($categories as $category) {
      $categoryTag = '<li><a href="images.php?user=' . $userName .'&category=' . $category . '" class="category-link">' . $category . '</a></li>';
      $navigationLinks .= $categoryTag;
    }
    $navigationLinks .= '</ul></div>';
  }
  return $navigationLinks;
}