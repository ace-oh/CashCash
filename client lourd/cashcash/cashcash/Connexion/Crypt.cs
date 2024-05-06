using System;
using System.Security.Cryptography;
using System.Text;

namespace cashcash.lesClasses
{
    internal class Crypt
    {
        public static string Crypter(string password, string salt)
        {
            byte[] saltBytes = Encoding.UTF8.GetBytes(salt);
            byte[] passwordBytes = Encoding.UTF8.GetBytes(password);

            Rfc2898DeriveBytes pbkdf2 = new Rfc2898DeriveBytes(passwordBytes, saltBytes, 1000);
            byte[] hash = pbkdf2.GetBytes(24);

            string hashString = Convert.ToBase64String(hash);
            return hashString;
        }
    }
}
