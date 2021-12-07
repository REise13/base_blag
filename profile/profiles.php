<?php
$title= 'Профили';
include('../includes/head.php');
include('../includes/navbar.php');
require_once "../config.php";
?>

<body>
    <div class="page-content p-3" id="content">
        <h2 class="display-4 text-white"></h2>
        <div class="separator"></div>
        <div class="search-form">
        <!-- Форма поиска профиля -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col mx-auto">
                        <div class="search-form bg-form p-5 rounded shadow-sm">
                        <?php
                            $url = htmlspecialchars($_SERVER['HTTP_REFERER']);
                            echo "<a href='$url' class='btn btn-custom mb-3'>Назад</a>"; 
                        ?>

                        <?php if($_SESSION['user_role'] == 1) { ?>
                            <a id="btnExport" href="#!" class="btn btn-secondary mr-3 mb-3">
                                Экспорт в Excel
                            </a>
                        <?php } ?>

                        <?php if (isset($_SESSION['profiles'])) { ?>
                            <?php $searchProfilesResult = $_SESSION['profiles']; ?>
                            <div id="style-scroll">
                                <p class="py-2">Результаты поиска: найдено <?php print_r(count($searchProfilesResult)); ?> записей.</p>
                                <table id="profileInfo" class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col">ФИО</th>
                                            <th scope="col">Возраст</th>
                                            <th scope="col">Город</th>
                                            <th scope="col">Пол</th>
                                            <th scope="col">ИНН</th>
                                            <th scope="col">Паспорт</th>
                                            <th scope="col">Категории</th>
                                            <th scope="col">Помощь</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($searchProfilesResult as $row) { ?>
                                            <tr class="row-click" data-href="profileinfo.php/?profile=<?php echo $row['profile_id'] ?>&people=<?php echo $row['id_people'] ?>">      
                                                <td><?php echo $row['fio'] ?></td>
                                                <td><?php echo $row['age'] ?></td>
                                                <td><?php echo $row['city_info'] ?></td>
                                                <td><?php echo $row['gender_info'] ?></td>
                                                <td><?php echo $row['INN'] ?></td>
                                                <td><?php echo $row['Passport'] ?></td>
                                                <td><?php echo $row['category_info'] ?></td>
                                                <td><?php echo $row['help_info'] ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    <?php } ?>   
                                    </div>
                                </table>
                            </div>        
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>

    <script>
        $(document).ready(function($){
            $(".row-click").click(function(){
                window.document.location = $(this).data("href");
            });
        });

        $('#btnExport').click(function () {
            $("#profileInfo").table2excel({
                filename: "Profili_BaseDDC.xls"
            });
        });
    </script>
</body>
</html>                      