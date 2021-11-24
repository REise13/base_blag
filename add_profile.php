<?php
session_start();
require_once 'config.php';

$sname = trim($_POST['sname']);
$name = trim($_POST['name']);
$patr = trim($_POST['patr']);
$gender = trim($_POST['gender']);
$yearBirth = trim($_POST['yearBirth']);
$inn = trim($_POST['inn']);
$phone = trim($_POST['phone']);
$passport = trim($_POST['passport']);
$city = trim($_POST['city']);
$category = $_POST['category'];

if ($inn == "") {
    $peopleINN = null;
}
else {
    $peopleINN = $inn;
}

$insertPeople = "INSERT INTO people(sName, Name, Patr, Year, INN, Phone, Passport, id_City, id_Gender)
    VALUES(:sname, :name, :patr, :yearBirth, :inn, :phone, :passport, :city, :gender)";
$stmt=$con->prepare($insertPeople);

try{
    $con->beginTransaction();
    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':yearBirth'=>$yearBirth,
        ':inn'=>$peopleINN, ':phone'=>$phone, ':passport'=>$passport, ':city'=>$city, ':gender'=>$gender));
    $stmt=$con->prepare("SELECT LAST_INSERT_ID()");
    $stmt->execute();
    $lastPeopleID = $stmt->fetchColumn();

    $stmt=$con->prepare("INSERT INTO profile(id_people, Forced_migrant, Destroyed_house, id_type_of_house, 
        id_type_heating, Family, Numb_of_Child, Note) VALUES(:people_id, 0, 0, 1, 1, null, null, null)");
    $stmt->bindParam(':people_id', $lastPeopleID, PDO::PARAM_INT);
    $stmt->execute();
    $stmt = $con->prepare("SELECT LAST_INSERT_ID()");
    $stmt->execute();
    $lastProfileID = $stmt->fetchColumn();

    $insertProfCategories = "INSERT INTO crosscategory(id_Profile, id_Category) VALUES(:profile_id, :category_id)";
    $stmt= $con->prepare($insertProfCategories);
    foreach($category as $cat) {
        $stmt->execute(array(':profile_id'=>$lastProfileID, ':category_id'=>$cat));
    }
    $con->commit();
    $_SESSION['profID'] = $lastProfileID;
    $_SESSION['peopleID'] = $lastPeopleID;
    unset($stmt);
    header("location: ../profileinfo.php/?profile=$lastProfileID&people=$lastPeopleID");
    exit;
}
catch (Exception $e) {
    throw $e;
}


?>