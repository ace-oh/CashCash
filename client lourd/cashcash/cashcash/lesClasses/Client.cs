using System;
using System.Collections.Generic;
using MySql.Data.MySqlClient;

namespace cashcash.lesClasses
{
    internal class Client
    {
        // Propriétés correspondant aux colonnes de la table client
        public long IdClient { get; set; }
        public string SIREN { get; set; }
        public string CodeAb { get; set; }
        public string Rue { get; set; }
        public long NumRue { get; set; }
        public long CpVille { get; set; }
        public string Ville { get; set; }
        public string Pays { get; set; }
        public long NumTel { get; set; }
        public string Mail { get; set; }
        public long IdAgences { get; set; }
        public long DistanceKm { get; set; }
        public TimeSpan DureeDeplacement { get; set; }

        private connexion dbConnection = new connexion();

        public List<Client> GetAllClients()
        {
            List<Client> clients = new List<Client>();

            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    string query = "SELECT * FROM client";
                    MySqlCommand command = new MySqlCommand(query, connection);

                    using (MySqlDataReader reader = command.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            // Créer un nouvel objet Client pour chaque ligne de résultat
                            Client client = new Client
                            {
                                IdClient = reader.GetInt64("idClient"),
                                SIREN = reader.GetString("SIREN"),
                                CodeAb = reader.GetString("codeAb"),
                                Rue = reader.GetString("rue"),
                                NumRue = reader.GetInt64("numRue"),
                                CpVille = reader.GetInt64("cpVille"),
                                Ville = reader.GetString("ville"),
                                Pays = reader.GetString("pays"),
                                NumTel = reader.GetInt64("numTel"),
                                Mail = reader.GetString("mail"),
                                IdAgences = reader.GetInt64("idAgences"),
                                DistanceKm = reader.GetInt64("distanceKm"),
                                DureeDeplacement = reader.GetTimeSpan("dureeDeplacement")
                            };

                            // Ajouter le client à la liste des clients
                            clients.Add(client);
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors de la récupération des informations des clients : " + ex.Message);
            }

            return clients;
        }
    }
}
