<?php $title= 'Поиск: Лиды' ?>
<?php include('head.php'); ?>
<?php include('navbar.php'); ?>
<?php require_once "config.php"; ?>


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
                                <?php if (isset($_SESSION['leads'])) { ?>
                                    <?php $searchLeadsResult = $_SESSION['leads']; ?>
                                    <div class="table-scrollbar">
                                        <table id="leads" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col-4">ФИО</th>
                                                    <th scope="col-3">ФИО нуждающегося</th>
                                                    <th scope="col-3">Город</th>
                                                    <th scope="col-2">Нужды</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($searchLeadsResult as $record) { ?>
                                                    <tr class="row-click" data-href="leadinfo.php/?lead=<?php echo $record['id']; ?>">
                                                        <td><?php echo $record['fio']; ?></td>
                                                        <td><?php echo $record['fio_need']; ?></td>
                                                        <td><?php echo $record['city']; ?></td>
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
            });
        </script>
    </body>
</html>                                    