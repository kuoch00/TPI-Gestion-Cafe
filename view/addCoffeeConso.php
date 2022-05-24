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
         <a href="?admin=home" role="button">Retour</a><?php
     }
 }
 
 ?>

<!-- si admin : bouton retour vers admin home -->
    <h3>Ajout de la consommation de café <?=$years['year1'] . '-'. $years['year2']?></h3>
    <div class="col-xl-10">
        <form action="?coffee=addConso" method="POST">
            <?php
                foreach ($locations as $location) {
                    ?>
                    <h4 class="mt-4"><?=$location['locName']?></h4>
                    <table class="table"> 
                        <thead>
                            <tr>
                                <th scope="col">Nom de la machine</th>
                                <th class="col-3" scope="col">Type</th>
                                <th class="col-2" scope="col">Prix du café</th>
                                <th class="col-lg-2 col-md-3" scope="col">Cafés par semaine</th>
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
                                <td><input class="form-control" type="number" name="<?=$machine['idMachine']?>"></td>
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
        </form>
    </div>
