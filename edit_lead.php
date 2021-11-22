<?php
session_start();
require_once 'config.php';

if(isset($_POST['btnLeadRegister'])) {
    $_SESSION['lead_fio'] = isset($_POST['fioNeed']) ? $_POST['fioNeed'] :'';
    $_SESSION['lead_phone'] = isset($_POST['phone']) ? $_POST['phone'] :'';

    header("location: ../register_profile.php");
}
 ?>