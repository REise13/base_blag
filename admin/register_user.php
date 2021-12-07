<?php
require_once "../config.php";

if (isset($_POST['btnRegisterUser'])) {
    $sname = trim($_POST['sname']);
    $fname = trim($_POST['fname']);
    $patr = trim($_POST['patr']);
    $login = trim($_POST['login']);
    $password = trim($_POST['userPassword']);
    $role = trim($_POST['userRole']);
    // create hash password
    $hashedPwd = hash('sha512', $password);
    $hex_strs = str_split($hashedPwd, 2);
    foreach($hex_strs as &$hex) {
        $hex = preg_replace('/^0/', '', $hex);
    }
    $hashedPwd = implode('', $hex_strs);
    $new_hashpass = strtoupper($hashedPwd);

    try {
        $con->beginTransaction();
        $stmt = $con->prepare("INSERT INTO user(login, pass, sName, fName, Patr, role_id) VALUES(:login, :pass, :sname, :fname, :patr, :role_id)");
        $stmt->execute(array(':login'=>$login, ':pass'=>$new_hashpass, 
            ':sname'=>$sname, ':fname'=>$fname, ':patr'=>$patr, ':role_id'=> $role));
        $con->commit();
        unset($stmt);
        header("Refresh: 5");
        echo "<script>
        $.confirm({
            title: 'Регистрация',
            content: 'Сотрудник зарегистрирован.',
            type: 'green',
            typeAnimated: true,
            buttons: {
                OK: {
                    text: 'OK',
                    btnClass: 'btn-green',
                    action: function(){
                    }
                }
            }
        });
        </script>";         
    } catch (Exception $e){
        $con->rollback();
        throw $e;
    }
}
?>

<div id="registerUser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="registerUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerUserLabel">Зарегистрировать пользователя</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="sname">Фамилия</label>
                        <input type="text" name="sname" id="sname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" name="fname" id="fname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="patr">Отчество</label>
                        <input type="text" name="patr" id="patr" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="login">Логин</label>
                        <input type="text" name="login" id="login" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Пароль</label>
                        <input type="password" name="userPassword" id="userPassword" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="userRole">Роль</label>
                        <div class="data_select">
                        <?php
                        $stmt = $con->prepare("SELECT * FROM user_role");
                        $stmt->execute();

                        $userRole = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if ($stmt->rowCount() > 0) { ?>
                            <select name="userRole" id="userRole" 
                                class="selectpicker show-tick" data-width="150px;" data-size="7" title="Выберите" required>
                                <?php foreach ($userRole as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['title'] ?></option>
                                <?php } ?>    
                            </select>   
                        <?php } ?>                    
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom mt-2" id="btnRegisterUser" name="btnRegisterUser">Зарегистрировать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>