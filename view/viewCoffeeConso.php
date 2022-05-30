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
        <a href="?admin=home" role="button">
            <i class="fa-solid fa-arrow-left"></i>
            Retour
        </a><?php
    }
}
 ?>

<h3 class="mt-4">Bilan de la consommation de café <?=$years['year1'] . '-'. $years['year2']?></h3>

<div class="d-flex">
<div class="col col-md-8 col-lg-6"><?php
    foreach($locations as $location){ ?> 
        <h4 class="mt-4"><?=$location['locName']?></h4>
        <table class="table table-hover">
            <thead>
                <th class="col-sm-8">Nom de la machine</th>
                <th>Cafés par semaine</th>
            </thead>
            <tbody>
                <?php  
                //affiche toutes les machines d'un lieu
                
                foreach($machines[$location['idLocation']] as $machine){  
                    $valueAdded = false;
                    ?>
                    <tr>  
                        <th class="text-break"><?=$machine['macName']?></th><?php
                        //chaque quantité 
                        foreach($coffeeQuantity as $coffee){  
                            //nb café indiqué
                            if($coffee['fkMachine'] == $machine['idMachine'] && $coffee['incCoffeeQuantity']!=""){ ?>   
                                <td><?=$coffee['incCoffeeQuantity']?></td> <?php
                                $valueAdded = true;
                                break;
                            }
                            
                        } 
                        if(!$valueAdded){?>
                            <td>0</td><?php
                        }
                        ?>
                    </tr> <?php
                }?>
            </tbody>
        </table> <?php  
    }//fin du foreach ?>
    <h4>Total : <?=$total?> CHF</h4>
    <p>Statut : <?=$status?></p>
    </div>

</div>

