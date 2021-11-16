<?php 
require_once "config.php";

if(isset($_POST['btnLeadSearch'])) {
    $searchFormFields = array('sname', 'name', 'patr', 'phone', 'city', 
        'lead_category', 'needHelp', 'houseType', 'family', 'child', 
        'adopted', 'volunteer', 'income', 'famUnemp', 'bdisctrict', 
        'migrant', 'regDate');
    $conditions = array();
    $params = array();

    $sqlDefaultlSearchLead = "SELECT * FROM baseddc.lead";

    foreach($searchFormFields as $field) {
        if(isset($_POST[$field]) && $_POST[$field] != "") {
            if($field == 'sname') {
                $conditions[] = "lastName=:sname";
                $params['sname'] = $field;
            }
            if($field == 'name') {
                $conditions[] = "firstName=:name";
                $params['name'] = $field;
            }
            if($field == 'patr') {
                $conditions[] = "patrName=:patr";
                $params['patr'] = $field;
            }
            if($field == 'phone') {
                $conditions[] = "phone=:phone";
                $params['phone'] = $field;
            }
            if($field == 'city') {
                $conditions[] = "city=:city";
                $params['city'] = $field;
            }
            if($field == 'needHelp') {
                $conditions[] = "need LIKE '%:needHelp%'";
                $params['needHelp'] = $field;
            }
            if ($field == 'lead_category') {
                $conditions[] = "categories IN (". $field .")";
            }
            if($field == 'houseType') {
                $conditions[] = "id_type_of_house=:houseType";
                $params['houseType'] = $field;
            }
            if($field == 'family') {
                $conditions[] = "id_family=:family";
                $params['family'] = $field;
            }
            if($field == 'child') {
                $conditions[] = "id_child=:child";
                $params['child'] = $field;
            }
            if($field == 'adopted') {
                $conditions[] = "adopted=:adopted";
                $params['adopted'] = $field;
            }
            if($field == 'volunteer') {
                $conditions[] = "volunteer=:volunteer";
                $params['volunteer'] = $field;
            }
            if($field == 'income') {
                $conditions[] = "income=:income";
                $params['income'] = $field;
            }
            if($field == 'famUnemp') {
                $conditions[] = "id_fam_unemp=:famUnemp";
                $params['famUnemp'] = $field;
            }
            if($field == 'bdisctrict') {
                $conditions[] = "district=:bdisctrict";
                $params['bdisctrict'] = $field;
            }
            if($field == 'migrant') {
                $conditions[] = "id_migrant=:migrant";
                $params['migrant'] = $field;
            }
            if($field == 'regDate') {
                $conditions[] = "datelead=:regDate";
                $params['regDate'] = $field;
            }
        }
    }
    
    if(count($conditions) > 0) {
        $sql .= $sqlDefaultlSearchLead . "WHERE " . implode(' AND ', $conditions); 
    
        $stmt = $con->prepare($sql);
        foreach($params as $key=>$value){
            $stmt->bindParam(':'.$key, $value);
        }
    } else {
        $sql = $sqlDefaultlSearchLead;
        $stmt = $con->prepare($sql);
    }
    $stmt->execute(); 
    $res = $stmt-fetchAll(PDO::FETCH_ASSOC);

    echo print_r($res);

}
?>