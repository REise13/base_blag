<?php
ob_start();
require_once "../config.php";  

if (isset($_POST['btnAddHelpType'])) {
    $helptype = $_POST['addHelpType'];

    $sqlAddHelpType = "INSERT INTO helptype(title) VALUES(:helptype)";
    $stmt = $con->prepare($sqlAddHelpType);

    try {
        $con->beginTransaction();
        $stmt->bindParam(':helptype', $helptype, PDO::PARAM_STR);
        $stmt->execute();
        $con->commit();
        unset($stmt);
        echo "<script>
        $.confirm({
            title: 'Тип помощи',
            content: 'Запись успешно добавлена.',
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
    }
    catch(Exception $e) {
        $con->rollback();
        throw $e;
    }
}
?>

<div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Добавить тип помощи</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="helptype">Тип помощи</label>
                        <input type="text" name="addHelpType" id="addHelpType" class="form-control">
                    </div>
                    <div class="separator"></div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-custom" name="btnAddHelpType" id="btnAddHelpType">Добавить</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>  