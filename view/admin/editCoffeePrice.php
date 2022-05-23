<div>
    <a href="?admin=home" role="button">Retour</a>
    <h3>Changer le prix du café</h3>
    <form action="?admin=updateCoffeePrice" method="POST">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom du type</th>
                <th>Nouveau prix du café à l'unité</th>
                <th>Prix du café à l'unité</th>
            </tr>
        </thead>
        <tbody><?php 
            foreach($types as $type){?> 
                <tr>
                    <th><?=$type['idTypeMachine']?></th>
                    <td><?=$type['typName']?></td>
                    <td><input type="number" value="<?=$type['typCoffeePrice']?>" name="<?=$type['idTypeMachine']?>" min="0" max="99.99" step="0.01"></td>
                    <td><?=$type['typCoffeePrice']?></td>
                </tr> <?php 
            }?>
        </tbody>
    </table>
    <button type="submit">Confirmer</button>
    </form>
</div>