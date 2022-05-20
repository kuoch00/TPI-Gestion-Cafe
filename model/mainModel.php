<?php
/**
 * Model principal
 */
class MainModel
{
    /**
     * constructeur
     */
    function __construct()
    {
        include ('config.php');

        try{
            // dsn = data source name 
            $dsn = "mysql:host=" . $login["servername"] . "; dbname=" . $login["database"] . "; charset=utf8" ;
            $this->pdo=new PDO($dsn, $login['username'], $login['password']);

            //Activer le mode exeption du pdo
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        // message d'erreur si connection ratée
        catch (PDOException $exeption){
            echo "Impossible de se connecter à la base de données. Code d'erreur : \n";
            echo $exeption->getMessage(); 
        }
        
    }

    /**
     * permet de préparer et d’exécuter une requête de type simple (sans where)
     *
     * @param string $query
     * @return array
     */
    protected function querySimpleExecute($query)
    {
        $req = $this->pdo->query($query);
        $arrayData = $this->formatData($req);
        $this->unsetData($req);
        return $arrayData;
    }

    /**
     * permet de préparer, de binder et d’exécuter une requête (select avec where ou insert, update et delete)
     *
     * @param string $query
     * @param array $binds
     * @return array
     */
    protected function queryPrepareExecute($query, $binds)
    {
        $req = $this->pdo->prepare($query);

        foreach($binds as $bind)
        {
            $req->bindValue($bind['marker'], $bind['var'], $bind['type']);
        }
        $req->execute();

        $dataArray = $this->formatData($req);

        $this->unsetData($req);

        return $dataArray;
    }


    /**
    * traiter les données pour les retourner par exemple en tableau associatif 
    * (avec PDO::FETCH_ASSOC)
    *
    *@param PDOStatement $req 
    */
    private function formatData($req)
    {
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
    * vide le jeu d’enregistrement
    *
    *@param $req
    *@return void
    */
    private function unsetData($req)
    {
        $req->closeCursor();
    }

    /**
     * check de la connexion, retourne rien si l'un des deux paramètres est faux
     *
     * @param [string] $username
     * @param [string] $password
     * @return array
     */
    public function checkConnexion($inputUsername, $inputPassword)
    {
        $teaPassword = $this->getPassword($inputUsername); 
        if($teaPassword){
            if(password_verify($inputPassword,$teaPassword[0]['teaPassword'])){
                $result = $this->getTeacher($teaPassword[0]['idTeacher']);
                return $result;
            }
            else{ 
                return false;
            } 
        }
        else{
            return false;
        }
    }

    /**
     * Recherche le mot de passe et l'id correspondant au nom d'utilisateur
     * Retourne vide si l'utilisateur n'existe pas
     *
     * @param [string] $username
     * @return array
     */
    private function getPassword($username)
    {
        $query = "SELECT idTeacher, teaPassword FROM `t_teacher` WHERE `teaUsername` LIKE :username ";
        $binds = array(
            0=>array(
                'var' => $username,
                'marker'=> ':username',
                'type'=> PDO::PARAM_STR
            )
        );
        $result = $this->queryPrepareExecute($query, $binds);
        return $result;
    }

    /**
     * recherche les données de l'utilisateur/enseignant
     *
     * @param [string] $id
     * @return array
     */
    private function getTeacher($id)
    {
        $query = "SELECT idTeacher, teaFirstname, teaLastname, teaIsAdmin, teaNbWeek FROM t_teacher WHERE idTeacher like :id";
        $binds = array(
            0=>array(
                'var' => $id,
                'marker'=> ':id',
                'type'=> PDO::PARAM_STR
            )
        );
        $result = $this->queryPrepareExecute($query, $binds);
        return $result;
    }

    
    /**
     * récupère tous les lieux dans t_location
     *
     * @return array
     */
    public function getAllLocations()
    {
        $query="SELECT idLocation, locName FROM t_location ";
        $result = $this->querySimpleExecute($query);
        return $result;
    }

    /**
     * récupère toutes les machines d'un lieu
     *
     * @param [string] $idLocation
     * @return array
     */
    public function getAllMachinesFromLocation($idLocation)
    {
        $query="SELECT `idMachine`,`macName`, t_typemachine.typName as macType, t_typemachine.typCoffeePrice as macCoffeePrice FROM `t_machine`
        INNER JOIN t_typemachine on t_machine.fkTypeMachine = t_typemachine.idTypeMachine
        WHERE `fkLocation` LIKE :idLocation";
        $binds=array(
            0=>array(
                'var'=> $idLocation,
                'marker'=>':idLocation',
                'type'=>PDO::PARAM_STR
            )
        );
        $result= $this->queryPrepareExecute($query, $binds);
        return $result;
    }

    /**
     * ajoute une consommation de café
     *
     * @param [array] $conso
     * @return array
     */
    public function addConso($conso)
    {
        $total = $this->calcTotal($conso); 
        $idTeacher = $_SESSION['user'][0]['idTeacher'];
         
        $addOrder = $this->addOrder($total, $idTeacher);
        $addInclude = $this->addAllInclude($conso);
        
    }

    /**
     * calcule le total des cafés de l'année
     *
     * @param [array] $conso
     * @return int
     */
    private function calcTotal($conso)
    {
        $totalWeek=0;
        $totalYear=0; 
        $listMachines = $this->getMachineCoffeePrices();

        foreach ($conso as $idMachine => $nbCafe) { 
            if($nbCafe!="" && $nbCafe!=0){  
                foreach ($listMachines as $oneMachine) {
                    if ($oneMachine['idMachine']==$idMachine) {
                        $totalWeek += $oneMachine['macCoffeePrice'] * $nbCafe ; 
                        break;
                    }
                }
            }
        }
        $totalYear = $totalWeek * $_SESSION['user'][0]['teaNbWeek']; 
        return $totalYear; 
    }

    /**
     * récupère la liste de toutes les machines à café avec le prix du café
     *
     * @return array
     */
    private function getMachineCoffeePrices()
    {
        $query="SELECT `idMachine`, t_typemachine.typCoffeePrice AS macCoffeePrice FROM `t_machine` 
        INNER JOIN t_typemachine on t_typemachine.idTypeMachine = t_machine.fkTypeMachine";
        $result = $this->querySimpleExecute($query);
        return $result;
    }
 
    /**
     * ajoute la commande de la consommation de café dans la base de données
     *
     * @param [string] $total
     * @param [int] $id
     * @return void
     */
    private function addOrder($total, $id)
    { 
        $query = "INSERT INTO t_order SET ordDate=:ordDate, ordTotal=:ordTotal, fkTeacher=:idTeacher";
        $binds=array(
            0=>array(
                'var'=> date("Y-m-d"),
                'marker'=>':ordDate',
                'type'=>PDO::PARAM_STR
            ),
            1=>array(
                'var'=>$total,
                'marker'=>':ordTotal',
                'type'=>PDO::PARAM_STR
            ),
            2=>array(
                'var'=>$id,
                'marker'=>':idTeacher',
                'type'=>PDO::PARAM_STR
            )
        );
        $result = $this->queryPrepareExecute($query, $binds); 
        return $result;
    }

    /**
     * ajout de chaque ligne de la commande dans t_include
     *
     * @param [array] $conso
     * @return void
     */
    private function addAllInclude($conso)
    {
        //récupère derniere commande effectuée (celle que l'on vient d'ajouter dans addOrder)
        $idOrder = $this->getLastOrder($_SESSION['user'][0]['idTeacher']); 

        //recup liste machines
        $listMachines = $this->getMachineCoffeePrices(); 

        foreach ($conso as $idMachine => $nbCafe) {  
            if($nbCafe!="" && $nbCafe!=0){
                foreach($listMachines as $machine){
                    if($machine['idMachine'] == $idMachine){
                        // echo $idMachine . " " . $idOrder[0]['idOrder']. " " . $nbCafe. " " . $machine['macCoffeePrice'];
                        // die();
                        $add = $this->addInclude($idMachine, $idOrder[0]['idOrder'], $nbCafe, $machine['macCoffeePrice']);
                    }
                } 
            }
        }
    }

    /**
     * Récupère l'id de la derniere commande de l'utilisateur
     *
     * @param [int] $idTeacher
     * @return array
     */
    private function getLastOrder($idTeacher)
    {
        $query ="SELECT MAX(`idOrder`) as idOrder FROM `t_order` WHERE fkTeacher=:idTeacher"; 
        $binds=array(
            0=>array(
                'var'=>$idTeacher,
                'marker'=>':idTeacher',
                'type'=>PDO::PARAM_STR
            )
        );
        $result = $this->queryPrepareExecute($query, $binds); 
        return $result;
    }

    /**
     * insertion dans t_include pour chaque machine
     *
     * @param [int] $idMachine
     * @param [int] $idOrder
     * @param [int] $coffeeQuantity
     * @param [string] $coffeePrice
     * @return void
     */
    private function addInclude($idMachine, $idOrder, $coffeeQuantity, $coffeePrice)
    { 
        $query="INSERT INTO t_include SET fkMachine=:idMachine, fkOrder=:idOrder, incCoffeeQuantity=:coffeeQuantity, incCoffeePrice=:coffeePrice";
        $binds=array(
            0=>array(
                'var'=>$idMachine,
                'marker'=>':idMachine',
                'type'=>PDO::PARAM_STR 
            ),
            1=>array(
                'var'=>$idOrder,
                'marker'=>':idOrder',
                'type'=>PDO::PARAM_STR 
            ),
            2=>array(
                'var'=>$coffeeQuantity,
                'marker'=>':coffeeQuantity',
                'type'=>PDO::PARAM_STR 
            ),
            3=>array(
                'var'=>$coffeePrice,
                'marker'=>':coffeePrice',
                'type'=>PDO::PARAM_STR 
            )
        );
        $result = $this->queryPrepareExecute($query, $binds);
        return $result;
    }

}




?>