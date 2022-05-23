<div>
    <a href="?admin=home" role="button">Retour</a>
    <h3>Ajouter une machine à café</h3>
    <form action="?admin=addMachine" method="POST">
        <label for="nom">Nom de la machine</label>
        <input type="text" name="nom" required>

        <label for="type">Type de machine à café</label>
        <input type="text" name="type" list="machineTypes">
        <datalist id="machineTypes" required>
            <?php
            foreach($machines as $machine){
                ?>
                <option value="<?=$machine['macType']?>"></option>
                <?php
            }
            ?>
        </datalist>

        <!-- affiche liste type existants (datalist) -->
        <p>ne pas remplir si le type de machine existe !</p>
        <label for="prix">Prix du café</label>
        <input placeholder="0" type="number" name="prix" min="0" max="99.99" step="0.01">

        <label for="emplacement">Emplacement</label>
        <!-- <input type="text" name="emplacement" list="machineLocations"> -->
        <select name="location" id="machineLocations" required><?php
            foreach($machines as $machine){
                ?>
                <option value="<?=$machine['macLocation']?>"><?=$machine['macLocation']?></option>
                <?php
            }?>
        </select>

        <button type="submit">Ajouter</button>
    </form>
</div>