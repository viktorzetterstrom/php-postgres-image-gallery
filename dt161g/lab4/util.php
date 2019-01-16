<?php
/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: util.php
 * Desc: Util file for laboration 4
 *
 * Anders Student
 * ansu6543
 * ansu6543@student.miun.se
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
 * To get more debugg information when developing set to true,
 * for production set to false
 ******************************************************************************/
$debug = true;

if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

?>
