<?php
// logout.php - for user logout

session_start();

// destroy all session data
$_SESSION = [];
session_unset();
session_destroy();

// optional: delete cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// redirect to homepage or login
header("Location: index.php");
exit;
?>
