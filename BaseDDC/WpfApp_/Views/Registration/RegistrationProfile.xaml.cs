using System.Windows;
using System.Net.Http;
using System.Runtime.Serialization;
using Newtonsoft.Json;
using BaseDTO;
using System.Collections.Generic;
using System.Net.Http.Headers;
using System.Text.RegularExpressions;
using System;
using RestSharp;
using WpfApp_.Views.Profile;

namespace WpfApp_.Views.Registration
{
    /// <summary>
    /// Логика взаимодействия для RegistrationProfile.xaml
    /// </summary>
    public partial class RegistrationProfile : Window
    {
        private List<DTO_Category> _allCategories;
        private List<DTO_Category> _selectedCategories;

        private string _registrationId = "";

        public RegistrationProfile()
        {
            InitializeComponent();
            _selectedCategories = new List<DTO_Category>();
            isHave_INN.IsChecked = false;

            City.DisplayMemberPath = "title";
            City.SelectedValuePath = "id";
            Gender.DisplayMemberPath = "title";
            Gender.SelectedValuePath = "id";
            AllCategoriesListBox.SelectedValuePath = "id";
            AllCategoriesListBox.DisplayMemberPath = "title";
            SelectedCategoriesListBox.SelectedValuePath = "id";
            SelectedCategoriesListBox.DisplayMemberPath = "title";

            _allCategories = StaticInfoCollections.InfoCollections.categories;
            City.ItemsSource = StaticInfoCollections.InfoCollections.cities;
            Gender.ItemsSource = StaticInfoCollections.InfoCollections.genders;

            AllCategoriesListBox.ItemsSource = _allCategories;
            City.SelectedItem = City.Items[0];
        }

        public RegistrationProfile(DTO_Lead_Get lead)
        {
            InitializeComponent();
            _selectedCategories = new List<DTO_Category>();
            isHave_INN.IsChecked = false;

            City.DisplayMemberPath = "title";
            City.SelectedValuePath = "id";
            Gender.DisplayMemberPath = "title";
            Gender.SelectedValuePath = "id";
            AllCategoriesListBox.SelectedValuePath = "id";
            AllCategoriesListBox.DisplayMemberPath = "title";
            SelectedCategoriesListBox.SelectedValuePath = "id";
            SelectedCategoriesListBox.DisplayMemberPath = "title";
            Phone.Text = lead.Phone;
            Email.Text = lead.Email;
            var fio = lead.FioNeed.Split(' ');
            Name.Text = fio[0];
            SecondName.Text = fio[1];
            Patr.Text = fio[2];
            City.Text = lead.City;
            _allCategories = StaticInfoCollections.InfoCollections.categories;
            City.ItemsSource = StaticInfoCollections.InfoCollections.cities;
            Gender.ItemsSource = StaticInfoCollections.InfoCollections.genders;



            AllCategoriesListBox.ItemsSource = _allCategories;
            City.SelectedItem = City.Items[0];
        }

        async private void Registration_Click(object sender, RoutedEventArgs e)
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

                
                List<int> categoryList = new List<int>();
                foreach (var item in _selectedCategories)
                {
                    categoryList.Add(item.id);
                }
                DTO_People_Reg peopleReg = new DTO_People_Reg()
                {
                    Name = Name.Text,
                    SName = SecondName.Text,
                    Patr = Patr.Text,
                    IdCity = (int)City.SelectedValue,
                    IdGender = (int)Gender.SelectedValue,
                    id_Categories = categoryList,
                    Inn = INN_text.Text,
                    Passport = Pasport.Text,
                    Email = Email.Text,
                    Phone = Phone.Text,
                    Year = Convert.ToInt32(Year.Text)
                };
                
                IRestResponse<string> RegistrationrId = await RestAPI.PostRestAsync<string>("/People/PeopleReg", peopleReg);
                if (RegistrationrId.StatusCode != System.Net.HttpStatusCode.OK) throw new Exception("Ошибка при регистрации пользователя");
                _registrationId = RegistrationrId.Data;
                StaticInfoCollections.GetInfoCollections();
                new Prof(_registrationId).Show();
                this.Close();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }

        }
        
        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
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

        private void Add_category_Click(object sender, RoutedEventArgs e)
        {
            if(AllCategoriesListBox.SelectedItem != null)
            {
                _selectedCategories.Add((DTO_Category)AllCategoriesListBox.SelectedItem);
                SelectedCategoriesListBox.ItemsSource = _selectedCategories;
                SelectedCategoriesListBox.Items.Refresh();
                if (_selectedCategories == null) return;
                _allCategories.Remove((DTO_Category)AllCategoriesListBox.SelectedItem);
                AllCategoriesListBox.ItemsSource = _allCategories;
                AllCategoriesListBox.Items.Refresh();
            }
        }

        private void Remove_category_Click(object sender, RoutedEventArgs e)
        {
            if(SelectedCategoriesListBox.SelectedItem != null)
            {
                _allCategories.Add((DTO_Category)SelectedCategoriesListBox.SelectedItem);
                AllCategoriesListBox.ItemsSource = _allCategories;
                AllCategoriesListBox.Items.Refresh();
                _selectedCategories.Remove((DTO_Category)SelectedCategoriesListBox.SelectedItem);
                SelectedCategoriesListBox.ItemsSource = _selectedCategories;
                SelectedCategoriesListBox.Items.Refresh();
            }
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
    }
}
