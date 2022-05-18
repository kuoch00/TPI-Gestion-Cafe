<?php
/**
 * auteur : Elisa Kuoch
 * date de création : 18.05.2022
 * description : controlleur de l'application
 */
    ob_start();

    //mvc
    include_once('model/mainModel.php');
    include('view/view.php');
    
    //login
    if(isset($_GET['login'])){
        if(($_GET['login'])=='connect'){
            $connect = new MainModel();
            //check info de connection
            // $_POST['username'] ['password]
        }
        include ("view/login.html");
    }

    //ajout / voir consommation de café
    elseif (isset($_GET["coffee"])){
        if($_GET['coffee']=='add'){
            //ajouter une consommation de café
        }
        elseif($_GET['coffee']=='view'){
            //voir bilan du café consommé
        }

    }

    //espace administrateur
    elseif (isset($_GET["admin"])){
        
        
    }
    else{
        // permet de faire une redirection directement la page home s'il n'y a rien (index)
        echo "<script>location.href=\"?login\"</script>";
    }
    
    ob_end_flush(); 
?>