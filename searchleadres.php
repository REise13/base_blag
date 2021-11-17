<?php 
require_once "config.php";

if(isset($_POST['btnLeadSearch'])) {
    $searchFormFields = array('sname', 'name', 'patr', 'phone', 'city', 
        'lead_category', 'needHelp', 'houseType', 'family', 'child', 
        'adopted', 'volunteer', 'income', 'famUnemp', 'bdisctrict', 
        'migrant', 'regDate');
    $params = array();

    foreach($searchFormFields as $field) {
        if (!empty($_POST[$field])) {
            $params[$field] = '%' . $_POST[$field] . '%';
        }
    }

    $where = implode(' AND ', array_map(function($item) {
        return "`$item` LIKE :$item";
    }, array_keys($params)));

    if (!empty($where)) {
        $stmt = $con->prepare("SELECT `id`, `lastName` FROM `lead`");
    }
    else {
       $stmt = $con->prepare($sqlDefaultlSearchLead . "SELECT `id`, `lastName` FROM `lead` WHERE $where"); 
    }
    
    $stmt->execute($params); 
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo print_r($res);

}
?>