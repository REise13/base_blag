<?php
// инициализация сессии
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Проверяем введен ли логин
    if(empty(trim($_POST["username"]))){
        $username_err = "Пожалуйста, введите логин.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Проверяем введен ли пароль
    if(empty(trim($_POST["password"]))){
        $password_err = "Пожалуйста, введите пароль.";
    } else{
        $password = trim($_POST["password"]);

        // создаем хэш введенного пароля
        $hashedPwd = hash('sha512', $_POST['password']);
        $hex_strs = str_split($hashedPwd, 2);

        foreach($hex_strs as &$hex) {
            $hex = preg_replace('/^0/', '', $hex);
        }
        $hashedPwd = implode('', $hex_strs);
        $new_hashpass = strtoupper($hashedPwd);

    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, login, pass, role_id FROM user WHERE login = :username";
        
        if($stmt = $con->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);
            
            if($stmt->execute()){
                // Если имя пользователя есть в базе, то проверяем пароль
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["login"];
                        $hashed_password = $row["pass"];
                        $userRole = $row["role_id"];
                        if($new_hashpass == $hashed_password){
                            // Пароль верный, открываем сессию пользователя
                            session_start();
                            
                            // Сохраняем данные в переменные сессии
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            $_SESSION["user_role"] = $userRole;
                            // При успешной авторизации перенаправить 
                            // на страницу поиска профиля
                            header("location: ../searchprof.php");
                        } else{
                            // Неверный пароль, вывести сообщение об ошибке
                            $login_err = "Неверный логин или пароль.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Неверный логин или пароль";
                }
            } else{
                echo "Что-то пошло не так. Попробуйте снова.";
            }

            unset($stmt);
        }
    }
    
    // Закрываем соединение с базой данных
    unset($con);
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
    <body class="login-page">
        <!--  <p>Введите логин и пароль.</p>-->
        <form class="form-signin shadow" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<img src="/logoBaseBlag[login form].png" width="64" height="66" class="mr-auto ny-auto" alt="logo">
            <?php
            if(!empty($login_err)){
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . $login_err . 
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button></div>';
            }
            ?>
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
            <input type="text" name="username" class="form-control rounded-pill
											border-0 shadow-sm px-4 mt-4 mb-2
            <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" 
            value="<?php echo $username; ?>" placeholder="Логин">

            <span class="invalid-feedback" style="margin: 0px;"><?php echo $password_err; ?></span>
            <input type="password" name="password" class="form-control rounded-pill
											border-0 shadow-sm px-4 mb-3
            <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Пароль">
            
            <button class="btn btn-block btn-custom rounded-pill px-2" type="submit" name="login">Войти</button>
        </form>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

    </body>
</html>