using System;
using System.Collections.Generic;
using System.IO;
using System.Windows.Forms;
using System.Xml.Linq;
using cashcash.lesClasses; // Assurez-vous d'importer l'espace de noms contenant la classe Client

namespace cashcash
{
    public partial class FormXML : Form
    {
        public FormXML()
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

        private void MailAutomatiqueToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Application.Exit();

        }

        private void test2ToolStripMenuItem_Click(object sender, EventArgs e)
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



        private void test3ToolStripMenuItem_Click(object sender, EventArgs e)
        {

            FormMailAutomatique formMailAutomatique = new FormMailAutomatique();

            this.Hide();

            formMailAutomatique.Show(); 

            this.Close();   
        }

        private void button1_Click(object sender, EventArgs e)
        {
            try
            {
                // Récupérer l'ID du client sélectionné
                long idClient = Convert.ToInt64(dataGridView1.SelectedRows[0].Cells["IdClient"].Value);

                // Créer une instance de la classe Materiel
                Materiel materiel = new Materiel();

                // Générer le fichier XML pour le client sélectionné
                materiel.GenererFichierXML(idClient);
            }
            catch (Exception ex)
            {
                MessageBox.Show("Une erreur est survenue lors de la génération du fichier XML : " + ex.Message, "Erreur");
            }
        }




        private void dataGridView1_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {

        }


        private void Form2_Load(object sender, EventArgs e)
        {

        }
    }
}