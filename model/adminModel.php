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

    public function addMachine($name, $location, $type)
    {
        //INSERT INTO `t_machine` (`idMachine`, `macName`, `fkLocation`, `fkTypeMachine`) VALUES (NULL, 'a', '1', '2') 
        $query="INSERT INTO t_machine SET macName=:name, fkLocation=:location, fkType=:type";
        
    }
}


?>