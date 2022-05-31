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
        //pas encore connecté :
        if(!isset($_SESSION['connected']) || !isset($_SESSION['user'])){ 
            //tentative de connexion une fois le nom d'utilisateur et mot de passe entré
            if(($_GET['login'])=='connect'){
                $conn = new MainModel();
                $teacher = $conn->checkConnexion($_POST['username'], $_POST['password']);
                
                if($teacher){//connexion réussie
                    $connectError = false;
                    //info de l'utilisateur 
                    $_SESSION['user'] = $teacher; 
                    
                    //is Admin ?
                    if($teacher[0]['teaIsAdmin']){  
                        $_SESSION['connected'] = 'admin';
                        header('Location: ?admin');
                    }
                    //user
                    else{
                        $_SESSION['connected'] = 'user'; 
                        header('Location: ?coffee');
                    } 
                }
                //connexion ratée : Retour a la page de connexion
                else{
                    //message erreur
                    $connectError = true;
                    //garde username pour retaper rapidement le mot de passe
                    $username = $_POST['username'];
                    include("view/login.php");
                }
            }
            //page de connexion
            else{
                include("view/login.php");
            }
        }
        //connecté
        else{
            //déconnexion
            if($_GET['login']=='disconnect'){
                unset($_SESSION['user']);
                unset($_SESSION['connected']);
                header('Location: ?login');
            } 
            //utilisateur connecté
            else{
                //admin
                if($_SESSION['connected'] == 'admin'){ 
                    header('Location: ?admin');
                }
                //user
                else{
                    header('Location: ?coffee');
                }
            }
        }
    }

    //formulaire / ajout / voir consommation de café
    elseif (isset($_GET['coffee'])){ 
        if(isset($_SESSION['user']) && $_SESSION['user']){ //vérifiation si utilisateur est connecté
            $conn = new MainModel();
            $currentMonth = date('m');
            $years = $conn->calcCurrentSchoolYear(date('m'));
            switch($_GET['coffee']){ 
                case 'add' : 
                    //verifie si conso deja commandée :
                    if($conn->hasOrdered($_SESSION['user'][0]['idTeacher'])){
                        header('Location: ?coffee=view');
                    }
                    else{
                        //récupère dernière consommation de café
                        // print_r();
                        // die();
                        // $id = $_SESSION['user'][0]['idTeacher'];
                        $lastConso = $conn->getLastConso($years, $_SESSION['user'][0]['idTeacher']);

                        //tableau de tous les lieux
                        $locations = $conn->getAllLocations(); 
                        
                        //tableau de toutes les machines de chaque lieu
                        foreach ($locations as $location) {
                            $machines[$location['idLocation']] = $conn->getAllMachinesFromLocation($location['idLocation']);
                        }
                        include('view/addCoffeeConso.php');
                    }   
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
                    } 
                    //recupère les données de la dernière commande
                    $lastOrder = $conn->getLastOrder($_SESSION['user'][0]['idTeacher']);
                    $coffeeQuantity = $conn->getCoffeeQuantity($lastOrder[0]['idOrder']);
                    $total = $lastOrder[0]['ordTotal'];
                    if($lastOrder[0]['ordTotalPaid']){
                        $status = 'Payé';
                    }
                    else{
                        $status = 'En attente de paiement';
                    }
                    include('view/viewCoffeeConso.php');
                    break;
                default :
                    header('Location: ?coffee=add');
                    break; 
            }
        }
        else{//l'utilisateur n'est pas connecté
            header('Location: ?login');
        }
    }

    //espace administrateur
    elseif (isset($_GET['admin'])){
        if(isset($_SESSION['user']) && $_SESSION['user']){ //utilisateur connecté
            if(isset($_SESSION['connected']) && $_SESSION['connected'] == 'admin'){ //utilisateur = admin
                $conn = new AdminModel();
                switch($_GET['admin']){
                    case 'home': 
                        $years = $conn->calcCurrentSchoolYear(date('m'));
                        $hasOrdered = $conn->hasOrdered($_SESSION['user'][0]['idTeacher']);
                        $machines = $conn->getMachines();
                        $teachers = $conn->getTeachers();
                        include('view/admin/home.php');
                        break;
                    case 'addMachineForm' :
                        $machines = $conn->getMachines();
                        $locations = $conn->getAllLocations();
                        include('view/admin/addMachine.php');
                        break;
                    case 'addMachine' :
                        $conn->addMachine(htmlspecialchars($_POST['nom']), $_POST['prix'], htmlspecialchars($_POST['type']), $_POST['location']);
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
                            $date = date('Y-m-d');
                            include('view/admin/addPayment.php');
                        }
                        break;
                    case 'updatePayment':
                        if(isset($_GET['id']) && $_GET['id']){
                            $id = $_GET['id']; 
                            $conn->addPayment($id, $_POST['amount'], $_POST['paymentDate']);
                            header('Location: ?admin=home');
                        } 
                        break; 
                    case 'viewConso':
                        if(isset($_GET['id'])&&$_GET['id']){
                            $years = $conn->calcCurrentSchoolYear(date('m'));
                            $teacherOrder = $conn->getTeacherOrder($_GET['id']);
                            
                            include('view/admin/teacherOrder.php');
                        }
                        break;
                    case 'editOrderForm': 
                        include ('view/admin/editOrder.php');
                        break;
                    default :
                        header('Location: ?admin=home');
                        break;
                } //fin du switch
            }
            else{//utilisateur != admin
                echo "Vous n'êtes pas autorisé à consulter cette page.";
                echo '<br><a href="?login" role="button" class="btn btn-primary">Retour</a>';
            }
        }
        else{//utilisateur pas connecté
            header('Location: ?login');
        }
    }
    else{
        // permet de faire une redirection directement la page home $_GET = rien
        header('Location: ?login');
    } 
    ob_end_flush(); 
?>