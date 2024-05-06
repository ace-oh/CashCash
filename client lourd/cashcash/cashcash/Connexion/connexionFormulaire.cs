using System;
using MySql.Data.MySqlClient;

namespace cashcash.lesClasses
{
    internal class connexionFormulaire
    {
        private connexion dbConnection = new connexion();

        public bool ConnecterUtilisateur(string id, string motDePasse)
        {
            bool connexionReussie = false;

            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    // Hash du mot de passe
                    string motDePasseHash = HashHelper.HashPassword(motDePasse);

                    // Requête ZSQL pour vérifier l'existence de l'utilisateur dans la table personnels
                    string query = "SELECT COUNT(*) FROM personnels WHERE id = @id";
                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.Parameters.AddWithValue("@id", id);
                    command.Parameters.AddWithValue("@mdp", motDePasseHash);

                    int count = Convert.ToInt32(command.ExecuteScalar());

                    // Si une ligne correspondante est trouvée, l'authentification réussit
                    if (count > 0)
                    {
                        connexionReussie = true;
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors de la connexion de l'utilisateur : " + ex.Message);
            }

            return connexionReussie;
        }
    }
}