using System;
using System.Collections.Generic;
using System.Globalization;
using System.IO;
using System.Linq;
using System.Windows.Forms;
using System.Xml;
using System.Xml.Linq;
using MySql.Data.MySqlClient;

namespace cashcash.lesClasses
{
    internal class Materiel
    {
        // Propriété correspondant à l'ID du client
        public long IdClient { get; set; }

        private connexion dbConnection = new connexion();

        public List<string> GetMaterielsByClientId(long idClient)
        {
            List<string> numSeries = new List<string>();

            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    // Requête SQL pour récupérer les numSeries d'un client spécifique
                    string query = "SELECT numSerie FROM matériel WHERE idClient = @idClient";
                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.Parameters.AddWithValue("@idClient", idClient);

                    using (MySqlDataReader reader = command.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            // Ajouter le numSerie à la liste des numSeries
                            string numSerie = reader.GetString("numSerie");
                            numSeries.Add(numSerie);
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors de la récupération des informations du matériel : " + ex.Message);
            }

            return numSeries;
        }

        public Dictionary<string, string> GetRefMaterielsByClientId(long idClient)
        {
            Dictionary<string, string> refMateriels = new Dictionary<string, string>();

            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    // Requête SQL pour récupérer les refMateriel associés à chaque numSerie du client
                    string query = "SELECT numSerie, refMateriel FROM appartenir WHERE numSerie IN (SELECT numSerie FROM matériel WHERE idClient = @idClient)";
                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.Parameters.AddWithValue("@idClient", idClient);

                    using (MySqlDataReader reader = command.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            // Ajouter le mapping numSerie - refMateriel au dictionnaire refMateriels
                            string numSerie = reader.GetString("numSerie");
                            string refMateriel = reader.GetString("refMateriel");
                            refMateriels.Add(numSerie, refMateriel);
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors de la récupération des informations du matériel : " + ex.Message);
            }

            return refMateriels;
        }
        public Dictionary<string, string> GetLibelleMaterielsByRefMateriel(Dictionary<string, string> refMateriels)
        {
            Dictionary<string, string> libelleMateriels = new Dictionary<string, string>();

            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    // Créer une liste de noms de paramètres
                    List<string> paramNames = new List<string>();
                    foreach (var kvp in refMateriels)
                    {
                        string paramName = "@refMateriel_" + kvp.Key; // Nom du paramètre
                        paramNames.Add(paramName); // Ajouter le nom du paramètre à la liste
                    }

                    // Requête SQL avec une jointure pour récupérer les libelléMateriel associés à chaque refMateriel
                    string query = "SELECT a.refMateriel, t.libelleMateriel " +
                                   "FROM appartenir a " +
                                   "JOIN typemateriel t ON a.refMateriel = t.refMateriel " +
                                   "WHERE a.refMateriel IN (" + string.Join(",", paramNames) + ")";
                    MySqlCommand command = new MySqlCommand(query, connection);

                    // Ajouter les valeurs des paramètres
                    foreach (var kvp in refMateriels)
                    {
                        string paramName = "@refMateriel_" + kvp.Key;
                        command.Parameters.AddWithValue(paramName, kvp.Value);
                    }

                    using (MySqlDataReader reader = command.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            // Ajouter le mapping refMateriel - libelleMateriel au dictionnaire libelleMateriels
                            string refMateriel = reader.GetString("refMateriel");
                            string libelleMateriel = reader.GetString("libelleMateriel");
                            libelleMateriels.Add(refMateriel, libelleMateriel);
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors de la récupération des informations du matériel : " + ex.Message);
            }

            return libelleMateriels;
        }
        public List<string> GetMaterielsSousContrat(long idClient)
        {
            List<string> materielsWithContract = new List<string>();

            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    // Requête SQL pour récupérer les matériels avec contrat associés au client spécifique
                    string query = "SELECT numMateriel FROM couvrir WHERE numContrat IN " +
                                   "(SELECT numContrat FROM souscrire WHERE idClient = @idClient)";
                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.Parameters.AddWithValue("@idClient", idClient);

                    using (MySqlDataReader reader = command.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            // Ajouter le matériel avec contrat à la liste des matériels
                            string numMateriel = reader.GetString("numMateriel");
                            materielsWithContract.Add(numMateriel);
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors de la récupération des matériels avec contrat : " + ex.Message);
            }

            return materielsWithContract;
        }

        public List<string> GetMaterielsHorsContrat(long idClient)
        {
            List<string> materielsWithoutContract = new List<string>();

            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    // Requête SQL pour récupérer les numéros de série des matériels sans contrat associés au client spécifique
                    string query = "SELECT numSerie FROM matériel WHERE idClient = @idClient " +
                                   "AND numSerie NOT IN " +
                                   "(SELECT numMateriel FROM couvrir WHERE numContrat IN " +
                                   "(SELECT numContrat FROM souscrire WHERE idClient = @idClient))";
                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.Parameters.AddWithValue("@idClient", idClient);

                    using (MySqlDataReader reader = command.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            // Ajouter le numéro de série du matériel sans contrat à la liste des matériels
                            string numSerie = reader.GetString("numSerie");
                            materielsWithoutContract.Add(numSerie);
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors de la récupération des matériels sans contrat : " + ex.Message);
            }

            return materielsWithoutContract;
        }


        public List<(string Key, string Value)> GetInfosContratByClientId(long idClient)
        {
            List<(string Key, string Value)> infosContrat = new List<(string, string)>();

            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    string query = @"SELECT c.* 
                             FROM souscrire s
                             JOIN contratmaintenance c ON s.numContrat = c.idContrat
                             WHERE s.idClient = @idClient";
                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.Parameters.AddWithValue("@idClient", idClient);

                    using (MySqlDataReader reader = command.ExecuteReader())
                    {
                        if (reader.Read())
                        {
                            // Ajouter les informations du contrat à la liste infosContrat
                            infosContrat.Add(("ID Contrat", reader["idContrat"].ToString()));
                            infosContrat.Add(("Date Signature", reader["dateSignature"].ToString()));
                            infosContrat.Add(("Date Echéance", reader["dateEcheance"].ToString()));
                            infosContrat.Add(("Date Renouvellement", reader["dateRenou"].ToString()));
                            infosContrat.Add(("Modif Date Echéance", reader["modifDateEcheance"].ToString()));
                            // Ajoutez d'autres colonnes de la table contratmaintenance selon vos besoins
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors de la récupération des informations du contrat : " + ex.Message);
            }

            return infosContrat;
        }

        public List<(string Key, string Value)> GetInfosMaterielByClientId(long idClient)
        {
            List<(string Key, string Value)> infosMateriel = new List<(string, string)>();

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
                        if (reader.Read())
                        {
                            // Ajouter les informations du matériel à la liste infosMateriel
                            infosMateriel.Add(("Numéro de Série", reader["numSerie"].ToString()));
                            infosMateriel.Add(("Date de Vente", reader["dateVente"].ToString()));
                            infosMateriel.Add(("Date d'Installation", reader["dateInstallation"].ToString()));
                            infosMateriel.Add(("Prix de Vente", reader["prixVente"].ToString()));
                            infosMateriel.Add(("Emplacement Client", reader["emplacementClient"].ToString()));
                            infosMateriel.Add(("Fin de Garantie", reader["finGarantie"].ToString()));
                            infosMateriel.Add(("ID Client", reader["idClient"].ToString()));
                            // Ajoutez d'autres colonnes de la table matériel selon vos besoins
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
        public List<(string Key, string Value)> GetInfosMaterielByNumSerie(string numSerie)
        {
            List<(string Key, string Value)> infosMateriel = new List<(string, string)>();

            try
            {
                using (MySqlConnection connection = dbConnection.GetConnection())
                {
                    connection.Open();

                    string query = @"SELECT * FROM matériel WHERE numSerie = @numSerie";
                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.Parameters.AddWithValue("@numSerie", numSerie);

                    using (MySqlDataReader reader = command.ExecuteReader())
                    {
                        if (reader.Read())
                        {
                            // Ajouter les informations du matériel à la liste infosMateriel
                            infosMateriel.Add(("Numéro de Série", reader["numSerie"].ToString()));
                            infosMateriel.Add(("Date de Vente", reader["dateVente"].ToString()));
                            infosMateriel.Add(("Date d'Installation", reader["dateInstallation"].ToString()));
                            infosMateriel.Add(("Prix de Vente", reader["prixVente"].ToString()));
                            infosMateriel.Add(("Emplacement Client", reader["emplacementClient"].ToString()));
                            infosMateriel.Add(("Fin de Garantie", reader["finGarantie"].ToString()));
                            infosMateriel.Add(("ID Client", reader["idClient"].ToString()));
                            // Ajoutez d'autres colonnes de la table matériel selon vos besoins
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

        public void GenererFichierXML(long idClient)
        {
            try
            {
                // Récupérer la date du jour avec l'heure, la minute et la seconde pour le nom du fichier XML
                string currentDate = DateTime.Now.ToString("yyyyMMdd_HHmmss");
                string fileName = $"XML_{currentDate}.xml";

                // Créer le document XML
                XDocument xmlDocument = new XDocument();
                XElement listeMateriel = new XElement("listeMateriel");
                xmlDocument.Add(listeMateriel);

                // Ajouter l'attribut idClient à l'élément materiels
                XElement materiels = new XElement("materiels", new XAttribute("idClient", $"cli{idClient}"));
                listeMateriel.Add(materiels);

                // Récupérer les informations nécessaires pour le fichier XML
                List<(string Key, string Value)> infosContrat = GetInfosContratByClientId(idClient);

                // Récupérer les références et les libellés des matériels
                Dictionary<string, string> refMateriels = GetRefMaterielsByClientId(idClient);
                Dictionary<string, string> libelleMateriels = GetLibelleMaterielsByRefMateriel(refMateriels);

                // Listes pour stocker les numéros de série déjà utilisés
                List<string> numSeriesDejaUtilisesSousContrat = new List<string>();
                List<string> numSeriesDejaUtilisesHorsContrat = new List<string>();

                // Vérifier s'il existe des matériels sous contrat pour le client
                List<string> materielsSousContrat = GetMaterielsSousContrat(idClient);
                if (materielsSousContrat.Count > 0)
                {
                    // Ajouter les informations des matériels sous contrat
                    XElement sousContratElement = new XElement("sousContrat");
                    foreach (var numSerie in materielsSousContrat)
                    {
                        if (!numSeriesDejaUtilisesSousContrat.Contains(numSerie))
                        {
                            XElement materielElement = new XElement("materiel");
                            List<(string Key, string Value)> infosMaterielSousContrat = GetInfosMaterielByNumSerie(numSerie);
                            foreach (var info in infosMaterielSousContrat)
                            {
                                string elementName = SanitizeXmlName(info.Key.Replace(" ", "_"));
                                switch (elementName)
                                {
                                    case "Numéro_de_Série":
                                        materielElement.Add(new XAttribute("numSerie", info.Value));
                                        numSeriesDejaUtilisesSousContrat.Add(info.Value); // Ajout du numéro de série à la liste des déjà utilisés
                                        break;
                                    case "Date_de_Vente":
                                        string refInterne = refMateriels[numSerie];
                                        string libelle = libelleMateriels[refInterne];
                                        XElement typeElement = new XElement("type",
                                                                            new XAttribute("refInterne", refInterne),
                                                                            new XAttribute("libelle", libelle));
                                        materielElement.Add(typeElement);
                                        DateTime dateVente = DateTime.ParseExact(info.Value, "dd/MM/yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                                        materielElement.Add(new XElement("date_vente", dateVente.ToString("yyyy-MM-dd")));
                                        break;
                                    case "Date_dInstallation":
                                        DateTime dateInstallation = DateTime.ParseExact(info.Value, "dd/MM/yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                                        materielElement.Add(new XElement("date_installation", dateInstallation.ToString("yyyy-MM-dd")));
                                        break;
                                    case "Prix_de_Vente":
                                        materielElement.Add(new XElement("prix_vente", info.Value));
                                        break;
                                    case "Emplacement_Client":
                                        materielElement.Add(new XElement("emplacement", info.Value));
                                        break;
                                    case "Fin_de_Garantie":
                                        DateTime dateEcheance = DateTime.ParseExact(infosContrat.Find(x => x.Key == "Date Echéance").Value, "dd/MM/yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                                        int nbJourAvantEcheance = (int)(dateEcheance.Date - DateTime.Now.Date).TotalDays;
                                        materielElement.Add(new XElement("nbJourAvantEcheance", nbJourAvantEcheance));
                                        break;
                                    case "ID_Client":
                                        break;
                                    default:
                                        materielElement.Add(new XElement(elementName, info.Value));
                                        break;
                                }
                            }
                            sousContratElement.Add(materielElement);
                        }
                    }
                    materiels.Add(sousContratElement);
                }

                // Vérifier s'il existe des matériels hors contrat pour le client
                List<string> materielsHorsContrat = GetMaterielsHorsContrat(idClient);
                if (materielsHorsContrat.Count > 0)
                {
                    // Ajouter les informations des matériels hors contrat
                    XElement horsContratElement = new XElement("horsContrat");
                    foreach (var numSerieHorsContrat in materielsHorsContrat)
                    {
                        if (!numSeriesDejaUtilisesHorsContrat.Contains(numSerieHorsContrat))
                        {
                            XElement materielElement = new XElement("materiel");
                            List<(string Key, string Value)> infosMaterielHorsContrat = GetInfosMaterielByNumSerie(numSerieHorsContrat);
                            foreach (var infoHorsContrat in infosMaterielHorsContrat)
                            {
                                string elementName = SanitizeXmlName(infoHorsContrat.Key.Replace(" ", "_"));
                                switch (elementName)
                                {
                                    case "Numéro_de_Série":
                                        materielElement.Add(new XAttribute("numSerie", infoHorsContrat.Value));
                                        numSeriesDejaUtilisesHorsContrat.Add(infoHorsContrat.Value); // Ajout du numéro de série à la liste des déjà utilisés
                                        break;
                                    case "Date_de_Vente":
                                        string refInterne = refMateriels[numSerieHorsContrat];
                                        string libelle = libelleMateriels[refInterne];
                                        XElement typeElement = new XElement("type",
                                                                            new XAttribute("refInterne", refInterne),
                                                                            new XAttribute("libelle", libelle));
                                        materielElement.Add(typeElement);
                                        DateTime dateVente = DateTime.ParseExact(infoHorsContrat.Value, "dd/MM/yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                                        materielElement.Add(new XElement("date_vente", dateVente.ToString("yyyy-MM-dd")));
                                        break;
                                    case "Date_dInstallation":
                                        DateTime dateInstallation = DateTime.ParseExact(infoHorsContrat.Value, "dd/MM/yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                                        materielElement.Add(new XElement("date_installation", dateInstallation.ToString("yyyy-MM-dd")));
                                        break;
                                    case "Prix_de_Vente":
                                        materielElement.Add(new XElement("prix_vente", infoHorsContrat.Value));
                                        break;
                                    case "Emplacement_Client":
                                        materielElement.Add(new XElement("emplacement", infoHorsContrat.Value));
                                        break;
                                    default:
                                        if (elementName != "Fin_de_Garantie" && elementName != "ID_Client")
                                        {
                                            materielElement.Add(new XElement(elementName, infoHorsContrat.Value));
                                        }
                                        break;
                                }
                            }
                            horsContratElement.Add(materielElement);
                        }
                    }
                    materiels.Add(horsContratElement);
                }

                // Enregistrer le document XML dans un fichier avec le nom spécifié
                string filePath = Path.Combine("FichierXML", fileName); // Assurez-vous que le dossier FichierXML existe
                xmlDocument.Save(filePath);

                // Afficher un message de confirmation
                MessageBox.Show("Le fichier XML a été généré avec succès.", "Succès");
            }
            catch (Exception ex)
            {
                MessageBox.Show("Une erreur est survenue lors de la génération du fichier XML : " + ex.Message, "Erreur");
            }
        }



        // Méthode pour supprimer les caractères non valides dans les noms d'éléments XML
        private string SanitizeXmlName(string input)
        {
            // Supprimer les caractères non valides
            string sanitizedInput = new string(input.Where(c => XmlConvert.IsXmlChar(c) && c != '\'').ToArray());
            // Remplacer les guillemets simples par un autre caractère ou les supprimer
            sanitizedInput = sanitizedInput.Replace("'", ""); // Vous pouvez remplacer par un trait de soulignement ou tout autre caractère valide si nécessaire
            return sanitizedInput;
        }

    }
}