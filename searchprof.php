<?php $title= 'Поиск' ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>

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
                                    <label for="sname" class="font-weight-bold">Имя</label>
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
                                require_once "config.php";
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
                                require_once "config.php";
                                $stmt = $con->prepare("SELECT id, title AS cat FROM category");
                                $stmt->execute();

                                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                           
                                if ($stmt->rowCount() > 0) { ?>
                                    <select name="categories" id="categories" 
                                        class="selectpicker show-tick" data-width="150px;" data-size="7" multiple>
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
                                require_once "config.php";
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
                                require_once "config.php";
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
                            
                            <input type="submit" class="btn btn-custom" value="Поиск">
                        </form>
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
        });
    </script>

</body>