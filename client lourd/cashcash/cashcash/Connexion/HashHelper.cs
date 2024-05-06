using System;
using System.Text;

namespace cashcash.lesClasses
{
    internal class HashHelper
    {
        public static string HashPassword(string password)
        {
            // Sel utilisé pour la génération du hachage
            string salt = "$2a$10$SomeSaltForCashCashApp$";

            // Utiliser la méthode Crypt pour générer le hachage
            string hashedPassword = Crypt.Crypter(password, salt);

            return hashedPassword;
        }

        public static bool VerifyPassword(string enteredPassword, string storedPassword)
        {
            // Comparer les hachages
            return storedPassword.Equals(HashPassword(enteredPassword));
        }
    }
}
