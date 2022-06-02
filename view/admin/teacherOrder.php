<?php
/**
 * auteur : Elisa Kuoch
 * date : 31.05.2022
 * description : page ou l'admin voit les informations de la commande d'un enseignant
 */
if($_SESSION['connected']=='admin'){?>
    <a href="?admin=home" role="button">
        <i class="fa-solid fa-arrow-left"></i>
        Retour
    </a><?php
}
?>

<h3 class="mt-4">Consommation <?=$years['year1'] . '-'. $years['year2']?></h3>
<h4 class="mt-4"><?=$teacherOrder[0]['teaFirstname']?> <?=$teacherOrder[0]['teaLastname']?></h4>

<div class="col col-md-6">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="col-6">Nom de la machine</th>
                <th>Cafés par semaine</th> 
            </tr>
        </thead>
        <tbody>
        <?php 
        foreach($consoList as $conso){?>
            <tr>
                <th><?=$conso['macName']?></th>
                <td><?=$conso['incCoffeeQuantity']?></td> 
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>   
</div> 
<div class="col col-md-6 mt-5">
    <table class="table table-hover">
    <tr>
        <th class="col-6">Montant</th>
        <td><?=$teacherOrder[0]['ordTotal']?></td>
    </tr>
    <tr>
        <th>Montant payé</th>
        <td><?=$teacherOrder[0]['ordTotalPaid'] ? $teacherOrder[0]['ordTotalPaid'] : '0.00'?></td>
    </tr>
    <tr>
        <th>Date de paiement</th>
        <td><?=$teacherOrder[0]['ordPaymentDate'] ? $teacherOrder[0]['ordPaymentDate'] : '-'?></td>
    </tr>
    </table>
</div>
<!-- afficher nb cafés sur les machines ? -->

