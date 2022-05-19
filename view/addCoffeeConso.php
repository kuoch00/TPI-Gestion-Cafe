<!-- nav -->
    <!-- prenom nom +  bouton déconnexion -->

<div>
    <form action="?coffee=addOrder" method="POST">
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
            }//fin foreach $location
        ?>
        <button type="submit">Valider</button>
    </form>
</div>