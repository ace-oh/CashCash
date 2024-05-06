using System;
using System.Collections.Generic;
using System.IO;
using System.Net.Mail;
using System.Net;
using System.Windows.Forms;
using iTextSharp.text;
using iTextSharp.text.pdf;
using MySql.Data.MySqlClient;

namespace cashcash.lesClasses
{
    internal class MailAutomatique
    {
        public string NumSerie { get; set; }
        public string NumContrat { get; set; }
        public long IdClient { get; set; }
        public DateTime DateSignature { get; set; }
        public DateTime DateEcheance { get; set; }
        public DateTime DateRenou { get; set; }

        private connexion dbConnection = new connexion();

        public List<MailAutomatique> GetMaterielInfosByClientId(long idClient)
        {
            List<MailAutomatique> infosMateriel = new List<MailAutomatique>();

            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    // Requête SQL pour récupérer les informations des matériels avec les contrats de maintenance expirant dans moins de 40 jours
                    string query = @"
                        SELECT m.numSerie, cm.idContrat, s.idClient, cm.dateSignature, cm.dateEcheance, cm.dateRenou
                        FROM matériel m
                        INNER JOIN couvrir c ON m.numSerie = c.numMateriel
                        INNER JOIN contratmaintenance cm ON c.numContrat = cm.idContrat
                        INNER JOIN souscrire s ON cm.idContrat = s.numContrat
                        WHERE cm.dateEcheance <= DATE_ADD(CURDATE(), INTERVAL 40 DAY) AND s.idClient = @idClient;";

                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.Parameters.AddWithValue("@idClient", idClient);

                    using (MySqlDataReader reader = command.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            // Créer un nouvel objet MailAutomatique pour chaque ligne de résultat
                            MailAutomatique materiel = new MailAutomatique
                            {
                                NumSerie = reader.GetString("numSerie"),
                                NumContrat = reader.GetString("idContrat"),
                                IdClient = reader.GetInt64("idClient"),
                                DateSignature = reader.GetDateTime("dateSignature"),
                                DateEcheance = reader.GetDateTime("dateEcheance"),
                                DateRenou = reader.GetDateTime("dateRenou")
                            };

                            // Ajouter le matériel à la liste des informations de matériel
                            infosMateriel.Add(materiel);
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors de la récupération des informations du matériel : " + ex.Message);
            }

            return infosMateriel;
        }
        public void CreerPdfFromDataGridView(DataGridView dataGridView)
        {
            // Déclarer la variable pdfFilePath en dehors du bloc try
            string pdfFilePath = string.Empty;

            // Vérifier si une ligne est sélectionnée dans le DataGridView
            if (dataGridView.SelectedRows.Count > 0)
            {
                // Créer un nouveau document PDF
                Document document = new Document();

                try
                {
                    // Définir le chemin où le PDF sera sauvegardé
                    string pdfFolderPath = @"PDF\"; // Le dossier PDF est situé dans la solution directement

                    // Vérifier si le dossier PDF existe, sinon le créer
                    if (!Directory.Exists(pdfFolderPath))
                    {
                        Directory.CreateDirectory(pdfFolderPath);
                    }

                    // Définir le nom du fichier PDF avec un horodatage pour le rendre unique
                    string pdfFileName = $"Matériel_Info_{DateTime.Now:yyyyMMddHHmmss}.pdf";
                    pdfFilePath = Path.Combine(pdfFolderPath, pdfFileName);

                    // Créer un écrivain PDF
                    PdfWriter writer = PdfWriter.GetInstance(document, new FileStream(pdfFilePath, FileMode.Create));

                    // Ouvrir le document
                    document.Open();

                    // Ajouter les informations du matériel dans le document PDF
                    foreach (DataGridViewRow row in dataGridView.SelectedRows)
                    {
                        PdfPTable table = new PdfPTable(dataGridView.Columns.Count);
                        for (int i = 0; i < dataGridView.Columns.Count; i++)
                        {
                            table.AddCell(new Phrase(dataGridView.Columns[i].HeaderText));
                        }
                        table.HeaderRows = 1;

                        for (int i = 0; i < dataGridView.Columns.Count; i++)
                        {
                            table.AddCell(new Phrase(row.Cells[i].Value.ToString()));
                        }

                        document.Add(table);
                    }

                    // Ajouter une nouvelle ligne pour la date de renouvellement et la date d'échéance du contrat renouvelé
                    foreach (DataGridViewRow row in dataGridView.SelectedRows)
                    {
                        DateTime dateEcheance = Convert.ToDateTime(row.Cells["DateFinContrat"].Value);
                        document.Add(new Paragraph($"Date de renouvellement du contrat de maintenance : {dateEcheance.AddDays(1).ToShortDateString()}"));
                        document.Add(new Paragraph($"Date d'échéance du contrat renouvelé : {dateEcheance.AddDays(1).AddYears(1).ToShortDateString()}"));
                    }
                }
                catch (Exception ex)
                {
                    Console.WriteLine("Erreur lors de la création du PDF : " + ex.Message);
                }
                finally
                {
                    // Fermer le document
                    document.Close();
                }

                // Afficher un message de confirmation avec le bon chemin du fichier PDF
                if (!string.IsNullOrEmpty(pdfFilePath))
                {
                    MessageBox.Show($"Le fichier PDF a été créé avec succès et enregistré dans {pdfFilePath}.", "PDF Créé", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
                else
                {
                    MessageBox.Show("Une erreur est survenue lors de la création du PDF.", "Erreur", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
            else
            {
                // Afficher un message si aucune ligne n'est sélectionnée dans le DataGridView
                MessageBox.Show("Veuillez sélectionner une ligne dans le DataGridView.", "Aucune ligne sélectionnée", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }

    }
}