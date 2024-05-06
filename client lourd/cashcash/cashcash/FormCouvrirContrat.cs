using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using cashcash.lesClasses;
namespace cashcash
{
    public partial class FormCouvrirContrat : Form
    {
        public FormCouvrirContrat()
        {
            InitializeComponent();

            // Appeler la méthode pour charger les clients dans le DataGridView
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

                // Créer une instance de la classe CouvrirContrat
                CouvrirContrat couvrirContrat = new CouvrirContrat();

                // Appeler la méthode pour récupérer les informations du matériel du client
                var infosMateriel = couvrirContrat.GetMaterielInfosByClientId(idClient);

                // Effacer toutes les lignes existantes dans le DataGridView2
                dataGridView2.Rows.Clear();

                // Définir les colonnes du DataGridView2 si elles ne sont pas déjà définies
                if (dataGridView2.Columns.Count == 0)
                {
                    dataGridView2.Columns.Add("NumSerie", "Numéro de Série");
                    dataGridView2.Columns.Add("DateVente", "Date de Vente");
                    dataGridView2.Columns.Add("DateInstallation", "Date d'Installation");
                    dataGridView2.Columns.Add("PrixVente", "Prix de Vente");
                    dataGridView2.Columns.Add("EmplacementClient", "Emplacement Client");
                    dataGridView2.Columns.Add("FinGarantie", "Fin de Garantie");
                    dataGridView2.Columns.Add("IdClient", "ID Client");
                }

                // Ajouter les informations du matériel dans le DataGridView2
                foreach (var materiel in infosMateriel)
                {
                    // Ajouter une nouvelle ligne dans le DataGridView2 avec les informations du matériel
                    dataGridView2.Rows.Add(
                        materiel.NumSerie,
                        materiel.DateVente,
                        materiel.DateInstallation,
                        materiel.PrixVente,
                        materiel.EmplacementClient,
                        materiel.FinGarantie,
                        materiel.IdClient
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
            // Vérifier si une ligne est sélectionnée dans le DataGridView1 (pour obtenir l'idClient)
            if (dataGridView1.SelectedRows.Count > 0)
            {
                // Récupérer l'ID du client sélectionné dans le DataGridView1
                long idClient = Convert.ToInt64(dataGridView1.SelectedRows[0].Cells["idClient"].Value);

                // Vérifier si une ligne est sélectionnée dans le DataGridView2 (pour obtenir le numSerie)
                if (dataGridView2.SelectedRows.Count > 0)
                {
                    // Récupérer le numéro de série du matériel sélectionné dans le DataGridView2
                    string numSerie = dataGridView2.SelectedRows[0].Cells["NumSerie"].Value.ToString();

                    // Créer une instance de la classe CouvrirContrat
                    CouvrirContrat couvrirContrat = new CouvrirContrat();

                    // Vérifier si le matériel possède déjà un contrat non expiré
                    if (couvrirContrat.MaterielPossedeContratNonExpirer(numSerie))
                    {
                        // Afficher un message d'erreur si le matériel possède déjà un contrat non expiré
                        MessageBox.Show($"Le matériel {numSerie} possède déjà un contrat de maintenance non expiré.", "Erreur", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                    else
                    {
                        // Vérifier si l'ID du client dans le DataGridView1 correspond à l'ID du client associé au matériel
                        if (couvrirContrat.VerifierCorrespondanceClient(idClient, numSerie))
                        {
                            // Si le matériel ne possède pas de contrat non expiré et correspond au client sélectionné, créer un nouveau contrat et l'associer
                            couvrirContrat.CreerContratEtAssocier(numSerie, idClient);

                            // Afficher un message de confirmation
                            MessageBox.Show($"Le contrat de maintenance a été créé pour le client {idClient} concernant le matériel {numSerie}.", "Contrat de maintenance créé", MessageBoxButtons.OK, MessageBoxIcon.Information);
                        }
                        else
                        {
                            // Afficher un message d'erreur si le client sélectionné ne correspond pas au client associé au matériel
                            MessageBox.Show($"Le client sélectionné ne correspond pas au client associé au matériel {numSerie}.", "Erreur", MessageBoxButtons.OK, MessageBoxIcon.Error);
                        }
                    }
                }
                else
                {
                    MessageBox.Show("Veuillez sélectionner un matériel dans le DataGridView2.", "Aucun matériel sélectionné", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                }
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
                // Appeler la méthode pour charger les matériels
                ChargerMateriels();
            }
            else
            {
                MessageBox.Show("Veuillez sélectionner un client dans le DataGridView1.", "Aucun client sélectionné", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
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

            this.Hide();  
            // Affichez la nouvelle fenêtre
            form2.Show();

            this.Close();

        }

        private void couvrirMatérielsToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Application.Exit();
        }

        private void mailAutomatiquePDFToolStripMenuItem_Click(object sender, EventArgs e)
        {
            FormMailAutomatique formMailAutomatique = new FormMailAutomatique();

            this.Hide();

            formMailAutomatique.Show();

            this.Close();
        }

    }
}
