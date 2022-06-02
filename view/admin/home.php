<div> 
    <h3>Espace admin</h3>
    <!-- alerte si commande pas ajoutée ? --> 
    <?php 
        if(isset($hasOrdered) && $hasOrdered){?>
            <a href="?coffee=view" role="button" class="btn btn-primary col-12 col-sm-auto">Voir ma consommation de café</a><?php
        }
        else{?>
            <a href="?coffee=add" role="button" class="btn btn-primary col-12 col-sm-auto">Ajouter ma consommation de café</a><?php
        }?>  
        
    <h3 class="mt-5">Liste des machines à café</h3>
    <div class="">
        <a href="?admin=addMachineForm" class="btn btn-primary my-1 me-1 col-12 col-sm-auto">Ajouter une machine à café</a>
        <a href="?admin=updateCoffeePriceForm" role="button" class="btn btn-primary my-1 col-12 col-sm-auto">Modifier le prix du café</a>
    </div>
    <div class="col-lg-6">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="col-sm-4">Nom</th>
                    <th class="col-sm-2">Type</th>
                    <th>Lieu</th>
                    <th>Prix du café</th>
                </tr>
            </thead>
            <tbody><?php 
                foreach($machines as $machine){?>
                    <tr>
                        <th><?=$machine['idMachine']?></th>
                        <td class="text-break"><?=$machine['macName']?></td>
                        <td><?=$machine['macType']?></td>
                        <td><?=$machine['macLocation']?></td>
                        <td class="text-end"><?=$machine['macCoffeePrice']?> CHF</td>
                    </tr><?php 
                }?> 
            </tbody>
        </table>
    </div>

    <h3 class="mt-5">Liste des consommations de café <?=$years['year1'] . '-'. $years['year2']?></h3>
    <!-- cache la table sur les petits ecrans -->
    
    <div class="d-none d-md-block"> 
        <table class="table table-hover"> 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th >Montant</th>
                    <th >Montant payé</th>
                    <th >Date de paiement</th>
                    <th class="col-md-3"></th> 
                </tr>
            </thead>
            <tbody><?php
                foreach($teachers as $teacher){?>
                <tr>
                    <th><?=$teacher['fkTeacher']?></th>
                    <td><?=$teacher['teaFirstname']?></td>
                    <td><?=$teacher['teaLastname']?></td>
                    
                    <td class="text-end"><?=$teacher['ordTotal']?> CHF</td>
                    <td class="text-end"><?=$teacher['ordTotalPaid'] ? $teacher['ordTotalPaid'] . " CHF" : '-'?></td>
                    <td><?=$teacher['ordPaymentDate'] ? $teacher['ordPaymentDate'] : '-'?></td> 
                    
                    <td class="text-center">
                        <a role="button" class="btn btn-primary" href="?admin=viewConso&idOrder=<?=$teacher['idOrder']?>&idTeacher=<?=$teacher['fkTeacher']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Détails"><i class="fa-solid fa-magnifying-glass"></i></a>
                        <a role="button" class="btn btn-secondary" href="?admin=updatePaymentForm&id=<?=$teacher['idOrder']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Ajouter/modifier un paiement"><i class="fa-solid fa-plus"></i></a>
                        <a role="button" class="btn btn-secondary" href="?admin=editOrderForm&idOrder=<?=$teacher['idOrder']?>&idTeacher=<?=$teacher['fkTeacher']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier la commande"><i class="fa-solid fa-pen"></i></a>
                    </td>
                </tr><?php
                }?> 

            </tbody> 
        </table>
    </div>
    
    <!-- table pour petits écrans -->
    <div class="d-block d-md-none"> 
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th></th>  
                </tr>
            </thead>
            <tbody><?php 
            foreach($teachers as $teacher){?>
                <tr>
                    <th><?=$teacher['fkTeacher']?></th> 
                    <td><?=$teacher['teaFirstname'] . ' ' . $teacher['teaLastname']?></td>
                    <td class="text-center ">
                        <div class="btn-group"> 
                            <a class="btn btn-secondary" href="?admin=viewConso&idOrder=<?=$teacher['idOrder']?>&idTeacher=<?=$teacher['fkTeacher']?>"><i class="fa-solid fa-magnifying-glass fa-sm"></i></a>
                            <a role="button" class="btn btn-secondary" href="?admin=updatePaymentForm&id=<?=$teacher['idOrder']?>"><i class="fa-solid fa-plus fa-sm"></i></a>
                            <a role="button" class="btn btn-secondary" href="?admin=editOrderForm&idOrder=<?=$teacher['idOrder']?>&idTeacher=<?=$teacher['fkTeacher']?>"><i class="fa-solid fa-pen fa-sm"></i></a>
                        </div>
                    </td> 
                </tr>  
                <!-- //not working -->
                
                
                <?php } //fin foreach
                ?>
            </tbody>
        </table>
    </div>
    <?php
    
    ?>
</div>