using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Windows.Forms;

namespace cashcash.lesClasses
{
    internal class CouvrirContrat
    {
        public string NumSerie { get; set; }
        public DateTime DateVente { get; set; }
        public DateTime DateInstallation { get; set; }
        public decimal PrixVente { get; set; }
        public string EmplacementClient { get; set; }
        public DateTime FinGarantie { get; set; }
        public long IdClient { get; set; }

        private connexion dbConnection = new connexion();

        public List<CouvrirContrat> GetMaterielInfosByClientId(long idClient)
        {
            List<CouvrirContrat> infosMateriel = new List<CouvrirContrat>();

            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    string query = @"SELECT * FROM matériel WHERE idClient = @idClient";
                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.Parameters.AddWithValue("@idClient", idClient);

                    using (MySqlDataReader reader = command.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            // Créer un nouvel objet CouvrirContrat pour chaque ligne de résultat
                            CouvrirContrat materiel = new CouvrirContrat
                            {
                                NumSerie = reader.GetString("numSerie"),
                                DateVente = reader.GetDateTime("dateVente"),
                                DateInstallation = reader.GetDateTime("dateInstallation"),
                                PrixVente = reader.GetDecimal("prixVente"),
                                EmplacementClient = reader.GetString("emplacementClient"),
                                FinGarantie = reader.GetDateTime("finGarantie"),
                                IdClient = reader.GetInt64("idClient")
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

        public void CreerContratEtAssocier(string numSerie, long idClient)
        {
            // Générer l'ID du contrat
            string idContrat = GenererIDContrat();

            // Date de signature (aujourd'hui)
            DateTime dateSignature = DateTime.Now;

            // Date d'échéance (dans 1 an)
            DateTime dateEcheance = dateSignature.AddYears(1);

            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    // Insérer le contrat dans la table contratmaintenance
                    string queryContrat = @"INSERT INTO contratmaintenance (idContrat, dateSignature, dateEcheance, dateRenou, modifDateEcheance)
                                            VALUES (@idContrat, @dateSignature, @dateEcheance, NULL, NULL)";
                    MySqlCommand commandContrat = new MySqlCommand(queryContrat, connection);
                    commandContrat.Parameters.AddWithValue("@idContrat", idContrat);
                    commandContrat.Parameters.AddWithValue("@dateSignature", dateSignature);
                    commandContrat.Parameters.AddWithValue("@dateEcheance", dateEcheance);
                    commandContrat.ExecuteNonQuery();

                    // Insérer l'association dans la table souscrire
                    string querySouscrire = @"INSERT INTO souscrire (numContrat, idClient)
                                              VALUES (@numContrat, @idClient)";
                    MySqlCommand commandSouscrire = new MySqlCommand(querySouscrire, connection);
                    commandSouscrire.Parameters.AddWithValue("@numContrat", idContrat);
                    commandSouscrire.Parameters.AddWithValue("@idClient", idClient);
                    commandSouscrire.ExecuteNonQuery();

                    // Insérer l'association dans la table couvrir
                    string queryCouvrir = @"INSERT INTO couvrir (numMateriel, numContrat)
                                            VALUES (@numMateriel, @numContrat)";
                    MySqlCommand commandCouvrir = new MySqlCommand(queryCouvrir, connection);
                    commandCouvrir.Parameters.AddWithValue("@numMateriel", numSerie);
                    commandCouvrir.Parameters.AddWithValue("@numContrat", idContrat);
                    commandCouvrir.ExecuteNonQuery();
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors de la création du contrat et de l'association : " + ex.Message);
            }
        }

        private string GenererIDContrat()
        {
            // Générer un ID de contrat unique (10 caractères alphanumériques)
            Random random = new Random();
            const string chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            return new string(Enumerable.Repeat(chars, 10)
              .Select(s => s[random.Next(s.Length)]).ToArray());
        }

        public bool MaterielPossedeContratNonExpirer(string numSerie)
        {
            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    // Requête pour vérifier si le matériel possède un contrat non expiré
                    string query = @"SELECT COUNT(*) FROM couvrir c
                                     INNER JOIN contratmaintenance cm ON c.numContrat = cm.idContrat
                                     WHERE c.numMateriel = @numMateriel AND cm.dateEcheance > NOW()";
                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.Parameters.AddWithValue("@numMateriel", numSerie);

                    // Exécuter la requête et obtenir le nombre de contrats non expirés
                    int contratNonExpirerCount = Convert.ToInt32(command.ExecuteScalar());

                    // Si le nombre de contrats non expirés est supérieur à 0, cela signifie que le matériel possède un contrat non expiré
                    return contratNonExpirerCount > 0;
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors de la vérification des contrats non expirés du matériel : " + ex.Message);
                return false;
            }
        }

        // Méthode pour vérifier si l'ID du client dans le DataGridView1 correspond à l'ID du client associé au matériel
        public bool VerifierCorrespondanceClient(long idClient, string numSerie)
        {
            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    // Requête SQL pour vérifier si l'ID du client correspond à celui associé au matériel
                    string query = "SELECT idClient FROM matériel WHERE numSerie = @numSerie";
                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.Parameters.AddWithValue("@numSerie", numSerie);

                    // Exécuter la commande et récupérer l'ID du client associé au matériel
                    object result = command.ExecuteScalar();

                    if (result != null)
                    {
                        long idClientAssocie = Convert.ToInt64(result);
                        return idClient == idClientAssocie;
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors de la vérification de la correspondance du client : " + ex.Message);
            }

            return false;
        }
    }
}
