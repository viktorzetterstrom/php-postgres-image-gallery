<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: logout.php
 * Desc: Logout logic for logging out.
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/
declare(strict_types = 1);
require_once('util.php');


// Initialize the session.
session_start();

// Unset all of the session variables.
$_SESSION = array();

// Delete session cookie
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}

// Destroy the session.
session_destroy();

header('location:index.php');