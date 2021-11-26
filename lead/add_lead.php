<?php
session_start();
require_once '../config.php';

$fio = trim($_POST['fio']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$reason = trim($_POST['reason']);
$fio_need = trim($_POST['fio_need']);
$city = trim($_POST['city']);
$district = trim($_POST['district']);
$houseType = trim($_POST['houseType']);
$bdistrict = trim($_POST['bdistrict']);
$migrant = trim($_POST['migrant']);
$famUnEmp = trim($_POST['famUnEmp']);
$income = trim($_POST['income']);
$family = trim($_POST['family']);
$children = trim($_POST['child']);
$adopted = trim($_POST['adopted']);
$categories = $_POST['categories'];
$addCatLead = trim($_POST['addCatLead']);
$need = trim($_POST['need']);
$volunteer = trim($_POST['volunteer']);
$subcontact = trim($_POST['subcontact']);

$catsLead = implode(',', $categories);

if(!empty($addCatLead)) {
    $catsLead .= ', '. $addCatLead;
}

$datelead = date('y-m-d');
$fio_leadneed = explode(" ", $fio_need);
$lastName = $fio_leadneed[0];
$firstName = $fio_leadneed[1];
$patrName = $fio_leadneed[2];

$sqlUpdateLead = "INSERT INTO `lead`(fio, phone, email, id_reason,
    fio_need, city, district, id_type_of_house, id_bdistrict,
    id_migrant, id_fam_unemp, income, id_family, id_child,
    adopted, categories, need, volunteer, subcontact, datelead,
    firstName, lastName, patrName) 
    VALUES(:fio, :phone, :email, :reason, 
        :fio_need, :city, :district, :houseType, :bdistrict, 
        :migrant, :famUnEmp, :income, :family, :children, 
        :adopted, :categories, :need, :volunteer, :subcontact,
        :datelead, :firstName, :lastName, :patrName)";
$stmt = $con->prepare($sqlUpdateLead);
try{
    $con->beginTransaction();
    $stmt->execute(array(':fio'=>$fio, ':phone'=>$phone, ':email'=>$email,
    ':reason'=>$reason, ':fio_need'=>$fio_need, ':city'=>$city, 
    ':district'=>$district, ':houseType'=>$houseType, ':bdistrict'=>$bdistrict, 
    ':migrant'=>$migrant, ':famUnEmp'=>$famUnEmp, ':income'=>$income, 
    ':family'=>$family, ':children'=>$children, ':adopted'=>$adopted, 
    ':categories'=>$catsLead, ':need'=>$need, ':volunteer'=>$volunteer, 
    ':subcontact'=>$subcontact, ':datelead'=>$datelead, ':firstName'=>$firstName, 
    ':lastName'=>$lastName,':patrName'=>$patrName));

    $stmt=$con->prepare("SELECT LAST_INSERT_ID()");
    $stmt->execute();
    $lastLeadID = $stmt->fetchColumn();
    $con->commit();
    unset($stmt);
    $_SESSION["flash"] = ["type"=>"success", "message"=> "Лид добавлен."];
    header("location: ../leadinfo.php/?lead=$lastLeadID");
    exit;
} catch (Exception $e) {
    $con->rollback();
    throw $e;
}    
?>