<?php $title= 'Лид'; ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>
<?php require_once "config.php"; ?>

<?php
$leadID = $_GET['lead'];
$_SESSION['lead'] = $leadID;
$selectLeadQuery = "SELECT `lead`.id, `lead`.fio, `lead`.phone, `lead`.email, `lead`.id_reason, 
lead_reason.title AS reason, `lead`.fio_need, `lead`.city, `lead`.district, 
`lead`.id_type_of_house, type_of_house.title AS houseType, 
`lead`.id_bdistrict, lead_bdisctrict.title AS bdistrict,
`lead`.id_migrant, lead_migrant.title AS migrant,
`lead`.id_fam_unemp, lead_fam_unemp.title AS famUnEmp,
`lead`.income AS income_id,
case
	WHEN `lead`.income = 1
	then 'Да'
	ELSE 'Нет'
END AS income,	
 `lead`.id_family, lead_family.title AS family,
`lead`.id_child, lead_childrens.title AS children,
`lead`.adopted AS adopted_id,
CASE 
	WHEN `lead`.adopted = 1
		THEN 'Да'
	WHEN `lead`.adopted = -1
		THEN 'Нет'
	ELSE 'Неизвестно'
END AS adopted,			
 `lead`.categories, `lead`.need, `lead`.volunteer AS volunteer_id,
 CASE
 	WHEN 	`lead`.volunteer = 1
 		THEN 'Да'
 	ELSE 'Нет'
END AS volunteer,	 	
`lead`.subcontact, `lead`.datelead, `lead`.firstName,
`lead`.lastName, `lead`.patrName   
FROM `lead`
JOIN type_of_house ON `lead`.id_type_of_house = type_of_house.id
JOIN lead_reason ON `lead`.id_reason = lead_reason.id
JOIN lead_bdisctrict ON `lead`.id_bdistrict = lead_bdisctrict.id
JOIN lead_childrens ON `lead`.id_child = lead_childrens.id
JOIN lead_family ON `lead`.id_family = lead_family.id
JOIN lead_fam_unemp ON `lead`.id_fam_unemp = lead_fam_unemp.id
JOIN lead_migrant ON `lead`.id_migrant = lead_migrant.id
WHERE `lead`.id=:id";
$stmt = $con->prepare($selectLeadQuery);
$stmt->bindParam(':id', $leadID, PDO::PARAM_INT);
$stmt->execute();
$leadInfo = $stmt->fetch();  

 ?>


    <body>
        <div class="page-content p-5" id="content">
            <div class="lead-info-form">
            <!-- форма информации о лиде -->
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="lead-info-form bg-form p-5 rounded shadow-sm">
                            <?php if (isset($_SESSION["flash"])) { 
                                vprintf("<div class='alert alert-%s'>%s</div>", $_SESSION["flash"]);
                                unset($_SESSION["flash"]);
                            }    
                            ?> 
                                <form action="\edit_lead.php" method="post">
                                    <div class="form-group row">
                                        <label for="fio" class="col-4 col-form-label">ФИО заявителя</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="fio" id="fio" class="info form-control border-0 px-2" value="<?php echo $leadInfo['fio']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-4 col-form-label">Телефон</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="phone" id="phone" class="info form-control border-0 px-2" value="<?php echo $leadInfo['phone']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-4 col-form-label">Email</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="email" id="email" class="info form-control border-0 px-2" value="<?php echo $leadInfo['email']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fioNeed" class="col-4 col-form-label">ФИО нуждающегося</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="fioNeed" id="fioNeed" class="info form-control border-0 px-2" value="<?php echo $leadInfo['fio_need']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="city" class="col-4 col-form-label">Город</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="city" id="city" class="info form-control border-0 px-2" value="<?php echo $leadInfo['city']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="district" class="col-4 col-form-label">Район</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="district" id="district" class="info form-control border-0 px-2" value="<?php echo $leadInfo['district']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="houseType" class="col-4 col-form-label">Тип жилья благополучателя?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="houseType" id="houseType" class="info form-control border-0 px-2" value="<?php echo $leadInfo['houseType']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="income" class="col-4 col-form-label">Есть ли доходы?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="income" id="income" class="info form-control border-0 px-2" value="<?php echo $leadInfo['income']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="adopted" class="col-4 col-form-label">Есть ли приемные?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="adopted" id="adopted" class="info form-control border-0 px-2" value="<?php echo $leadInfo['adopted']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="categories" class="col-4 col-form-label">Категории</label>
                                        <div class="col-sm-8">
                                            <textarea name="categories" id="categories" class="info form-control border-0 px-2" rows="3"><?php echo $leadInfo['categories']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="need" class="col-sm-4 col-form-label">Какая помощь необходима?</label>
                                        <div class="col-sm-8">
                                            <textarea name="need" id="need" class="info form-control border-0 px-2" rows="3"><?php echo $leadInfo['need']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="volunteer" class="col-sm-4 col-form-label">Желает ли быть волонтером?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="volunteer" id="volunteer" class="info form-control border-0 px-2" value="<?php echo $leadInfo['volunteer']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subContact" class="col-sm-4 col-form-label">Контакты с нуждающимся</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="subContact" id="subContact" class="info form-control border-0 px-2" value="<?php echo $leadInfo['subcontact']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="dateLead" class="col-sm-4 col-form-label">Дата анкетирования</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="dateLead" id="dateLead" class="info form-control border-0 px-2" value="<?php echo $leadInfo['datelead']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bdistrict" class="col-sm-4 col-form-label">Подвергался ли район обстрелу?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="bdistrict" id="bdistrict" class="info form-control border-0 px-2" value="<?php echo $leadInfo['bdistrict']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="children" class="col-sm-4 col-form-label">У благополучателя в семье есть ли несовершеннолетние?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="children" id="children" class="info form-control border-0 px-2" value="<?php echo $leadInfo['children']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="famUnemp" class="col-sm-4 col-form-label">У благополучателя в семье есть ли трудоспособные?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="famUnemp" id="famUnemp" class="info form-control border-0 px-2" value="<?php echo $leadInfo['famUnEmp']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="family" class="col-sm-4 col-form-label">У благополучателя семья полноценная?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="family" id="family" class="info form-control border-0 px-2" value="<?php echo $leadInfo['family']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="migrant" class="col-sm-4 col-form-label">Благополучатель переселенец?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="migrant" id="migrant" class="info form-control border-0 px-2" value="<?php echo $leadInfo['migrant']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="reason" class="col-sm-4 col-form-label">Для кого была заполнена анкета?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="reason" id="reason" class="info form-control border-0 px-2" value="<?php echo $leadInfo['reason']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-10 text-center">
                                        <div class="btn-group pt-4" role="group">
                                            <button type="submit" class="btn btn-edit mr-3" id="btnLeadRegister" name="btnLeadRegister">Зарегистрировать</button>
                                            <button type="button" class="btn btn-edit mr-3" data-toggle="modal" data-target="#editLeadInfo">Изменить</button>
                                            <button type="submit" class="btn btn-delete" id="btnLeadDelete" name="btnLeadDelete">Удалить</button>
                                        </div>
                                    </div>                         
                                </form>

                                <div class="modal fade" id="editLeadInfo" tabindex="-1" aria-labelledby="editLeadInfoLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-dialog-fullscreen">
                                        <div class="modal-content modal-content-fullscreen">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editLeadInfoLabel">Изменить информацию о лиде</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">    
                                                <form role="form" action="\edit_lead.php" method="post">
                                                    <div class="form-group row">
                                                        <label for="fio" class="col-3 col-form-label">ФИО заявителя</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="fio_edit" id="fio_edit" class="form-control" 
                                                            value="<?php echo $leadInfo['fio']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="phone" class="col-3 col-form-label">Телефон</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="phone_edit" id="phone_edit" class="form-control" 
                                                            value="<?php echo $leadInfo['phone']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="email" class="col-3 col-form-label">Email</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="email_edit" id="email_edit" class="form-control" 
                                                            value="<?php echo $leadInfo['email']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="lastName_edit" class="col-3 col-form-label">Фамилия нуждающегося</label>
                                                        <div class="col-sm-9">
                                                            <input id="lastName_edit" class="form-control" type="text" name="lastName_edit" 
                                                            value="<?php echo $leadInfo['lastName']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="firstName_edit" class="col-3 col-form-label">Имя нуждающегося</label>
                                                        <div class="col-sm-9">
                                                            <input id="firstName_edit" class="form-control" type="text" name="firstName_edit" 
                                                            value="<?php echo $leadInfo['firstName']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="patrName_edit" class="col-3 col-form-label">Отчество нуждающегося</label>
                                                        <div class="col-sm-9">
                                                            <input id="patrName_edit" class="form-control" type="text" name="patrName_edit" 
                                                            value="<?php echo $leadInfo['patrName']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="city_edit" class="col-3 col-form-label">Город</label>
                                                        <div class="col-sm-9">
                                                            <input id="city_edit" class="form-control" type="text" name="city_edit" 
                                                            value="<?php echo $leadInfo['city']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="district_edit" class="col-3 col-form-label">Район</label>
                                                        <div class="col-sm-9">
                                                            <input id="district_edit" class="form-control" type="text" name="district_edit" 
                                                            value="<?php echo $leadInfo['district']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="income_edit" class="col-3 col-form-label">Есть ли доходы?</label>
                                                        <div class="data_select col-sm-9">
                                                            <select name="income_edit" id="income_edit" 
                                                                class="selectpicker show-tick form-control">
                                                                    <option value="1" <?php if($leadInfo['income'] == 'Да') echo 'selected' ?>>Да</option>
                                                                    <option value="-1" <?php if($leadInfo['income'] == 'Нет') echo 'selected' ?>>Нет</option>
                                                            </select>                      
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="migrant_edit" class="col-3 col-form-label">Благополучатель переселенец?</label>
                                                        <div class="data_select col-sm-9">
                                                        <?php
                                                        $stmt = $con->prepare("SELECT id, title AS migrant FROM lead_migrant");
                                                        $stmt->execute();

                                                        $migrant = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        if ($stmt->rowCount() > 0) { ?>
                                                            <select name="migrant_edit" id="migrant_edit" 
                                                                class="selectpicker show-tick form-control">
                                                                <?php foreach ($migrant as $res) { ?>
                                                                    <?php if ($leadInfo['id_migrant'] == $res['id']) { ?>
                                                                        <option value="<?php echo $res['id']; ?>" selected><?php echo $res['migrant'] ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $res['id']; ?>"><?php echo $res['migrant'] ?></option>
                                                                    <?php } ?>    
                                                                <?php } ?>    
                                                            </select>   
                                                        <?php } ?>                    
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="houseType_edit" class="col-3 col-form-label">Тип жилья благополучателя</label>
                                                        <div class="data_select col-sm-9">
                                                        <?php
                                                        $stmt = $con->prepare("SELECT id, title AS house FROM type_of_house");
                                                        $stmt->execute();

                                                        $house = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        if ($stmt->rowCount() > 0) { ?>
                                                            <select name="houseType_edit" id="houseType_edit" 
                                                                class="selectpicker show-tick form-control">
                                                                <?php foreach ($house as $res) { ?>
                                                                    <?php if ($leadInfo['id_type_of_house'] == $res['id']) { ?>
                                                                        <option value="<?php echo $res['id']; ?>" selected><?php echo $res['house'] ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $res['id']; ?>"><?php echo $res['house'] ?></option>
                                                                    <?php } ?>    
                                                                <?php } ?>    
                                                            </select>   
                                                        <?php } ?>                    
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="adopted_edit" class="col-3 col-form-label">Есть ли приемные?</label>
                                                        <div class="data_select col-sm-9">
                                                            <select name="adopted_edit" id="adopted_edit" 
                                                            class="selectpicker show-tick form-control">
                                                                <option value="1" <?php if($leadInfo['adopted'] == 'Да') echo 'selected' ?>>Да</option>
                                                                <option value="-1" <?php if($leadInfo['adopted'] == 'Нет') echo 'selected' ?>>Нет</option>
                                                                <option value="0" <?php if($leadInfo['adopted'] == 'Неизвестно') echo 'selected' ?>>Неизвестно</option>
                                                            </select>                      
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="categories" class="col-3 col-form-label">Категории</label>
                                                        <div class="col-sm-9">
                                                            <textarea name="categories_edit" id="categories_edit" class="form-control" rows="3"><?php echo $leadInfo['categories']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="need" class="col-sm-3 col-form-label">Какая помощь необходима?</label>
                                                        <div class="col-sm-9">
                                                            <textarea name="need_edit" id="need_edit" class="form-control" rows="3"><?php echo $leadInfo['need']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="volunteer_edit" class="col-3 col-form-label">Желаете ли быть волонтёром?</label>
                                                        <div class="data_select col-sm-9">
                                                            <select name="volunteer_edit" id="volunteer_edit" 
                                                            class="selectpicker show-tick form-control">
                                                                <option value="1" <?php if($leadInfo['volunteer'] == 'Да') echo 'selected' ?>>Да</option>
                                                                <option value="-1" <?php if($leadInfo['volunteer'] == 'Нет') echo 'selected' ?>>Нет</option> 
                                                            </select>                      
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="subcontact_edit" class="col-3 col-form-label">Контакты с нуждающимся</label>
                                                        <div class="col-sm-9">
                                                            <input id="subcontact_edit" class="form-control" type="text" name="subcontact_edit" 
                                                            value="<?php echo $leadInfo['subcontact']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="datelead_edit" class="col-3 col-form-label">Дата анкетирования</label>
                                                        <div class="col-sm-9">
                                                            <input id="datelead_edit" class="datepicker form-control" type="text" name="datelead_edit" 
                                                            value="<?php echo $leadInfo['datelead']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="children_edit" class="col-3 col-form-label">У благополучателя в семье есть несовершеннолетние?</label>
                                                        <div class="data_select col-sm-9">
                                                        <?php
                                                        $stmt = $con->prepare("SELECT id, title AS child FROM lead_childrens");
                                                        $stmt->execute();

                                                        $child = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        if ($stmt->rowCount() > 0) { ?>
                                                            <select name="children_edit" id="children_edit" 
                                                                class="selectpicker show-tick form-control">
                                                                <?php foreach ($child as $res) { ?>
                                                                    <?php if ($leadInfo['id_child'] == $res['id']) { ?>
                                                                        <option value="<?php echo $res['id']; ?>" selected><?php echo $res['child'] ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $res['id']; ?>"><?php echo $res['child'] ?></option>
                                                                    <?php } ?>    
                                                                <?php } ?>    
                                                            </select>   
                                                        <?php } ?>                    
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="famUnEmp_edit" class="col-3 col-form-label">У благополучателя в семье есть трудоспособные?</label>
                                                        <div class="data_select col-sm-9">
                                                        <?php
                                                        $stmt = $con->prepare("SELECT id, title AS emp FROM lead_fam_unemp");
                                                        $stmt->execute();

                                                        $famUnemp = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        if ($stmt->rowCount() > 0) { ?>
                                                            <select name="famUnEmp_edit" id="famUnEmp_edit" 
                                                                class="selectpicker show-tick form-control">
                                                                <?php foreach ($famUnemp as $res) { ?>
                                                                    <?php if ($leadInfo['id_fam_unemp'] == $res['id']) { ?>
                                                                        <option value="<?php echo $res['id']; ?>" selected><?php echo $res['emp'] ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $res['id']; ?>"><?php echo $res['emp'] ?></option>
                                                                    <?php } ?>    
                                                                <?php } ?>    
                                                            </select>   
                                                        <?php } ?>                    
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="family_edit" class="col-3 col-form-label">У благополучателя семья полноценная?</label>
                                                        <div class="data_select col-sm-9">
                                                        <?php
                                                        $stmt = $con->prepare("SELECT id, title AS family FROM lead_family");
                                                        $stmt->execute();

                                                        $child = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        if ($stmt->rowCount() > 0) { ?>
                                                            <select name="family_edit" id="family_edit" 
                                                                class="selectpicker show-tick form-control">
                                                                <?php foreach ($child as $res) { ?>
                                                                    <?php if ($leadInfo['id_family'] == $res['id']) { ?>
                                                                        <option value="<?php echo $res['id']; ?>" selected><?php echo $res['family'] ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $res['id']; ?>"><?php echo $res['family'] ?></option>
                                                                    <?php } ?>    
                                                                <?php } ?>    
                                                            </select>   
                                                        <?php } ?>                    
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="reason_edit" class="col-3 col-form-label">Для кого была заполнена анкета?</label>
                                                        <div class="data_select col-sm-9">
                                                        <?php
                                                        $stmt = $con->prepare("SELECT id, title AS reason FROM lead_reason");
                                                        $stmt->execute();

                                                        $child = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        if ($stmt->rowCount() > 0) { ?>
                                                            <select name="reason_edit" id="reason_edit" 
                                                                class="selectpicker show-tick form-control">
                                                                <?php foreach ($child as $res) { ?>
                                                                    <?php if ($leadInfo['id_reason'] == $res['id']) { ?>
                                                                        <option value="<?php echo $res['id']; ?>" selected><?php echo $res['reason'] ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $res['id']; ?>"><?php echo $res['reason'] ?></option>
                                                                    <?php } ?>    
                                                                <?php } ?>    
                                                            </select>   
                                                        <?php } ?>                    
                                                        </div>
                                                    </div>
                                                    <div class="separator"></div>
                                                    <button type="submit" class="btn btn-custom" name="btnEditLeadInfo" id="btnEditLeadInfo">Сохранить</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button> 
                                                </form>    
                                            </div>
                                        </div>
                                    </div>
                                </div>               
                            </div>
                        </div>
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
</html>                                