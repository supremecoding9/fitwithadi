<?php
// Initialize the session
session_start();
#######################################################################
$nolog = 1;
#######################################################################
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();

// unset cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-3600);
        setcookie($name, '', time()-3600, '/');
    }
}

setcookie('loggedin', "", time() - 3600);
setcookie("access", "", time() - 3600);

// Redirect to login page
header("location: login.php");
exit;
?>