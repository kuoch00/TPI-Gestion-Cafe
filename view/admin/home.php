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
            <a href="?coffee=view" role="button" class="btn btn-primary">Voir ma consommation de café</a><?php
        }
        else{?>
            <a href="?coffee=add" role="button" class="btn btn-primary">Ajouter ma consommation de café</a><?php
        }
        ?>
    

    <h3 class="mt-4">Machines a café</h3>
    <a href="?admin=addMachineForm" class="btn btn-primary">Ajouter une machine à café</a>
    <a href="?admin=updateCoffeePriceForm" role="button" class="btn btn-primary">Modifier le prix du café</a>
    <div class="col-lg-6">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Lieu</th>
                    <th class="col-lg-3">Prix du café</th>
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
    </div>
    <h3 class="mt-4">Liste des consommations de café <?=$years['year1'] . '-'. $years['year2']?></h3>
    <table class="table">
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
                    <td><a href="?admin=updatePaymentForm&id=<?=$teacher['idOrder']?>"><i class="fa-solid fa-pen fa"></i></a></td><?php
                }
                else{
                    //class disabled de bootstrap + classe pour make icon look disable?> 
                    <td><a><i class="fa-solid fa-pen fa-disabled"></i></a></td><?php
                }
                ?> 
            </tr><?php
            }?> 

        </tbody> 
    </table>
    <?php
    
    ?>
</div>