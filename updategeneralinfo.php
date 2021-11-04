<?php 
session_start();
require_once('config.php');

$profID = $_SESSION['profID'];
$peopleID = $_SESSION['peopleID'];

if (isset($_POST['btnEditProfInfo'])) {
    $sname = trim($_POST['sname_edit']);
    $name = trim($_POST['name_edit']);
    $patr = trim($_POST['patr_edit']);
    $gender = trim($_POST['gender_edit']);
    $birth = trim($_POST['birth_edit']);
    $inn = trim($_POST['inn_edit']);
    $passport = trim($_POST['passport_edit']);
    $phone = trim($_POST['phone_edit']);
    $city = trim($_POST['city_edit']);

    $sql = "UPDATE people SET sName=:sname, Name=:name, Patr=:patr, Year=:year, INN=:inn,
        Phone=:phone, Passport=:passport, id_City=:city_id, id_Gender=:gender_id
        WHERE id=:people_id ";

    $stmt=$con->prepare($sql);
    if($stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':year'=> $birth, 
        ':inn'=> $inn, ':phone'=>$phone, ':passport'=>$passport, ':city_id'=>$city, 
        ':gender_id'=>$gender, ':people_id'=> $_SESSION['peopleID']))) {
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
        $message = "Информация успешно обновлена.";
        $_SESSION['message'] = $message;
        exit;            
    }
    
}   
?>
