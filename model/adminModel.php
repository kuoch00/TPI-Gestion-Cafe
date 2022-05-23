<?php
//TODO : Dates de query à modifier !!
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
        $query="SELECT `fkTeacher`, t_teacher.teaFirstname, t_teacher.teaLastname, `ordTotal`,`ordTotalPaid`,`ordPaymentDate` FROM `t_order` 
        INNER JOIN t_teacher on t_teacher.idTeacher = t_order.fkTeacher
        WHERE `ordDate` BETWEEN '2022-01-01' AND '2022-07-31'";
        $result=$this->querySimpleExecute($query);
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
}


?>