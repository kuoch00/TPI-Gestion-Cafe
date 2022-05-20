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
        //temp pour faciliter les tests
        unset($_SESSION['user']);
        unset($_SESSION['connected']);

        
        //tentative de connexion
        if(!isset($_SESSION['connected'])){

        
            if(($_GET['login'])=='connect'){
                $conn = new MainModel();
                $teacher = $conn->checkConnexion($_POST['username'], $_POST['password']);
                //connexion réussie
                if($teacher){
                    $_SESSION['user'] = $teacher;
                    //Admin
                    if($teacher[0]['teaIsAdmin']){
                        $_SESSION['connected'] = 'admin';
                        echo 'admin is connected';
                        print_r($teacher);
                        header('Location: ?admin');
                    }
                    //user
                    else{
                        $_SESSION['connected'] = 'user'; 
                        echo 'user is connected';
                        print_r($teacher);
                        header('Location: ?coffee');
                    }
                    
                }
                //connexion ratée : Retour a la page de connexion
                else{
                    //message erreur a faire passer??
                    header('Location: ?login');
                }
            }
            //page de connexion
            else{
                include ("view/login.html");
            }
        }//fin isset $_SESSION['connected'] 
        else{
            //trouver un moyen pour ne pas répéter ce code...
            if($teacher[0]['teaIsAdmin']){
                $_SESSION['connected'] = 'admin';
                echo 'admin is connected';
                print_r($teacher);
                header('Location: ?admin');
            }
            //user
            else{
                $_SESSION['connected'] = 'user'; 
                echo 'user is connected';
                print_r($teacher);
                header('Location: ?coffee');
            }
        }
    }

    //formulaire / ajout / voir consommation de café
    elseif (isset($_GET["coffee"])){
        //page ajout consommation de café
        if($_GET['coffee']=='add'){ 
            $conn = new MainModel();
            //tableau de tous les lieux
            $locations = $conn->getAllLocations(); 
            //tableau de toutes les machines de chaque lieu
            foreach ($locations as $location) {
                $machines[$location['idLocation']] = $conn->getAllMachinesFromLocation($location['idLocation']);
            }
            include('view/addCoffeeConso.php');
        }
        //ajout de la consommation dans la base de données
        elseif($_GET['coffee']=='addConso'){
            //print_r($_POST);//affiche les id de chaque machine ainsi que le nombre de cafés consommés par semaine
            $conn = new MainModel();
            //ajout de la consommation de café dans la base de données
            $conn->addConso($_POST);
            
        }
        //voir bilan du café consommé
        elseif($_GET['coffee']=='view'){
            
        }
        else{
            header('location: ?coffee=add');
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