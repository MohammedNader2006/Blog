<?php

function clean($data){
    return trim(strip_tags($data));

}

function validateEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePassword($pass){
    return strlen($pass) >= 6;
}