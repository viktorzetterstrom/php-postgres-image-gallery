<?PHP
/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: login.php
 * Desc: Login page for laboration 4
 *
 * Anders Student
 * ansu6543
 * ansu6543@student.miun.se
 ******************************************************************************/

// User_array holds user name and password
// There are two users m with password m and a whit password a
// Just to show how to iterate through an map array



// Example code
session_start();
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
$responseText = "Session count is: " . $_SESSION['count'];

header('Content-Type: application/json');
echo json_encode($responseText);

?>