<?php $title= 'Поиск' ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>
<?php require_once "config.php"; ?>

<body>
    <div class="page-content p-3" id="content">
        <h2 class="display-4 text-white"></h2>
        <div class="separator"></div>
        <div class="search-form">
        <!-- Форма поиска профиля -->
            <div class="row">
                <div class="container">
                    <div class="search-form bg-form p-5 rounded shadow-sm">
                        <form role="form" action="" method="POST">
                            <div class="form-row">
                                <div class="col">
                                    <label for="sname" class="font-weight-bold">Фамилия</label>
                                    <input type="text" class="rounded-pill form-control" id="sname" name="sname">
                                </div>
                                <div class="col">
                                    <label for="name" class="font-weight-bold">Имя</label>
                                    <input type="text" class="rounded-pill form-control" id="name" name="name">
                                </div>
                                <div class="col">
                                    <label for="patr" class="font-weight-bold">Отчество</label>
                                    <input type="text" class="rounded-pill form-control" id="patr" name="patr">
                                </div>
                            </div>
                            
                            <div class="form-group mt-3">
                                <label for="age" class="font-weight-bold">Возраст</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="age1">От</label>
                                            <input type="text" name="age1" id="age1" class="rounded-pill form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="age2">До</label>
                                            <input type="text" class="rounded-pill form-control" name="age2" id="age2">
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label for="cities" class="text-uppercase font-weight-bold">Город</label>
                                <div class="data_select">
                                <?php
                                $stmt = $con->prepare("SELECT id, title AS city FROM city");
                                $stmt->execute();

                                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($stmt->rowCount() > 0) { ?>
                                    <select name="city" id="city" 
                                        class="selectpicker show-tick" data-width="150px;" data-size="7" required>
                                        <option value="0">Все</option>
                                        <?php foreach ($results as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['city'] ?></option>
                                        <?php } ?>    
                                    </select>   
                                <?php } ?>                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categories" class="text-uppercase font-weight-bold">Категории</label>
                                <div class="data_select">
                                <?php
                                $stmt = $con->prepare("SELECT id, title AS cat FROM category");
                                $stmt->execute();

                                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                           
                                if ($stmt->rowCount() > 0) { ?>
                                    <select name="categories[]" id="categories" 
                                        class="selectpicker show-tick" data-width="150px;" data-size="7" multiple="multiple">
                                        <option value="0">Все</option>
                                        <?php foreach ($results as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['cat'] ?></option>
                                        <?php } ?>    
                                    </select>   
                                <?php } ?>                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="donor" class="text-uppercase font-weight-bold">Донор</label>
                                <div class="data_select" data-width="150px;">
                                <?php
                                $stmt = $con->prepare("SELECT id, title AS donor FROM donor");
                                $stmt->execute();

                                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($stmt->rowCount() > 0) { ?>
                                    <select name="donor" id="donor" 
                                    class="selectpicker show-tick" data-size="7" required>
                                        <option value="0">Все</option>
                                        <?php foreach ($results as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['donor'] ?></option>
                                        <?php } ?>    
                                    </select>   
                                <?php } ?>   
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="project" class="text-uppercase font-weight-bold">Проект</label>
                                <div class="data_select">
                                <?php
                                $stmt = $con->prepare("SELECT id, title AS prj FROM project");
                                $stmt->execute();

                                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($stmt->rowCount() > 0) { ?>
                                    <select name="project" id="project"
                                    class="selectpicker show-tick form-control" data-width="150px;" data-size="7" required>
                                        <option value="0">Все</option>
                                        <?php foreach ($results as $row) { ?>
                                            <option style="font-size: 14px;" value="<?php echo $row['id']; ?>"><?php echo $row['prj'] ?></option>
                                        <?php } ?>    
                                    </select>   
                                <?php } ?>   
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-custom" data-toggle="modal" data-target="#searchResultModal">Поиск</button>
                        </form>

                        <div class="modal fade" id="searchResultModal" tabindex="-1"
                            aria-labelledby="searchResultModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="searchResultModalLabel">Результаты поиска</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { ?>
                                        <table class="table table-striped table-bordered">
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
                                                $sname = trim($_POST['sname']);
                                                $name = trim($_POST['name']);
                                                $patr = trim($_POST['patr']);
                                                $age1 = trim($_POST['age1']);
                                                $age2 = trim($_POST['age2']);
                                                $city = trim($_POST['city']);
                                                $categories = explode(",", $_POST['categories']);
                                                $donor = trim($_POST['donor']);
                                                $project = trim($_POST['project']);

                                                $default_sql_search = "SELECT profile_id, fio, age, city_info, gender_info, INN, Passport, category_info, help_info";
                                                foreach ($categories as $category) {
                                                    if ($category == 0) {
                                                        if ($sname == '' and $name == '' and $patr == '' and $age1 == '' and $age2 == '') {
                                                            if ($donor == 0 and $city == 0 and $project == 0){
                                                                $sql = $default_sql_search; 
                                                            }    
                                                            elseif ($donor != 0 and $city == 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE donor_ids LIKE ':donor' OR donor_ids LIKE ':donor,%' ";
                                                            }    
                                                            elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE id_City=:city ";
                                                            } 
                                                            elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE project_ids LIKE ':project' OR project_ids LIKE ':project,%' "
                                                            }   
                                                            elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE (project_ids LIKE ':project'"
                                                                    ."OR project_ids LIKE ':project,%') AND id_City=:city"; 
                                                            }    
                                                            elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE (donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND id_City=:city";
                                                            }    
                                                            else ($donor != 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE (donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND (project_ids LIKE ':project' "
                                                                    ."OR project_ids LIKE ':project,%')";
                                                            }
                                                        }
                                                        
                                                        elseif ($sname == '' and $name == '' and $patr == '' and $age1 != '' and $age2 != '') {
                                                            if ($donor == 0 and $city == 0 and $project == 0){
                                                                $sql = $default_sql_search . " WHERE age >= :age1 AND age <= :age2"; 
                                                            }    
                                                            elseif ($donor != 0 and $city == 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE age >= :age1 AND age <= :age2 AND " 
                                                                    . "(donor_ids LIKE ':donor' OR donor_ids LIKE ':donor,%') ";
                                                            }    
                                                            elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE age >= :age1 AND age <= :age2 AND id_City=:city ";
                                                            } 
                                                            elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE age >= :age1 AND age <= :age2 AND " 
                                                                    . "(project_ids LIKE ':project' OR project_ids LIKE ':project,%') "
                                                            }   
                                                            elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE age >= :age1 AND age <= :age2 AND"
                                                                    ."(project_ids LIKE ':project'"
                                                                    ."OR project_ids LIKE ':project,%') AND id_City=:city"; 
                                                            }    
                                                            elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE age >= :age1 AND age <= :age2 AND"
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND id_City=:city";
                                                            }    
                                                            else ($donor != 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE age >= :age1 AND age <= :age2 AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND (project_ids LIKE ':project' "
                                                                    ."OR project_ids LIKE ':project,%')";
                                                            }
                                                        }
                                                        
                                                        elseif ($sname != '' and $name == '' and $patr == '' and $age1 != '' and $age2 != '') {
                                                            if ($donor == 0 and $city == 0 and $project == 0){
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2)"; 
                                                            }    
                                                            elseif ($donor != 0 and $city == 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND " 
                                                                    . "(donor_ids LIKE ':donor' OR donor_ids LIKE ':donor,%') ";
                                                            }    
                                                            elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                                                            } 
                                                            elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND " 
                                                                    . "(project_ids LIKE ':project' OR project_ids LIKE ':project,%') "
                                                            }   
                                                            elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND"
                                                                    ."(project_ids LIKE ':project'"
                                                                    ."OR project_ids LIKE ':project,%') AND id_City=:city"; 
                                                            }    
                                                            elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND"
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND id_City=:city";
                                                            }    
                                                            else ($donor != 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND (age >= :age1 AND age <= :age2) AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND (project_ids LIKE ':project' "
                                                                    ."OR project_ids LIKE ':project,%')";
                                                            }
                                                        }

                                                        elseif ($sname != '' and $name == '' and $patr == '' and $age1 == '' and $age2 == '') {
                                                            if ($donor == 0 and $city == 0 and $project == 0){
                                                                $sql = $default_sql_search . " WHERE sName=:sname"; 
                                                            }    
                                                            elseif ($donor != 0 and $city == 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND " 
                                                                    . "(donor_ids LIKE ':donor' OR donor_ids LIKE ':donor,%') ";
                                                            }    
                                                            elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND id_City=:city ";
                                                            } 
                                                            elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND " 
                                                                    . "(project_ids LIKE ':project' OR project_ids LIKE ':project,%') "
                                                            }   
                                                            elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND "
                                                                    ."(project_ids LIKE ':project'"
                                                                    ."OR project_ids LIKE ':project,%') AND id_City=:city"; 
                                                            }    
                                                            elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND id_City=:city";
                                                            }    
                                                            else ($donor != 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND (project_ids LIKE ':project' "
                                                                    ."OR project_ids LIKE ':project,%')";
                                                            }
                                                        }

                                                        elseif ($sname == '' and $name != '' and $patr == '' and $age1 == '' and $age2 == '') {
                                                            if ($donor == 0 and $city == 0 and $project == 0){
                                                                $sql = $default_sql_search . " WHERE Name=:name "; 
                                                            }    
                                                            elseif ($donor != 0 and $city == 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE Name=:name AND " 
                                                                    . "(donor_ids LIKE ':donor' OR donor_ids LIKE ':donor,%') ";
                                                            }    
                                                            elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE Name=:name AND id_City=:city ";
                                                            } 
                                                            elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE Name=:name AND " 
                                                                    . "(project_ids LIKE ':project' OR project_ids LIKE ':project,%') "
                                                            }   
                                                            elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE Name=:name AND "
                                                                    ."(project_ids LIKE ':project'"
                                                                    ."OR project_ids LIKE ':project,%') AND id_City=:city"; 
                                                            }    
                                                            elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE Name=:name AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND id_City=:city";
                                                            }    
                                                            else ($donor != 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE Name=:name AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND (project_ids LIKE ':project' "
                                                                    ."OR project_ids LIKE ':project,%')";
                                                            }
                                                        }

                                                        elseif ($sname == '' and $name != '' and $patr == '' and $age1 != '' and $age2 != '') {
                                                            if ($donor == 0 and $city == 0 and $project == 0){
                                                                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2)"; 
                                                            }    
                                                            elseif ($donor != 0 and $city == 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                                                                    . "(donor_ids LIKE ':donor' OR donor_ids LIKE ':donor,%') ";
                                                            }    
                                                            elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                                                            } 
                                                            elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                                                                    . "(project_ids LIKE ':project' OR project_ids LIKE ':project,%') "
                                                            }   
                                                            elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND"
                                                                    ."(project_ids LIKE ':project'"
                                                                    ."OR project_ids LIKE ':project,%') AND id_City=:city"; 
                                                            }    
                                                            elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND"
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND id_City=:city";
                                                            }    
                                                            else ($donor != 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE Name=:name AND (age >= :age1 AND age <= :age2) AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND (project_ids LIKE ':project' "
                                                                    ."OR project_ids LIKE ':project,%')";
                                                            }
                                                        }
                                                        
                                                        elseif ($sname == '' and $name == '' and $patr != '' and $age1 == '' and $age2 == '') {
                                                            if ($donor == 0 and $city == 0 and $project == 0){
                                                                $sql = $default_sql_search . " WHERE Patr=:patr "; 
                                                            }    
                                                            elseif ($donor != 0 and $city == 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND " 
                                                                    . "(donor_ids LIKE ':donor' OR donor_ids LIKE ':donor,%') ";
                                                            }    
                                                            elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND id_City=:city ";
                                                            } 
                                                            elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND " 
                                                                    . "(project_ids LIKE ':project' OR project_ids LIKE ':project,%') "
                                                            }   
                                                            elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND "
                                                                    ."(project_ids LIKE ':project'"
                                                                    ."OR project_ids LIKE ':project,%') AND id_City=:city"; 
                                                            }    
                                                            elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND id_City=:city";
                                                            }    
                                                            else ($donor != 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND (project_ids LIKE ':project' "
                                                                    ."OR project_ids LIKE ':project,%')";
                                                            }
                                                        }
                                                        
                                                        elseif ($sname == '' and $name == '' and $patr != '' and $age1 != '' and $age2 != '') {
                                                            if ($donor == 0 and $city == 0 and $project == 0){
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2)"; 
                                                            }    
                                                            elseif ($donor != 0 and $city == 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                                                                    . "(donor_ids LIKE ':donor' OR donor_ids LIKE ':donor,%') ";
                                                            }    
                                                            elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                                                            } 
                                                            elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND " 
                                                                    . "(project_ids LIKE ':project' OR project_ids LIKE ':project,%') "
                                                            }   
                                                            elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                                    ."(project_ids LIKE ':project'"
                                                                    ."OR project_ids LIKE ':project,%') AND id_City=:city"; 
                                                            }    
                                                            elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND"
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND id_City=:city";
                                                            }    
                                                            else ($donor != 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE Patr=:patr AND (age >= :age1 AND age <= :age2) AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND (project_ids LIKE ':project' "
                                                                    ."OR project_ids LIKE ':project,%')";
                                                            }
                                                        }

                                                        elseif ($sname != '' and $name != '' and $patr == '' and $age1 == '' and $age2 == '') {
                                                            if ($donor == 0 and $city == 0 and $project == 0){
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name "; 
                                                            }    
                                                            elseif ($donor != 0 and $city == 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND " 
                                                                    . "(donor_ids LIKE ':donor' OR donor_ids LIKE ':donor,%') ";
                                                            }    
                                                            elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND id_City=:city ";
                                                            } 
                                                            elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND " 
                                                                    . "(project_ids LIKE ':project' OR project_ids LIKE ':project,%') "
                                                            }   
                                                            elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                                                                    ."(project_ids LIKE ':project'"
                                                                    ."OR project_ids LIKE ':project,%') AND id_City=:city"; 
                                                            }    
                                                            elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND id_City=:city";
                                                            }    
                                                            else ($donor != 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND (project_ids LIKE ':project' "
                                                                    ."OR project_ids LIKE ':project,%')";
                                                            }
                                                        }
                                                        
                                                        elseif ($sname != '' and $name != '' and $patr == '' and $age1 != '' and $age2 != '') {
                                                            if ($donor == 0 and $city == 0 and $project == 0){
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2)"; 
                                                            }    
                                                            elseif ($donor != 0 and $city == 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                                                                    . "(donor_ids LIKE ':donor' OR donor_ids LIKE ':donor,%') ";
                                                            }    
                                                            elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND id_City=:city ";
                                                            } 
                                                            elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND " 
                                                                    . "(project_ids LIKE ':project' OR project_ids LIKE ':project,%') "
                                                            }   
                                                            elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND"
                                                                    ."(project_ids LIKE ':project'"
                                                                    ."OR project_ids LIKE ':project,%') AND id_City=:city"; 
                                                            }    
                                                            elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND"
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND id_City=:city";
                                                            }    
                                                            else ($donor != 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Name=:name AND (age >= :age1 AND age <= :age2) AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND (project_ids LIKE ':project' "
                                                                    ."OR project_ids LIKE ':project,%')";
                                                            }
                                                        }

                                                        elseif ($sname != '' and $name == '' and $patr != '' and $age1 == '' and $age2 == '') {
                                                            if ($donor == 0 and $city == 0 and $project == 0){
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr "; 
                                                            }    
                                                            elseif ($donor != 0 and $city == 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND " 
                                                                    . "(donor_ids LIKE ':donor' OR donor_ids LIKE ':donor,%') ";
                                                            }    
                                                            elseif ($donor == 0 and $city != 0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND id_City=:city ";
                                                            } 
                                                            elseif ($donor == 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND " 
                                                                    . "(project_ids LIKE ':project' OR project_ids LIKE ':project,%') "
                                                            }   
                                                            elseif ($donor == 0 and $city != 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                                                                    ."(project_ids LIKE ':project'"
                                                                    ."OR project_ids LIKE ':project,%') AND id_City=:city"; 
                                                            }    
                                                            elseif ($donor != 0 and $city !=0 and $project == 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND id_City=:city";
                                                            }    
                                                            else ($donor != 0 and $city == 0 and $project != 0) {
                                                                $sql = $default_sql_search . " WHERE sName=:sname AND Patr=:patr AND "
                                                                    ."(donor_ids LIKE ':donor' "
                                                                    ."OR donor_ids LIKE ':donor,%') AND (project_ids LIKE ':project' "
                                                                    ."OR project_ids LIKE ':project,%')";
                                                            }
                                                        }
                                                    }                
                                                }
                                                ?>
                                            </tbody>
                                         <?php } ?>   
                                        </table>        
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, laudantium qui optio, obcaecati ea, minus quae excepturi odit voluptates voluptatibus distinctio rem modi illo perspiciatis fugit officia in corrupti quia.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                            Закрыть
                                        </button>
                                    </div>
                                </div>
                            </div>                    
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>    
    <!-- block content end -->

    <script>
        $(document).ready(function() {
            $(document).scroll(function () {
                var scroll = $(this).scrollTop();
                var topDist = $("#navbarSupportedContent").position();
                if (scroll > topDist.top) {
                    $('nav').css({"position":"fixed","top":"0"});
                } else {
                    $('nav').css({"position":"static","top":"auto"});
                }
            });

            $("")
        });
    </script>

</body>