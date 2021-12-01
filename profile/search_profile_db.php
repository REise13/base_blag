<?php
session_start();

if(isset($_POST['btnLeadSearch'])) {
    $searchFormFields = array('sname', 'name', 'patr', 'age1', 'age2', 
        'city', 'categories', 'donor', 'project');
    $params = array();
    $categories = "";
    $age = "";
    $donor = "";
    $project = "";

    foreach($searchFormFields as $field) {
        if (!empty($_POST[$field])) {
            if ($field == 'sname')
                $params['sName'] = $_POST['sname'];
            if ($field == 'name')
                $params['Name'] = $_POST['name'];
            if ($field == 'city')
                $params['id_City'] = $_POST['id_City'];                                                           
        }
    }

    $where = implode(' AND ', array_map(function($item) {
            return "$item=:$item";    
    }, array_keys($params)));

    if (!empty($_POST['categories'])) {
        $cats = $_POST['categories'];
        $categories = "cat_ids IN($cats)";    
    }
    
    if (!empty($_POST['age1']) and !empty($_POST['age2'])) {
        $age1 = $_POST['age1'];
        $age2 = $_POST['age2'];
        $age = "(age >= $age1 AND age <= $age2)";
    }

    if (!empty($_POST['donor'])) {
        $d = $_POST['donor'];
        $donor = "(donor_ids IN($d))";
    }
    
    if (!empty($_POST['project'])) {
        $pr = $_POST['project'];
        $donor = "(project_ids IN($pr))";
    }
    $searchProfile = "SELECT profile_id, id_people, fio, age, city_info, gender_info, INN, Passport, category_info, help_info FROM profile_search";

    if (!empty($where) && !empty($categories) && !empty($donor) && !empty($age) && !empty($project)) {
       $stmt = $con->prepare($searchProfile . " WHERE $where AND ". $categories . " AND ".$donor. " AND ".$age. " AND ".$project);  
    } else if (!empty($where) && empty($categories) && empty($donor) && empty($age) && empty($project)) {
        $stmt = $con->prepare($searchProfile . " WHERE $where");
    } else if (empty($where) && !empty($categories) && empty($donor) && empty($age) && empty($project)) {
        $stmt = $con->prepare($searchProfile . " WHERE $categories");
    } else if (empty($where) && empty($categories) && !empty($donor) && empty($age) && empty($project)) {
        $stmt = $con->prepare($searchProfile . " WHERE $donor");
    } else if (empty($where) && empty($categories) && empty($donor) && !empty($age) && empty($project)) {
        $stmt = $con->prepare($searchProfile . " WHERE $age");
    } else if (empty($where) && empty($categories) && empty($donor) && empty($age) && !empty($project)) {
        $stmt = $con->prepare($searchProfile . " WHERE $project");
    } else if (!empty($where) && !empty($categories) && empty($donor) && empty($age) && empty($project)) {
        $stmt = $con->prepare($searchProfile . " WHERE $where AND ".$categories);
    } else if (!empty($where) && empty($categories) && !empty($donor) && empty($age) && empty($project)) {
        $stmt = $con->prepare($searchProfile . " WHERE $where AND ".$donor);
    } else if (!empty($where) && empty($categories) && empty($donor) && !empty($age) && empty($project)) {
        $stmt = $con->prepare($searchProfile . " WHERE $where AND ".$age);
    } else if (!empty($where) && empty($categories) && empty($donor) && empty($age) && !empty($project)) {
        $stmt = $con->prepare($searchProfile . " WHERE $where AND ".$project);
    }    
    else {
        $stmt = $con->prepare($searchLead);
    }
    
    $stmt->execute($params); 
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $_SESSION['leads'] = $res;
    header("location: ../leads.php");
    exit;
} 
 ?>