<div>
    <a href="?admin=home" role="button">
        <i class="fa-solid fa-arrow-left"></i>
        Retour 
    </a>
    <h3 class="mt-4">Changer le prix du café</h3>
    <div class="d-flex col-lg-6">
        <form action="?admin=updateCoffeePrice" method="POST">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="col">ID</th>
                    <th class="col-4">Nom du type</th>
                    <th class="col">Nouveau prix du café à l'unité</th>
                    <th class="col">Prix du café à l'unité</th>
                </tr>
            </thead>
            <tbody><?php 
                foreach($types as $type){?> 
                    <tr>
                        <th><?=$type['idTypeMachine']?></th>
                        <td><?=$type['typName']?></td>
                        <td><input class="form-control"  type="number" value="<?=$type['typCoffeePrice']?>" name="<?=$type['idTypeMachine']?>" min="0" max="99.99" step="0.01"></td>
                        <td><?=$type['typCoffeePrice']?></td>
                    </tr> <?php 
                }?>
            </tbody>
        </table>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-primary" type="submit"  onclick="confirmUpdate()">Sauvegarder</button>
        </div>
        </form>
    </div>
</div>