<?php
session_start();

// امسح كل بيانات السيشن
$_SESSION = [];

// دمر السيشن
session_destroy();

// امسح الكوكي
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// redirect
header("location: ../index.php");
exit;