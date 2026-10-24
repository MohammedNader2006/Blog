<?php
function adminOnly(){

    session_start();

    // منع الكاش
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");

    if(!isset($_SESSION['user'])){
        header("location: ../index.php");
        exit;
    }
}