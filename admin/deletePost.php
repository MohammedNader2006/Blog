<?php
require __DIR__ . '/../helpers/auth.php';
adminOnly();

require __DIR__ . '/../config/database.php';

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $sql = "DELETE FROM posts WHERE id='$id'";

    mysqli_query($conn, $sql);

    header("location: dashboard.php");
    exit;
}