<?php
include '../function.php';
include '../connect.php';
$email = filterRequest("email");
$verify = filterRequest("VerifyCode");

$stmt = $con->prepare("SELECT * FROM users Where user_email='$email'AND user_verifycode='$verify'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
    $data = array(
        "user_approved" => "1"
    );
    updateData("users", $data, "user_email='$email'");
} else {
    printFailure("Verify Code is not correct ");
}
