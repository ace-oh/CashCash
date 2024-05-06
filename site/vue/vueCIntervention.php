<?php
// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure le fichier de fonctions
    // Récupérer l'ID technicien sélectionné depuis le formulaire
    $idTech = $_POST['idTech'];
    $selectedDate = !empty($_POST['selectedDate']) ? $_POST['selectedDate'] : null;

    // Récupérer les informations d'intervention en fonction de l'ID du technicien et de la date sélectionnée (si elle est spécifiée)
    $interventions = infosIntervention($idTech, $selectedDate);
}
?>

<form method="post" action="" id="interventionForm"> <!-- Ajoutez un ID au formulaire -->
    <label for="idTech">ID Technicien:</label>
    <select name="idTech" id="idTech" onchange="this.form.submit()" readonly>
        <option value="">Sélectionnez un technicien</option>
        <?php
        $technicianIds = getAllTechnicianIds();
        foreach ($technicianIds as $technicianId) {
            $selected = ($technicianId == $_POST['idTech']) ? 'selected' : ''; // Vérifier si l'option est sélectionnée
            echo "<option value=\"$technicianId\" $selected>$technicianId</option>"; // Ajouter l'attribut selected si nécessaire
        }
        ?>
    </select>

    <label for="selectedDate">Sélectionner une date:</label>
    <input type="date" name="selectedDate" id="selectedDate" onchange="document.getElementById('interventionForm').submit()">

    <?php if(isset($interventions) && !empty($interventions)) { ?>
    <table>
        <thead>
            <tr>
                <th>ID Intervention</th>
                <th>Client</th>
                <th>Date Intervention</th>
                <th>Date Fin Intervention</th>
                <th>Commentaire</th>
                <th>État</th>
                <th>Générer PDF</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($interventions as $intervention) { ?>
            <tr>
                <td><?php echo $intervention['idInter']; ?></td>
                <td><?php echo $intervention['clientInter']; ?></td>
                <td><?php echo $intervention['dateInter']; ?></td>
                <td><?php echo $intervention['dateFinInter']; ?></td>
                <td><?php echo $intervention['commentInter']; ?></td>
                <td><?php echo $intervention['etat']; ?></td>

                <!-- Bouton "Générer PDF" pour cette intervention -->
                <td>
                    <input type="hidden" name="idInter[]" value="<?php echo $intervention['idInter']; ?>" />
                    <input type="hidden" name="clientInter[]" value="<?php echo $intervention['clientInter']; ?>" />
                    <input type="hidden" name="dateInter[]" value="<?php echo $intervention['dateInter']; ?>" />
                    <input type="hidden" name="dateFinInter[]" value="<?php echo $intervention['dateFinInter']; ?>" />
                    <input type="hidden" name="commentInter[]" value="<?php echo $intervention['commentInter']; ?>" />
                    <input type="hidden" name="etat[]" value="<?php echo $intervention['etat']; ?>" />
                    <button class="plus" type="submit" name="generate_pdf" value="<?php echo $intervention['idInter']; ?>">Générer PDF</button>
                </td>


            </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php } else { ?>
    <p>Aucune intervention trouvée.</p>
    <?php } ?>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_pdf'])) {
            if ($pdf_generated) {
                echo 'Le fichier PDF a été créé avec succès : <a target="__blank" href="' . $file_name . '">Télécharger</a>';
            } else {
                echo 'La génération du PDF a échoué. Veuillez réessayer.';
            }
        }
    ?>
</form>
