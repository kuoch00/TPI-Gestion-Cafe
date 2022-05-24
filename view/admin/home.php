<div> 
    <h3>Admin</h3>
    <!-- alerte si commande pas ajoutée ? --> 
    <?php
        if(isset($machineAdded) && $machineAdded){?>
            <p>machine correctement ajoutée</p><?php
        }
    ?>

        <?php
        if(isset($hasOrdered) && $hasOrdered){?>
            <a href="?coffee=view" role="button">Voir ma consommation de café</a><?php
        }
        else{?>
            <a href="?coffee=add" role="button">Ajouter ma consommation de café</a><?php
        }
        ?>
    

    <h3>Machines a café</h3>
    <a href="?admin=addMachineForm">Ajouter une machine à café</a>
    <a href="?admin=updateCoffeePriceForm" role="button">Modifier le prix du café</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Type</th>
                <th>Lieu</th>
                <th>Prix du café</th>
            </tr>
        </thead>
        <tbody><?php 
            foreach($machines as $machine){?>
                <tr>
                    <th><?=$machine['idMachine']?></th>
                    <td><?=$machine['macName']?></td>
                    <td><?=$machine['macType']?></td>
                    <td><?=$machine['macLocation']?></td>
                    <td><?=$machine['macCoffeePrice']?></td>
                </tr><?php 
            }?> 
        </tbody>
    </table>

    <h3>Liste des consommations de café <?=$years['year1'] . '-'. $years['year2']?></h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Montant</th>
                <th>Montant payé</th>
                <th>Date de paiement</th>
                <th>Ajouter un paiement</th> 
            </tr>
        </thead>
        <tbody><?php
            foreach($teachers as $teacher){?>
            <tr>
                <th><?=$teacher['fkTeacher']?></th>
                <td><?=$teacher['teaFirstname']?></td>
                <td><?=$teacher['teaLastname']?></td>
                <td><?=$teacher['ordTotal']?></td>
                <td><?=$teacher['ordTotalPaid'] ? $teacher['ordTotalPaid'] : '-'?></td>
                <td><?=$teacher['ordPaymentDate'] ? $teacher['ordPaymentDate'] : '-'?></td> 
                <?php
                if(!$teacher['ordPaymentDate'] && !$teacher['ordTotalPaid']){?>
                    <td><a href="?admin=updatePaymentForm&id=<?=$teacher['idOrder']?>"><i sclass="fa-solid fa-pen">a</i></a></td><?php
                }
                else{
                    //class disabled de bootstrap + classe pour make icon look disable?> 
                    <td><a><i sclass="fa-solid fa-pen">a</i></a></td><?php
                }
                ?> 
            </tr><?php
            }?> 

        </tbody> 
    </table>
    <?php
    
    ?>
</div>