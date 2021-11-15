<?php $title= 'Поиск' ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>
<?php require_once "config.php"; ?>


<body>
    <div class="page-content p-3" id="content">
        <div class="register-form">
        <!-- Форма регистрации профиля -->
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="register-form bg-form p-5 rounded shadow-sm">
                            <form action="\add_profile.php" method="post">
                                <div class="form-group">
                                    <label for="sname">Фамилия</label>
                                    <input type="text" name="sname" id="sname" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="name">Имя</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="patr">Отчество</label>
                                    <input type="text" name="patr" id="patr" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Пол</label>
                                    <div class="data_select">
                                    <?php
                                    $stmt = $con->prepare("SELECT id, title AS gender FROM gender");
                                    $stmt->execute();

                                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if ($stmt->rowCount() > 0) { ?>
                                        <select name="gender" id="gender" 
                                            class="selectpicker show-tick" data-width="150px;" data-size="7" required>
                                            <?php foreach ($results as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['gender'] ?></option>
                                            <?php } ?>    
                                        </select>   
                                    <?php } ?>                    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="yearBirth">Год рождения</label>
                                    <input type="text" name="yearBirth" id="yearBirth" class="form-control">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-4">
                                        <label for="inn">ИНН</label>
                                        <input type="text" name="inn" id="inn" class="form-control">
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="form-check" style="padding: 35px 10px 0 40px; position: absolute;">
                                            <input type="checkbox" name="notINN" id="notiNN" class="form-check-input" value="1">
                                            <label for="notINN" class="form-check-label">Отсутствует</label>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="form-group">
                                    <label for="phone">Телефон</label>
                                    <input type="text" name="phone" id="phone" class="form-control">
                                </div>
                                <di class="form-group">
                                    <label for="passport">Паспорт</label>
                                    <input type="text" name="passport" id="passport" class="form-control">
                                </di>
                                <div class="form-group">
                                    <label for="city">Город</label>
                                    <div class="data_select">
                                        <?php
                                        $sql = "SELECT id, title AS city FROM city";
                                        $stmt=$con->prepare($sql);
                                        $stmt->execute();
                                        
                                        $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if ($stmt->rowCount() > 0) { ?>
                                        <select name="city" id="city" class="selectpicker show-tick"
                                            title="Выберите" data-width="150px;" data-size="7" data-live-search="true" required>
                                            <?php foreach($cities as $city) { ?>
                                                <?php if ($city['id'] == 999) { ?>
                                                    <option value="<?php echo $city['id']; ?>" selected><?php echo $city['city']; ?></option>
                                                <?php } else { ?>    
                                                <option value="<?php echo $city['id']; ?>">
                                                    <?php echo $city['city']; ?>
                                                </option>
                                                <?php } ?>
                                            <?php } ?>      
                                        </select>
                                        <?php } unset($stmt); ?>
                                    </div>
                                </div>                
                                <div class="form-group">
                                    <label for="categories">Категории</label>
                                    <div class="data_select">
                                        <?php
                                        $sql = "SELECT id, title AS category FROM category";
                                        $stmt = $con->prepare($sql);
                                        $stmt->execute();
                                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        
                                        if ($stmt->rowCount() > 0) { ?>
                                        <select name="category[]" id="category" class="selectpicker show-tick form-control" 
                                            title="Выберите" data-size="7" multiple="multiple" required>
                                            <?php foreach($categories as $category) { ?>
                                                <option value="<?php echo $category['id']; ?>">
                                                    <?php echo $category['category']; ?>
                                                </option>
                                            <?php } ?>    
                                        </select>
                                        <?php } unset($stmt); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-custom mt-2" id="btnRegisterProfile" name="btnRegisterProfile">Зарегистрировать</button>
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
            $('input[type="checkbox"]').click(function(){
                if($(this).prop("checked") == true) {
                    $(':input[name="inn"]').prop('disabled', true);
                }
                else {
                    $(':input[name="inn"]').prop('disabled', false);
                }
            });    
        });
    </script>
</body>
</html>                            