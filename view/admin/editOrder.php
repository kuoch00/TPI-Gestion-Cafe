<a href="?admin=home" role="button">
    <i class="fa-solid fa-arrow-left"></i>
    Retour
</a>
<h3 class="mt-4">Modification de la commande</h3>
<h4 class="mt-4"><?=$teacherOrder[0]['teaFirstname']?> <?=$teacherOrder[0]['teaLastname']?></h4>
<div class="col col-md-6">
<form action="?admin=editOrder&idOrder=<?=$_GET['idOrder']?>&idTeacher=<?=$_GET['idTeacher']?>" method="POST">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nom de la machine</th>
                <th>Cafés par semaine</th>
                <th>Modification</th>
            </tr>
        </thead>
        <tbody><?php
            foreach($machines as $machine){?>
                <tr>
                    <th><?=$machine['macName']?></th><?php
                    $entered= false;
                foreach($consoList as $conso){
                    if($machine['macName'] == $conso['macName']){?>
                        <td><?=$conso['incCoffeeQuantity']?></td><?php 
                        $entered = true;
                        break;
                    }
                }
                if(!$entered){//affiche 0 si pas trouvé dans consoList?>
                    <td>0</td><?php 
                }
                ?>
                <td><input value="<?=$conso['incCoffeeQuantity'] ? $conso['incCoffeeQuantity'] : 0?>" onfocus="this.value=''" name="<?=$machine['idMachine']?>" class="form-control" type="number" min = 0 max = 99></td>
                </tr><?php
            }?> 
        </tbody>
    </table>    
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-primary" type="submit"">Modifier</button>
    </div>
</form>
</div>