using cashcash.lesClasses;
using System;
using System.Windows.Forms;

namespace cashcash
{
    public partial class FormConnexion : Form
    {
        private connexionFormulaire connexionManager;

        public FormConnexion()
        {
            InitializeComponent();

            // Initialisation de l'instance de connexionFormulaire
            connexionManager = new connexionFormulaire();
        }

        private void Form1_Load(object sender, EventArgs e)
        {

        }



        // Événement déclenché lorsque le bouton de connexion est cliqué
        private void button1_Click(object sender, EventArgs e)
        {
            // Récupérer l'ID et le mot de passe saisis par l'utilisateur
            string id = textBox1.Text;
            string motDePasse = textBox2.Text;

            // Vérifier la connexion de l'utilisateur à l'aide de connexionFormulaire
            bool connexionReussie = connexionManager.ConnecterUtilisateur(id, motDePasse);

            // Si la connexion est réussie, ouvrir la nouvelle fenêtre ou effectuer toute autre action requise
            if (connexionReussie)
            {
                // Une fois la connexion réussie, masquez la fenêtre actuelle
                this.Hide();

                // Créez une instance de la nouvelle fenêtre Form2
                FormXML form2 = new FormXML();

                // Affichez la nouvelle fenêtre
                form2.ShowDialog();

                
            }
            else
            {
                // Afficher un message d'erreur si la connexion a échoué
                MessageBox.Show("Identifiant ou mot de passe incorrect.", "Erreur de connexion", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

    }
}
