<?php
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

    // public function getAllLocationsMachines()
    // {
        
    // }
    /**
     * get all locations in t_location
     *
     * @return array
     */
    public function getAllLocations()
    {
        $query="SELECT idLocation, locName FROM t_location ";
        $result = $this->querySimpleExecute($query);
        return $result;
    }

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

    
}




?>