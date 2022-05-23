<?php
/**
 * auteur : Elisa Kuoch
 * date de création : 18.05.2022
 * description : controlleur de l'application
 */
    ob_start();

    //mvc
    include_once('model/mainModel.php');
    include_once('model/adminModel.php');
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
    elseif (isset($_GET['coffee'])){
        $conn = new MainModel();
        switch($_GET['coffee']){ 
            case 'add' : 
                //tableau de tous les lieux
                $locations = $conn->getAllLocations(); 
                //tableau de toutes les machines de chaque lieu
                foreach ($locations as $location) {
                    $machines[$location['idLocation']] = $conn->getAllMachinesFromLocation($location['idLocation']);
                }
                include('view/addCoffeeConso.php');
                break;
            case 'addConso' : 
                //ajout de la consommation de café dans la base de données
                $addConso = $conn->addConso($_POST);
                
                header('Location: ?coffee=view');
                break;
            case 'view' : 
                $locations = $conn->getAllLocations();
                foreach($locations as $location){
                    $machines[$location['idLocation']] = $conn->getAllMachinesFromLocation($location['idLocation']); 
                    //machine['idMachine] == t_include.fkMachine =>
                } 
                //recupère les données de la dernière commande
                $lastOrder = $conn->getLastOrder($_SESSION['user'][0]['idTeacher']);

                $coffeeQuantity = $conn->getCoffeeQuantity($lastOrder[0]['idOrder']);
                $total = $lastOrder[0]['ordTotal'];
                // print_r($total);
                if($lastOrder[0]['ordTotalPaid']){
                    $status= "Payé";
                }
                else{
                    $status = "En attente de paiement";
                }
                include('view/viewCoffeeConso.php');
                break;
            default :
                header('Location: ?coffee=add');
                break; 
        }
    }

    //espace administrateur
    elseif (isset($_GET['admin'])){
        $conn = new AdminModel();
        switch($_GET['admin']){
            case 'home':
                $machines = $conn->getMachines();
                $teachers = $conn->getTeachers();
                include('view/admin/home.php');
                break;
            case 'addMachineForm' :
                $machines = $conn->getMachines();
                include('view/admin/addMachine.php');
                break;
            case 'addMachine' :
                $conn->addMachine($_POST['nom'], $_POST['prix'], $_POST['type'], $_POST['location']);
                header('Location: ?admin=home');
                break;
            case 'updateCoffeePriceForm' :
                $types = $conn->getAllTypes();
                include('view/admin/editCoffeePrice.php');
                break;
            case 'updateCoffeePrice' : 
                // die();
                $conn->updateCoffeePrices($_POST);
                header('Location: ?admin=home');
                break;
            case 'updatePaymentForm':
                if(isset($_GET['id']) && $_GET['id']){
                    $id = $_GET['id']; 
                    $order = $conn->getOrder($id);
                    include('view/admin/addPayment.php');
                }
                break;
            case 'updatePayment':
                if(isset($_GET['id']) && $_GET['id']){
                    $id = $_GET['id']; 
                    $conn->addPayment($id, $_POST['amount'], $_POST['paymentDate']);
                }
                break;
            default :
                header('Location: ?admin=home');
                break;
        } 
    }
    else{
        // permet de faire une redirection directement la page home s'il n'y a rien (index)
        echo "<script>location.href=\"?login\"</script>";
    }
    
    ob_end_flush(); 
?>