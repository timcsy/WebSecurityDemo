<?
// Using session
session_start(['cookie_secure' => false, 'cookie_httponly' => true]); // turn on cookie_secure if using HTTPS
// Clean session
session_destroy();
header('Location: index.php');
?>