<?php
session_start();
require_once 'config.php';

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
    try {
        $con->beginTransaction();
        $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':year'=> $birth, 
        ':inn'=> $inn, ':phone'=>$phone, ':passport'=>$passport, ':city_id'=>$city, 
        ':gender_id'=>$gender, ':people_id'=> $peopleID));
        $con->commit();
        unset($stmt);
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    } catch (Exception $e){
        $con->rollback();
        throw $e;
    }  
}   

if(isset($_POST['btnEditFamily'])) { 
    $family = trim($_POST['family']);

    $sql = "UPDATE profile SET Family=:family WHERE id=:profile_id ";
    $stmt=$con->prepare($sql);
    try {
        $con->beginTransaction();
        $stmt->execute(array(':family'=>$family, ':profile_id'=> $profID));
        $con->commit();
        $_SESSION["flash"] = ["type" => "success", "message" => "Данные о семье обновлены."];
        unset($stmt);
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    } catch (Exception $e){
        $con->rollback();
        throw $e;
    } 
}

if(isset($_POST['btnEditNote'])) { 
    $note = trim($_POST['note']);

    $sql = "UPDATE profile SET Note=:note WHERE id=:profile_id ";

    $stmt=$con->prepare($sql);
    try {
        $con->beginTransaction();
        $stmt->execute(array(':note'=>$note, ':profile_id'=> $profID));
        $con->commit();
        $_SESSION["flash"] = ["type" => "success", "message" => "Примечание обновлено."];
        unset($stmt);
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    } catch (Exception $e){
        $con->rollback();
        throw $e;
    }  
}

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
    try {
        $con->beginTransaction();
        $stmt->execute(array(':house'=>$house_type, ':heating'=>$heating_type, 
        ':migrant'=>$forced_migrant, ':dest_house'=>$destroyed_house, ':profile_id'=> $profID));
        $con->commit();
        $_SESSION["flash"] = ["type" => "success", "message" => "Данные изменены."];
        unset($stmt);
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    } catch (Exception $e){
        $con->rollback();
        throw $e;
    }  
}


if(isset($_POST['btnAddCategory'])) {
    $category = $_POST['select_category'];
    $arrayLength = count($category);

    $sql = "INSERT INTO crosscategory(id_Profile, id_Category) VALUES(:profile_id, :category_id) ";
    $stmt= $con->prepare($sql);
    try {
        $con->beginTransaction();
        foreach($category as $cat)
        {
            $stmt->execute(array(':profile_id'=>$profID, ':category_id'=>$cat));
        }
        $con->commit();
        $_SESSION["flash"] = ["type" => "success", "message" => "Категория добавлена."];
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    } catch (Exception $e){
        $con->rollback();
        throw $e;
    }  
}


if(isset($_POST['btnDeleteCategory'])) {
    $category = $_POST['profile_category'];
    $arrayLength = count($category);

    $sql = "DELETE FROM crosscategory WHERE id=:profile_category_id";
    $stmt= $con->prepare($sql);
    try {
        $con->beginTransaction();
        foreach($category as $cat)
        {
            $stmt->execute(array(':profile_category_id'=>$cat));
        }
        $con->commit();
        $_SESSION["flash"] = ["type" => "success", "message" => "Категория удалена."];
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    } catch (Exception $e){
        $con->rollback();
        throw $e;
    }
   
}
unset($stmt);


if(isset($_POST['btnAddTraining'])) {
    $training = $_POST['select_training'];
    $date = $_POST['date_training'];
    $format_date = date("Y-m-d", strtotime($date));  

    $sql = "INSERT INTO crosstraining(id_Profile, id_Training, date_training) VALUES(:profile_id, :training_id, :date_training) ";
    $stmt= $con->prepare($sql);
    try {
        $con->beginTransaction();
        $stmt->execute(array(':profile_id'=>$profID, ':training_id'=>$training, ':date_training'=>$format_date));
        $con->commit();
        $_SESSION["flash"] = ["type" => "success", "message" => "Тренинг добавлен."];
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    } catch (Exception $e){
        $con->rollback();
        throw $e;
    }  
}
unset($stmt);


if(isset($_POST['btnDeleteTraining'])) {
    $training = $_POST['profile_training'];
    $arrayLength = count($training);

    $sql = "DELETE FROM crosstraining WHERE id=:profile_training_id";
    $stmt= $con->prepare($sql);
    $i = 0;
    try {
        $con->beginTransaction();
        foreach($training as $tr)
        {
            $stmt->execute(array(':profile_training_id'=>$tr));
        }
        $con->commit();
        unset($stmt);
        $_SESSION["flash"] = ["type" => "success", "message" => "Тренинг удален."];
        header("location: ../profileinfo.php/?profile=$profID&people=$peopleID");
    } catch (Exception $e){
        $con->rollback();
        throw $e;
    }
   
}


if(isset($_POST['btnAddNeed'])) {
    $need = $_POST['select_need'];

    $sql = "INSERT INTO crossneed(id_Profile, id_Need) VALUES(:profile_id, :need_id)";
    $stmt= $con->prepare($sql);
    try {
        $con->beginTransaction();
        foreach($need as $n)
        {
            $stmt->execute(array(':profile_id'=>$profID, ':need_id'=>$n));
        }
        $con->commit();
        unset($stmt);
    } catch (Exception $e){
        $con->rollback();
        throw $e;
    }  
}

if(isset($_POST['btnDeleteNeed'])) {
    $need= $_POST['profile_need'];

    $sql = "DELETE FROM crossneed WHERE id_Profile=:profile_need_id";
    $stmt= $con->prepare($sql);
    try {
        $con->beginTransaction();
        foreach($need as $n)
        {
            $stmt->execute(array(':profile_need_id'=>$n));
        }
        $con->commit();
        unset($stmt);
    } catch (Exception $e){
        $con->rollback();
        throw $e;
    } 
}

?>    