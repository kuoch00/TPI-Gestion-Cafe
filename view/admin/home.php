<div> 
    <h3>Admin</h3>
    <!-- alerte si commande pas ajoutée ? -->
    <a href="?coffee=add" role="button">Ajouter ma consommation de café</a>
    <a href="?coffee=view" role="button">Voir ma consommation de café</a>

    <h3>Machines a café</h3>
    <a href="?admin=addMachineForm">Ajouter une machine à café</a>
    <a href="?admin=updateCoffeePriceForm" role="button">Modifier le prix du café</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Type</th>
                <th>Lieu</th>
                <th>Prix du café</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($machines as $machine){?>
                <tr>
                    <th><?=$machine['idMachine']?></th>
                    <td><?=$machine['macName']?></td>
                    <td><?=$machine['macType']?></td>
                    <td><?=$machine['macLocation']?></td>
                    <td><?=$machine['macCoffeePrice']?></td>
                </tr> 
            <?php
            }
            ?>
        </tbody>

    </table>

    <h3>Liste des consommations de café 2022-2023</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Montant</th>
                <th>Montant payé</th>
                <th>Date de paiement</th>
                <th>Ajouter un paiement</th> 
            </tr>
        </thead>
        <tbody><?php
            foreach($teachers as $teacher){?>
            <tr>
                <th><?=$teacher['fkTeacher']?></th>
                <td><?=$teacher['teaFirstname']?></td>
                <td><?=$teacher['teaLastname']?></td>
                <td><?=$teacher['ordTotal']?></td>
                <td><?=$teacher['ordTotalPaid']?></td>
                <td><?=$teacher['ordPaymentDate']?></td> 
                <td><a href="?admin=updatePaymentForm"><i class="fa-solid fa-pen">a</i></a></td>
            </tr><?php
            }?> 
        </tbody> 
    </table>
</div>