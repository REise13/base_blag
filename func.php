<?php
require_once "config.php";

$profID = $_SESSION['profID'];
$peopleID = $_SESSION['peopleID'];

function editNote($note) {
    $sql = "UPDATE profile SET Note=:note WHERE id=:profile_id ";
    $stmt=$con->prepare($sql);
    if($stmt->execute(array(':note'=>$note, ':profile_id'=> $profID))) {
        echo '<script>alert("данные успешно изменены");</script>';
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    }
} 

?>
