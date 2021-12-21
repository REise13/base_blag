<?php
ob_start();
$title= 'Категории';
include('../includes/head.php');
include('../includes/navbar.php'); 
require_once "../config.php"; 

if (isset($_POST['btnAddNewCategory'])) {
    $newCategory = $_POST['newCategory'];
    $countCatArray = count($_POST['newCategory']);

    $sqlAddNewCategory = "INSERT INTO category(title) VALUES(:category)";
    $stmt = $con->prepare($sqlAddNewCategory);
    try {
        $con->beginTransaction();
        if ($countCatArray > 0) {
            for($i=0; $i < $countCatArray; $i++) {
                if (trim($_POST['newCategory'][$i] != "")) {
                    $stmt->bindParam(':category', $newCategory[$i], PDO::PARAM_STR);
                    $stmt->execute();
                }
            }  
        }
        $con->commit(); 
        $_SESSION["flash"] = ["type" => "primary", "message" => "Категория добавлена."];
        unset($stmt);
        header("Refresh:5");
    } catch(Exception $e) {
        $con->rollback();
        throw $e;
    }
}

if(isset($_POST['btnDeleteSelCategory'])) {
    $categoryID = $_POST['categoryID'];

    try{
        $con->beginTransaction();
        $sql = "SELECT id_Category FROM crosscategory";
        $stmt=$con->prepare($sql);
        $stmt->execute();
        $crosscategory = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($categoryID as $id) {
            if (in_array($id, $crosscategory)) {
                $sql = "DELETE FROM crosscategory WHERE id_Category=:crosscategory";
                $stmt=$con->prepare($sql);
                $stmt->bindParam(":crosscategory", $id, PDO::PARAM_INT);
                $stmt->execute();
                $sql = "DELETE FROM category WHERE id=:category";
                $stmt=$con->prepare($sql);
                $stmt->bindParam(":category", $id, PDO::PARAM_INT);
                $stmt->execute();
            }
            else {
                $sql = "DELETE FROM category WHERE id=:category";
                $stmt=$con->prepare($sql);
                $stmt->bindParam(":category", $id, PDO::PARAM_INT);
                $stmt->execute(); 
            }
            
        }
        $con->commit();
        $_SESSION["flash"] = ["type" => "primary", "message" => "Категория удалена."];
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
            <div class="col-lg-7 mx-auto p-5">
                <div class="card shadow border-0 mb-5">
                    <div class="card-body bg-form">
                        <p class="font-weight-bold h5 py-3" style="color: #4922a5c9;">Категории</p>
                        <?php if (isset($_SESSION["flash"])) { 
                                vprintf("<div class='alert alert-%s'>%s</div>", $_SESSION["flash"]);
                                unset($_SESSION["flash"]);
                        }    
                        ?> 
                        <form method="post">
                            <div class="table-scrollbar" id="style-scroll">
                               <?php
                                $getCategory = "SELECT * FROM category ORDER BY title";
                                $stmt = $con->prepare($getCategory);
                                $stmt->execute();
                                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if ($stmt->rowCount() > 0) { 
                                    foreach ($categories as $category) { ?>
                                        <div class="form-group px-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="<?php echo $category['id']; ?>" 
                                                name="categoryID[]" value="<?php echo $category['id']; ?>">
                                                <label class="cursor-pointer custom-control-label custom-color" for="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?> 
                            </div>
                            
                            <div class="separator"></div>    
                            <div class="form-group">
                                <table class="table-responsive" id="categoriesInfo">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" id="newCategory" name="newCategory[]" placeholder="Название категории" class="form-control">
                                            </td>
                                            <td>
                                                <button type="button" name="addCatField" id="addCatField" class="btn btn-info">
                                                    <i class="far fa-plus"></i>
                                                </button>
                                            </td>        
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-custom" id="btnAddNewCategory" name="btnAddNewCategory">Добавить</button>
                                <button type="submit" class="btn btn-delete" id="btnDeleteSelCategory" name="btnDeleteSelCategory">Удалить</button>
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
            $('#addCatField').click(function(){
                i++;
                $('#categoriesInfo').append('<tr id="row'+i+'"><td><input type="text" name="newCategory[]" placeholder="Название категории" class="form-control" /></td><td><button type="button" name="removeCatField" id="'+i+'" class="btn btn-danger btn-remove"><i class="far fa-times"></i></button></td></tr>');
            });
        
            $(document).on('click', '.btn-remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
            });
        });
    </script>
</body>
</html>    