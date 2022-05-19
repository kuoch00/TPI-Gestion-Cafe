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
        //tentative de connexion
        if(($_GET['login'])=='connect'){
            $conn = new MainModel();
            $teacher = $conn->checkConnexion($_POST['username'], $_POST['password']);
            //connexion réussie
            if($teacher){
                //Admin
                if($teacher[0]['teaIsAdmin']){
                    $_SESSION['connected'] = 'admin';
                    echo 'admin is connected';
                    print_r($teacher);
                    // header('Location: ?admin');
                }
                //user
                else{
                    $_SESSION['connected'] = 'user';
                    echo 'user is connected';
                    print_r($teacher);
                    // header('Location: ?coffee');
                }
            }
            //connexion ratée : Retour a la page de connexion
            else{
                header('Location: ?login');
            }
        }
        //page de connexion
        else{
            include ("view/login.html");
        }
        
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
        $page = $_GET['admin'];
        if($page == 'home'){

        }
        
        
        
    }
    else{
        // permet de faire une redirection directement la page home s'il n'y a rien (index)
        echo "<script>location.href=\"?login\"</script>";
    }
    
    ob_end_flush(); 
?>