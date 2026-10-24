<?php

$conn = mysqli_connect("localhost", "root", "", "blog_dashboard");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}