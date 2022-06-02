<div>
    <!-- 
        auteur :  Elisa Kuoch
        date : 20.05.2022
        description : Page ajout d'un paiement recu
     -->
<a href="?admin=home" role="button">
    <i class="fa-solid fa-arrow-left"></i>
    Retour
</a>
    <h3 class="mt-4">Ajout du montant recu</h3>
    <div class="d-flex col-lg-6">
    <form action="?admin=updatePayment&idOrder=<?=$order[0]['idOrder']?>" method="POST">
        <div class="row">
            <h4 class="mt-4"><?=$order[0]['teaFirstname'] . " " . $order[0]['teaLastname']?></h4>
            
            <div class="row mt-2">
                <div class="col d-flex align-items-center">
                    <label class="form-label" for="montant">Montant dû : </label>
                </div>
                <div class="col ">
                    <p class="mb-0"><?=$order[0]['ordTotal']?> CHF</p>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col d-flex align-items-center">
                    <label class="form-label" for="montant">Montant reçu : </label>
                </div>
                <div class="col">
                    <input class="form-control" type="number" name="amount" value="<?=$order[0]['ordTotal']?>" min="<?=$order[0]['ordTotal']?>" step=".01" id="" required>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col d-flex align-items-center">
                    <label class="form-label" for="date">Date de paiement</label>
                </div>
                <div class="col">
                    <input class="form-control" type="date" value="<?=$date?>" name="paymentDate" id="paymentDate" min="<?=$order[0]['ordDate']?>" max="<?=$date?>" required>
                </div>
            </div>
            <div class="row">
                <div class=" d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                    <button class="btn btn-primary" type="submit">Valider</button>
                </div>
            </div>
            
        </div>
    </form>
    </div>
</div>