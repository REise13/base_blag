<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="#">
            <img src="/logoBaseBlag.png" height="48" class="d-inline-block align-top mx-2" alt="baseddc logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fad fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a href="../searchprof.php" class="nav-link">
                    <i class="fad fa-search"></i>        
                    Поиск
                </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fad fa-user-plus"></i>
                        Регистрация профиля
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" id="leadDropdown"
                    role="button" data-toggle="dropdown" 
                    ariahaspopup="true" aria-expanded="false">
                        <i class="fad fa-user-friends"></i>
                        Лиды
                    </a>
                    <div class="dropdown-menu" aria-labelledby="leadDropdown">
                        <a href="#" class="dropdown-item">Поиск</a>
                        <a href="#" class="dropdown-item">Добавить лида</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" id="infoDropdown"
                    role="button" data-toggle="dropdown" 
                    ariahaspopup="true" aria-expanded="false">
                        <i class="fad fa-info"></i>
                        Информация
                    </a>
                    <div class="dropdown-menu" aria-labelledby="infodDropdown">
                        <a href="#" class="dropdown-item">Категории</a>
                        <a href="#" class="dropdown-item">Нужды</a>
                        <a href="#" class="dropdown-item">Тренинги</a>
                        <a href="#" class="dropdown-item">Проекты</a>
                        <a href="#" class="dropdown-item">Тип помощи</a>
                    </div>
                </li>
            </ul>
            <div class="form-inline my-2 my-lg-0">
                <a href="../logout.php" class="btn btn-logout my-2 my-sm-0">
                    Выйти
                    <i class="fad fa-sign-out-alt"></i>
                </a>
                
            </div>
        </div>
    </nav>
</header>

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
