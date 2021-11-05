<?php
session_start();
require_once 'config.php';

$profID = $_SESSION['profID'];
$peopleID = $_SESSION['peopleID'];

if(isset($_POST['btnEditHouseHeating'])) { 
    $house_type = trim($_POST['housetype_edit']);
    $heating_type = trim($_POST['heating_edit']);
    $forced_migrant = trim($_POST['migrant']);
    $destroyed_house = trim($_POST['dest_house']);

    $sql = "UPDATE profile SET id_type_of_house=:house, id_type_heating=:heating, 
        Forced_migrant=:migrant, Destroyed_house=:dest_house  
        WHERE id=:profile_id ";

    $stmt=$con->prepare($sql);
    if($stmt->execute(array(':house'=>$house_type, ':heating'=>$heating_type, 
        ':migrant'=>$forced_migrant, ':dest_house'=>$destroyed_house, ':profile_id'=> $profID))) {
        echo 'success test';
    }
    else {
        echo 'something went wrong';
    }
} 
       
?>