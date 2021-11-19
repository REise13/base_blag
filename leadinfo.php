<?php $title= 'Лид'; ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>
<?php require_once "config.php"; ?>

    <body>
        <div class="page-content p-5" id="content">
            <div class="lead-info-form">
            <!-- форма информации о лиде -->
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="lead-info-form bg-form p-4 rounded shadow-sm">
                                <form action="" method="post">
                                    <div class="container">
                                        <dl class="row">
                                            <dt class="col-sm-3">ФИО заявителя</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">Телефон</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">ФИО нуждающегося</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">Город</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">Район</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">Тип жилья благополучателя</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">Есть ли доходы?</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">Есть ли приемные?</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">Категории</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3">Какая помощь необходима?</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3 text-right">Желает ли быть волонтером?</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3 text-right">Контакты с нуждающимся</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3 text-right">Дата анкетирования</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3 text-right">Подвергался ли район обстрелу?</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3 text-right">У благополучателя в семье есть ли несовершеннолетние?</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3 text-right">У благополучателя в семье есть ли трудоспособные?</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3 text-right">У благополучателя семья полноценная?</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3 text-right">Благополучатель переселенец?</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-3 text-right">Для кого была заполнена анкета?</dt>
                                            <dd class="col-sm-9 text-left"></dd>
                                        </dl>
                                    </div>
                                    
                                    <!-- <div class="form-group row">
                                        <label for="fio" class="col-4 col-form-label">ФИО заявителя</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="fio" id="fio" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-4 col-form-label">Телефон</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="phone" id="phone" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-4 col-form-label">Email</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="email" id="email" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fioNeed" class="col-4 col-form-label">ФИО нуждающегося</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="fioNeed" id="fioNeed" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="city" class="col-4 col-form-label">Город</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="city" id="city" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="district" class="col-4 col-form-label">Район</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="district" id="district" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="houseType" class="col-4 col-form-label">Тип жилья благополучателя?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="houseType" id="houseType" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="income" class="col-4 col-form-label">Есть ли доходы?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="income" id="income" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="adopted" class="col-4 col-form-label">Есть ли приемные?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="adopted" id="adopted" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="categories" class="col-4 col-form-label">Категории</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="categories" id="categories" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="need" class="col-sm-4 col-form-label">Какая помощь необходима?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="need" id="need" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="volunteer" class="col-sm-4 col-form-label">Желает ли быть волонтером?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="volunteer" id="volunteer" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subContact" class="col-sm-4 col-form-label">Контакты с нуждающимся</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="subContact" id="subContact" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="dateLead" class="col-sm-4 col-form-label">Дата анкетирования</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="dateLead" id="dateLead" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bdistrict" class="col-sm-4 col-form-label">Подвергался ли район обстрелу?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="bdistrict" id="bdistrict" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="children" class="col-sm-4 col-form-label">У благополучателя в семье есть ли несовершеннолетние?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="children" id="children" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="famUnemp" class="col-sm-4 col-form-label">У благополучателя в семье есть ли трудоспособные?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="famUnemp" id="famUnemp" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="family" class="col-sm-4 col-form-label">У благополучателя семья полноценная?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="family" id="family" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="migrant" class="col-sm-4 col-form-label">Благополучатель переселенец?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="migrant" id="migrant" class="info form-control border-0 px-2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="reason" class="col-sm-4 col-form-label">Для кого была заполнена анкета?</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="reason" id="reason" class="info form-control border-0 px-2">
                                        </div>
                                    </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>                                