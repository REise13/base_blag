<?php $title= 'Поиск' ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>
<?php require_once "config.php"; ?>


<body>
    <div class="page-content p-3" id="content">
        <div class="search-form">
        <!-- Форма поиска профиля -->
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="search-form bg-form p-5 rounded shadow-sm">
                            <form role="form" action="/searchprofileresult.php" method="GET">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="sname" class="">Фамилия</label>
                                        <input type="text" class="form-control
											border-0 px-4" id="sname" name="sname">
                                    </div>
                                    <div class="col">
                                        <label for="name" class="">Имя</label>
                                        <input type="text" class="form-control
											border-0 px-4" id="name" name="name">
                                    </div>
                                    <div class="col">
                                        <label for="patr" class="">Отчество</label>
                                        <input type="text" class="form-control
											border-0 px-4" id="patr" name="patr">
                                    </div>
                                </div>                                
                                <div class="form-group mt-3">
                                    <label for="age">Возраст</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="age1">От</label>
                                                <input type="text" name="age1" id="age1" class="form-control border-0 px-4">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="age2">До</label>
                                                <input type="text" class="form-control border-0  px-4" name="age2" id="age2">
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label for="cities" class="">Город</label>
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
                                    <label for="categories" class="">Категории</label>
                                    <div class="data_select">
                                    <?php
                                    $stmt = $con->prepare("SELECT id, title AS cat FROM category");
                                    $stmt->execute();

                                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            
                                    if ($stmt->rowCount() > 0) { ?>
                                        <select name="categories[]" id="categories" 
                                            class="selectpicker show-tick" data-width="150px;" data-size="7" multiple="multiple">
                                            <option value="0" selected>Все</option>
                                            <?php foreach ($results as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['cat'] ?></option>
                                            <?php } ?>    
                                        </select>   
                                    <?php } ?>                    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="donor" class="">Донор</label>
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
                                    <label for="project" class="">Проект</label>
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
                                
                                <button type="submit" class="btn btn-custom px-4"  name="searchProfile">Поиск</button>
                            </form>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>    
    <!-- block content end -->

</body>