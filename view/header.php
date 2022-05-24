<p>image</p>
<a href="?login">GestCafés</a>
<?php
    if(isset($_SESSION['user']) && isset($_SESSION['connected'])){?>
        <p><?=$_SESSION['user'][0]['teaFirstname'] . " " . $_SESSION['user'][0]['teaLastname']?></p>
        <a href="?login=disconnect">Se déconnecter</a><?php
    }
?>