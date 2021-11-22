<?php $title= 'Лид'; ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>
<?php require_once "config.php"; ?>

<?php
$leadID = $_GET['lead'];
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
                                            <button type="submit" class="btn btn-edit mr-3" id="btnLeadEdit" name="btnLeadEdit">Изменить</button>
                                            <button type="submit" class="btn btn-delete" id="btnLeadDelete" name="btnLeadDelete">Удалить</button>
                                        </div>
                                    </div>
                                </form>
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