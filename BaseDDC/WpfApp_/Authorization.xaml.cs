using Newtonsoft.Json;
using System;
using System.Net.Http;
using System.Windows;
using BaseDTO;
using System.Text;
using System.Security.Cryptography;
using System.Collections.Generic;
using System.Threading.Tasks;
using RestSharp;

namespace WpfApp_.Views
{
    /// <summary>
    /// Логика взаимодействия для Authorization.xaml
    /// </summary>
    public partial class Authorization : Window
    {
        public Authorization()
        {
            InitializeComponent();
            Config.LoadConfig();
        }

        private void  Loggin_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                IRestResponse responseSalt = RestAPI.GetRest("/Auth/getKey/" + Login.Text);
                if (responseSalt.StatusCode != System.Net.HttpStatusCode.OK) throw new Exception(responseSalt.Content);
                string hashpass = GetHash(Password.Password);
                var salt = JsonConvert.DeserializeObject<string>(responseSalt.Content);
                string hash = GetHash(hashpass + salt);
                IRestResponse<DTO_User_Auth> responseAuth =  RestAPI.PostRest<DTO_User_Auth>("/Auth/postPass/" + Login.Text, hash);
                if (responseAuth.StatusCode != System.Net.HttpStatusCode.OK) throw new Exception("Ошибка входа! \n Неверный пароль или логин");
                DTO_User_Auth user = responseAuth.Data;
                DTO_Auth_Obj auth = new DTO_Auth_Obj() { user_id = user.Id, token = user.Token, obj = null };

                RestAPI.SetRequestUserObject(auth);
                RestAPI.SetUserAuth(user);

                try
                {
                    StaticInfoCollections.GetInfoCollections();
                }
                catch (Exception ex)
                {
                    MessageBox.Show("Не удалось загрузить справочную информацию", "Ошибка");
                }

                new MainWindow().Show();
                this.Close();
            }
            catch(Exception ex)
            {
                MessageBox.Show(ex.Message,"Ошибка");
            }
            
        }


        private string GetHash(string inputString)
        {
            SHA512 sha512 = SHA512Managed.Create();
            byte[] bytes = Encoding.UTF8.GetBytes(inputString);
            byte[] hash = sha512.ComputeHash(bytes);
            return GetStringFromHash(hash);
        }

        private string GetStringFromHash(byte[] hash)
        {
            StringBuilder result = new StringBuilder();
            for (int i = 0; i < hash.Length; i++)
            {
                result.Append(hash[i].ToString("X2"));
            }
            return result.ToString();
        }

    }
}
