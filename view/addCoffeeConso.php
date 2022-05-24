<!-- ajouter un nav avec prenom nom +  bouton déconnexion --> 
<!-- 
    auteur : Elisa Kuoch
    date : 19.05.2022
    description : formulaire d'ajout de la consommation de café
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

<!-- si admin : bouton retour vers admin home -->
    <h3>Ajout de la consommation de café <?=$years['year1'] . '-'. $years['year2']?></h3>
    <div class="">
        <form action="?coffee=addConso" method="POST">
            <div class="d-flex align-items-center justify-content-center ">
                <div>
                    <?php
                    foreach ($locations as $location) {
                        ?>
                        <h4 class="mt-4"><?=$location['locName']?></h4>
                        <table class="table"> 
                            <thead>
                                <tr>
                                    <th scope="col-6">Nom de la machine</th>
                                    <th class="col" scope="col">Type</th>
                                    <th class="col" scope="col">Prix du café</th>
                                    <th class="col-4" scope="col">Cafés par semaine</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($machines[$location['idLocation']] as $machine) { 
                                ?>  
                                <tr>
                                    <th scope="row"><?=$machine['macName']?></th>
                                    <td><?=$machine['macType']?></td>
                                    <td><?=$machine['macCoffeePrice']?> CHF</td>
                                    <td><input class="form-control" type="number" value="0" name="<?=$machine['idMachine']?>" min = 0 max=100></td>
                                </tr> 
                            <?php
                                }//fin foreach $machines
                            ?>
                            </tbody>  
                        </table>
                        <?php
                    }//fin foreach $locations
                    ?>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="submit">Valider</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
