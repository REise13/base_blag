using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Forms;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using BaseDTO;

namespace WpfApp_.Views.Profile
{
    /// <summary>
    /// Логика взаимодействия для Edit_People_data.xaml
    /// </summary>
    public partial class Edit_People_data : Window
    {

        private List<DTO_Category> _categories { get; set; }
        private DTO_People_Get _people;

        public Edit_People_data(DTO_People_Get people)
        {
            StaticInfoCollections.GetInfoCollections();

            InitializeComponent();
            _people = people;
            Gender.DisplayMemberPath = "title";
            Gender.SelectedValuePath = "id";
            City.DisplayMemberPath = "title";
            City.SelectedValuePath = "id";
            Gender.ItemsSource = StaticInfoCollections.InfoCollections.genders;
            City.ItemsSource = StaticInfoCollections.InfoCollections.cities;

            Name.Text = people.Name;
            SecondName.Text = people.SName;
            Patr.Text = people.Patr;
            Gender.SelectedValue = people.IdGenderNavigation.id;
            Year.Text = Convert.ToString(people.Year);
            if (people.Inn == null)
            {
                isHave_INN.IsChecked = true;
            }
            INN_text.Text = people.Inn;
            Email.Text = people.Email;
            Phone.Text = people.Phone;
            City.SelectedValue = people.IdCityNavigation.id;
            Pasport.Text = people.Passport;
        }

        private void Edit_People_ClickAsync(object sender, RoutedEventArgs e)
        {
            try
            {
                if (Name.Text.Equals("") || Name.Text.Equals(" ")) throw new Exception("Имя не заполнено");
                if (SecondName.Equals("") || SecondName.Equals(" ")) throw new Exception("Фамлия не заполнено");
                if (Patr.Text.Equals("") || Patr.Text.Equals(" ")) throw new Exception("Отчество не заполнено");
                if (Gender.SelectedItem == null) throw new Exception("Пол не выбран");
                if (Year.Text.Length < 4) throw new Exception("Год не заполнен");
                if (isHave_INN.IsChecked == false)
                {
                    if (INN_text.Text.Length < 10)
                        throw new Exception("ИНН не заполнено");
                }
                if (Phone.Text.Equals("") || Phone.Text.Equals(" ")) throw new Exception("Телефон не заполнен");
                if (Pasport.Text.Equals("") || Pasport.Text.Equals(" ")) throw new Exception("Паспортные данные не запонены");
                if (City.SelectedItem == null) throw new Exception("Город не выбран");
                
                var newPeople = new DTO_People_Update()
                {
                    Id = _people.Id,
                    Name = Name.Text,
                    SName = SecondName.Text,
                    Patr = Patr.Text,
                    IdCity = (int)City.SelectedValue,
                    IdGender = (int)Gender.SelectedValue,
                    Inn = INN_text.Text,
                    Passport = Pasport.Text,
                    Email = Email.Text,
                    Phone = Phone.Text,
                    Year = Convert.ToInt32(Year.Text)
                };

                DialogResult dialogResult = System.Windows.Forms.MessageBox.Show("Сохранение", "Сохранить изменения?", MessageBoxButtons.YesNo);
                if (dialogResult == System.Windows.Forms.DialogResult.Yes)
                {
                    var result = RestAPI.PostRest("/People/UpdatePersonal", newPeople);
                    this.Close();
                }
            }
            catch (Exception ex)
            {
                System.Windows.MessageBox.Show("Ошибка:" + ex.Message + "\n В методе:" + ex.TargetSite);
            }
        }

        private List<System.Windows.Input.Key> number_keys = new List<System.Windows.Input.Key> {
            System.Windows.Input.Key.D0,
            System.Windows.Input.Key.D1,
            System.Windows.Input.Key.D2,
            System.Windows.Input.Key.D3,
            System.Windows.Input.Key.D4,
            System.Windows.Input.Key.D5,
            System.Windows.Input.Key.D6,
            System.Windows.Input.Key.D7,
            System.Windows.Input.Key.D8,
            System.Windows.Input.Key.D9,
            System.Windows.Input.Key.NumPad0,
            System.Windows.Input.Key.NumPad1,
            System.Windows.Input.Key.NumPad2,
            System.Windows.Input.Key.NumPad3,
            System.Windows.Input.Key.NumPad4,
            System.Windows.Input.Key.NumPad5,
            System.Windows.Input.Key.NumPad6,
            System.Windows.Input.Key.NumPad7,
            System.Windows.Input.Key.NumPad8,
            System.Windows.Input.Key.NumPad9,
            System.Windows.Input.Key.OemPlus,
            System.Windows.Input.Key.OemPipe,
            System.Windows.Input.Key.Multiply,
            System.Windows.Input.Key.Oem2,
            System.Windows.Input.Key.Oem5

        };

        private void Name_KeyDown(object sender, System.Windows.Input.KeyEventArgs e)
        {
            if (number_keys.Contains(e.Key))
            {
                e.Handled = true;
                return;
            }
            if (e.Key == System.Windows.Input.Key.Back) return;

            if (e.Key == System.Windows.Input.Key.OemMinus)
            {
                e.Handled = false;
                return;
            }
            if (e.Key >= System.Windows.Input.Key.Q || e.Key <= System.Windows.Input.Key.OemPeriod)
            {
                e.Handled = false;
                return;
            }
            e.Handled = true;
            return;
        }
        
        private void isHave_INN_Checked(object sender, RoutedEventArgs e)
        {
            if (isHave_INN.IsChecked == true)
            {
                INN_text.IsEnabled = false;
            }
        }

        private void isHave_INN_Unchecked(object sender, RoutedEventArgs e)
        {
            if (isHave_INN.IsChecked == false)
            {
                INN_text.IsEnabled = true;
            }
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }
    }
}
