<?php
session_start();
require_once 'config.php';

$leadID = $_SESSION['lead'];

if(isset($_POST['btnLeadRegister'])) {
    $_SESSION['lead_fio'] = isset($_POST['fioNeed']) ? $_POST['fioNeed'] :'';
    $_SESSION['lead_phone'] = isset($_POST['phone']) ? $_POST['phone'] :'';

    header("location: ../register_profile.php");
}

if(isset($_POST['btnEditLeadInfo'])) {
    $fio = trim($_POST['fio_edit']);
    $phone = trim($_POST['phone_edit']);
    $email = trim($_POST['email_edit']);
    $lastName = trim($_POST['lastName_edit']);
    $firstName = trim($_POST['firstName_edit']);
    $patrName = trim($_POST['patrName_edit']);
    $city = trim($_POST['city_edit']);
    $district = trim($_POST['district_edit']);
    $income = trim($_POST['income_edit']);
    $migrant = trim($_POST['migrant_edit']);
    $houseType = trim($_POST['houseType_edit']);
    $adopted = trim($_POST['adopted_edit']);
    $categories = trim($_POST['categories_edit']);
    $need = trim($_POST['need_edit']);
    $volunteer = trim($_POST['volunteer_edit']);
    $subcontact = trim($_POST['subcontact_edit']);
    $datelead = trim($_POST['datelead_edit']);
    $children = trim($_POST['children_edit']);
    $famUnEmp = trim($_POST['famUnEmp_edit']);
    $family = trim($_POST['family_edit']);
    $reason = trim($_POST['reason_edit']);
    $fio_need = $lastName . ' ' . $firstName . ' ' . $patrName;

    $sqlUpdateLead = "UPDATE `lead` SET fio=:fio, phone=:phone, email=:email,
        id_reason=:reason, fio_need=:fio_need, city=:city, district=:district, 
        id_type_of_house=:houseType, id_migrant=:migrant, id_fam_unemp=:famUnEmp,
        income=:income, id_family=:family, id_child=:children, adopted=:adopted,
        categories=:categories, need=:need, volunteer=:volunteer, subcontact=:subcontact,
        datelead=:datelead, firstName=:firstName, lastName=:lastName, patrName=:patrName
        WHERE id=:leadID";
    $stmt = $con->prepare($sqlUpdateLead);
    try{
        $con->beginTransaction();
        $stmt->execute(array(':fio'=>$fio, ':phone'=>$phone, ':email'=>$email,
        ':reason'=>$reason, ':fio_need'=>$fio_need, ':city'=>$city, ':district'=>$district,
        ':houseType'=>$houseType, ':migrant'=>$migrant, ':famUnEmp'=>$famUnEmp, 
        ':income'=>$income, ':family'=>$family, ':children'=>$children, ':adopted'=>$adopted, 
        ':categories'=>$categories, ':need'=>$need, ':volunteer'=>$volunteer, 
        ':subcontact'=>$subcontact, ':datelead'=>$datelead, ':firstName'=>$firstName, 
        ':lastName'=>$lastName,':patrName'=>$patrName, ':leadID'=>$leadID));

        $con->commit();
        unset($stmt);
        $_SESSION["flash"] = ["type" => "primary", "message" => "Данные о лиде обновлены."];
        header("location: ../leadinfo.php/?lead=$leadID");
        exit;
    } catch (Exception $e) {
        $con->rollback();
        throw $e;
    }    
}

if(isset($_POST['btnDeleteLead'])) {
    $sql = "DELETE FROM `lead` WHERE id=:id";
    $stmt = $con->prepare($sql);

    try{
        $con->beginTransaction();
        $stmt->bindParam(':id', $leadID, PDO::PARAM_INT);
        $stmt->execute();
        $con->commit();
        unset($stmt);
        $_SESSION["flash"] = ["type"=>"warning", "message"=>"Лид удален."];
        header("location: ../searchlead.php");
        exit;
    }
    catch (Exception $e) {
        $con->rollback();
        throw $e;
    }
}
 ?>