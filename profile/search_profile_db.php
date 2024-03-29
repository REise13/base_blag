<?php
session_start();
require_once "../config.php";

if (isset($_POST['btnSearchProfile'])) {
    $sname = trim($_POST['sname']);
    $name = trim($_POST['name']);
    $patr = trim($_POST['patr']);
    $age1 = trim($_POST['age1']);
    $age2 = trim($_POST['age2']);
    $city = trim($_POST['city']);
    $donor = trim($_POST['donor']);
    $project = trim($_POST['project']);
    $categories = $_POST['categories'];
    $selectedCategory[] = join(",",$categories);
    $cats = implode(",",$categories);
    $default_sql_search = "SELECT profile_id, id_people, fio, age, city_info, gender_info, INN, Passport, category_info, help_info FROM profile_search";
    if (in_array( "0", $selectedCategory)) {
        if ($sname == '' and $name == '' and $patr == '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search; 
                $stmt = $con->prepare($sql);
                $stmt->execute();
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE donor_ids IN ($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute();
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':city'=>$city));
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute();
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE project_ids IN($project) AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array( ':city'=> $city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE (donor_ids LIKE '$donor' "
                    ."OR donor_ids LIKE '$donor,%') AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array( ':city'=> $city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE donor_ids IN($donor) AND (project_ids IN($project))";
                $stmt=$con->prepare($sql);
                $stmt->execute();
            }
            else {
                $sql = $default_sql_search. " WHERE (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(  ':city'=> $city));
            }
        }
        
        elseif ($sname == '' and $name == '' and $patr == '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE age >= :age1 AND age <= :age2"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2,  ':city'=> $city));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND "
                    ."(project_ids IN($project) AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=>$age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND "
                    ."(donor_ids IN($donor)) AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND donor_ids IN($donor) AND (project_ids IN($project))";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor)) " .
                "AND (project_ids IN($project)) AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city));
            }
        }
        
        elseif ($sname != '' and $name == '' and $patr == '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2)"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project) ";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city"; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project))";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE sName:sname AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }

        elseif ($sname != '' and $name == '' and $patr == '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname"; 
                $stmt = $con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,'$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':city'=>$city));

            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND " 
                    . "project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND "
                    ."project_ids IN($project)"
                    ." AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND "
                    ."(donor_ids LIKE IN($donor) "
                    ." AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND "
                    ."(donor_ids IN($donor)) "
                    ." AND project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,   ));    
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,  ':city'=>$city));
            }
        }

        elseif ($sname == '' and $name != '' and $patr == '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE Name=:name"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,'$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':city'=>$city));

            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND " 
                    . "project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND "
                    ."(project_ids IN($project)"
                    ." AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND "
                    ."(donor_ids LIKE IN($donor) "
                    ." AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND "
                    ."(donor_ids IN($donor)) "
                    ." AND project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,   ));    
            }
            else {
                $sql = $default_sql_search. " WHERE Name=:name AND (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,  ':city'=>$city));
            }
        }

        elseif ($sname == '' and $name != '' and $patr == '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2)"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project) ";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city"; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project))";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }
        
        elseif ($sname == '' and $name == '' and $patr != '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE Patr=:patr "; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND " 
                    . "project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND"
                    ."(project_ids IN($project)) AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND"
                    ."(donor_ids IN($donor)) AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project))";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE Patr=:patr AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,   ':city'=>$city)); 
            }
        }
        
        elseif ($sname == '' and $name == '' and $patr != '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2)"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project) ";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city"; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project))";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }

        elseif ($sname != '' and $name != '' and $patr == '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,'$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':city'=>$city));

            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND " 
                    . "project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                    ."(project_ids IN($project)"
                    ." AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                    ."(donor_ids LIKE IN($donor) "
                    ." AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                    ."(donor_ids IN($donor)) "
                    ." AND project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,   ));    
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,  ':city'=>$city));
            }
        }
        
        elseif ($sname != '' and $name != '' and $patr == '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2)"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project) ";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city"; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project))";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }

        elseif ($sname != '' and $name == '' and $patr != '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,'$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':city'=>$city));

            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND " 
                    . "project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                    ."(project_ids IN($project)"
                    ." AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                    ."(donor_ids LIKE IN($donor) "
                    ." AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                    ."(donor_ids IN($donor)) "
                    ." AND project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,   ));    
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND Patr=:patr AND (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,   ':city'=>$city));
            }
        }

        elseif ($sname != '' and $name == '' and $patr != '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2)"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project) ";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city"; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project))";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }
        
        elseif ($sname == '' and $name != '' and $patr != '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr,));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr,'$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':city'=>$city));

            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND " 
                    . "project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND "
                    ."(project_ids IN($project)"
                    ." AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND "
                    ."(donor_ids LIKE IN($donor) "
                    ." AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND "
                    ."(donor_ids IN($donor)) "
                    ." AND project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr,   ));    
            }
            else {
                $sql = $default_sql_search. " WHERE Name=:name AND Patr=:patr AND (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr,   ':city'=>$city));
            }
        }

        elseif ($sname == '' and $name != '' and $patr != '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2)"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project) ";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city"; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project))";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }

        elseif ($sname != '' and $name != '' and $patr != '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,'$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':city'=>$city));

            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND " 
                    . "project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND "
                    ."(project_ids IN($project)"
                    ." AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND "
                    ."(donor_ids LIKE IN($donor) "
                    ." AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND "
                    ."(donor_ids IN($donor)) "
                    ." AND project_ids IN($project) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,   ));    
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,   ':city'=>$city));
            }
        }

        else {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2)"; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor) ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project) ";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city"; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project))";
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city";
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }
    }

    // if $selectedCategoryCount != 0
    else {
        $getcatfromsql = " cat_ids in (". $cats .")";
        if ($sname == '' and $name == '' and $patr == '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE ". $getcatfromsql; 
                $stmt = $con->prepare($sql);
                $stmt->execute();
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE donor_ids IN ($donor)  AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array('$donor'=>$donor));
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE id_City=:city  AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':city'=>$city));
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE project_ids IN($project)  AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array('$project'=>$project));
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE project_ids IN($project) AND id_City=:city AND". $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array( ':city'=> $city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE (donor_ids LIKE '$donor' "
                    ."OR donor_ids LIKE '$donor,%') AND id_City=:city AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array( ':city'=> $city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE donor_ids IN($donor) AND (project_ids IN($project)) AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute();
            }
            else {
                $sql = $default_sql_search. " WHERE (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city AND". $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(  ':city'=> $city));
            }
        }
        
        elseif ($sname == '' and $name == '' and $patr == '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE age >= :age1 AND age <= :age2 AND". $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor)  AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2,  ':city'=> $city));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND id_City=:city  AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project)  AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND "
                    ."(project_ids IN($project) AND id_City=:city AND". $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=>$age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND "
                    ."(donor_ids IN($donor)) AND id_City=:city AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND donor_ids IN($donor) AND (project_ids IN($project)) AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor)) " .
                "AND (project_ids IN($project)) AND id_City=:city AND". $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city));
            }
        }
        
        elseif ($sname != '' and $name == '' and $patr == '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND".$getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor)  AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project) ".$getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city".$getcatfromsql; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city".$getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project))".$getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE sName:sname AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }

        elseif ($sname != '' and $name == '' and $patr == '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND".$getcatfromsql; 
                $stmt = $con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND " 
                    . "donor_ids IN($donor)  AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,'$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND id_City=:city  AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':city'=>$city));

            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND " 
                    . "project_ids IN($project)  AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND "
                    ."(project_ids IN($project)"
                    ." AND id_City=:city AND".$getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND "
                    ."(donor_ids LIKE IN($donor) "
                    ." AND id_City=:city AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND "
                    ."(donor_ids IN($donor)) "
                    ." AND project_ids IN($project)  AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,   ));    
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city AND".$getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname,  ':city'=>$city));
            }
        }

        elseif ($sname == '' and $name != '' and $patr == '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE Name=:name AND".$getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND " 
                    . "donor_ids IN($donor)  AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,'$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND id_City=:city  AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':city'=>$city));

            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND " 
                    . "project_ids IN($project)  AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND "
                    ."(project_ids IN($project)"
                    ." AND id_City=:city AND".$getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND "
                    ."(donor_ids LIKE IN($donor) "
                    ." AND id_City=:city AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND "
                    ."(donor_ids IN($donor)) "
                    ." AND project_ids IN($project)  AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,   ));    
            }
            else {
                $sql = $default_sql_search. " WHERE Name=:name AND (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city AND".$getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,  ':city'=>$city));
            }
        }

        elseif ($sname == '' and $name != '' and $patr == '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND".$getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor)  AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project)  AND".$getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city AND".$getcatfromsql; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city AND".$getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project)) AND".$getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city AND".$getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }
        
        elseif ($sname == '' and $name == '' and $patr != '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE Patr=:patr  AND". $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND " 
                    . "donor_ids IN($donor)  AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND id_City=:city  AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND " 
                    . "project_ids IN($project)  AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND"
                    ."(project_ids IN($project)) AND id_City=:city AND". $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND"
                    ."(donor_ids IN($donor)) AND id_City=:city AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project)) AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE Patr=:patr AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,   ':city'=>$city)); 
            }
        }
        
        elseif ($sname == '' and $name == '' and $patr != '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND". $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor)  AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND". $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project)  AND". $getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city AND" . $getcatfromsql; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city AND" . $getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project)) AND" . $getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }

        elseif ($sname != '' and $name != '' and $patr == '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND" . $getcatfromsql; 
                $stmt = $con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND " 
                    . "donor_ids IN($donor)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,'$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND id_City=:city  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':city'=>$city));

            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND " 
                    . "project_ids IN($project)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                    ."(project_ids IN($project)"
                    ." AND id_City=:city AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                    ."(donor_ids LIKE IN($donor) "
                    ." AND id_City=:city AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                    ."(donor_ids IN($donor)) "
                    ." AND project_ids IN($project)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,   ));    
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,  ':city'=>$city));
            }
        }
        
        elseif ($sname != '' and $name != '' and $patr == '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project)  AND" . $getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city AND" . $getcatfromsql; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city AND" . $getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project)) AND" . $getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }

        elseif ($sname != '' and $name == '' and $patr != '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND " 
                    . "donor_ids IN($donor)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,'$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND id_City=:city  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':city'=>$city));

            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND " 
                    . "project_ids IN($project)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                    ."(project_ids IN($project)"
                    ." AND id_City=:city AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                    ."(donor_ids LIKE IN($donor) "
                    ." AND id_City=:city AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                    ."(donor_ids IN($donor)) "
                    ." AND project_ids IN($project)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,  '$project'=>$project ));    
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND Patr=:patr AND (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,   ':city'=>$city));
            }
        }

        elseif ($sname != '' and $name == '' and $patr != '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project)) AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }
        
        elseif ($sname == '' and $name != '' and $patr != '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr,));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND " 
                    . "donor_ids IN($donor)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr,'$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND id_City=:city  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':city'=>$city));

            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND " 
                    . "project_ids IN($project)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND "
                    ."(project_ids IN($project)"
                    ." AND id_City=:city AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND "
                    ."(donor_ids LIKE IN($donor) "
                    ." AND id_City=:city AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND "
                    ."(donor_ids IN($donor)) "
                    ." AND project_ids IN($project)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr,   ));    
            }
            else {
                $sql = $default_sql_search. " WHERE Name=:name AND Patr=:patr AND (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr,   ':city'=>$city));
            }
        }

        elseif ($sname == '' and $name != '' and $patr != '' and $age1 != '' and $age2 != '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project)  AND" . $getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city AND" . $getcatfromsql; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city AND" . $getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project)) AND" . $getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }

        elseif ($sname != '' and $name != '' and $patr != '' and $age1 == '' and $age2 == '') {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND " 
                    . "donor_ids IN($donor)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,'$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND id_City=:city  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':city'=>$city));

            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND " 
                    . "project_ids IN($project)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, '$project'=>$project));
            }   
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND "
                    ."(project_ids IN($project)"
                    ." AND id_City=:city AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND "
                    ."(donor_ids LIKE IN($donor) "
                    ." AND id_City=:city AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND "
                    ."(donor_ids IN($donor)) "
                    ." AND project_ids IN($project)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,   ));    
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (donor_ids IN($donor))" .
                "AND (project_ids IN($project)) AND id_City=:city AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,   ':city'=>$city));
            }
        }

        else {
            if ($donor == 0 and $city == 0 and $project == 0){
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND" . $getcatfromsql; 
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2));
            }    
            elseif ($donor != 0 and $city == 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "donor_ids IN($donor)  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, '$donor'=>$donor));    
            }    
            elseif ($donor == 0 and $city != 0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
            } 
            elseif ($donor == 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                    . "project_ids IN($project)  AND" . $getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, '$project'=>$project));    
            }
            elseif ($donor == 0 and $city != 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(project_ids IN($project)) AND id_City=:city AND" . $getcatfromsql; 
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));    
            }    
            elseif ($donor != 0 and $city !=0 and $project == 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                    ."(donor_ids IN($donor)) AND id_City=:city AND" . $getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  ':city'=>$city));
            }    
            elseif ($donor != 0 and $city == 0 and $project != 0) {
                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                    ."donor_ids IN($donor) AND (project_ids IN($project)) AND" . $getcatfromsql;
                    $stmt=$con->prepare($sql);
                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,  '$project'=>$project));
            }
            else {
                $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN($donor))" .
                "AND project_ids IN($project) AND id_City=:city AND" . $getcatfromsql;
                $stmt=$con->prepare($sql);
                $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2,   ':city'=>$city)); 
            }
        }
    }
    
    $searchResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($searchResult)) {
        $_SESSION['profiles'] = $searchResult;
        header("location: /profile/profiles.php");
        exit; 
    } else {
        $_SESSION["flash"] = ["type" => "warning", "message" => "По поиску ничего не найдено."];
        header("location: /profile/searchprof.php");
        exit;
    }
} 
 ?>