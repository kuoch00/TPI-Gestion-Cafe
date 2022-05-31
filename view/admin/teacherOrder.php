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

<h3 class="mt-4">Consommation <?=$years['year1'] . '-'. $years['year2']?> : <?=$teacherOrder[0]['teaFirstname']?> <?=$teacherOrder[0]['teaLastname']?></h3>
<table class="table">
<tr>
<th>Montant</th>
<td><?=$teacherOrder[0]['ordTotal']?></td>
</tr>
<tr>
<th>Montant payé</th>
<td><?=$teacherOrder[0]['ordTotalPaid'] ? $teacherOrder[0]['ordTotalPaid'] : 'Non payé'?></td>
</tr>
<tr>
<th>Date de paiement</th>
<td><?=$teacherOrder[0]['ordPaymentDate'] ? $teacherOrder[0]['ordPaymentDate'] : '-'?></td>
</tr>
</table>

<!-- afficher nb cafés sur les machines ? -->

