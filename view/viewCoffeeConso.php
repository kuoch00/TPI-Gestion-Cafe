<!-- 
    auteur : Elisa Kuoch
    date : 20.05.2022
    description : page où l'utilisateur va pouvoir voir le bilan de sa commande 
 --> 
<?php
 if(!$_SESSION['connected']){
    header('Location: ?login');
 }
 else{
     if($_SESSION['connected']=='admin'){?>
         <a href="?admin=home" role="button">Retour</a><?php
     }
 }
 ?>

<h3>Bilan de la consommation de café <?=$years['year1'] . '-'. $years['year2']?></h3>
<div class="col-xl-5"><?php
    foreach($locations as $location){ ?> 
        <h4 class="mt-4"><?=$location['locName']?></h4>
        <table class="table">
            <thead>
                <th>Nom de la machine</th>
                <th>Nombre de cafés par semaine</th>
            </thead>
            <tbody>
                <?php  
                //affiche toutes les machines d'un lieu
                foreach($machines[$location['idLocation']] as $machine){  ?>
                    <tr>  
                        <th><?=$machine['macName']?></th><?php
                        foreach($coffeeQuantity as $coffee){  
                            //nb café indiqué
                            if($coffee['fkMachine'] == $machine['idMachine'] && $coffee['incCoffeeQuantity']!=""){ ?>   
                                <td><?=$coffee['incCoffeeQuantity']?></td> <?php
                                break;
                            }
                        } ?>
                    </tr> <?php
                }?>
            </tbody>
        </table> <?php  
    }//fin du foreach ?>
    <h4>Total : <?=$total?> CHF</h4>
    <p>Statut : <?=$status?></p>
</div>

