<div>
<a href="?admin=home" role="button">Retour</a>
    <h3>Ajout du montant recu</h3>
    <form action="?admin=updatePayment&id=<?=$order[0]['idOrder']?>" method="POST">
    <div>
        <h4><?=$order[0]['teaFirstname'] . " " . $order[0]['teaLastname']?></h4>
        
        <label for="montant">Montant dû : </label>
        <p><?=$order[0]['ordTotal']?>CHF</p>

        <label for="montant">Montant reçu : </label>
        <input type="number" name="amount" value="<?=$order[0]['ordTotal']?>" min="<?=$order[0]['ordTotal']?>" step=".01" id="" required>

        <label for="date">Date de paiement</label>
        
        <input type="date" value="<?=$date?>" name="paymentDate" id="paymentDate" min="<?=$order[0]['ordDate']?>" max="<?=$date?>" required>
    
        <button type="submit">Valider</button>
    </div>

    </form>
</div>