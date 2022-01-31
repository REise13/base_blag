<?php
ob_start();
$title= 'Категории';
include('../includes/head.php');
include('../includes/navbar.php'); 
require_once "../config.php"; 

if (isset($_POST['btnAddNewNeed'])) {
    $newNeed = $_POST['newNeed'];
    $countNeedArray = count($_POST['newNeed']);

    $sqlAddNewNeed = "INSERT INTO need(title) VALUES(:need)";
    $stmt = $con->prepare($sqlAddNewNeed);
    try {
        $con->beginTransaction();
        if ($countNeedArray > 0) {
            for($i=0; $i < $countNeedArray; $i++) {
                if (trim($_POST['newNeed'][$i] != "")) {
                    $stmt->bindParam(':need', $newNeed[$i], PDO::PARAM_STR);
                    $stmt->execute();
                }
            }  
        }
        $con->commit(); 
        $_SESSION["flash"] = ["type" => "primary", "message" => "Нужды добавлены."];
        unset($stmt);
        header("Refresh:5");
    } catch(Exception $e) {
        $con->rollback();
        throw $e;
    }
}

if(isset($_POST['btnDeleteSelNeed'])) {
    $needID = $_POST['needID'];

    try{
        $con->beginTransaction();
        $sql = "SELECT id_Need FROM crossneed";
        $stmt=$con->prepare($sql);
        $stmt->execute();
        $crossneed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($needID as $id) {
            if (in_array($id, $crossneed)) {
                $sql = "DELETE FROM crossneed WHERE id_Need=:crossneed";
                $stmt=$con->prepare($sql);
                $stmt->bindParam(":crossneed", $id, PDO::PARAM_INT);
                $stmt->execute();
                $sql = "DELETE FROM need WHERE id=:need";
                $stmt=$con->prepare($sql);
                $stmt->bindParam(":need", $id, PDO::PARAM_INT);
                $stmt->execute();
            }
            else {
                $sql = "DELETE FROM need WHERE id=:need";
                $stmt=$con->prepare($sql);
                $stmt->bindParam(":need", $id, PDO::PARAM_INT);
                $stmt->execute(); 
            }
        }
        
        $con->commit();
        $_SESSION["flash"] = ["type" => "primary", "message" => "Нужды удалены."];
        unset($stmt);
        header("Refresh:5");
    }
    catch (Exception $e) {
        $con->rollback();
        throw $e;
    }
}
?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto p-5">
                <div class="card shadow border-0 mb-5">
                    <div class="card-body bg-form">
                        <p class="font-weight-bold h5 py-3" style="color: #1b90f0;">Нужды</p>
                        <?php if (isset($_SESSION["flash"])) { 
                                vprintf("<div class='alert alert-%s'>%s</div>", $_SESSION["flash"]);
                                unset($_SESSION["flash"]);
                        }    
                        ?> 
                        <form method="post">
                            <div class="table-scrollbar" id="style-scroll">
                                <?php
                                $getNeed = "SELECT * FROM need ORDER BY title";
                                $stmt = $con->prepare($getNeed);
                                $stmt->execute();
                                $need = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if ($stmt->rowCount() > 0) { 
                                    foreach ($need as $row) { ?>
                                        <div class="form-group px-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="<?php echo $row['id']; ?>" 
                                                name="needID[]" value="<?php echo $row['id']; ?>">
                                                <label class="cursor-pointer custom-control-label custom-color" for="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            
                            <div class="separator"></div>    
                            <div class="form-group">
                                <table class="table-responsive" id="needInfo">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" id="newNeed" name="newNeed[]" placeholder="Название нужды" class="form-control">
                                            </td>
                                            <td>
                                                <button type="button" name="addNeedField" id="addNeedField" class="btn btn-info">
                                                    <i class="far fa-plus"></i>
                                                </button>
                                            </td>        
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-custom" id="btnAddNewNeed" name="btnAddNewNeed">Добавить</button>
                                <button type="submit" class="btn btn-delete" id="btnDeleteSelNeed" name="btnDeleteSelNeed">Удалить</button>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            var i=1;
            $('#addNeedField').click(function(){
                i++;
                $('#needInfo').append('<tr id="row'+i+'"><td><input type="text" name="newNeed[]" placeholder="Название нужды" class="form-control" /></td><td><button type="button" name="removeNeedField" id="'+i+'" class="btn btn-danger btn-remove"><i class="far fa-times"></i></button></td></tr>');
            });
        
            $(document).on('click', '.btn-remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
            });
        });
    </script>
</body>
</html>    