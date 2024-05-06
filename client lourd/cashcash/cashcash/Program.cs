using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Windows.Forms;
using cashcash.lesClasses; // Importez le namespace contenant la classe connexion

namespace cashcash
{
    internal static class Program
    {
        /// <summary>
        /// Point d'entrée principal de l'application.
        /// </summary>
        [STAThread]
        static void Main()
        {
            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);

            // Créez une instance de la classe connexion
            connexion conn = new connexion();

            // Exécutez la fonction TestConnection() de l'instance de la classe connexion
            bool connectionSuccessful = conn.TestConnection();

            // Affichez le résultat de la connexion dans la console
            Console.WriteLine("La connexion à la base de données est réussie : " + connectionSuccessful);

            // Exécutez l'application en affichant Form1
            Application.Run(new FormConnexion());
        }
    }
}
