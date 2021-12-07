<?php
$title= 'Регистрация лида';
include('../includes/head.php');
include('../includes/navbar.php');
require_once "../config.php";
?>
    <body>
        <div class="page-content p-3" id="content">
            <div class="register-lead-form">
            <!-- Форма регистрации лида -->
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="bg-form p-5 rounded shadow-sm">
                                <form action="./add_lead.php" method="post">
                                    <p class="font-weight-bold h5 pb-2" style="color: #4922a5c9;">
                                        Заявка на получение гуманитарной помощи нуждающегося и его семьи
                                    </p>
                                    <div class="form-group">
                                        <label for="fio">Пожалуйста, представьтесь</label>
                                        <input id="fio" class="form-control" type="text" name="fio">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Контактный телефон</label>
                                        <input id="phone" class="form-control" type="text" name="phone">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" class="form-control" type="text" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="reason">Зачем вы заполняете данную заявку?</label>
                                        <div class="data_select">
                                        <?php
                                        $stmt = $con->prepare("SELECT id, title AS reason FROM lead_reason");
                                        $stmt->execute();

                                        $reason = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if ($stmt->rowCount() > 0) { ?>
                                            <select name="reason" id="reason" 
                                                class="selectpicker show-tick form-control" title="Выберите" required> 
                                                <?php foreach ($reason as $res) { ?>
                                                    <option value="<?php echo $res['id']; ?>"><?php echo $res['reason'] ?></option> 
                                                <?php } ?>    
                                            </select>   
                                        <?php } ?>                    
                                        </div>
                                    </div>
                                    <div class="separator"></div>
                                    <p class="font-weight-bold h5 pb-2" style="color: #4922a5c9;">
                                        Непосредственная информация о нуждающемся
                                    </p>
                                    <div class="form-group">
                                        <label for="fio_need">
                                            ФИО нуждающегося (главы семьи (домохозяйства), контактного лица)
                                        </label>
                                        <input id="fio_need" class="form-control" type="text" name="fio_need">
                                    </div>
                                    <div class="form-group">
                                        <label for="city">Населённый пункт проживания в настоящий момент</label>
                                        <input id="city" class="form-control" type="text" name="city">
                                    </div>
                                    <div class="form-group">
                                        <label for="district">Район проживания</label>
                                        <input id="district" class="form-control" type="text" name="district">
                                    </div>
                                    <div class="form-group ">
                                        <label for="houseType">Место проживания нуждающегося</label>
                                        <div class="data_select">
                                        <?php
                                        $stmt = $con->prepare("SELECT id, title AS house FROM type_of_house");
                                        $stmt->execute();

                                        $house = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if ($stmt->rowCount() > 0) { ?>
                                            <select name="houseType" id="houseType" 
                                                class="selectpicker show-tick form-control" title="Выберите" required>
                                                <?php foreach ($house as $res) { ?>
                                                    <option value="<?php echo $res['id']; ?>"><?php echo $res['house'] ?></option>  
                                                <?php } ?>    
                                            </select>   
                                        <?php } ?>                    
                                        </div>
                                    </div>
                                    <div class="separator"></div>
                                    <p class="font-weight-bold h5 pb-2" style="color: #4922a5c9;">
                                        Социальные уязвимости нуждающегося и его семьи
                                    </p>
                                    <div class="form-group">
                                        <label for="bdistrict">
                                            В настоящий момент микрорайон проживания подвергается обстрелам?
                                        </label>
                                        <div class="data_select">
                                        <?php
                                        $stmt = $con->prepare("SELECT id, title AS bdistrict FROM lead_bdisctrict");
                                        $stmt->execute();

                                        $bdistrict = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if ($stmt->rowCount() > 0) { ?>
                                            <select name="bdistrict" id="bdistrict" 
                                            class="selectpicker show-tick form-control" title="Выберите" required>
                                            <?php foreach($bdistrict as $res) { ?>
                                                <option value="<?php echo $res['id']; ?>"><?php echo $res['bdistrict']; ?></option>
                                            <?php } ?>    
                                            </select>
                                        <?php } ?>    
                                        </div>
                                    </div>
                                    <div class="form-group py-2">
                                        <label for="migrant">
                                            Был ли нуждающийся вынужден менять место своего проживания 
                                            за время военного конфликта, из-за угроз и проблем, с ним связанных?
                                        </label>
                                        <div class="data_select">
                                        <?php
                                        $stmt = $con->prepare("SELECT id, title AS migrant FROM lead_migrant");
                                        $stmt->execute();

                                        $migrant = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if ($stmt->rowCount() > 0) { ?>
                                            <select name="migrant" id="migrant" 
                                            class="selectpicker show-tick form-control" title="Выберите" required>
                                            <?php foreach ($migrant as $res) { ?>
                                                <option value="<?php echo $res['id']; ?>"><?php echo $res['migrant'] ?></option>  
                                            <?php } ?>    
                                            </select>   
                                        <?php } ?>                    
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="famUnemp">
                                            Есть ли в семье (домохозяйстве) нуждающегося трудоспособные
                                            (возможно частично) лица, не имеющие работы?
                                        </label>
                                        <div class="data_select">
                                            <?php 
                                            $sql = "SELECT id, title  AS famUnemp FROM lead_fam_unemp";
                                            $stmt = $con->prepare($sql);
                                            $stmt->execute();
                                            $leadFamUnemp = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <?php if($stmt->rowCount() > 0) { ?>
                                            <select name="famUnEmp" id="famUnEmp" 
                                            class="form-control selectpicker show-tick" title="Выберите" required>
                                                <?php foreach($leadFamUnemp as $famunemp) { ?>
                                                    <option value="<?php echo $famunemp['id']; ?>">
                                                        <?php echo $famunemp['famUnemp']; ?>
                                                    </option>
                                                <?php } ?>    
                                            </select>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-row py-2">
                                        <div class="form-group col">
                                            <label for="income">
                                                В данной семье (домохозяйстве) есть источники доходов, 
                                                позволяющие им удовлетворять свои базовые 
                                                (физиологические и медицинцинские) потребности?
                                            </label>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="radio" name="income" id="income1" value="1">
                                                <label class="cursor-pointer custom-control-label custom-color" for="income1">
                                                    Да
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="radio" name="income" id="income2" value="-1">
                                                <label class="cursor-pointer custom-control-label custom-color" for="income2">
                                                    Нет
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="family">
                                            Семья (домохозяйство) нуждающихся полная 
                                            (есть муж и жена (включая сожителей)) или нет?
                                        </label>
                                        <div class="data_select">
                                            <?php 
                                            $sql = "SELECT id, title AS family FROM lead_family";
                                            $stmt = $con->prepare($sql);
                                            $stmt->execute();
                                            $leadFamily = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <?php if ($stmt->rowCount() > 0) { ?>
                                            <select name="family" id="family" 
                                            class="form-control selectpicker show-tick" title="Выберите">
                                                <?php foreach($leadFamily as $fam) { ?>
                                                    <option value="<?php echo $fam['id']; ?>">
                                                        <?php echo $fam['family']; ?>
                                                    </option>
                                                <?php } ?>    
                                            </select>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group py-2">
                                        <label for="child">В семье есть несовершеннолетние дети на иждивении?</label>
                                        <div class="data_select">
                                            <?php 
                                            $sql = "SELECT id, title AS children FROM lead_childrens";
                                            $stmt = $con->prepare($sql);
                                            $stmt->execute();
                                            $leadChildren = $stmt->fetchALL(PDO::FETCH_ASSOC);
                                            ?>
                                            <?php if($stmt->rowCount() > 0) { ?>
                                            <select name="child" id="child" 
                                            class="form-control selectpicker show-tick" title="Выберите" required>
                                                <?php foreach($leadChildren as $ch) { ?>
                                                    <option value="<?php echo $ch['id']; ?>">
                                                        <?php echo $ch['children']; ?>
                                                    </option>
                                                <?php } ?>    
                                            </select>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                       <div class="form-group col">
                                            <label for="adopted">
                                                В семье есть усыновлённые/удочерённые несовершеннолетние лица?
                                            </label>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="radio" name="adopted" id="adopted1" value="1">
                                                <label class="cursor-pointer custom-control-label custom-color" for="adopted1">
                                                    Да
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="radio" name="adopted" id="adopted2" value="-1">
                                                <label class="cursor-pointer custom-control-label custom-color" for="adopted2">
                                                    Нет
                                                </label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="radio" name="adopted" id="adopted3" value="0">
                                                <label class="cursor-pointer custom-control-label custom-color" for="adopted3">
                                                    Неизвестно
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group py-2">
                                        <label for="lead_cat">
                                            Выберите все дополнительные социальные уязвимости 
                                            нуждающегося (в том числе членов его домохозяйства)
                                        </label>
                                        <div class="data_select">
                                            <select name="categories[]" id="categories" 
                                                class="selectpicker form-control show-tick" multiple="multiple" title="Выберите" required>
                                                <option value="малоимущие">малоимущие</option>
                                                <option value="одинокие пожилые люди">одинокие пожилые люди</option>
                                                <option value="лица старше 75 лет">лица старше 75 лет</option>
                                                <option value="лица с хроническими заболеваниями">лица с хроническими заболеваниями</option>
                                                <option value="инвалиды I группы">инвалиды I группы</option>
                                                <option value="инвалиды II группы">инвалиды II группы</option>
                                                <option value="инвалиды III группы">инвалиды III группы</option>
                                                <option value="дети инвалиды или дети с хроническими заболеваниями">дети инвалиды или дети с хроническими заболеваниями</option>
                                                <option value="военные разрушения">военные разрушения</option>
                                                <option value="дополнительных социальных уязвимостей нет">дополнительных социальных уязвимостей нет</option>
                                            </select>
                                            <textarea name="addCatLead" id="addCatLead" class="mt-3 form-control col-6 input" placeholder="Другое" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="need">
                                            Опишите, какая именно гуманитарная помощь нуждающемуся была бы 
                                            на Ваш взгляд наиболее актуальной и своевременной?
                                        </label>
                                        <input id="need" class="form-control" type="text" name="need">
                                    </div>
                                    <div class="form-group py-2">
                                        <label for="volunteer">
                                            Есть ли возможность Вам заниматься волонтёрской деятельностью?
                                        </label>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="radio" name="volunteer" id="volunteer1" value="1">
                                            <label class="cursor-pointer custom-control-label custom-color" for="volunteer1">
                                                Да
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="radio" name="volunteer" id="volunteer2" value="-1">
                                            <label class="cursor-pointer custom-control-label custom-color" for="volunteer2">
                                                Нет
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subcontact">
                                            Если Вы заполняете анкету в интересах третьего лица, пожалуйста, 
                                            укажите способы прямой связи с ним
                                        </label>
                                        <input id="subcontact" class="form-control" type="text" name="subcontact">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-custom mt-3">Добавить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                            
    </body>
</html>