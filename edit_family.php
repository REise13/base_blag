<?php
session_start();
require_once('config.php');

$profID = $_SESSION['profID'];
$peopleID = $_SESSION['peopleID'];

if(isset($_POST['btnEditFamily'])) { 
    $family = trim($_POST['family']);

    $sql = "UPDATE profile SET Family=:family WHERE id=:profile_id ";

    $stmt=$con->prepare($sql);
    if($stmt->execute(array(':family'=>$family, ':profile_id'=> $profID))) {
        echo '<script>alert("данные успешно изменены");</script>';
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    }
}
?>    