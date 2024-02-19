<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}

include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.utilisateur.inc.php";
include_once "$racine/modele/bd.techniciens.inc.php";

$id = getMailULoggedOn();
$util = getUtilisateurByMailU($id);
$emploi = getEmploiUserById($id);
$role = $emploi["nomRôle"];

if (isLoggedOn()) {
    if ($role == "assistant") {
        // Code spécifique pour l'assistant
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date("Y-m-d");
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date("Y-m-d");
        $agent = isset($_POST['agent']) ? $_POST['agent'] : '';

        // Récupérer les interventions pour la période et l'agent spécifiés
        $interventions = Intervention::getInterventionsDateAgent($start_date, $agent);

        $menuBurger[] = Array("url" => "./?action=iintervention", "label" => "Mes interventions");
        $menuBurger[] = Array("url" => "./?action=profil", "label" => "Mon profil");

        $titre = "Mes interventions";
        include_once "$racine/vue/entete.html.php";
        include_once "$racine/vue/vueMonProfil.php";
        include_once "$racine/vue/vueIIntervention.php";
        include_once "$racine/vue/pied.html.php";
    } else {
        // Code pour un utilisateur non assistant
        $titre = "Page réservée aux assistants";
        include_once "$racine/vue/entete.html.php";
        echo "<p>Vous n'avez pas l'autorisation d'accéder à cette page.</p>";
        include_once "$racine/vue/pied.html.php";
    }
} else {
    $titre = "T'es pas co bouffon";
    include_once "$racine/vue/entete.html.php";
    include_once "$racine/vue/pied.html.php";
}
?>
