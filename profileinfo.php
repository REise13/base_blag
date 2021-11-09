<?php $title= 'Профиль' ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>
<?php require_once "config.php"; ?>

<?php 
$profID = $_GET['profile'];
$peopleID = $_GET['people'];
$_SESSION['profID'] = $profID;
$_SESSION['peopleID'] = $peopleID;



$getGeneralInfo = "SELECT sName, Name, Patr, gender_info, yearbirth, INN, Passport, Phone, city_info FROM profile_search WHERE profile_id=:id";
$stmt = $con->prepare($getGeneralInfo);
$stmt -> bindParam(':id', $profID, PDO::PARAM_INT);
$stmt->execute();
$profileInfo = $stmt->fetch();

?>

<script>
    $(document).ready(function(){
        $('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#navPill a[href="' + activeTab + '"]').tab('show');
        }
    });
</script>

<body>
    <div class="row">
        <div class="col-lg-8 pt-5 mx-auto">
            <div class="bg-form rounded-lg shadow-sm p-5">
                <!-- Profile form tabs -->
                <ul role="tablist" class="nav bg-light nav-pills rounded-pill nav-fill mb-3" id="navPill">
                    <li class="nav-item">
                        <a data-toggle="pill" href="#nav-tab-general-info" class="nav-link active rounded-pill">
                                            <i class="fad fa-user"></i>
                                            Основная информация
                                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="pill" href="#nav-tab-other-info" class="nav-link rounded-pill">
                                            <i class="fad fa-angle-double-right"></i>
                                            Дополнительно
                                        </a>
                    </li>
                    <?php if($_SESSION['user_role'] == 1) { ?>
                    <li class="nav-item">
                        <a data-toggle="pill" href="#nav-tab-delete-profile" class="nav-link rounded-pill">
                                             <i class="fad fa-minus-circle"></i>
                                            Удалить профиль
                                        </a>
                    </li>
                    <?php } ?>
                </ul>
                 <!-- end -->
                <div class="tab-content">
                    <!-- nav-tab-general-info -->
                    <div id="nav-tab-general-info" class="tab-pane fade show active">
                        <?php if ($_SESSION['message'] != "") { ?>
                            <!-- alert message -->
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['message']; $_SESSION['message'] = "";?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- end -->
                        <?php } ?>
                        <form class="pt-3">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="sname">Фамилия</label>
                                    <input type="text" name="sname" id="sname" class="info form-control border-0 px-4" value="<?php echo $profileInfo['sName'] ?>">
                                </div>
                                <div class="form-group col">
                                    <label for="name">Имя</label>
                                    <input type="text" name="name" id="name" class="info form-control border-0 px-4" value="<?php echo $profileInfo['Name'] ?>">
                                </div>
                                <div class="form-group col">
                                    <label for="patr">Отчество</label>
                                    <input type="text" name="patr" id="patr" class="info form-control border-0 px-4" value="<?php echo $profileInfo['Patr'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                   <label for="gender">Пол</label>
                                    <input type="text" name="gender" id="gender" class="info form-control border-0 px-4" value="<?php echo $profileInfo['gender_info'] ?>"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="birth">Год рождения</label>
                                    <input type="text" name="birth" id="birth" class="info form-control border-0 px-4" value="<?php echo $profileInfo['yearbirth'] ?>">
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label for="inn">ИНН</label>
                                <input type="text" name="inn" id="inn" class="info form-control border-0 px-4" value="<?php echo $profileInfo['INN'] ?>"> 
                            </div>
                            <div class="form-group">
                                <label for="passport">Паспорт</label>
                                <input type="text" name="passport" id="passport" class="info form-control border-0 px-4" value="<?php echo $profileInfo['Passport'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Телефон</label>
                                <input type="text" name="phone" id="phone" class="info form-control border-0 px-4" value="<?php echo $profileInfo['Phone'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="city">Город</label>
                                <input type="text" name="city" id="city" class="info form-control border-0 px-4" value="<?php echo $profileInfo['city_info'] ?>"> 
                            </div>
                            <button type="button" class="btn btn-edit mt-2" data-toggle="modal" data-target="#editGeneralInfo">
                                <i class="fad fa-edit"></i>
                                Редактировать
                            </button>
                        </form>
                        <div class="modal fade" id="editGeneralInfo" tabindex="-1" aria-labelledby="editGeneralInfoLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editGeneralInfoLabel">Основная информация</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">    
                                        <form role="form" action="/updategeneralinfo.php" method="post">
                                            <div class="form-group ">
                                                <label for="sname">Фамилия</label>
                                                <input type="text" name="sname_edit" id="sname_edit" class="form-control" value="<?php echo $profileInfo['sName'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Имя</label>
                                                <input type="text" name="name_edit" id="name_edit" class="form-control" value="<?php echo $profileInfo['Name'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="patr">Отчество</label>
                                                <input type="text" name="patr_edit" id="patr_edit" class="form-control" value="<?php echo $profileInfo['Patr'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="gender">Пол</label>
                                                <div class="data_select">
                                                <?php
                                                $stmt = $con->prepare("SELECT id, title AS gender FROM gender");
                                                $stmt->execute();

                                                $gender = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                if ($stmt->rowCount() > 0) { ?>
                                                    <select name="gender_edit" id="gender_edit" 
                                                        class="selectpicker show-tick" data-width="150px;" data-size="7" required>
                                                        <?php foreach ($gender as $row) { ?>
                                                            <?php if ($profileInfo['gender_info'] == $row['gender']) { ?>
                                                                <option value="<?php echo $row['id']; ?>" selected><?php echo $row['gender'] ?></option>
                                                            <?php } else { ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['gender'] ?></option>
                                                            <?php } ?>    
                                                        <?php } ?>    
                                                    </select>   
                                                <?php } ?>                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="birth">Год рождения</label>
                                                <input type="text" name="birth_edit" id="birth_edit" class="form-control" value="<?php echo $profileInfo['yearbirth'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="inn">ИНН</label>
                                                <input type="text" name="inn_edit" id="inn_edit" class="form-control" value="<?php echo $profileInfo['INN'] ?>"> 
                                            </div>
                                            <div class="form-group">
                                                <label for="passport">Паспорт</label>
                                                <input type="text" name="passport_edit" id="passport_edit" class="form-control" value="<?php echo $profileInfo['Passport'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Телефон</label>
                                                <input type="text" name="phone_edit" id="phone_edit" class="form-control" value="<?php echo $profileInfo['Phone'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="city">Город</label>
                                                <div class="data_select">
                                                <?php
                                                $stmt = $con->prepare("SELECT id, title AS city FROM city");
                                                $stmt->execute();

                                                $city = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                if ($stmt->rowCount() > 0) { ?>
                                                    <select name="city_edit" id="city_edit" 
                                                        class="selectpicker show-tick" data-width="150px;" data-size="7" data-live-search="true" required>
                                                        <?php foreach ($city as $res) { ?>
                                                            <?php if ($profileInfo['city_info'] == $res['city']) { ?>
                                                                <option value="<?php echo $res['id']; ?>" selected><?php echo $res['city'] ?></option>
                                                            <?php } else { ?>
                                                                <option value="<?php echo $res['id']; ?>"><?php echo $res['city'] ?></option>
                                                            <?php } ?>    
                                                        <?php } ?>    
                                                    </select>   
                                                <?php } ?>                    
                                                </div>
                                            </div>
                                            <div class="separator"></div>
                                            <button type="submit" class="btn btn-custom" name="btnEditProfInfo" id="btnEditProfInfo">Сохранить</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button> 
                                        </form>    
                                    </div>
                                </div>

                            </div>
                        </div>     
                    </div>
                    <!-- end -->

                    <!-- nav-tab-other-info -->
                    <div id="nav-tab-other-info" class="tab-pane fade">
                            <?php
                            $getProfOtherInfo = "SELECT * FROM profile_info WHERE profile_id=:id ";
                            $stmt = $con->prepare($getProfOtherInfo);
                            $stmt -> bindParam(':id', $profID, PDO::PARAM_INT);
                            $stmt->execute();
                            $profileOtherInfo = $stmt->fetch();  
                            ?>
                            <form action="/edit_family.php"  method="post">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="family">Семья</label>
                                        <button type="submit" class="btn btn-edit right mx-2 mb-2 p-1" name="btnEditFamily" id="btnEditFamily">
                                            <i class="fad fa-pencil-alt"></i>
                                            Изменить
                                        </button>
                                        <textarea name="family" id="family" class="form-control border-0 px-4"><?php echo $profileOtherInfo['Family'] ?></textarea>
                                    </div>
                                </div>
                            </form>    
                            <div class="separator"></div>
                            <div class="form-group">
                            <?php
                            $getProfOtherInfo = "SELECT Note FROM profile WHERE id=:id ";
                            $stmt = $con->prepare($getProfOtherInfo);
                            $stmt -> bindParam(':id', $profID, PDO::PARAM_INT);
                            $stmt->execute();
                            $profileNote = $stmt->fetch();  
                            ?>
                                <form action="/edit_profile.php" method="post">
                                    <div class="form-group">
                                        <label for="family">Примечание</label>
                                        <button type="submit" class="btn btn-edit right mx-2 mb-2 p-1" name="btnEditNote" id="btnEditNote">
                                            <i class="fad fa-pencil-alt"></i>
                                            Изменить
                                        </button>
                                        <textarea name="note" id="note" class="form-control border-0 px-4"><?php echo $profileNote['Note'] ?></textarea>
                                    </div>
                                </form>
                            </div> 
                            <div class="separator"></div>
                            
                            <form action="/edit_profile.php" method="post">
                                <div class="form-row">
                                     <div class="form-group col">
                                        <label for="house_type">Тип жилья</label>
                                        <div class="data_select">
                                        <?php
                                        $stmt = $con->prepare("SELECT id, title AS house_type FROM type_of_house");
                                        $stmt->execute();

                                        $house = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if ($stmt->rowCount() > 0) { ?>
                                            <select name="housetype_edit" id="housetype_edit" 
                                                class="selectpicker show-tick form-control" data-width="150px;" data-size="7" required>
                                                <?php foreach ($house as $row) { ?>
                                                    <?php if ($profileOtherInfo['house_type'] == $row['house_type']) { ?>
                                                        <option value="<?php echo $row['id']; ?>" selected><?php echo $row['house_type'] ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['house_type'] ?></option>
                                                    <?php } ?>    
                                                <?php } ?>    
                                            </select>   
                                        <?php } ?>                    
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label for="heating">Тип отопления</label>
                                        <div class="data_select">
                                        <?php
                                        $stmt = $con->prepare("SELECT id, title AS heating FROM heating_type");
                                        $stmt->execute();

                                        $heating = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if ($stmt->rowCount() > 0) { ?>
                                            <select name="heating_edit" id="heating_edit" 
                                                class="selectpicker show-tick form-control" data-width="150px;" data-size="7" required>
                                                <?php foreach ($heating as $row) { ?>
                                                    <?php if ($profileOtherInfo['heat_type'] == $row['heating']) { ?>
                                                        <option value="<?php echo $row['id']; ?>" selected><?php echo $row['heating'] ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['heating'] ?></option>
                                                    <?php } ?>    
                                                <?php } ?>    
                                            </select>   
                                        <?php } ?>                    
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <div class="form-check col">
                                        <?php if ($profileOtherInfo['Forced_migrant'] == 1) { ?>
                                            <input class="info form-check-input" type="checkbox" id="migrant" name="migrant" value="1" checked>
                                        <?php } else { ?>
                                            <input class="info form-check-input" type="checkbox" id="migrant" name="migrant" value="1">
                                        <?php } ?>   
                                        <label class="form-check-label" for="migrant">Вынужденный переселенец</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check col">
                                        <?php if ($profileOtherInfo['Destroyed_house'] == 1) { ?>
                                            <input class="info form-check-input" type="checkbox" id="dest_house" name="dest_house" value="1" checked>
                                        <?php } else { ?>
                                            <input class="info form-check-input" type="checkbox" id="dest_house" name="dest_house" value="1">
                                        <?php } ?>   
                                        <label class="form-check-label" for="inlineCheckbox2">Разрушено жилье</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-custom" name="btnEditHouseHeating" id="btnEditHouseHeating">Изменить</button>       
                            </form>             
                            
                            <div class="separator"></div>
                            <div class="form-group">
                                <label for="categories">Категории</label>
                                <button class="btn btn-custom right mb-2 px-3" data-toggle="modal" data-target="#addCategory">
                                    <i class="fal fa-plus fa-lg"></i>
                                </button>
                                <button class="btn btn-delete right mb-2 px-3" data-toggle="modal" data-target="#deleteCategory">
                                        <i class="fal fa-minus fa-lg"></i>
                                </button>
                                <?php 
                                $getProfOtherInfo = "SELECT crosscategory.id_Category AS id, category.title AS category 
                                    FROM crosscategory left JOIN category ON crosscategory.id_Category=category.id 
                                    WHERE crosscategory.id_Profile=:id  ";
                                $stmt = $con->prepare($getProfOtherInfo);
                                $stmt -> bindParam(':id', $profID, PDO::PARAM_INT);
                                $stmt->execute();
                                $profileCategory = $stmt->fetchAll(PDO::FETCH_ASSOC);  
                                ?>
                                <textarea name="categories" id="categories" class="info form-control border-0 px-4" readonly><?php foreach ($profileCategory as $category) { ?><?php echo $category['category'] . '; ' ?> <?php } ?></textarea>
                            </div>

                            <!-- modal addCategory -->
                            <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addCategoryLabel">Добавить категорию</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/edit_profile.php" method="post">
                                                <div class="form-group">
                                                    <label for="gender">Категории</label>
                                                    <div class="data_select">
                                                    <?php
                                                    $stmt = $con->prepare("SELECT id, title AS category FROM category");
                                                    $stmt->execute();

                                                    $cats = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($profileCategory as $category) {
                                                        if (($key = array_search($category, $cats)) !== false) { 
                                                            unset($cats[$key]);
                                                            continue;
                                                        }
                                                    }        
                                                    ?>
                                                        <select name="select_category[]" id="select_category" 
                                                            class="selectpicker show-tick" data-width="150px;" data-size="7" multiple="multiple" title="Выберите">
                                                            <?php foreach ($cats as $cat) {?>
                                                                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['category'] ?></option>     
                                                            <?php } ?>   
                                                        </select>                  
                                                    </div>
                                                    <div class="separator"></div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-custom" name="btnAddCategory" id="btnAddCategory">Добавить</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button> 
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                            <!-- end -->

                            <!-- modal deleteCategory -->
                            <div class="modal fade" id="deleteCategory" tabindex="-1" aria-labelledby="deleteCategoryLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteCategoryLabel">Удалить категорию</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/edit_profile.php" method="post">
                                                <div class="form-group">
                                                    <label for="gender">Категории</label>
                                                    <div class="data_select">
                                                        <select name="profile_category[]" id="profile_category" 
                                                            class="selectpicker show-tick" data-width="150px;" data-size="7" multiple="multiple" title="Выберите">
                                                            <?php foreach ($profileCategory as $prof_cat) {?>
                                                                <option value="<?php echo $prof_cat['id']; ?>"><?php echo $prof_cat['category'] ?></option>     
                                                            <?php } ?>   
                                                        </select>                  
                                                    </div>
                                                    <div class="separator"></div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-delete" name="btnDeleteCategory" id="btnDeleteCategory">Удалить</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button> 
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <!-- end -->
                            <div class="separator"></div>
                            <div class="form-group">
                                <label for="training">Тренинги</label>
                                <button class="btn btn-edit b-block right mx-2 mb-2 px-3">
                                        <i class="fal fa-plus fa-lg"></i>
                                </button>
                                <button class="btn btn-delete b-block right mb-2 px-3">
                                        <i class="fal fa-minus fa-lg"></i>
                                </button>

                                <?php
                                $getProfTraining = "SELECT crosstraining.id_Training, training.title AS training FROM crosstraining JOIN training ON crosstraining.id_Training=training.id WHERE crosstraining.id_Profile=:id ";
                                $stmt = $con->prepare($getProfTraining);
                                $stmt -> bindParam(':id', $profID, PDO::PARAM_INT);
                                $stmt->execute();
                                $profileTraining = $stmt->fetchAll(PDO::FETCH_ASSOC);   
                                ?>
                                <textarea name="training" id="training" class="info form-control border-0 px-4"><?php foreach ($profileTraining as $training) { ?><?php echo $training['training'] . '; ' ?> <?php } ?></textarea>
                            
                                <div class="modal fade" id="" tabindex="-1" aria-labelledby="Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="Label">Основная информация</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                             
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary"></button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>          

                            </div>
                            <div class="separator"></div>
                            <div class="form-group">
                                <label for="needs">Нужды</label>
                                <button class="btn btn-edit b-block right mx-2 mb-2 px-3">
                                        <i class="fal fa-plus fa-lg"></i>
                                </button>
                                <button class="btn btn-delete b-block right mb-2 px-3">
                                        <i class="fal fa-minus fa-lg"></i>
                                </button>        

                                <?php
                                $getProfTraining = "SELECT crossneed.id_Need, need.title AS need FROM crossneed JOIN need ON crossneed.id_Need=need.id WHERE crossneed.id_Profile=:id ";
                                $stmt = $con->prepare($getProfTraining);
                                $stmt -> bindParam(':id', $profID, PDO::PARAM_INT);
                                $stmt->execute();
                                $profileNeed = $stmt->fetchAll(PDO::FETCH_ASSOC);   
                                ?>    
                                <textarea name="needs" id="needs" class="info form-control border-0 px-4"><?php foreach ($profileNeed as $need) { ?><?php echo $need['need'] . '; ' ?> <?php } ?></textarea>
                            
                                <div class="modal fade" id="" tabindex="-1" aria-labelledby="Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="Label">Основная информация</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary"></button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>          

                            </div>
                            <div class="separator"></div>
                            <div class="form-group">
                                <label for="help">Помощь</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Проект</th>
                                                <th>Дата начала</th>
                                                <th>Дата окончания</th>
                                                <th>Тип проекта</th>
                                                <th>Донор</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $getProfHelp = "SELECT help.start_date, help.end_date, project.title AS project, 
                                                helptype.title AS project_type, donor.title AS donor
                                                FROM help
                                                JOIN project ON help.id_project = project.id
                                                JOIN helptype ON help.id_helptype = helptype.id
                                                JOIN donor ON help.id_donor = donor.id
                                                WHERE help.id_profile=:id ";
                                            $stmt = $con->prepare($getProfHelp);
                                            $stmt -> bindParam(':id', $profID, PDO::PARAM_INT);
                                            $stmt->execute();
                                            $profileHelp = $stmt->fetchAll(PDO::FETCH_ASSOC);   
                                            ?>
                                            
                                            <?php foreach ($profileHelp as $help) { ?>
                                            <tr>
                                                <td><?php echo $help['project'] ?></td>
                                                <td><?php echo $help['start_date'] ?></td>
                                                <td><?php echo $help['end_date'] ?></td>
                                                <td><?php echo $help['project_type'] ?></td>
                                                <td><?php echo $help['donor'] ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <button class="btn btn-edit b-block right mx-2 mb-2">
                                        <i class="fad fa-pencil-alt"></i>
                                        Добавить помощь
                                </button>
                                <button class="btn btn-delete b-block right mb-2">
                                        <i class="fal fa-minus"></i>
                                        Удалить
                                </button>

                                <div class="modal fade" id="" tabindex="-1" aria-labelledby="Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="Label">Основная информация</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary"></button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>  

                            </div>
                        </form>
                    </div>
                    <!-- end -->

                    <!-- nav-tab-delete-profile -->
                    <div id="nav-tab-delete-profile" class="tab-pane fade">
                        <form action="" role="form">
                            <p class="alert alert-danger">Удалить данный профиль?</p>
                        </form>
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.info').prop('readonly', true);

        })
    </script>
</body>                   