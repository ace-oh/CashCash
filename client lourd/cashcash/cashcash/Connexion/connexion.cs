using System;
using MySql.Data.MySqlClient;

namespace cashcash.lesClasses
{
    internal class connexion
    {
        private string connectionString = "Server=localhost;Database=ap2;Uid=cashcash;Pwd=Azerty12*";

        public MySqlConnection GetConnection()
        {
            MySqlConnection connection = new MySqlConnection(connectionString);
            return connection;
        }

        public bool TestConnection()
        {
            try
            {
                using (MySqlConnection connection = GetConnection())
                {
                    connection.Open();
                    if (connection.State == System.Data.ConnectionState.Open)
                    {
                        Console.WriteLine("Connexion réussie à la base de données.");
                        return true;
                    }
                    else
                    {
                        Console.WriteLine("La connexion à la base de données est fermée.");
                        return false;
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur de connexion à la base de données : " + ex.Message);
                return false;
            }
        }
    }
}