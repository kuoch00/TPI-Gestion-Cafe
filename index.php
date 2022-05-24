<?php
/**
 * auteur : Elisa Kuoch
 * date : 18.05.2022
 * description : page index qui amène vers le main controller du site
 */
session_start();
include("./controller/mainController.php"); //header + page
include('view/footer.html');
?>
