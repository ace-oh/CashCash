
<div>
<h2><center>Créer une intervention</center></h2>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"])) {
    // Appeler la fonction seulement lorsque le formulaire est soumis
    formulaireIntervention();
}

?>



<form method="post" action="">
    <center>

    <label for="idClient">Id client:</label>
    <select name="idClient" required>
        <option value="">Sélectionnez un client</option>
        <?php
        $clientIds = getAllClientIds();
        foreach ($clientIds as $clientId) {
            echo "<option value=\"$clientId\">$clientId</option>";
        }
        ?>
    </select>

    <label for="dateDebut">Date de début:</label>
    <input type="date" name="dateDebut" id="dateDebut" required min='<?php echo date('Y-m-d'); ?>'>

    <label for="dateFin">Date de fin:</label>
    <input type="date" name="dateFin" required min='<?php echo date('Y-m-d'); ?>'>

    <label for="idTechnicien">Id technicien:</label>
    <select name="idTechnicien" required>
        <option value="">Sélectionnez un technicien</option>
        <?php
        $technicianIds = getAllTechnicianIds();
        foreach ($technicianIds as $technicianId) {
            echo "<option value=\"$technicianId\">$technicianId</option>";
        }
        ?>
    </select>

    <button type="submit" name="submit_button">Enregistrer</button>
    </center>
</form>


</div>