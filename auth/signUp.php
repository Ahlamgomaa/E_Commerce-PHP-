<?php
include '../connect.php';
include '../function.php';
$username = filterRequest("username");
$password = sha1("password");
$email = filterRequest("email");
$phone = filterRequest("phone");
$verifyCode = rand(10000, 99999); //random number
$stmt = $con->prepare("SELECT * FROM users Where user_email=? OR user_phone=?");
$stmt->execute(array($email, $phone));
$count = $stmt->rowCount();
if ($count > 0) {
    printFailure("email or phone already exists ");
} else {
    $data = array(
        "user_name" => $username,
        "user_email" => $email,
        "user_password" => $password,
        "user_phone" => $phone,
        "user_verifycode" => "0"
    );
    SendMail($email, "Verify Code ECommerce App", "Verify Code $verifyCode");
    insertData("users", $data);
}
