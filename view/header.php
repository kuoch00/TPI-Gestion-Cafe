<div class="header">

    <!-- <img src="resources/img/header.png"  alt="" style="height: 60px; width:auto;"> -->
    <a class="title position-absolute ms-3 mt-2" href="?login">GestCafés</a>
    
</div>

<?php
    if(isset($_SESSION['user']) && isset($_SESSION['connected'])){?>
        <div class="d-grid gap-2 d-flex justify-content-end me-3">
            <p><?=$_SESSION['user'][0]['teaFirstname'] . " " . $_SESSION['user'][0]['teaLastname']?></p>
            <a href="?login=disconnect"> 
                Se déconnecter
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        </div><?php
    }
?>