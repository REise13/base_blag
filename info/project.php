<?php
ob_start();
$title= 'Проекты';
include('../includes/head.php');
include('../includes/navbar.php'); 
require_once "../config.php"; 

if (isset($_POST['btnAddNewProject'])) {
    $newProject = $_POST['newProject'];
    $countProjectArray = count($_POST['newProject']);

    $sqlAddNewProject = "INSERT INTO project(title) VALUES(:project)";
    $stmt = $con->prepare($sqlAddNewProject);
    try {
        $con->beginTransaction();
        if ($countProjectArray > 0) {
            for($i=0; $i < $countProjectArray; $i++) {
                if (trim($_POST['newProject'][$i] != "")) {
                    $stmt->bindParam(':project', $newProject[$i], PDO::PARAM_STR);
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

if(isset($_POST['btnDeleteSelProject'])) {
    $projectID = $_POST['projectID'];

    try{
        $con->beginTransaction();
        $sql = "SELECT id_project FROM help";
        $stmt=$con->prepare($sql);
        $stmt->execute();
        $help_project = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($projectID as $id) {
            if (in_array($id, $help_project)) {
                $sql = "DELETE FROM help WHERE id_project=:help_project";
                $stmt=$con->prepare($sql);
                $stmt->bindParam(":help_project", $id, PDO::PARAM_INT);
                $stmt->execute();
                $sql = "DELETE FROM project WHERE id=:project";
                $stmt=$con->prepare($sql);
                $stmt->bindParam(":project", $id, PDO::PARAM_INT);
                $stmt->execute();
            }
            else {
                $sql = "DELETE FROM project WHERE id=:project";
                $stmt=$con->prepare($sql);
                $stmt->bindParam(":project", $id, PDO::PARAM_INT);
                $stmt->execute(); 
            }
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
                        <p class="font-weight-bold h5 py-3" style="color: #4922a5c9;">Проекты</p>
                        <form method="post">
                            <div class="table-scrollbar" id="style-scroll">
                                <?php
                                $getProject = "SELECT * FROM project";
                                $stmt = $con->prepare($getProject);
                                $stmt->execute();
                                $project = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if ($stmt->rowCount() > 0) { 
                                    foreach ($project as $row) { ?>
                                    <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="<?php echo $row['id']; ?>" 
                                                name="projectID[]" value="<?php echo $row['id']; ?>">
                                                <label class="cursor-pointer custom-control-label custom-color" for="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            
                            <div class="separator"></div>    
                            <div class="form-group">
                                <table class="table-responsive" id="projectInfo">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" id="newProject" name="newProject[]" placeholder="Проект" class="form-control">
                                            </td>
                                            <td>
                                                <button type="button" name="addNeedField" id="addProjectField" class="btn btn-info">
                                                    <i class="far fa-plus"></i>
                                                </button>
                                            </td>        
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-custom" id="btnAddNewProject" name="btnAddNewProject">Добавить</button>
                                <button type="submit" class="btn btn-delete" id="btnDeleteSelProject" name="btnDeleteSelProject">Удалить</button>
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
            $('#addProjectField').click(function(){
                i++;
                $('#projectInfo').append('<tr id="row'+i+'"><td><input type="text" name="newProject[]" placeholder="Проект" class="form-control" /></td><td><button type="button" name="removeProjectField" id="'+i+'" class="btn btn-danger btn-remove"><i class="far fa-times"></i></button></td></tr>');
            });
        
            $(document).on('click', '.btn-remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
            });
        });
    </script>
</body>
</html>    