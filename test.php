<?php
include './function.php'; 
include './connect.php';
$table='users'; 
$data=array(
    'user_name'=>"ahlam gomaa",
    'user_email'=>"ahlamgomaa@gmail.com",
    'user_password'=>"852002",
    'user_phone'=>"01130456987",
    'user_verifycode'=>"05689"
);
$count=insertData($table,$data);    