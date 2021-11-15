<?php $title= 'Поиск лида'; ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>
<?php require_once "config.php"; ?>

    <body>
        <div class="page-content p-5" id="content">
            <div class="search-lead-form">
            <!-- Форма поиска лида -->
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="search-lead-form bg-form p-4 rounded shadow-sm">
                                <form action="" method="get">
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="sname" class="">Фамилия</label>
                                            <input type="text" class="form-control
                                                border-0 px-2" name="sname" id="sname">
                                        </div>
                                        <div class="form-group col">
                                            <label for="name" class="">Имя</label>
                                            <input type="text" class="form-control
                                                border-0 px-2" name="name" id="name">
                                        </div>
                                        <div class="form-group col">
                                            <label for="patr" class="">Отчество</label>
                                            <input type="text" class="form-control
                                                border-0 px-2" name="patr" id="patr">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="phone">Телефон</label>
                                            <input type="text" name="phone" id="phone" 
                                            class="form-control border-0 px-2">
                                        </div>
                                        <div class="form-group col">
                                            <label for="city">Город</label>
                                            <input type="text" name="city" id="city" 
                                            class="form-control border-0 px-2">
                                        </div>
                                    </div>    
                                    <div class="form-group mt-3">
                                        <label for="lead_cat">Категории</label>
                                        <div class="data_select">
                                            <select name="lead_category" id="lead_category" 
                                                class="selectpicker form-control show-tick" multiple="multiple" title="Выберите">
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
                                        </div>
                                    </div>
                                    <div class="separator"></div>
                                    <div class="form-group">
                                        <label for="needHelp">Какая помощь нужна?</label>
                                        <input type="text" name="needHelp" id="needHelp" 
                                        class="form-control border-0 px-2">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="houseType">Тип жилья</label>
                                            <div class="data_select">
                                                <select name="houseType" id="houseType" 
                                                class="form-control selectpicker show-tick" title="Выберите">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col">
                                            <label for="family">Семья полная?</label>
                                            <div class="data_select">
                                                <select name="family" id="family" 
                                                class="form-control selectpicker show-tick" title="Выберите">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="child">Есть несовершеннолетние?</label>
                                        <div class="data_select">
                                            <select name="child" id="child" 
                                            class="form-control selectpicker show-tick" title="Выберите">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                       <div class="form-group col">
                                            <label for="adopted">Есть ли усыновленные дети?</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="adopted" id="adopted" value="1">
                                                <label class="form-check-label custom" for="adopted">
                                                    Да
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="adopted" id="adopted" value="2">
                                                <label class="form-check-label" for="adopted">
                                                    Нет
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator"></div>
                                    <div class="form-group">
                                        <label for="volunter">Волонтер?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="volunteer" id="volunteer" value="1">
                                            <label class="form-check-label" for="volunter">
                                                Да
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="volunteer" id="volunteer" value="2">
                                            <label class="form-check-label" for="volunteer">
                                                Нет
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="adopted">Есть ли доходы?</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="income" id="income" value="1">
                                                <label class="form-check-label" for="income">
                                                    Да
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="income" id="income" value="-1">
                                                <label class="form-check-label" for="income">
                                                    Нет
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="famUnemp" class="pb-1">Есть ли трудоспособные?</label>
                                        <select name="famUnemp" id="famUnemp" class="form-control selectpicker show-tick" title="Выберите">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-5">
                                            <label for="bdistrict">Подвергается район обстрелу?</label>
                                            <div class="data_select">
                                                <select name="bdistrict" id="bdistrict" class="form-control selectpicker show-tick" title="Выберите">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-7">
                                            <label for="migrant">Переселенец?</label>
                                            <div class="data_select">
                                                <select name="migrant" id="migrant" class="form-control selectpicker show-tick" title="Выберите">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator"></div>
                                    <div class="form-group">
                                        <label for="regDate">Выбор даты</label>
                                        <input type="date" name="regDate" id="regDate" class="form-control border-0">
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
