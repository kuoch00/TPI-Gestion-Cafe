<!-- 
    auteur : Elisa Kuoch
    date : 19.05.2022
    description : formulaire d'ajout de la consommation de café
 -->
<?php //bouton retour seulement pour admin
    if($_SESSION['connected'] && $_SESSION['connected']=='admin'){?>
        <a href="?admin=home" role="button">
            <i class="fa-solid fa-arrow-left"></i>
            Retour
        </a><?php
    }
?>

<div class="col">
    <h3 class="mt-4">Ajout de la consommation de café <?=$years['year1'] . '-'. $years['year2']?></h3>
    <div>
        <form action="?coffee=addConso" method="POST">
            <div class="d-flex">
                <div>
                    <?php
                    foreach ($locations as $location) {
                        if(!empty($machines[$location['idLocation']])){ //affiche pas si aucune machine dans le lieu ?>  
                        
                        <h4 class="mt-4"><?=$location['locName']?></h4>
                        <table class="table table-hover"> 
                            <thead>
                                <tr>
                                    <th class="align-middle">Nom de la machine</th>
                                    <th class="align-middle">Type</th>
                                    <th class="align-middle">Prix du café</th>
                                    <th class="align-middle col-3">Cafés par semaine</th>
                                    <th class="align-middle text-break">Nb cafés année passée</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($machines[$location['idLocation']] as $machine) { 
                                ?>  
                                <tr>
                                    <th class="text-break" scope="row"><?=$machine['macName']?></th>
                                    <td><?=$machine['macType']?></td>
                                    <td> <div class="d-flex"> <?=$machine['macCoffeePrice']?><div class="d-none d-sm-block ms-1"> CHF</div> </div></td>
                                    <td><input class="form-control" type="number" value="0" name="<?=$machine['idMachine']?>" min = 0 max=100></td>
                                    <?php
                                    $entered=false;
                                    foreach($lastConso as $conso){
                                        if($conso['macName']==$machine['macName']){?>
                                            <td><?=$conso['incCoffeeQuantity']?></td> <?php  
                                            $entered = true;
                                            break ;
                                        } 
                                    }
                                    if(!$entered){//si aucune information: afficher 0?>
                                        <td>0</td> <?php
                                    }
                                    ?> 
                                </tr> 
                            <?php
                                }//fin foreach $machines
                            ?>
                            </tbody>  
                        </table>
                        <?php 
                        } //fin if !empty
                    }//fin foreach $locations
                    ?>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="submit">Valider</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


