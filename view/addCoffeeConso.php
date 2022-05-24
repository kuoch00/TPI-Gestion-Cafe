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
<div>
    <form action="?coffee=addConso" method="POST">
        <?php
            foreach ($locations as $location) {
                ?>
                <h3><?=$location['locName']?></h3>
                <table> 
                    <thead>
                        <tr>
                            <th scope="col">Nom de la machine</th>
                            <th scope="col">Type</th>
                            <th scope="col">Prix du café</th>
                            <th scope="col">Nb de cafés par semaine</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($machines[$location['idLocation']] as $machine) { 
                        ?>  
                        <tr>
                            <th scope="row"><?=$machine['macName']?></th>
                            <td><?=$machine['macType']?></td>
                            <td><?=$machine['macCoffeePrice']?></td>
                            <td><input type="number" name="<?=$machine['idMachine']?>"></td>
                        </tr> 
                    <?php
                        }//fin foreach $machines
                    ?>
                    </tbody>  
                </table>
                <?php
            }//fin foreach $locations
        ?>
        <button type="submit">Valider</button>
    </form>
</div>
