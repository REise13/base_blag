using System.Security.Cryptography;
using System.Text;
using System.Windows;
using BaseDTO;

namespace WpfApp_.Views.Registration
{
    /// <summary>
    /// Логика взаимодействия для RegistrationUser.xaml
    /// </summary>
    public partial class RegistrationUser : Window
    {
        private DTO_User_Create _user;

        public RegistrationUser()
        {
            InitializeComponent();
            _user = new DTO_User_Create();
            this.DataContext = _user;
            Roles.ItemsSource = StaticInfoCollections.InfoCollections.user_Roles;
            Roles.DisplayMemberPath = "title";
            Roles.SelectedValuePath = "id";
        }

        private void Registration_Click(object sender, RoutedEventArgs e)
        {
            _user.RoleId = (int)Roles.SelectedValue;
            _user.Pass = GetHash(Password.Password);
            var response = RestAPI.PostRest("/User/Create", _user);
            MessageBox.Show(response.Content);
            this.Close();
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
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
