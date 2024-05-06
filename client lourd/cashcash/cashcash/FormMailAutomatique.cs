using cashcash.lesClasses;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace cashcash
{
    public partial class FormMailAutomatique : Form
    {
        public FormMailAutomatique()
        {
            InitializeComponent();

            ChargerClients();
        }

        private void ChargerClients()
        {
            // Créer une instance de la classe Client
            Client client = new Client();

            // Récupérer la liste des clients
            var clients = client.GetAllClients();

            // Assigner la liste des clients au DataSource du DataGridView
            dataGridView1.DataSource = clients;
        }

        private void ChargerMateriels()
        {
            // Vérifier si une ligne est sélectionnée dans le DataGridView1
            if (dataGridView1.SelectedRows.Count > 0)
            {
                // Récupérer l'ID du client sélectionné dans le DataGridView1
                long idClient = Convert.ToInt64(dataGridView1.SelectedRows[0].Cells["IdClient"].Value);

                // Créer une instance de la classe MailAutomatique
                MailAutomatique mailAutomatique = new MailAutomatique();

                // Appeler la méthode pour récupérer les informations des matériels du client avec les contrats de maintenance expirant dans moins de 40 jours
                var infosMateriel = mailAutomatique.GetMaterielInfosByClientId(idClient);

                // Effacer toutes les lignes existantes dans le DataGridView2
                dataGridView2.Rows.Clear();

                // Définir les colonnes du DataGridView2 si elles ne sont pas déjà définies
                if (dataGridView2.Columns.Count == 0)
                {
                    dataGridView2.Columns.Add("NumSerie", "Numéro de Série");
                    dataGridView2.Columns.Add("NumContrat", "Numéro de Contrat");
                    dataGridView2.Columns.Add("IdClient", "ID Client");
                    dataGridView2.Columns.Add("DateDebutContrat", "Date de Début de Contrat");
                    dataGridView2.Columns.Add("DateFinContrat", "Date de Fin de Contrat");
                }

                // Ajouter les informations des matériels avec les contrats de maintenance dans le DataGridView2
                foreach (var materiel in infosMateriel)
                {
                    // Ajouter une nouvelle ligne dans le DataGridView2 avec les informations du matériel
                    dataGridView2.Rows.Add(
                        materiel.NumSerie,
                        materiel.NumContrat,
                        materiel.IdClient,
                        materiel.DateSignature,
                        materiel.DateEcheance
                    );
                }
            }
            else
            {
                // Si aucun client n'est sélectionné, vider le DataGridView2
                dataGridView2.Rows.Clear();
            }
        }
        private void button1_Click(object sender, EventArgs e)
        {
            // Vérifier si une ligne est sélectionnée dans le DataGridView1
            if (dataGridView1.SelectedRows.Count > 0)
            {
                // Générer le PDF à partir du DataGridView2
                MailAutomatique mailAutomatique = new MailAutomatique();
                mailAutomatique.CreerPdfFromDataGridView(dataGridView2);
            }
            else
            {
                MessageBox.Show("Veuillez sélectionner un client dans le DataGridView1.", "Aucun client sélectionné", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }





        private void button2_Click(object sender, EventArgs e)
        {
            // Vérifier si une ligne est sélectionnée dans le DataGridView1
            if (dataGridView1.SelectedRows.Count > 0)
            {
                // Récupérer l'ID du client sélectionné dans le DataGridView1
                long idClient = Convert.ToInt64(dataGridView1.SelectedRows[0].Cells["IdClient"].Value);

                // Créer une instance de la classe MailAutomatique
                MailAutomatique mailAutomatique = new MailAutomatique();

                // Appeler la méthode pour récupérer les informations du matériel du client
                var infosMateriel = mailAutomatique.GetMaterielInfosByClientId(idClient);

                // Vérifier si des informations sur les matériels ont été trouvées
                if (infosMateriel.Count > 0)
                {
                    // Effacer toutes les lignes existantes dans le DataGridView2
                    dataGridView2.Rows.Clear();

                    // Définir les colonnes du DataGridView2 si elles ne sont pas déjà définies
                    if (dataGridView2.Columns.Count == 0)
                    {
                        dataGridView2.Columns.Add("NumSerie", "Numéro de Série");
                        dataGridView2.Columns.Add("NumContrat", "Numéro de Contrat");
                        dataGridView2.Columns.Add("IdClient", "ID Client");
                        dataGridView2.Columns.Add("DateDebutContrat", "Date de Début de Contrat");
                        dataGridView2.Columns.Add("DateFinContrat", "Date de Fin de Contrat");
                    }

                    // Ajouter les informations des matériels dans le DataGridView2
                    foreach (var materiel in infosMateriel)
                    {
                        // Ajouter une nouvelle ligne dans le DataGridView2 avec les informations du matériel
                        dataGridView2.Rows.Add(
                            materiel.NumSerie,
                            materiel.NumContrat,
                            materiel.IdClient,
                            materiel.DateSignature, // Utilisation de DateSignature à la place de DateDebutContrat
                            materiel.DateEcheance // Utilisation de DateEcheance à la place de DateFinContrat
                        );
                    }
                }
                else
                {
                    dataGridView2.Rows.Clear();

                    MessageBox.Show("Aucun matériel avec un contrat expirant dans moins de 40 jours n'a été trouvé pour ce client.", "Aucun contrat trouvé", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
            }
            else
            {
                MessageBox.Show("Veuillez sélectionner un client dans le DataGridView1.", "Aucun client sélectionné", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }




        private void FormMailAutomatique_Load(object sender, EventArgs e)
        {

        }

        private void dataGridView2_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {

        }


        private void dataGridView1_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {

        }

        private void fichierXMLToolStripMenuItem_Click(object sender, EventArgs e)
        {
            // Créez une instance de la nouvelle fenêtre Form2
            FormXML form2 = new FormXML();

            // Masquer la fenêtre actuelle
            this.Hide();
            // Affichez la nouvelle fenêtre
            form2.Show();

            this.Close();

        }

        private void couvrirMatérielsToolStripMenuItem_Click(object sender, EventArgs e)
        {
            // Créer une instance du formulaire FormCouvrirContrat
            FormCouvrirContrat formCouvrirContrat = new FormCouvrirContrat();

            // Masquer la fenêtre actuelle
            this.Hide();

            // Afficher le formulaire
            formCouvrirContrat.Show();

            // Fermer la fenêtre actuelle après avoir ouvert le nouveau formulaire
            this.Close();
        }

        private void pDFContratToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Application.Exit();

        }
    }
}
