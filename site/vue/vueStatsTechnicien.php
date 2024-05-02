<?php
// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $mois = $_POST['mois'];
    $annee = $_POST['annee'];
    $idTechnicien = $_POST['idTechnicien'];

    // Appeler la fonction nbInterventionTech pour obtenir les données sur le nombre d'interventions
    $interventions = nbInterventionTech($mois, $annee, $idTechnicien);

    // Créer un tableau associatif pour stocker les données sur le nombre d'interventions
    $dataNbInterventions = [];

    // Remplir le tableau avec les données d'interventions
    foreach ($interventions as $intervention) {
        $jour = $intervention['jour'];
        // Ajouter un 0 devant les jours de 1 à 9 pour assurer un tri correct
        if ($jour < 10) {
            $jour = '0' . $jour;
        }
        $dataNbInterventions["Jour $jour"] = $intervention['nbInterventions'];
    }

    // Obtenir le nombre de jours dans le mois sélectionné
    $nbJoursMois = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);

    // Remplir les jours manquants avec un nombre d'interventions égal à zéro
    for ($jour = 1; $jour <= $nbJoursMois; $jour++) {
        $jourLabel = ($jour < 10) ? 'Jour 0' . $jour : "Jour $jour";
        if (!isset($dataNbInterventions[$jourLabel])) {
            $dataNbInterventions[$jourLabel] = 0;
        }
    }

    // Trier le tableau par clés (jours) pour obtenir les jours dans l'ordre croissant
    ksort($dataNbInterventions);

    // Organiser les données pour Chart.js pour le nombre d'interventions
    $labelsNbInterventions = array_keys($dataNbInterventions);
    $valuesNbInterventions = array_values($dataNbInterventions);

    // Convertir les données en format JSON pour être utilisées dans Chart.js pour le nombre d'interventions
    $labelsJSONNbInterventions = json_encode($labelsNbInterventions);
    $valuesJSONNbInterventions = json_encode($valuesNbInterventions);

    // Appeler la fonction tempsInterventionTech pour obtenir les données sur le temps d'intervention
    $tempsIntervention = tempsInterventionTech($mois, $annee, $idTechnicien);

    // Créer un tableau associatif pour stocker les données sur le temps d'intervention
    $dataTempsIntervention = [];

    // Remplir le tableau avec les données sur le temps d'intervention
    foreach ($tempsIntervention as $intervention) {
        $jour = $intervention['jour'];
        // Ajouter un 0 devant les jours de 1 à 9 pour assurer un tri correct
        if ($jour < 10) {
            $jour = '0' . $jour;
        }
        $dataTempsIntervention["Jour $jour"] = $intervention['totalHeures'];
    }

    // Obtenir le nombre de jours dans le mois sélectionné
    $nbJoursMois = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);

    // Remplir les jours manquants avec un temps d'intervention égal à zéro
    for ($jour = 1; $jour <= $nbJoursMois; $jour++) {
        $jourLabel = ($jour < 10) ? 'Jour 0' . $jour : "Jour $jour";
        if (!isset($dataTempsIntervention[$jourLabel])) {
            $dataTempsIntervention[$jourLabel] = 0;
        }
    }

    // Trier le tableau par clés (jours) pour obtenir les jours dans l'ordre croissant
    ksort($dataTempsIntervention);

    // Organiser les données pour Chart.js pour le temps d'intervention
    $labelsTempsIntervention = array_keys($dataTempsIntervention);
    $valuesTempsIntervention = array_values($dataTempsIntervention);

    // Convertir les données en format JSON pour être utilisées dans Chart.js pour le temps d'intervention
    $labelsJSONTempsIntervention = json_encode($labelsTempsIntervention);
    $valuesJSONTempsIntervention = json_encode($valuesTempsIntervention);

    // Appeler la fonction distanceKmIntervention pour obtenir les données sur la distance parcourue
    $interventionsDistance = distanceKmIntervention($mois, $annee, $idTechnicien);

    // Créer un tableau associatif pour stocker les données sur la distance parcourue
    $dataInterventionsDistance = [];

    // Remplir le tableau avec les données de distance parcourue
    foreach ($interventionsDistance as $intervention) {
        $jour = $intervention['jour'];
        // Ajouter un 0 devant les jours de 1 à 9 pour assurer un tri correct
        if ($jour < 10) {
            $jour = '0' . $jour;
        }
        $dataInterventionsDistance["Jour $jour"] = $intervention['totalDistance'];
    }

    // Obtenir le nombre de jours dans le mois sélectionné
    $nbJoursMois = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);

    // Remplir les jours manquants avec une distance égale à zéro
    for ($jour = 1; $jour <= $nbJoursMois; $jour++) {
        $jourLabel = ($jour < 10) ? 'Jour 0' . $jour : "Jour $jour";
        if (!isset($dataInterventionsDistance[$jourLabel])) {
            $dataInterventionsDistance[$jourLabel] = 0;
        }
    }

    // Trier le tableau par clés (jours) pour obtenir les jours dans l'ordre croissant
    ksort($dataInterventionsDistance);

    // Organiser les données pour Chart.js pour la distance totale des interventions
    $labelsDistanceInterventions = array_keys($dataInterventionsDistance);
    $valuesDistanceInterventions = array_values($dataInterventionsDistance);

    // Convertir les données en format JSON pour être utilisées dans Chart.js pour la distance totale des interventions
    $labelsJSONDistanceInterventions = json_encode($labelsDistanceInterventions);
    $valuesJSONDistanceInterventions = json_encode($valuesDistanceInterventions);

}
?>


<form method="post" action="" class="graphiqueMois">
    <label for="mois">Sélectionner le mois :</label>
    <select name="mois" id="mois">
        <option value="1">Janvier</option>
        <option value="2">Février</option>
        <option value="3">Mars</option>
        <option value="4">Avril</option>
        <option value="5">Mai</option>
        <option value="6">Juin</option>
        <option value="7">Juillet</option>
        <option value="8">Août</option>
        <option value="9">Septembre</option>
        <option value="10">Octobre</option>
        <option value="11">Novembre</option>
        <option value="12">Décembre</option>
    </select>

    <label for="annee">Sélectionner l'année :</label>
    <input type="number" name="annee" id="annee" min="1900" max="2099" value="<?php echo date('Y'); ?>" required>

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
    <button type="submit">Afficher</button>
</form>

<canvas id="interventionChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Récupérer les données JSON pour le premier graphique
    var labelsNbInterventions = <?php echo $labelsJSONNbInterventions; ?>;
    var valuesNbInterventions = <?php echo $valuesJSONNbInterventions; ?>;

    // Configurer les données pour Chart.js
    var ctx1 = document.getElementById('interventionChart').getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labelsNbInterventions,
            datasets: [{
                label: 'Nombre d\'interventions par jour',
                data: valuesNbInterventions,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1 // Incrément de l'axe des ordonnées
                }
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': Jour ' + tooltipItem.label;
                    }
                }
            }
        }
    });
</script>

<canvas id="dureeInterventionChart"></canvas>

<script>
    // Récupérer les données JSON pour le deuxième graphique
    var labelsTempsIntervention = <?php echo $labelsJSONTempsIntervention; ?>;
    var valuesTempsIntervention = <?php echo $valuesJSONTempsIntervention; ?>;

    // Configurer les données pour Chart.js
    var ctx2 = document.getElementById('dureeInterventionChart').getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: labelsTempsIntervention,
            datasets: [{
                label: 'Durée d\'intervention par jour (en heures)',
                data: valuesTempsIntervention,
                backgroundColor: 'rgba(0, 128, 0, 0.2)', // Vert avec une opacité de 0.2
                borderColor: 'rgba(0, 128, 0, 1)', // Vert solide

                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    // Incrément de l'axe des ordonnées (en heures)
                    stepSize: 1
                }
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                        // Afficher la durée d'intervention en heures
                        return datasetLabel + ': Jour ' + tooltipItem.label + ' - ' + tooltipItem.value + ' heures';
                    }
                }
            }
        }
    });
</script>

<canvas id="nbKilometreChart"></canvas>

<script>
    // Récupérer les données JSON pour le graphique de distance
    var labelsInterventionsDistance = <?php echo $labelsJSONDistanceInterventions; ?>;
    var valuesInterventionsDistance = <?php echo $valuesJSONDistanceInterventions; ?>;

    // Configurer les données pour Chart.js
    var ctx2 = document.getElementById('nbKilometreChart').getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: labelsInterventionsDistance,
            datasets: [{
                label: 'Distance parcourue par jour (en km)',
                data: valuesInterventionsDistance,
                backgroundColor: 'rgba(255, 0, 0, 0.2)', // Vert avec une opacité de 0.2
                borderColor: 'rgba(255, 0, 0, 1)', // Vert solide
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    // Incrément de l'axe des ordonnées (en km)
                    stepSize: 1
                }
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                        // Afficher la distance parcourue en km
                        return datasetLabel + ': Jour ' + tooltipItem.label + ' - ' + tooltipItem.value + ' km';
                    }
                }
            }
        }
    });
</script>