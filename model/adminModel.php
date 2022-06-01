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
    public function getOrder($id)
    {
        $query="SELECT `idOrder`,`ordTotal`,ordDate ,`fkTeacher`,t_teacher.teaFirstname, t_teacher.teaLastname FROM `t_order`
        INNER JOIN t_teacher ON t_teacher.idTeacher = t_order.fkTeacher
        WHERE `idOrder`=:id";
        $binds=array(
            0=>array(
                'var'=>$id,
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
    private function getTypeId($type)
    {
        $query="SELECT idTypeMachine FROM t_typemachine WHERE typName=:type";
        $binds=array(
            0=>array(
                'var'=>$type,
                'marker'=>':type',
                'type'=>PDO::PARAM_STR 
            )
        );
        $result = $this->queryPrepareExecute($query, $binds);
        return $result;

    }

    /**
     * ajout nouveau type de machine à café
     *
     * @param [string] $name
     * @param [type] $price
     * @return void
     */
    private function addType($name, $price)
    {
        $query="INSERT INTO t_typemachine SET typCoffeePrice=:price, typName=:name";
        $binds=array(
            0=>array(
                'var'=>$price,
                'marker'=>':price',
                'type'=>PDO::PARAM_STR
            ),
            1=>array(
                'var'=>$name,
                'marker'=>':name',
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
     * @param [type] $prices
     * @return void
     */
    public function updateCoffeePrices($prices)
    {
        foreach ($prices as $id=>$price){
            $query = "UPDATE t_typemachine SET typCoffeePrice = :price WHERE t_typemachine.idTypeMachine = :id ";
            $binds=array(
                0=>array(
                    'var'=> $id,
                    'marker'=>':id',
                    'type'=>PDO::PARAM_STR
                ),
                1=>array(
                    'var'=>$price,
                    'marker'=>':price',
                    'type'=>PDO::PARAM_STR
                )
            );
            $result = $this->queryPrepareExecute($query, $binds); 
        }
       
    }

    /**
     * ajout du paiement dans la base de données
     *
     * @param [int] $id
     * @param [decimal] $amount
     * @param [date] $date
     * @return void
     */
    public function addPayment($id, $amount, $date)
    {
        $query="UPDATE `t_order` SET `ordPaymentDate` = :date , `ordTotalPaid` = :amount WHERE `t_order`.`idOrder` = :id";
        $binds=array(
            0=>array(
                'var'=>$id,
                'marker'=>':id',
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

    public function getTeacherOrder($idTeacher)
    {
        $years = $this->calcCurrentSchoolYear(date('m'));
        $date1 = $years['year1'] . "-08-01";
        $date2 = $years['year2'] . "-07-31";

        $query="SELECT fkTeacher, t_teacher.teaFirstname, t_teacher.teaLastname, ordTotal, ordTotalPaid, ordPaymentDate, idOrder FROM t_order
        INNER JOIN t_teacher on t_teacher.idTeacher = t_order.fkTeacher
        WHERE fkTeacher LIKE :id AND ordDate BETWEEN :date1 AND :date2";

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
                'marker'=>':id',
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
        $query="SELECT `fkMachine`, t_machine.macName,`incCoffeeQuantity` FROM `t_include` INNER JOIN t_machine On t_machine.idMachine = fkMachine WHERE `fkOrder` LIKE :id ";
        
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
     * met a jour la commande avec les nouvelles quantités et le nouveau montant
     *
     * @param [type] $idOrder
     * @param [type] $idMachine
     * @param [type] $coffeeQuantity
     * @return void
     */
    public function updateOrder($idOrder, $idTeacher, $consoMachines)
    {
        $total = 0;
        //$machines = $this->getMachines();
        //update in t_include
        foreach($consoMachines as $idMachine=>$coffeeQuantity){
            if($coffeeQuantity==""){
                $coffeeQuantity=0;
            }
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


            $coffeePrice = $this->getOrderCoffeePrice($idOrder, $idMachine);
            $total += $coffeeQuantity * $coffeePrice[0]['incCoffeePrice'];
            // echo $total;
        }

        //get teacher and nb week
        $nbWeek = $this->getTeacherNbWeek($idTeacher);
        //calc total
        $total = $total*$nbWeek[0]['teaNbWeek'];
        // die($total);
        

        //update order now
            //calc new total puis update
            $this->updateOrderTotal($total, $idOrder);

            
            
        
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

    
}


?>