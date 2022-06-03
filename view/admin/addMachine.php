<div>
    <a href="?admin=home" role="button">
        <i class="fa-solid fa-arrow-left"></i>
        Retour 
    </a>
    <h3 class="mt-4">Ajouter une machine à café</h3>
    <form  action="?admin=addMachine" method="POST">
        <div class="d-flex ">
            <div class="col-lg-8">
                <div class="row my-2">
                    <div class="col">
                        <label for="nom">Nom de la machine</label>
                    </div>
                    <div class="col">
                        <input class="form-control" type="text" id="nom" name="nom" required>
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col">
                        <label for="type">Type de machine à café</label>
                    </div>
                    <div class="col">
                        <input class="form-control" type="text" id="type" name="type" list="machineTypes" required>
                    </div>
                    <datalist id="machineTypes">
                        <?php
                        foreach($machines as $machine){
                            ?>
                            <option value="<?=$machine['macType']?>"></option>
                            <?php
                        }
                        ?>
                    </datalist>
                </div> 
                <div class="row my-2"> 
                    <div class="col"> 
                        <div class="row">
                            <div class="col-4">
                                <label for="prix">Prix du café</label>
                            </div>
                            <div class="col">
                                <p class="form-text my-0">ne pas remplir si le type de machine existe !</p>
                            </div> 
                        </div> 
                    </div>
                    <div class="col">
                        <input class="form-control" value="0" type="number" id="prix" name="prix" min="0" max="99.95" step="0.05">
                    </div> 
                </div> 
                <div class="row my-2">
                    <div class="col">
                        <label for="emplacement">Emplacement</label>
                    </div> 
                    <div class="col"> 
                        <select class="form-select" name="location" id="emplacement" required>
                        
                        <option value="" selected disabled>Choose</option>
                        <?php 
                        
                        foreach($locations as $location){?> 
                            <option value="<?=$location['locName']?>"><?=$location['locName']?></option><?php
                        }?>
                        </select> 
                    </div> 
                </div> 
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary" type="submit">Valider</button>
                </div>
            </div>
        </div>
    </form>
</div>