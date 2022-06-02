<?php
//TODO : Dates de query à modifier !!

use LDAP\Result;

class AdminModel extends MainModel
{
    /**
     * récupère toutes les machines à café
     *
     * @return array
     */
    public function getMachines()
    {
        $query="SELECT `idMachine`,`macName`, t_typemachine.typName as macType, t_location.locName as macLocation, t_typemachine.typCoffeePrice as macCoffeePrice FROM `t_machine` 
        INNER JOIN t_typemachine on t_typemachine.idTypeMachine = t_machine.fkTypeMachine
        INNER JOIN t_location on t_location.idLocation = t_machine.fkLocation";
        $result=$this->querySimpleExecute($query);
        return $result;
    }

    /**
     * récupère toutes les commandes (avec les noms des enseignants)
     *
     * @return array
     */
    public function getTeachers()
    {
        $years = $this->calcCurrentSchoolYear(date('m'));
        // print_r($years);
        
        $date1 = $years['year1'] . "-08-01";
        $date2 = $years['year2'] . "-07-31";
        // die($date1);
        $query="SELECT fkTeacher, t_teacher.teaFirstname, t_teacher.teaLastname, ordTotal, ordTotalPaid, ordPaymentDate, idOrder FROM t_order
        INNER JOIN t_teacher on t_teacher.idTeacher = t_order.fkTeacher
        WHERE ordDate BETWEEN :date1 AND :date2";
        $binds=array(
            0=>array(
                'var'=>$date1,
                'marker'=>':date1',
                'type'=>PDO::PARAM_STR
            ),
            1=>array(
                'var'=>$date2,
                'marker'=>':date2',
                'type'=>PDO::PARAM_STR
            )
        );
        $result=$this->queryPrepareExecute($query, $binds);
        // $result=$this->querySimpleExecute($query);
        return $result;
    }

    /**
     * récupère les données d'une commande
     *
     * @param [int] $id
     * @return array
     */
    public function getOrder($idOrder)
    {
        $query="SELECT `idOrder`,`ordTotal`,ordDate ,`fkTeacher`,t_teacher.teaFirstname, t_teacher.teaLastname FROM `t_order`
        INNER JOIN t_teacher ON t_teacher.idTeacher = t_order.fkTeacher
        WHERE `idOrder`=:id";
        $binds=array(
            0=>array(
                'var'=>$idOrder,
                'marker'=>':id',
                'type'=>PDO::PARAM_STR   
            )
        );
        $result = $this->queryPrepareExecute($query, $binds);
        return $result;
    }

    /**
     * Ajout d'une nouvelle machine à café
     *
     * @param [string] $name
     * @param [decimal] $price
     * @param [string] $type
     * @param [string] $location
     * @return void
     */
    public function addMachine($name, $price, $type, $location)
    {
        //verifie si type existe
        $typeExists = $this->getTypeId($type);
        if($typeExists){
            $typeId = $typeExists; 
        }
        else{
            //ajoute nouveau type
            $this->addType($type, $price);
            $typeId = $this->getTypeId($type);
        } 
        $locationId = $this->getLocationId($location); 
        $query="INSERT INTO t_machine SET macName=:name, fkLocation=:location, fkTypeMachine=:type";
        $binds=array(
            0=>array(
                'var'=>$name,
                'marker'=>':name',
                'type'=>PDO::PARAM_STR  
            ),
            1=>array(
                'var'=>$locationId[0]['idLocation'],
                'marker'=>':location',
                'type'=>PDO::PARAM_STR  
            ),
            2=>array(
                'var'=>$typeId[0]['idTypeMachine'],
                'marker'=>':type',
                'type'=>PDO::PARAM_STR  
            )
        );
        $result = $this->queryPrepareExecute($query, $binds);
        return $result;
        
    }

    /**
     * récupère l'id du type de la machine à café
     *
     * @param [string] $type
     * @return void
     */
    private function getTypeId($typeName)
    {
        $query="SELECT idTypeMachine FROM t_typemachine WHERE typName=:typeName";
        $binds=array(
            0=>array(
                'var'=>$typeName,
                'marker'=>':typeName',
                'type'=>PDO::PARAM_STR 
            )
        );
        $result = $this->queryPrepareExecute($query, $binds);
        return $result;

    }

    /**
     * ajout nouveau type de machine à café
     *
     * @param [string] $typName
     * @param [type] $coffeePrice
     * @return void
     */
    private function addType($typName, $coffeePrice)
    {
        $query="INSERT INTO t_typemachine SET typCoffeePrice=:coffeePrice, typName=:typName";
        $binds=array(
            0=>array(
                'var'=>$coffeePrice,
                'marker'=>':coffeePrice',
                'type'=>PDO::PARAM_STR
            ),
            1=>array(
                'var'=>$typName,
                'marker'=>':typName',
                'type'=>PDO::PARAM_STR
            )
        );
        $result = $this->queryPrepareExecute($query, $binds);
        return $result;
    }

    /**
     * récupère l'id de l'emplacement de la machine a café
     *
     * @param [type] $locationName
     * @return void
     */
    private function getLocationId($locationName)
    {
        $query="SELECT idLocation FROM `t_location` WHERE `locName` = :locationName";
        $binds=array(
            0=>array(
                'var'=>$locationName,
                'marker'=>':locationName',
                'type'=>PDO::PARAM_STR 
            )
        );
        $result = $this->queryPrepareExecute($query, $binds);
        return $result;
    }

    /**
     * récupère tous les types de machine à café
     *
     * @return array
     */
    public function getAllTypes()
    {
        $query="SELECT `idTypeMachine`,`typCoffeePrice`,`typName` FROM `t_typemachine`";
        $result = $this->querySimpleExecute($query);
        return $result;
    }

    /**
     * Met a jour le prix des cafés
     *
     * @param [array] $coffeePrices
     * @return void
     */
    public function updateCoffeePrices($coffeePrices)
    {
        foreach ($coffeePrices as $idType=>$coffeePrice){
            $query = "UPDATE t_typemachine SET typCoffeePrice = :coffeePrice WHERE t_typemachine.idTypeMachine = :idType ";
            $binds=array(
                0=>array(
                    'var'=> $idType,
                    'marker'=>':idType',
                    'type'=>PDO::PARAM_STR
                ),
                1=>array(
                    'var'=>$coffeePrice,
                    'marker'=>':coffeePrice',
                    'type'=>PDO::PARAM_STR
                )
            );
            $this->queryPrepareExecute($query, $binds); 
        }
    }

    /**
     * ajout du paiement dans la base de données
     *
     * @param [int] $idOrder
     * @param [decimal] $amount
     * @param [date] $date
     * @return void
     */
    public function addPayment($idOrder, $amount, $date)
    {
        $query="UPDATE `t_order` SET `ordPaymentDate` = :date , `ordTotalPaid` = :amount WHERE `t_order`.`idOrder` = :idOrder";
        $binds=array(
            0=>array(
                'var'=>$idOrder,
                'marker'=>':idOrder',
                'type'=>PDO::PARAM_STR
            ),
            1=>array(
                'var'=>$amount,
                'marker'=>':amount',
                'type'=>PDO::PARAM_STR
            ),
            2=>array(
                'var'=>$date,
                'marker'=>':date',
                'type'=>PDO::PARAM_STR
            )
        );
        $this->queryPrepareExecute($query, $binds); 
    }

    /**
     * récupère la commande d'un enseignant
     *
     * @param [int] $idTeacher
     * @return array
     */
    public function getTeacherOrder($idTeacher)
    {
        $years = $this->calcCurrentSchoolYear(date('m'));
        $date1 = $years['year1'] . "-08-01";
        $date2 = $years['year2'] . "-07-31";

        $query="SELECT fkTeacher, t_teacher.teaFirstname, t_teacher.teaLastname, ordTotal, ordTotalPaid, ordPaymentDate, idOrder FROM t_order
        INNER JOIN t_teacher on t_teacher.idTeacher = t_order.fkTeacher
        WHERE fkTeacher LIKE :idTeacher AND ordDate BETWEEN :date1 AND :date2";

        $binds=array(
            0=>array(
                'var'=>$date1,
                'marker'=>':date1',
                'type'=>PDO::PARAM_STR
            ),
            1=>array(
                'var'=>$date2,
                'marker'=>':date2',
                'type'=>PDO::PARAM_STR
            ),
            2=>array(
                'var'=>$idTeacher,
                'marker'=>':idTeacher',
                'type'=>PDO::PARAM_STR
            )
        );

        $result = $this->queryPrepareExecute($query,$binds);
        return $result;

    }

    /**
     * récupère la consommation d'une commande
     *
     * @param [int] $idOrder
     * @return array
     */
    public function getConsoOrder($idOrder)
    {
        $query="SELECT `fkMachine`, t_machine.macName,`incCoffeeQuantity` FROM `t_include` INNER JOIN t_machine On t_machine.idMachine = fkMachine WHERE `fkOrder` LIKE :idOrder ";
        
        $binds=array(
            0=>array(
                'var'=>$idOrder,
                'marker'=>':idOrder',
                'type'=>PDO::PARAM_STR
            )
        );
        $result = $this->queryPrepareExecute($query, $binds);
        return $result;
    }

    /**
     * met à jour la commande avec les nouvelles quantités et le nouveau montant
     *
     * @param [int] $idOrder
     * @param [int] $idMachine
     * @param [int] $coffeeQuantity
     * @return void
     */
    public function updateOrder($idOrder, $idTeacher, $consoMachines)
    {
        $total = 0;
        
        foreach($consoMachines as $idMachine=>$coffeeQuantity){
            if($coffeeQuantity==""){
                $coffeeQuantity=0;
            }
            //check if exist in t_include
            
            $check = $this->existsInclude($idOrder, $idMachine);
            
            if($check){
                $this->updateInclude($idOrder, $idMachine, $coffeeQuantity);
                //récupère le prix du café au moment de la commande
                $coffeePrice = $this->getOrderCoffeePrice($idOrder, $idMachine);
            }
            else{
                //recupère le prix du café de la machine (actuel)
                $coffeePrice = $this->getOneCoffeePrice($idMachine);
                //ajoute dans t_include
                $this->addInclude($idMachine, $idOrder, $coffeeQuantity, $coffeePrice[0]['typCoffeePrice']);
            } 
            $total += $coffeeQuantity * $coffeePrice[0]['incCoffeePrice']; 
        }//fin foreach

        //récupère le nombre de semaines de l'enseignant
        $nbWeek = $this->getTeacherNbWeek($idTeacher);
        //calcul du montant (montant café de la semaine * nombre de semaines de travail)
        $total = $total*$nbWeek[0]['teaNbWeek'];

        //met a jour le montant de la commande
        $this->updateOrderTotal($total, $idOrder);

    }

    /**
     * met a jour la table t_include
     *
     * @param [type] $idOrder
     * @param [type] $idMachine
     * @param [type] $coffeeQuantity
     * @return array
     */
    private function updateInclude($idOrder, $idMachine, $coffeeQuantity)
    {
        $query="UPDATE `t_include` SET `incCoffeeQuantity` = :coffeeQuantity WHERE `t_include`.`fkMachine` = :idMachine AND `t_include`.`fkOrder` = :idOrder; ";
            $binds=array(
                0=>array(
                    'var'=>$idOrder,
                    'marker'=>':idOrder',
                    'type'=>PDO::PARAM_STR
                ),
                1=>array(
                    'var'=>$idMachine,
                    'marker'=>':idMachine',
                    'type'=>PDO::PARAM_STR
                ),
                2=>array(
                    'var'=>$coffeeQuantity,
                    'marker'=>':coffeeQuantity',
                    'type'=>PDO::PARAM_STR
                )
            );
        $this->queryPrepareExecute($query, $binds); 
        
    }

    /**
     * recupère le prix du café de la commande (au cas ou le prix aurait changé entre temps, qu'il ne s'applique pas.)
     *
     * @param [int] $idOrder
     * @param [int] $idMachine
     * @return array
     */
    private function getOrderCoffeePrice($idOrder, $idMachine)
    {
        $query="SELECT `incCoffeePrice` FROM `t_include` WHERE `fkMachine` = :idMachine AND `fkOrder` = :idOrder";
        $binds=array(
            0=>array(
                'var'=>$idOrder,
                'marker'=>':idOrder',
                'type'=>PDO::PARAM_STR
            ),
            1=>array(
                'var'=>$idMachine,
                'marker'=>':idMachine',
                'type'=>PDO::PARAM_STR
            )
        );
        $result= $this->queryPrepareExecute($query, $binds);
        return $result;
    }

    /**
     * Undocumented function
     *
     * @param [type] $total
     * @param [type] $idOrder
     * @return void
     */
    private function updateOrderTotal($total, $idOrder)
    {
        $query="UPDATE `t_order` SET `ordTotal` = :total WHERE `t_order`.`idOrder` = :idOrder; ";
            $binds=array(
                0=>array(
                    'var'=>$total,
                    'marker'=>':total',
                    'type'=>PDO::PARAM_STR
                ),
                1=>array(
                    'var'=>$idOrder,
                    'marker'=>':idOrder',
                    'type'=>PDO::PARAM_STR
                )
            );
            $result= $this->queryPrepareExecute($query, $binds);
    }

    private function getTeacherNbWeek($idTeacher)
    {
        $query="SELECT `teaNbWeek` FROM `t_teacher` WHERE `idTeacher` like :idTeacher";
        $binds=array(
            0=>array(
                'var'=>$idTeacher,
                'marker'=>':idTeacher',
                'type'=>PDO::PARAM_STR
            )
        );
        $result= $this->queryPrepareExecute($query, $binds);
        return $result;
    }

    /**
     * récupère le prix du café d'une machine à café
     *
     * @param [int] $idMachine
     * @return array
     */
    private function getOneCoffeePrice($idMachine)
    {
        $query="SELECT `typCoffeePrice` FROM `t_typemachine` INNER JOIN t_machine ON t_machine.fkTypeMachine = `idTypeMachine` WHERE t_machine.idMachine LIKE :idMachine ";
        $binds=array(
            0=>array(
                'var'=>$idMachine,
                'marker'=>':idMachine',
                'type'=>PDO::PARAM_STR
            )
        );
        $result= $this->queryPrepareExecute($query, $binds);
        return $result;
    }
    
    /**
     * verifie si un enregistrement existe avec les memes id
     *
     * @param [int] $idOrder
     * @param [int] $idMachine
     * @return array
     */
    private function existsInclude($idOrder, $idMachine)
    {
        $query="SELECT `fkOrder` FROM `t_include` WHERE `fkOrder` LIKE :idOrder and `fkMachine` LIKE :idMachine ";
        $binds=array(
            0=>array(
                'var'=>$idOrder,
                'marker'=>':idOrder',
                'type'=>PDO::PARAM_STR
            ),
            1=>array(
                'var'=>$idMachine,
                'marker'=>':idMachine',
                'type'=>PDO::PARAM_STR
            )
        );
        $result= $this->queryPrepareExecute($query, $binds);
        return $result;
    }
}


?>