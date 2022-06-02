<div class="header">
    <!-- <img src="resources/img/header.png"  alt="" style="height: 60px; width:auto;"> -->
    <div class=" position-absolute ms-3 mt-2">
        <a class="title" href="?login">GestCafés  <i class="fa-solid fa-mug-saucer"></i></a>
    </div> 
</div>
<?php
    if(isset($_SESSION['user']) && isset($_SESSION['connected'])){?>
        <div class="d-grid gap-2 d-flex justify-content-end me-3">
            <p><?=$_SESSION['user'][0]['teaFirstname'] . " " . $_SESSION['user'][0]['teaLastname']?></p>
            <a href="?login=disconnect"> 
                Déconnexion
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        </div><?php
    }
?>