<?php
ob_start();
$title= 'Категории';
include('head.php');
include('navbar.php'); 
require_once "config.php"; 

if (isset($_POST['btnAddNewTraining'])) {
    $newTraining = $_POST['newTraining'];
    $countTrainingArray = count($_POST['newTraining']);

    $sqlAddNewTraining = "INSERT INTO training(title) VALUES(:training)";
    $stmt = $con->prepare($sqlAddNewTraining);
    try {
        $con->beginTransaction();
        if ($countTrainingArray > 0) {
            for($i=0; $i < $countTrainingdArray; $i++) {
                if (trim($_POST['newTraining'][$i] != "")) {
                    $stmt->bindParam(':training', $newTraining[$i], PDO::PARAM_STR);
                    $stmt->execute();
                }
            }  
        }
        $con->commit(); 
        unset($stmt);
        header("Refresh:0");
    } catch(Exception $e) {
        $con->rollback();
        throw $e;
    }
}

if(isset($_POST['btnDeleteSelTraining'])) {
    $trainingID = $_POST['trainingID'];

    $sql = "DELETE FROM training WHERE id=:trainingID";
    $stmt=$con->prepare($sql);
    try{
        $con->beginTransaction();
        foreach($needID as $id) {
            $stmt->bindParam(":trainingID", $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        $con->commit();
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
                        <p class="font-weight-bold h5 py-3" style="color: #4922a5c9;">Тренинги</p>
                        <form method="post">
                            <div class="table-scrollbar" id="style-scroll">
                                <?php
                                $getTraining = "SELECT * FROM training";
                                $stmt = $con->prepare($getTraining);
                                $stmt->execute();
                                $training = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if ($stmt->rowCount() > 0) { 
                                    foreach ($training as $row) { ?>
                                    <div class="form-group">
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