<?php
// Vérifiez si le formulaire a été soumis et si le bouton "Générer PDF" a été cliqué
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_pdf'])) {
    // Récupérez l'ID de l'intervention sélectionnée
    $selected_id = $_POST['generate_pdf'];

    // Trouvez l'index de l'ID sélectionné dans le tableau des ID d'intervention
    $index = array_search($selected_id, $_POST['idInter']);

    // Récupérez les détails de l'intervention correspondante
    $idInter = $_POST['idInter'][$index];
    $clientInter = $_POST['clientInter'][$index];
    $dateInter = $_POST['dateInter'][$index];
    $dateFinInter = $_POST['dateFinInter'][$index];
    $commentInter = $_POST['commentInter'][$index];
    $etat = $_POST['etat'][$index];
    
    try {
        // Inclure le fichier principal de TCPDF
        require_once('tcpdf.php');

        // Créer une nouvelle instance de TCPDF
        $pdf = new TCPDF();

        // Ajouter une page au document
        $pdf->AddPage();

        // Définir la police et la taille du texte
        $pdf->SetFont('helvetica', '', 12);

        // Écrire les informations de l'intervention dans le PDF
        $pdf->Cell(0, 10, 'ID Intervention: ' . $idInter, 0, 1);
        $pdf->Cell(0, 10, 'Client: ' . $clientInter, 0, 1);
        $pdf->Cell(0, 10, 'Date Intervention: ' . $dateInter, 0, 1);
        $pdf->Cell(0, 10, 'Date Fin Intervention: ' . $dateFinInter, 0, 1);
        $pdf->Cell(0, 10, 'Commentaire: ' . $commentInter, 0, 1);
        $pdf->Cell(0, 10, 'État: ' . $etat, 0, 1);

        // Nom du fichier de sortie
        $file_name = '/PHP/cashcash/pdf/interventions_' . date('YmdHis') . '.pdf';

        // Sauvegarder le PDF dans le dossier spécifié
        $pdf->Output($_SERVER['DOCUMENT_ROOT'] . $file_name, 'F');

        // Indiquer que le PDF a été généré avec succès
        $pdf_generated = true;
    } catch (Exception $e) {
        // En cas d'erreur, indiquer que la génération du PDF a échoué
        $pdf_generated = false;
    }
}

?>
