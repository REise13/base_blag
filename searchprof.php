<?php $title= 'Поиск' ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>

<?php 
require_once "config.php";

$sql = "SELECT id, title FROM category";

$stmt = $con->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(); 

?>
<body>
    <div class="page-content p-5" id="content">
        <h2 class="display-4 text-white"></h2>
        <div class="separator"></div>
        <div class="search-form">
        <!-- Форма поиска профиля -->
            <div class="row">
                <div class="container w-100">
                    <div class="search-form bg-form p-5 rounded shadow-sm">
                        <form role="form" action="" method="POST">
                            <div class="form-row">
                                <div class="col">
                                    <label for="sname" class="font-weight-bold">Фамилия</label>
                                    <input type="text" class="form-control" id="sname" name="sname">
                                </div>
                                <div class="col">
                                    <label for="sname" class="font-weight-bold">Имя</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="col">
                                    <label for="patr" class="font-weight-bold">Отчество</label>
                                    <input type="text" class="form-control" id="patr" name="patr">
                                </div>
                            </div>
                            
                            <div class="form-group mt-3">
                                <label for="age" class="font-weight-bold">Возраст</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="age1">От</label>
                                            <input type="text" name="age1" id="age1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="age2">До</label>
                                            <input type="text" class="form-control" name="age2" id="age2">
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label for="cities" class="text-uppercase font-weight-bold">Категории</label>
                                <div class="data_select">
                                    <select name="cities" id="cities" placeholder="" class="selectpicker" multiple>
                                        <option>Выберите</option>
                                        <option value="0" selected>Все</option>
                                        <?php foreach($data as $row): ?>
                                            <option value="<?= $row['id']; ?>"> <?= $cat['title']; ?> </option>
                                        <?php endforeach; ?>    
                                    </select><hr>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="diagnos" class="text-uppercase font-weight-bold">Донор</label>
                                <div class="data_select">
                                    <select name="diagnos" id="diagnos" class="form-control">
                                        <option>Выберите</option>
                                        <option value="0">Все</option>
                                        
                                    </select> <hr>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cities" class="text-uppercase font-weight-bold">Проект</label>
                                <div class="data_select">
                                    <select name="cities" id="cities" placeholder="" class="form-control">
                                        <option>Выберите</option>
                                        <option value="0">Все</option>
                                    </select><hr>
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


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

</body>