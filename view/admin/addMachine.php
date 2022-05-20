<div>
    <a href="?admin=home" role="button">Retour</a>
    <h3>Ajouter une machine à café</h3>
    <form action="?admin=addMachine" method="POST">
        <label for="nom">Nom de la machine</label>
        <input type="text" name="nom">

        <label for="type">Type de café</label>
        <input type="text" name="type">
        <!-- affiche liste type existants (datalist de bootstrap) -->
        
        <!-- disable celui ci ? faire un checkbox indiquant si new coffee type (unchecked=disable)? -->
        <label for="prix">Prix du café</label>
        <input type="number" name="prix">

        <label for="emplacement">Emplacement</label>
        <input type="text" name="emplacement">
        <!-- affiche liste lieux existants (datalist de bootstrap) -->

        <button type="submit">Ajouter</button>
    </form>
</div>