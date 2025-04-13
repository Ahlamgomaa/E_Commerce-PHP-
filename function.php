<?php
define('MB', 1048576);
function filterRequest($requestname)
{
    return htmlspecialchars(strip_tags($_POST[$requestname]));
}
function getAllData($table, $where = null, $value = null)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT * FROM $table where $where=?");
    $stmt->execute($value);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($count > 0) {
        echo json_encode(array('status' => 'success', 'data' => $data));
    } else {
        echo json_encode(array('status' => 'failed', 'message' => 'No Data Found'));
    }
    return $count;
}
function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table($fields) VALUES($ins)";
    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json = true) {
        if ($count > 0) {
            echo json_encode(array('status' => 'success', 'message' => 'Data Inserted Successfully'));
        } else {
            echo json_encode(array('status' => 'failed', 'message' => 'Failed to Insert Data'));
        }
    }
    return $count;
}
function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();
    foreach ($data as $key => $val) {
        $cols[] = "$key= ?";
        $vals[] = $val;
    }
    $sql = "UPDATE $table SET " . implode(',', $cols) . " WHERE $where";
    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json = true) {
        if ($count > 0) {
            echo json_encode(array('status' => 'success', 'message' => 'Data Updated Successfully'));
        } else {
            echo json_encode(array('status' => 'failed', 'message' => 'Failed to Update Data'));
        }
    }
    return $count;
}
function deleteData($table, $where, $value, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json = true) {
        if ($count > 0) {
            echo json_encode(array('status' => 'success', 'message' => 'Data Deleted Successfully'));
        } else {
            echo json_encode(array('status' => 'failed', 'message' => 'Failed to Delete Data'));
        }
    }
    return $count;
}
function uploadImage($imageRequest)
{
    global $msgError;
    $imagename = rand(1000, 10000) . '-' . $_FILES[$imageRequest]['name'];
    $imagetmp = $_FILES[$imageRequest]['tmp_name'];
    $imagesize = $_FILES[$imageRequest]['size'];
    $allowedExt = array('jpg', 'mp3', 'pdf', 'gif', 'png');
    $strToArray = explode('.', $imagename);
    $ext = end($strToArray);
    $ext = strtolower($ext);
    if (!empty($imagename) && !in_array($ext, $allowedExt)) {
        $msgError = 'Ext';
    }
    if ($imagesize > 2 * MB) {
        $msgError = 'Size';
    }
    if (empty($msgError)) {
        move_uploaded_file($imagetmp, 'uploads/' . $imagename);
        return $imagename;
    } else {
        return "fail";
    }
}
function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
        return true;
    } else {
        return false;
    }
}
function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != 'ahlam' || $_SERVER['PHP_AUTH_PW'] != '852002') {
            header('WWW-Authenticate:Basic realm ="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }
}
function printFailure($message = "none")
{
    echo json_encode(array("status" => "Failure", "message" => $message));
}
function SendMail($to, $title, $body)
{
    $header = "From: ahlamgomaa304@gmail.com\r\n";
    $header .= "Cc: ahlamgomaa304@gmail.com\r\n";

    if (mail($to, $title, $body, $header)) {
        echo "✅ Email sent successfully to $to with subject '$title'";
    } else {
        echo "❌ Failed to send email to $to";
    }
}
