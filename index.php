<?php

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}

// Change this to your connection info.
$DATABASE_HOST = '127.0.0.1';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'YpUVMwmR8)';
$DATABASE_NAME = 'baseddc';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$username = $password = "";
$login_error = "";



if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // создаем хэш введенного пароля
    $hashedPwd = hash('sha512', $_POST['password']);
    $hex_strs = str_split($hashedPwd, 2);

    foreach($hex_strs as &$hex) {
        $hex = preg_replace('/^0/', '', $hex);
    }
    $hashedPwd = implode('', $hex_strs);
    $new_hashpass = strtoupper($hashedPwd);


    $sql = "SELECT id, login, pass FROM user WHERE login = ?";

    if($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt,"s", $param_username);

        // добавляем параметры
        $param_username = $username;

        // если запрос выполняется
        if(mysqli_stmt_execute($stmt)) {
            // сохранить полученный результат запроса
            mysqli_stmt_store_result($stmt);

            // если такой логин есть в базе, то проверяем пароль
            if(mysqli_stmt_num_rows($stmt) == 1) {
                // добавить полученные параметры к переменным
                mysqli_stmt_bind_result($stmt, $id, $login, $hash_pass);
                if(mysqli_stmt_fetch($stmt)) {
                    if ($new_hashpass === $hash_pass) {
                        // если пароль верный, то создаем сессию
                        session_start();

                        // сохраняем данные в переменные сессии
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $login;

                        // редирект на главную страницу
                        header("location: home.php");
                    } else {
                        $login_error = "Неверный логин и/или пароль.";
                    }
                } else {
                    echo 'Что-то пошло не так. Попробуйте снова.';
                }

                mysqli_stmt_close($stmt);
            }
        }

    }
    mysqli_stmt_close($stmt);
}

?>


<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="style.css">

        <title>База благополучателей</title>
    </head>
    <body>
        <!--  <p>Введите логин и пароль.</p>-->
        <?php
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>
        <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1 class="h3 mb-3 text-center"></h1>
            <label for="login" class="sr-only">Логин</label>
            <input type="text" id="username" class="mb-3 rounded-pill form-control" name="username" placeholder="Логин" required autofocus>
            <label for="password" class="sr-only">Пароль</label>
            <input type="password" id="password" class="mb-3 rounded-pill form-control" name="password" placeholder="Пароль" required>
            <button class="btn btn-custom rounded-pill btn-block p-2" type="submit" name="login">Войти</button>
        </form>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

    </body>
</html>