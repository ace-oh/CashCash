<?php
// Initialiser une variable pour suivre si la génération du PDF a réussi ou échoué
$pdf_generated = false;

// Vérifiez si le formulaire a été soumis et si le bouton "Générer PDF" a été cliqué
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_pdf'])) {
    // Récupérer l'ID technicien sélectionné depuis le formulaire
    $idTech = $_POST['idTech'];
    $selectedDate = !empty($_POST['selectedDate']) ? $_POST['selectedDate'] : null;

    try {
        // Récupérer les informations d'intervention en fonction de l'ID du technicien et de la date sélectionnée (si elle est spécifiée)
        $interventions = infosIntervention($idTech, $selectedDate);

        // Inclure le fichier principal de TCPDF
        require_once('tcpdf.php');

        // Créer une nouvelle instance de TCPDF
        $pdf = new TCPDF();

        // Ajouter une page au document
        $pdf->AddPage();

        // Définir la police et la taille du texte
        $pdf->SetFont('helvetica', '', 12);

        // Écrire les informations de l'intervention dans le PDF
        foreach($interventions as $intervention) {
            $pdf->Cell(0, 10, 'ID Intervention: ' . $intervention['idInter'], 0, 1);
            $pdf->Cell(0, 10, 'Client: ' . $intervention['clientInter'], 0, 1);
            $pdf->Cell(0, 10, 'Date Intervention: ' . $intervention['dateInter'], 0, 1);
            $pdf->Cell(0, 10, 'Date Fin Intervention: ' . $intervention['dateFinInter'], 0, 1);
            $pdf->Cell(0, 10, 'Commentaire: ' . $intervention['commentInter'], 0, 1);
            $pdf->Cell(0, 10, 'ID Technicien: ' . $intervention['idTech'], 0, 1);
            $pdf->Cell(0, 10, 'État: ' . $intervention['etat'], 0, 1);
            $pdf->Ln(); // Ajouter un saut de ligne entre les interventions
        }

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
