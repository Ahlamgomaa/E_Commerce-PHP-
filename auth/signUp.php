<?php
include '../connect.php';
include '../function.php';
$username=filterRequest("username");
$password=sha1("password");
$email=filterRequest("email");
$phone=filterRequest("phone");
$verifyCode=("0");
$stmt=$con->prepare("SELECT * FROM users Where user_email=? OR user_phone=?");
$stmt->execute(array($email,$phone));
$count=$stmt->rowCount();
if($count>0){
    printFailure("email or phone already exists ");
}else{
    $data=array(
        "user_name"=>$username,
        "user_email"=>$email,
        "user_password"=>$password,
        "user_phone"=>$phone,
        "user_verifycode"=>"0"
    );
    insertData("users",$data);
}