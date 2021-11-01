<?php $title= 'Профиль' ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>
<?php require_once "config.php"; ?>

<?php 
$profID = $_GET['profile'];
$getGeneralInfo = "SELECT sName, Name, Patr, gender_info, yearbirth, INN, Passport, Phone, city_info FROM profile_search WHERE profile_id=:id";
$stmt = $con->prepare($getGeneralInfo);
$stmt -> bindParam(':id', $profID, PDO::PARAM_INT);
$stmt->execute();
$profileInfo = $stmt->fetch();

?>

<body>
    <div class="row">
        <div class="col-lg-8 pt-5 mx-auto">
            <div class="bg-form rounded-lg shadow-sm p-5">
                <!-- Profile form tabs -->
                <ul role="tablist" class="nav bg-light nav-pills rounded-pill nav-fill mb-3">
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
                    <li class="nav-item">
                        <a data-toggle="pill" href="#nav-tab-delete-profile" class="nav-link rounded-pill">
                                             <i class="fad fa-minus-circle"></i>
                                            Удалить профиль
                                        </a>
                    </li>
                </ul>
                 <!-- end -->
                <div class="tab-content">
                    <!-- nav-tab-general-info -->
                    <div id="nav-tab-general-info" class="tab-pane fade show active">
                        <form role="form" class="pt-3" action="" method="POST">
                            <p><?php echo $_GET['profile'] ?></p>
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
                            <button type="submit" class="btn btn-edit center">
                                <i class="fad fa-edit"></i>
                                Редактировать
                            </button>
                        </form>     
                    </div>
                    <!-- end -->

                    <!-- nav-tab-other-info -->
                    <div id="nav-tab-other-info" class="tab-pane fade">
                        <form role="form" class="pt-3" action="" method="post">
                            <?php
                            $getProfOtherInfo = "SELECT * FROM profile_info WHERE profile_id=:id ";
                            $stmt = $con->prepare($getProfOtherInfo);
                            $stmt -> bindParam(':id', $profID, PDO::PARAM_INT);
                            $stmt->execute();
                            $profileOtherInfo = $stmt->fetch();  
                            ?>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="family">Семья</label>
                                    <textarea name="family" id="family" class="info form-control border-0 px-4"><?php echo $profileOtherInfo['Family'] ?></textarea>
                                </div>
                            </div>
                            <div class="separator"></div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="house_type">Тип жилья</label>
                                    <input type="text" name="house_type" id="house_type" class="info form-control border-0 px-4" 
                                        value="<?php echo $profileOtherInfo['house_type'] ?>">    
                                </div>
                                <div class="form-group col">
                                    <label for="heating_type">Тип отопления</label>
                                    <input type="text" name="heating_type" id="heating_type" class="info form-control border-0 px-4"
                                       value="<?php echo $profileOtherInfo['heat_type'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <?php if ($profileOtherInfo['Forced_migrant'] == 1) { ?>
                                        <input class="info form-check-input" type="checkbox" id="inlineCheckbox1" value="<?php echo $profileOtherInfo['Forced_migrant'] ?>" checked>
                                    <?php } else { ?>
                                        <input class="info form-check-input" type="checkbox" id="inlineCheckbox1" value="<?php echo $profileOtherInfo['Forced_migrant'] ?>">
                                    <?php } ?>   
                                    <label class="form-check-label" for="inlineCheckbox1">Вынужденный переселенец</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <?php if ($profileOtherInfo['Destroyed_house'] == 1) { ?>
                                        <input class="info form-check-input" type="checkbox" id="inlineCheckbox2" value="<?php echo $profileOtherInfo['Destroyed_house'] ?>" checked>
                                    <?php } else { ?>
                                        <input class="info form-check-input" type="checkbox" id="inlineCheckbox2" value="<?php echo $profileOtherInfo['Destroyed_house'] ?>">
                                    <?php } ?>   
                                    <label class="form-check-label" for="inlineCheckbox2">Разрушено жилье</label>
                                </div>
                            </div>
                            <div class="separator"></div>
                            <div class="form-group">
                                <label for="categories">Категории</label>
                                <?php 
                                $getProfOtherInfo = "SELECT category_info FROM profile_search WHERE profile_id=:id ";
                                $stmt = $con->prepare($getProfOtherInfo);
                                $stmt -> bindParam(':id', $profID, PDO::PARAM_INT);
                                $stmt->execute();
                                $profileCategory = $stmt->fetch();  
                                ?>
                                <textarea name="categories" id="categories" class="info form-control border-0 px-4" readonly><?php echo $profileCategory['category_info'] ?></textarea>
                            </div>
                            <div class="separator"></div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="training">Тренинги</label>
                                    <textarea name="training" id="training" class="info form-control border-0 px-4" readonly></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="needs">Нужды</label>
                                    <textarea name="needs" id="needs" class="info form-control border-0 px-4" readonly></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="help">Помощь</label>
                                <table class="table table-light">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
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