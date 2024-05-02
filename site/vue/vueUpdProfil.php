<?php
// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idClient'])) {
    // Inclure le fichier de fonctions
    // Récupérer l'ID client sélectionné depuis le formulaire
    $idClient = $_POST['idClient'];

    // Récupérer les informations du client
    $clientInfo = infosClient($idClient);

    // Pré-remplir les champs du formulaire avec les informations du client
    $siren = $clientInfo['SIREN'];
    $codeAb = $clientInfo['codeAb'];
    $rue = $clientInfo['rue'];
    $numRue = $clientInfo['numRue'];
    $cpVille = $clientInfo['cpVille'];
    $ville = $clientInfo['ville'];
    $pays = $clientInfo['pays'];
    $numTel = $clientInfo['numTel'];
    $mail = $clientInfo['mail'];
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"]) && isset($_POST['idClient'])) {

    $nouvelleRue = $_POST['nouveauRue'];
    $nouveauNumRue = $_POST['nouveauNumRue'];
    $nouveauCpVille = $_POST['nouveauCpVille'];
    $nouvelleVille = $_POST['nouvelleVille'];
    $nouveauPays = $_POST['nouveauPays'];
    $nouveauNumTel = $_POST['nouveauNumTel'];
    $nouveauMail = $_POST['nouveauMail'];

    // Appeler la fonction pour mettre à jour les informations du client
    $result = updateClientInfo($idClient, $nouvelleRue, $nouveauNumRue, $nouveauCpVille, $nouvelleVille, $nouveauPays, $nouveauNumTel, $nouveauMail);

    // Vérifier si la mise à jour a réussi ou s'il y a eu une erreur
    if ($result === true) {
        // Afficher un message de succès
        echo "Les informations du client ont été mises à jour avec succès.";
    } else {
        // Afficher le message d'erreur
        echo "Erreur: " . $result;
    }
}
?>


<div class="modifierProfil">
    <h2>Modifier infos clients</h2>

    <form method="post" action="">
        <label for="idClient">Id client:</label>
        <select name="idClient" id="idClient" onchange="this.form.submit()">
            <option value="">Sélectionnez un client</option>
            <?php
            $clientIds = getAllClientIds();
            foreach ($clientIds as $clientId) {
                $selected = ($clientId == $_POST['idClient']) ? 'selected' : ''; // Vérifier si l'option est sélectionnée
                echo "<option value=\"$clientId\" $selected>$clientId</option>"; // Ajouter l'attribut selected si nécessaire
            }
            ?>
        </select>


        <div class="infos flexC">
            <div class="oldInfos md-6">
                <label for="siren">SIREN:</label>
                <input type="text" name="siren" id="siren" value="<?php echo isset($siren) ? $siren : ''; ?>" readonly><br>

                <label for="codeAb">Code Ab:</label>
                <input type="text" name="codeAb" id="codeAb" value="<?php echo isset($codeAb) ? $codeAb : ''; ?>" readonly><br>

                <label for="rue">Rue:</label>
                <input type="text" name="rue" id="rue" value="<?php echo isset($rue) ? $rue : ''; ?>" readonly><br>

                <label for="numRue">Numéro de Rue:</label>
                <input type="text" name="numRue" id="numRue" value="<?php echo isset($numRue) ? $numRue : ''; ?>" readonly><br>

                <label for="cpVille">Code Postal Ville:</label>
                <input type="text" name="cpVille" id="cpVille" value="<?php echo isset($cpVille) ? $cpVille : ''; ?>" readonly><br>

                <label for="ville">Ville:</label>
                <input type="text" name="ville" id="ville" value="<?php echo isset($ville) ? $ville : ''; ?>" readonly><br>

                <label for="pays">Pays:</label>
                <input type="text" name="pays" id="pays" value="<?php echo isset($pays) ? $pays : ''; ?>" readonly><br>

                <label for="numTel">Numéro de Téléphone:</label>
                <input type="text" name="numTel" id="numTel" value="<?php echo isset($numTel) ? $numTel : ''; ?>" readonly><br>

                <label for="mail">Email:</label>
                <input type="text" name="mail" id="mail" value="<?php echo isset($mail) ? $mail : ''; ?>" readonly><br>
            </div>

        <div class="newInfos md-6">
            <label for="nouveauRue">Nouvelle Rue:</label>
            <input type="text" name="nouveauRue" id="nouveauRue"><br>

            <label for="nouveauNumRue">Nouveau Numéro de Rue:</label>
            <input type="text" name="nouveauNumRue" id="nouveauNumRue"><br>

            <label for="nouveauCpVille">Nouveau Code Postal Ville:</label>
            <input type="text" name="nouveauCpVille" id="nouveauCpVille"><br>

            <label for="nouvelleVille">Nouvelle Ville:</label>
            <input type="text" name="nouvelleVille" id="nouvelleVille"><br>

            <!-- Ajout des champs manquants -->
            <label for="nouveauPays">Nouveau Pays:</label>
            <input type="text" name="nouveauPays" id="nouveauPays"><br>

            <label for="nouveauNumTel">Nouveau Numéro de Téléphone:</label>
            <input type="text" name="nouveauNumTel" id="nouveauNumTel"><br>

            <label for="nouveauMail">Nouveau Email:</label>
            <input type="text" name="nouveauMail" id="nouveauMail"><br>
        </div>
        
    </div>

    <!-- Bouton de soumission -->
    <button type="submit" name="submit_button" class="plus">Enregistrer</button>
</form>





</div>