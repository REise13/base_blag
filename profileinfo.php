<?php $title= 'Профиль' ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>
<?php require_once "config.php"; ?>

<body>
    <div class="row">
        <div class="col-lg-8 pt-5 mx-auto">
            <div class="bg-form rounded-lg shadow-sm p-5">
                <!-- Profile form tabs -->
                <ul role="tablist" class="nav bg-light nav-pills rounded-pill nav-fill mb-3">
                    <li class="nav-item">
                        <a data-toggle="pill" href="#nav-tab-general-info" class="nav-link active rounded-pill">
                                            <i class=""></i>
                                            Основная информация
                                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="pill" href="#nav-tab-other-info" class="nav-link rounded-pill">
                                            <i class=""></i>
                                            Дополнительно
                                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="pill" href="#nav-tab-delete-profile" class="nav-link rounded-pill">
                                            <i class=""></i>
                                            Удалить профиль
                                        </a>
                    </li>
                </ul>
                 <!-- end -->
                <div class="tab-content">
                    <!-- nav-tab-general-info -->
                    <div id="nav-tab-general-info" class="tab-pane fade show active">
                        <form role="form" class="pt-3" action="" method="POST">
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
                            <div class="form-row mt-2">
                                <div class="form-group col-md-3">
                                    <label for="gender">Пол</label>
                                    <input type="text" name="gender" id="gender" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="birth">Год рождения</label>
                                    <input type="text" name="birth" id="birth" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="inn">ИНН</label>
                                    <input type="text" name="inn" id="inn" class="form-control">
                                </div>
                                <div class="form-group col">
                                    <label for="passport">Паспорт</label>
                                    <input type="text" name="passport" id="passport" class="form-control">
                                </div>
                                <div class="form-group col">
                                    <label for="phone">Телефон</label>
                                    <input type="text" name="phone" id="phone" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-3">
                                    <label for="city">Город</label>
                                    <input type="text" name="city" id="city" class="form-control"> 
                                </div>
                            </div>
                        </form>     
                    </div>
                    <!-- end -->

                    <!-- nav-tab-other-info -->
                    <div id="nav-tab-other-info" class="tab-pane fade">
                        <form role="form" action="" method="post">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="family">Семья</label>
                                    <textarea name="family" id="family" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="separator"></div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="house_type">Тип жилья</label>
                                    <input type="text" name="house_type" id="house_type" class="form-control">
                                </div>
                                <div class="form-group col">
                                    <label for="heating_type">Тип отопления</label>
                                    <input type="text" name="heating_type" id="heating_type" class="form-control">
                                </div>
                            </div>
                            <div class="separator"></div>
                            <div class="form-group">
                                <label for="categories">Категории</label>
                                <textarea name="categories" id="categories" class="form-control"></textarea>
                            </div>
                            <div class="separator"></div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="training">Тренинги</label>
                                    <textarea name="training" id="training" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="needs">Нужды</label>
                                    <textarea name="needs" id="needs" class="form-control"></textarea>
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
</body>                   