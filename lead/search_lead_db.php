<?php 
require_once "../config.php";
session_start();

if(isset($_POST['btnLeadSearch'])) {
    $searchFormFields = array('sname', 'name', 'patr', 'phone', 'city', 
        'needHelp', 'houseType', 'family', 'child', 
        'adopted', 'volunteer', 'income', 'famUnemp', 'bdisctrict', 
        'migrant', 'regDate');
    $params = array();
    $searchCategories = "";
    
    foreach($searchFormFields as $field) {
        if (!empty($_POST[$field])) {
            if ($field == 'sname')
                $params['lastName'] = $_POST['sname'];
            if ($field == 'name')
                $params['firstName'] = $_POST['name'];
            if ($field == 'patr')
                $params['patrName'] = $_POST['patr'];
            if ($field == 'phone')
                $params['phone'] = $_POST['phone'];
            if ($field == 'city')
                $params['city'] = $_POST['city'];
            if ($field == 'houseType')
                $params['id_type_of_house'] = $_POST['houseType'];
            if ($field == 'family')
                $params['id_family'] = $_POST['family'];
            if ($field == 'child')
                $params['id_child'] = $_POST['child'];
            if ($field == 'adopted')
                $params['adopted'] = $_POST['adopted'];
            if ($field == 'volunteer')
                $params['volunteer'] = $_POST['volunteer'];
            if ($field == 'income')
                $params['income'] = $_POST['income'];
            if ($field == 'famUnemp')
                $params['id_fam_unemp'] = $_POST['famUnemp'];
            if ($field == 'bdisctrict')
                $params['id_bdistrict'] = $_POST['bdisctrict'];
            if ($field == 'migrant')
                $params['id_migrant'] = $_POST['migrant'];
            if ($field == 'regDate') {
                $regDate = $_POST['regDate'];
                $frmtDate = date("Y-m-d", strtotime($regDate));
                $params['datelead'] = $frmtDate;
            }                                                                   
        }
    }

    $where = implode(' AND ', array_map(function($item) {
        if ($item != "categories") {
            return "`$item`=:$item";    
        }
    }, array_keys($params)));

    if(!empty($_POST['needHelp'])) {
        $need = $_POST['needHelp'];
        $searchNeed = "`need` LIKE '%$need%'";
    }

    if (!empty($_POST['categories'])) {
        $categories = $_POST['categories'];
        $searchCategories = implode(' AND ', array_map(function($word) {
            return "`categories` LIKE '%$word%'";    
        },$categories));
    }
    
    $searchLead = "SELECT `id`, `fio`, `phone`, `fio_need`, `city`, `need` FROM `lead`";

    if (!empty($where) && !empty($searchCategories) && !empty($searchNeed)) {
       $stmt = $con->prepare($searchLead . " WHERE $where AND". $searchCategories . " AND ".$searchNeed);  
    } else if (!empty($where) && empty($searchCategories) && empty($searchNeed)) {
        $stmt = $con->prepare($searchLead . " WHERE $where");
    } else if (!empty($where) && empty($searchCategories) && !empty($searchNeed)) {
        $stmt = $con->prepare($searchLead . " WHERE $where AND ".$searchNeed);
    } else if (!empty($where) && !empty($searchCategories) && empty($searchNeed)) {
        $stmt = $con->prepare($searchLead . " WHERE $where AND ".$searchCategories);
    } else if (empty($where) && !empty($searchCategories) && empty($searchNeed)) {
        $stmt = $con->prepare($searchLead . " WHERE " . $searchCategories);   
    } else if (empty($where) && empty($searchCategories) && !empty($searchNeed)) {
        $stmt = $con->prepare($searchLead . " WHERE " . $searchNeed);
    } else if (empty($where) && !empty($searchCategories) && !empty($searchNeed)) {
        $stmt = $con->prepare($searchLead . " WHERE " . $searchCategories . " AND " . $searchNeed);
    } else {
        $stmt = $con->prepare($searchLead);
    }
    
    $stmt->execute($params); 
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $_SESSION['leads'] = $res;
    header("location: ./leads.php");
    exit;
}
?>
