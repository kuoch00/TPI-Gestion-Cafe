<div>
<a href="?admin=home" role="button">
    <i class="fa-solid fa-arrow-left"></i>
    Retour
</a>
    <h3>Ajout du montant recu</h3>
    <div class="d-flex align-items-center justify-content-center ">
    <form action="?admin=updatePayment&id=<?=$order[0]['idOrder']?>" method="POST">
        <div>
            <h4><?=$order[0]['teaFirstname'] . " " . $order[0]['teaLastname']?></h4>
            
            <div class="row">
                <div class="col">
                    <label class="form-label" for="montant">Montant dû : </label>
                </div>
                <div class="col">
                    <p><?=$order[0]['ordTotal']?> CHF</p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label" for="montant">Montant reçu : </label>
                </div>
                <div class="col">
                    <input class="form-control" type="number" name="amount" value="<?=$order[0]['ordTotal']?>" min="<?=$order[0]['ordTotal']?>" step=".01" id="" required>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label" for="date">Date de paiement</label>
                </div>
                <div class="col">
                    <input class="form-control" type="date" value="<?=$date?>" name="paymentDate" id="paymentDate" min="<?=$order[0]['ordDate']?>" max="<?=$date?>" required>
                </div>
            </div>
        
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-primary" type="submit">Valider</button>
            </div>
        </div>
    </form>
    </div>
</div>