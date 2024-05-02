<div class="mesInterventions">
    <h2>Mes interventions</h2>

    <?php
        $technicianId = $util["id"];
        $interventions = getInterventionsByTechnicianId($technicianId);
        $distancesToClients = getAllDistancesToClients($technicianId);

        $interventionsPerPage = 15;
        $totalInterventions = count($interventions);
        $totalPages = ceil($totalInterventions / $interventionsPerPage);

        $currentPage = isset($_POST['page']) ? max(1, intval($_POST['page'])) : 1;
        $offset = ($currentPage - 1) * $interventionsPerPage;
        $interventions = array_slice($interventions, $offset, $interventionsPerPage);

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"])) {
            updateIntervention();
        }
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID Intervention</th>
                <th>Client</th>
                <th>Date Intervention</th>
                <th>Etat</th>
                <th>Commentaire</th>
                <th>Date et Heure</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($interventions as $intervention): ?>
                <tr>
                    <td><?= $intervention['idInter'] ?></td>
                    <td><?= $intervention['clientInter'] ?></td>
                    <td><?= $intervention['dateInter'] ?></td>
                    <td><?= $intervention['etat'] ?></td>
                    <?php
                        $isClosestClient = false;
                        foreach ($distancesToClients as $client) {
                            if ($client['idClient'] === $intervention['clientInter'] && $client['distanceKm'] < 15) {
                                $isClosestClient = true;
                                break;
                            }
                        }
                    ?>
                    <td><?= $isClosestClient ? '<span style="color: red;">Traiter en priorité</span>' : '' ?></td>
                    <?php if ($intervention['etat'] != 'Terminé' && $intervention['etat'] != 'Non débuté') : ?>
                        <!-- Contenu à exécuter si la condition est vraie -->
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="idInter" value="<?= $intervention['idInter'] ?>">
                                <textarea name="commentaire" id="commentaire" cols="15" rows="3"></textarea>
                            </td>
                            <td>
                                <input type="date" name="dateHeure" id="dateHeure" min="<?= date('Y-m-d'); ?>">
                            </td>
                            <td>
                                <input class="plus" type="submit" name="submit_button" value="Ajouter Commentaire">
                            </form>
                        </td>
                    <?php else: ?>
                        <!-- Contenu à exécuter si la condition est faux -->
                        <td colspan="3">Interventions terminées ou non débutées</td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <form action="" method="post" class="pagination">
        <?php if ($totalPages > 1): ?>
            <input type="hidden" name="page" value="<?= $currentPage ?>">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <button type="submit" name="page" value="<?= $i ?>" <?= ($i == $currentPage) ? 'class="active"' : '' ?>><?= $i ?></button>
            <?php endfor; ?>
        <?php endif; ?>
    </form>
</div>
