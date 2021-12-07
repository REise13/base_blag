<?php
$title= 'Лиды';
include('../includes/head.php');
include('../includes/navbar.php');
require_once "../config.php";
?>

    <body>
        <div class="page-content p-3" id="content">
            <h2 class="display-4 text-white"></h2>
            <div class="separator"></div>
            <div class="search-form">
            <!-- Результаты поиска лида -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="bg-form p-5 rounded shadow-sm">
                                <?php
                                    $url = htmlspecialchars($_SERVER['HTTP_REFERER']);
                                    echo "<a href='$url' class='btn btn-custom mb-3'>Назад</a>"; 
                                ?>

                                <?php if($_SESSION['user_role'] == 1) { ?>
                                    <a id="btnExport" href="#!" class="btn btn-secondary mr-3 mb-3">
                                        Экспорт в Excel
                                    </a>
                                <?php } ?>

                                <?php if (isset($_SESSION['leads'])) { ?>
                                    <?php $searchLeadsResult = $_SESSION['leads']; ?>
                                    <div id="style-scroll">
                                        <table id="leadsInfo" class="table table-bordered table-responsive">
                                            <thead>
                                                <tr>
                                                    <th scope="col-4">ФИО</th>
                                                    <th scope="col-3">ФИО нуждающегося</th>
                                                    <th scope="col-3">Город</th>
                                                    <th scope="col">Телефон</th>
                                                    <th scope="col-2">Нужды</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($searchLeadsResult as $record) { ?>
                                                    <tr class="row-click" data-href="leadinfo.php/?lead=<?php echo $record['id']; ?>">
                                                        <td><?php echo $record['fio']; ?></td>
                                                        <td><?php echo $record['fio_need']; ?></td>
                                                        <td><?php echo $record['city']; ?></td>
                                                        <td><?php echo $record['phone']; ?></td>
                                                        <td><?php echo $record['need']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                <?php } ?>
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

                $('#btnExport').click(function () {
                    $("#leadsInfo").table2excel({
                        filename: "Leads_BaseDDC.xls"
                    });
                });
            });
        </script>
    </body>
</html>                                    