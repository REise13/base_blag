<?php
ob_start();
$title= 'Категории';
include('head.php');
include('navbar.php'); 
require_once "config.php"; 

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
        unset($stmt);
        header("Refresh:0");
    } catch(Exception $e) {
        $con->rollback();
        throw $e;
    }
}

if(isset($_POST['btnDeleteSelCategory'])) {
    $categoryID = $_POST['categoryID'];

    $sql = "DELETE FROM category WHERE id=:categoryID";
    $stmt=$con->prepare($sql);
    try{
        $con->beginTransaction();
        foreach($categoryID as $id) {
            $stmt->bindParam(":categoryID", $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        $con->commit();
        unset($stmt);
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
                        <form method="post">
                            <div class="table-scrollbar" id="style-scroll">
                               <?php
                                $getCategory = "SELECT * FROM category";
                                $stmt = $con->prepare($getCategory);
                                $stmt->execute();
                                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if ($stmt->rowCount() > 0) { 
                                    foreach ($categories as $category) { ?>
                                    <div class="form-group">
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