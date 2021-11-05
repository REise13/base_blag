<?php
session_start();
require_once 'config.php';

$profID = $_SESSION['profID'];
$peopleID = $_SESSION['peopleID'];

if(isset($_POST['btnEditNote'])) { 
    $note = trim($_POST['note']);

    $sql = "UPDATE profile SET Note=:note WHERE id=:profile_id ";

    $stmt=$con->prepare($sql);
    if($stmt->execute(array(':note'=>$note, ':profile_id'=> $profID))) {
        echo '<script>alert("данные успешно изменены");</script>';
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    }
}
unset($stmt);

if(isset($_POST['btnEditHouseHeating'])) { 
    $house_type = trim($_POST['housetype_edit']);
    $heating_type = trim($_POST['heating_edit']);
    $forced_migrant = trim($_POST['migrant']);
    $destroyed_house = trim($_POST['dest_house']);
    if ($forced_migrant == "") {
        $forced_migrant = 0;
    }
    if ($destroyed_house == "") {
        $destroyed_house = 0;
    }

    $sql = "UPDATE profile SET id_type_of_house=:house, id_type_heating=:heating, 
        Forced_migrant=:migrant, Destroyed_house=:dest_house  
        WHERE id=:profile_id ";
    $stmt=$con->prepare($sql);
    if($stmt->execute(array(':house'=>$house_type, ':heating'=>$heating_type, 
        ':migrant'=>$forced_migrant, ':dest_house'=>$destroyed_house, ':profile_id'=> $profID))) {
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    }
    else {
        echo 'something went wrong';
    }
}
unset($stmt);

f(isset($_POST['btnEAddCategory'])) { 
    
    $sql = "";
    $stmt=$con->prepare($sql);
    if($stmt->execute(array(':profile_id'=> $profID))) {
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    }
    else {
        echo 'something went wrong';
    }
}    


?>    