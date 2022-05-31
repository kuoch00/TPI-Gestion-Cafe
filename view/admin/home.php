<div> 
    <h3>Admin</h3>
    <!-- alerte si commande pas ajoutée ? --> 
    <?php 
        if(isset($hasOrdered) && $hasOrdered){?>
            <a href="?coffee=view" role="button" class="btn btn-primary">Voir ma consommation de café</a><?php
        }
        else{?>
            <a href="?coffee=add" role="button" class="btn btn-primary">Ajouter ma consommation de café</a><?php
        }?>  
    <h3 class="mt-5">Liste des machines à café</h3>
    <a href="?admin=addMachineForm" class="btn btn-primary my-1">Ajouter une machine à café</a>
    <a href="?admin=updateCoffeePriceForm" role="button" class="btn btn-primary my-1">Modifier le prix du café</a>
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
                        <td><?=$machine['macName']?></td>
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
    
    <div class="d-none d-sm-block"> 
        <table class="table table-hover"> 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th d-none d-sm-block>Montant</th>
                    <th d-none d-sm-block>Montant payé</th>
                    <th d-none d-sm-block>Date de paiement</th>
                    
                    <th>Ajouter un paiement</th> 
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
    </div>
    
    <!-- table pour petits écrans -->
    <div class="d-block d-sm-none"> 
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Paiement</th> 
                </tr>
            </thead>
            <tbody><?php 
            foreach($teachers as $teacher){?>
                <tr>
                    <th><?=$teacher['fkTeacher']?></th>
                    <td><?=$teacher['teaFirstname']?></td>
                    <td><?=$teacher['teaLastname']?></td>
                    <?php
                        if(!$teacher['ordPaymentDate'] && !$teacher['ordTotalPaid']){?>
                            <td class="text-center row"><a role="button" class="btn btn-primary" href="?admin=updatePaymentForm&id=<?=$teacher['idOrder']?>">Ajouter</a></td><?php
                        }
                        else{
                            //class disabled de bootstrap + classe pour make icon look disable?> 
                            <td class="text-center row"><a role="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">Voir infos</a></td>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?=$teacher['teaFirstname'] .  ' ' . $teacher['teaLastname']?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">  
                                        Montant : <?=$teacher['ordTotal']?> CHF<br>
                                        Montant payé : <?=$teacher['ordTotalPaid']?> CHF<br>
                                        Date de paiement : <?=$teacher['ordPaymentDate']?>
                                    </div>
                                    <div class="modal-footer"> 
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    ?> 
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
    
    ?>
</div>