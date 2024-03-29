<?php
ob_start();
$title= 'Категории';
include('../includes/head.php');
include('../includes/navbar.php'); 
require_once "../config.php"; 

if (isset($_POST['btnAddNewTraining'])) {
    $newTraining = $_POST['newTraining'];
    $countTrainingArray = count($_POST['newTraining']);

    $sqlAddNewTraining = "INSERT INTO training(title) VALUES(:training)";
    $stmt = $con->prepare($sqlAddNewTraining);
    try {
        $con->beginTransaction();
        if ($countTrainingArray > 0) {
            for($i=0; $i < $countTrainingArray; $i++) {
                if (trim($_POST['newTraining'][$i] != "")) {
                    $stmt->bindParam(':training', $newTraining[$i], PDO::PARAM_STR);
                    $stmt->execute();
                }
            }  
        }
        $con->commit(); 
        unset($stmt);
        $_SESSION["flash"] = ["type" => "primary", "message" => "Тренинг добавлен."];
        header("Refresh:0");
    } catch(Exception $e) {
        $con->rollback();
        throw $e;
    }
}

if(isset($_POST['btnDeleteSelTraining'])) {
    $trainingID = $_POST['trainingID'];
    try{
        $con->beginTransaction();
        $sql = "SELECT id_Training FROM crosstraining";
        $stmt=$con->prepare($sql);
        $stmt->execute();
        $crosstraining = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($trainingID as $id) {
            if ($id == $need) {
                $sql = "DELETE FROM crosstraining WHERE id_Training=:crosstraining";
                $stmt=$con->prepare($sql);
                $stmt->bindParam(":crosstraining", $id, PDO::PARAM_INT);
                $stmt->execute();
                $sql = "DELETE FROM training WHERE id=:training";
                $stmt=$con->prepare($sql);
                $stmt->bindParam(":training", $id, PDO::PARAM_INT);
                $stmt->execute();
            }
            else {
                $sql = "DELETE FROM training WHERE id=:training";
                $stmt=$con->prepare($sql);
                $stmt->bindParam(":training", $id, PDO::PARAM_INT);
                $stmt->execute(); 
            }
            
        }
        
        $con->commit();
        $_SESSION["flash"] = ["type" => "primary", "message" => "Тренинг удалён."];
        unset($stmt);
        header("Refresh:0");
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
                        <p class="font-weight-bold h5 py-3" style="color: #1b90f0;">Тренинги</p>
                        <?php if (isset($_SESSION["flash"])) { 
                                vprintf("<div class='alert alert-%s'>%s</div>", $_SESSION["flash"]);
                                unset($_SESSION["flash"]);
                        }    
                        ?> 
                        <form method="post">
                            <div class="table-scrollbar" id="style-scroll">
                                <?php
                                $getTraining = "SELECT * FROM training ORDER BY title";
                                $stmt = $con->prepare($getTraining);
                                $stmt->execute();
                                $training = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if ($stmt->rowCount() > 0) { 
                                    foreach ($training as $row) { ?>
                                        <div class="form-group px-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="<?php echo $row['id']; ?>" 
                                                name="trainingID[]" value="<?php echo $row['id']; ?>">
                                                <label class="cursor-pointer custom-control-label custom-color" for="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            
                            <div class="separator"></div>    
                            <div class="form-group">
                                <table class="table-responsive" id="trainingInfo">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" id="newTraining" name="newTraining[]" placeholder="Тренинг" class="form-control">
                                            </td>
                                            <td>
                                                <button type="button" name="addTrainingField" id="addTrainingField" class="btn btn-info">
                                                    <i class="far fa-plus"></i>
                                                </button>
                                            </td>        
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-custom" id="btnAddNewTraining" name="btnAddNewTraining">Добавить</button>
                                <button type="submit" class="btn btn-delete" id="btnDeleteSelTraining" name="btnDeleteSelTraining">Удалить</button>
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
            $('#addTrainingField').click(function(){
                i++;
                $('#trainingInfo').append('<tr id="row'+i+'"><td><input type="text" name="newTraining[]" placeholder="Тренинг" class="form-control" /></td><td><button type="button" name="removeTrainingField" id="'+i+'" class="btn btn-danger btn-remove"><i class="far fa-times"></i></button></td></tr>');
            });
        
            $(document).on('click', '.btn-remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
            });
        });
    </script>
</body>
</html>    