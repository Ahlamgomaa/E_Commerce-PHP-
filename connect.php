<?php
$dsn='mysql:host=localhost;dbname=e_commerceapp';
$user='root';   
$pass='';
$options=array(
    PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
);
try{
    $con=new PDO($dsn,$user,$pass,$options);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    echo "You are connected Welcome to Database";
}
catch(PDOException $e){
    echo $e->getMessage();
}   
