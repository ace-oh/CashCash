<link rel="stylesheet" href="style.php" />
<div>
    <h2>
        <center>Mes interventions</center>
    </h2>

    <?php
    $technicianId = $util["id"];
    $interventions = getInterventionsByTechnicianId($technicianId);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"])) {
        updateIntervention();
    }
    ?>

    <table border="1" class="center">
        <center>
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
                        <td>
                            <?= $intervention['idInter'] ?>
                        </td>
                        <td>
                            <?= $intervention['clientInter'] ?>
                        </td>
                        <td>
                            <?= $intervention['dateInter'] ?>
                        </td>
                        <td>
                            <?= $intervention['etat'] ?>
                        </td>

                        <?php if ($intervention['etat'] != 'Terminé' && $intervention['etat'] != 'Non débuté'): ?>
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
                                <input type="submit" name="submit_button" value="Ajouter Commentaire">
                                </form>
                            </td>
                        <?php else: ?>
                            <!-- Contenu à exécuter si la condition est faux -->
                            <td colspan="3">Interventions terminées ou non débutées</td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </center>
    </table>
</div>