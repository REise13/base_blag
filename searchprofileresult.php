<?php $title= 'Поиск профиля' ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>
<?php require_once "config.php"; ?>

<body>
    <div class="page-content p-3" id="content">
        <h2 class="display-4 text-white"></h2>
        <div class="separator"></div>
        <div class="search-form">
        <!-- Форма поиска профиля -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col mx-auto">
                        <div class="search-form bg-form p-5 rounded shadow-sm">
                        <?php
                            $url = htmlspecialchars($_SERVER['HTTP_REFERER']);
                            echo "<a href='$url' class='btn btn-custom mb-3'>Назад</a>"; 
                        ?>
                        <?php if (isset($_GET['sname'], $_GET['name'], $_GET['patr'], $_GET['age1'], $_GET['age2'], $_GET['city'], $_GET['donor'], $_GET['project'], $_GET['categories'])) { ?>
                            <div class="table-scrollbar">
                                <table id="profileInfo" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">ФИО</th>
                                            <th scope="col">Возраст</th>
                                            <th scope="col">Город</th>
                                            <th scope="col">Пол</th>
                                            <th scope="col">ИНН</th>
                                            <th scope="col">Паспорт</th>
                                            <th scope="col">Категории</th>
                                            <th scope="col">Помощь</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sname = trim($_GET['sname']);
                                        $name = trim($_GET['name']);
                                        $patr = trim($_GET['patr']);
                                        $age1 = trim($_GET['age1']);
                                        $age2 = trim($_GET['age2']);
                                        $city = trim($_GET['city']);
                                        $donor = trim($_GET['donor']);
                                        $project = trim($_GET['project']);
                                        $categories = $_GET['categories'];
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
                                                    $sql = $default_sql_search . " WHERE donor_ids IN (:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':donor'=>$donor));
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':city'=>$city));
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':project'=>$project));
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE project_ids IN(:project) AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':project'=>$project, ':city'=> $city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE (donor_ids LIKE ':donor' "
                                                        ."OR donor_ids LIKE ':donor,%') AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':donor'=>$donor, ':city'=> $city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE donor_ids IN(:donor) AND (project_ids IN(:project))";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':donor'=> $donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':donor'=>$donor, ':project'=>$project, ':city'=> $city));
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=> $city));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND "
                                                        ."(project_ids IN(:project) AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=>$age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND "
                                                        ."(donor_ids IN(:donor)) AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND donor_ids IN(:donor) AND (project_ids IN(:project))";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor)) " .
                                                    "AND (project_ids IN(:project)) AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project) ";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city"; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project))";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName:sname AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname,':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':city'=>$city));

                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND " 
                                                        . "project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND "
                                                        ."(project_ids LIKE IN(:project)"
                                                        ." AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':project'=>$project, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND "
                                                        ."(donor_ids LIKE IN(:donor) "
                                                        ." AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND "
                                                        ."(donor_ids IN(:donor)) "
                                                        ." AND project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':donor'=>$donor, ':project'=>$project, ));    
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname,':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name,':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':city'=>$city));

                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND " 
                                                        . "project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND "
                                                        ."(project_ids LIKE IN(:project)"
                                                        ." AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':project'=>$project, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND "
                                                        ."(donor_ids LIKE IN(:donor) "
                                                        ." AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND "
                                                        ."(donor_ids IN(:donor)) "
                                                        ." AND project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':donor'=>$donor, ':project'=>$project, ));    
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE Name=:name AND (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name,':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project) ";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city"; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project))";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND " 
                                                        . "project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project))";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE Patr=:patr AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project) ";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city"; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project))";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':city'=>$city));

                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND " 
                                                        . "project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                                                        ."(project_ids LIKE IN(:project)"
                                                        ." AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':project'=>$project, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                                                        ."(donor_ids LIKE IN(:donor) "
                                                        ." AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                                                        ."(donor_ids IN(:donor)) "
                                                        ." AND project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':donor'=>$donor, ':project'=>$project, ));    
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project) ";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city"; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project))";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':city'=>$city));

                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND " 
                                                        . "project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                                                        ."(project_ids LIKE IN(:project)"
                                                        ." AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':project'=>$project, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                                                        ."(donor_ids LIKE IN(:donor) "
                                                        ." AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                                                        ."(donor_ids IN(:donor)) "
                                                        ." AND project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ));    
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND Patr=:patr AND (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project) ";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city"; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project))";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr,':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':city'=>$city));

                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND " 
                                                        . "project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND "
                                                        ."(project_ids LIKE IN(:project)"
                                                        ." AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':project'=>$project, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND "
                                                        ."(donor_ids LIKE IN(:donor) "
                                                        ." AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND "
                                                        ."(donor_ids IN(:donor)) "
                                                        ." AND project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ));    
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE Name=:name AND Patr=:patr AND (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project) ";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city"; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project))";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':city'=>$city));

                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND " 
                                                        . "project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND "
                                                        ."(project_ids LIKE IN(:project)"
                                                        ." AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':project'=>$project, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND "
                                                        ."(donor_ids LIKE IN(:donor) "
                                                        ." AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND "
                                                        ."(donor_ids IN(:donor)) "
                                                        ." AND project_ids IN(:project) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ));    
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city"; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor) ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project) ";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city"; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project))";
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city";
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                    $sql = $default_sql_search . " WHERE donor_ids IN (:donor)  AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':donor'=>$donor));
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE id_City=:city  AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':city'=>$city));
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE project_ids IN(:project)  AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':project'=>$project));
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE project_ids IN(:project) AND id_City=:city AND". $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':project'=>$project, ':city'=> $city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE (donor_ids LIKE ':donor' "
                                                        ."OR donor_ids LIKE ':donor,%') AND id_City=:city AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':donor'=>$donor, ':city'=> $city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE donor_ids IN(:donor) AND (project_ids IN(:project)) AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':donor'=> $donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city AND". $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':donor'=>$donor, ':project'=>$project, ':city'=> $city));
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
                                                        . "donor_ids IN(:donor)  AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=> $city));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND id_City=:city  AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project)  AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND "
                                                        ."(project_ids IN(:project) AND id_City=:city AND". $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=>$age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND "
                                                        ."(donor_ids IN(:donor)) AND id_City=:city AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE (age >= :age1 AND age <= :age2) AND donor_ids IN(:donor) AND (project_ids IN(:project)) AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor)) " .
                                                    "AND (project_ids IN(:project)) AND id_City=:city AND". $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor)  AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project) ".$getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city".$getcatfromsql; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city".$getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project))".$getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName:sname AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor)  AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname,':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND id_City=:city  AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':city'=>$city));

                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND " 
                                                        . "project_ids IN(:project)  AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND "
                                                        ."(project_ids LIKE IN(:project)"
                                                        ." AND id_City=:city AND".$getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':project'=>$project, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND "
                                                        ."(donor_ids LIKE IN(:donor) "
                                                        ." AND id_City=:city AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND "
                                                        ."(donor_ids IN(:donor)) "
                                                        ." AND project_ids IN(:project)  AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':donor'=>$donor, ':project'=>$project, ));    
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city AND".$getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname,':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor)  AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name,':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND id_City=:city  AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':city'=>$city));

                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND " 
                                                        . "project_ids IN(:project)  AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND "
                                                        ."(project_ids LIKE IN(:project)"
                                                        ." AND id_City=:city AND".$getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':project'=>$project, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND "
                                                        ."(donor_ids LIKE IN(:donor) "
                                                        ." AND id_City=:city AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND "
                                                        ."(donor_ids IN(:donor)) "
                                                        ." AND project_ids IN(:project)  AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':donor'=>$donor, ':project'=>$project, ));    
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE Name=:name AND (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city AND".$getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name,':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor)  AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project)  AND".$getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city AND".$getcatfromsql; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city AND".$getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project)) AND".$getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city AND".$getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor)  AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND id_City=:city  AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND " 
                                                        . "project_ids IN(:project)  AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city AND". $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project)) AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE Patr=:patr AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor)  AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND". $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project)  AND". $getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city AND" . $getcatfromsql; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city AND" . $getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project)) AND" . $getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':patr'=>$patr,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND id_City=:city  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':city'=>$city));

                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND " 
                                                        . "project_ids IN(:project)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                                                        ."(project_ids LIKE IN(:project)"
                                                        ." AND id_City=:city AND" . $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':project'=>$project, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                                                        ."(donor_ids LIKE IN(:donor) "
                                                        ." AND id_City=:city AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                                                        ."(donor_ids IN(:donor)) "
                                                        ." AND project_ids IN(:project)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':donor'=>$donor, ':project'=>$project, ));    
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city AND" . $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project)  AND" . $getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city AND" . $getcatfromsql; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city AND" . $getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project)) AND" . $getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name,':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr,':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND id_City=:city  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':city'=>$city));

                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND " 
                                                        . "project_ids IN(:project)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                                                        ."(project_ids LIKE IN(:project)"
                                                        ." AND id_City=:city AND" . $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':project'=>$project, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                                                        ."(donor_ids LIKE IN(:donor) "
                                                        ." AND id_City=:city AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                                                        ."(donor_ids IN(:donor)) "
                                                        ." AND project_ids IN(:project)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':donor'=>$donor, ':project'=>$project ));    
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND Patr=:patr AND (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city AND" . $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city AND" . $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project)) AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr,':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND id_City=:city  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':city'=>$city));

                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND " 
                                                        . "project_ids IN(:project)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND "
                                                        ."(project_ids LIKE IN(:project)"
                                                        ." AND id_City=:city AND" . $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':project'=>$project, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND "
                                                        ."(donor_ids LIKE IN(:donor) "
                                                        ." AND id_City=:city AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND "
                                                        ."(donor_ids IN(:donor)) "
                                                        ." AND project_ids IN(:project)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ));    
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE Name=:name AND Patr=:patr AND (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city AND" . $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project)  AND" . $getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city AND" . $getcatfromsql; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city AND" . $getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project)) AND" . $getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
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
                                                        . "donor_ids IN(:donor)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr,':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND id_City=:city  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':city'=>$city));

                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND " 
                                                        . "project_ids IN(:project)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':project'=>$project));
                                                }   
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND "
                                                        ."(project_ids LIKE IN(:project)"
                                                        ." AND id_City=:city AND" . $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':project'=>$project, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND "
                                                        ."(donor_ids LIKE IN(:donor) "
                                                        ." AND id_City=:city AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND "
                                                        ."(donor_ids IN(:donor)) "
                                                        ." AND project_ids IN(:project)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ));    
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (donor_ids IN(:donor))" .
                                                    "AND (project_ids IN(:project)) AND id_City=:city AND" . $getcatfromsql; 
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':donor'=>$donor, ':project'=>$project, ':city'=>$city));
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
                                                        . "donor_ids IN(:donor)  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor));    
                                                }    
                                                elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city  AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':city'=>$city));    
                                                } 
                                                elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                                                        . "project_ids IN(:project)  AND" . $getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':project'=>$project));    
                                                }
                                                elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(project_ids IN(:project)) AND id_City=:city AND" . $getcatfromsql; 
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':project'=>$project, ':city'=>$city));    
                                                }    
                                                elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                        ."(donor_ids IN(:donor)) AND id_City=:city AND" . $getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':city'=>$city));
                                                }    
                                                elseif ($donor != 0 and $city == 0 and $project != 0) {
                                                    $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                                                        ."donor_ids IN(:donor) AND (project_ids IN(:project)) AND" . $getcatfromsql;
                                                        $stmt=$con->prepare($sql);
                                                        $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project));
                                                }
                                                else {
                                                    $sql = $default_sql_search. " WHERE sName=:sname AND Name=:name AND Patr=:patr AND (age >= :age1 AND age <= :age2) AND (donor_ids IN(:donor))" .
                                                    "AND project_ids IN(:project) AND id_City=:city AND" . $getcatfromsql;
                                                    $stmt=$con->prepare($sql);
                                                    $stmt->execute(array(':sname'=>$sname, ':name'=>$name, ':patr'=>$patr, ':age1'=> $age1, ':age2'=> $age2, ':donor'=>$donor, ':project'=>$project, ':city'=>$city)); 
                                                }
                                            }
                                        }
                                        
                                        $searchResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        ?>
                                        <?php foreach ($searchResult as $row) { ?>
                                                <tr class="row-click" data-href="profileinfo.php/?profile=<?php echo $row['profile_id'] ?>&people=<?php echo $row['id_people'] ?>">      
                                                    <td><?php echo $row['fio'] ?></td>
                                                    <td><?php echo $row['age'] ?></td>
                                                    <td><?php echo $row['city_info'] ?></td>
                                                    <td><?php echo $row['gender_info'] ?></td>
                                                    <td><?php echo $row['INN'] ?></td>
                                                    <td><?php echo $row['Passport'] ?></td>
                                                    <td><?php echo $row['category_info'] ?></td>
                                                    <td><?php echo $row['help_info'] ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    <?php } ?>   
                                    </div>
                        
                                </table>        
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>

    <script>
        $(document).ready(function($){
            $(".row-click").click(function(){
                window.document.location = $(this).data("href");
            });
        });
    </script>
</body>                      