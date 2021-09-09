using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Windows;
using System.Windows.Input;
using BaseDTO;
using Newtonsoft.Json;
using WpfApp_.Views.Profile;
using RestSharp;
using Microsoft.Win32;
using System.Diagnostics;
using System.Windows.Controls;
using Excel = Microsoft.Office.Interop.Excel;
using System.IO;
using System.Threading.Tasks;
using System.Data;
using Microsoft.Office.Interop.Excel;
using ClosedXML.Excel;
using System.Text;

namespace WpfApp_
{
    /// <summary>
    /// Логика взаимодействия для Search.xaml
    /// </summary>
    public partial class Search : System.Windows.Window
    {
        private List<DTO_Category> _selectedCategories;
        private List<DTO_Category> _allCategories;
        private List<DTO_Gender> _allGenders;
        private List<DTO_City> _allCities;
        private List<DTO_Donor> _allDonors;
        private List<DTO_Project_Get> _projects; 

        public Search()
        {
            InitializeComponent();
            _selectedCategories = new List<DTO_Category>();

            using (HttpClient client = new HttpClient())
            {
                var result = client.PostAsJsonAsync(Config.Connection + "/Project/Get/", RestAPI.RequestUserObj).Result;
                string resultContent = result.Content.ReadAsStringAsync().Result;
                _projects = JsonConvert.DeserializeObject<List<DTO_Project_Get>>(resultContent);
            }

            _allCategories = StaticInfoCollections.InfoCollections.categories;
            _allCities = StaticInfoCollections.InfoCollections.cities;
            _allGenders = StaticInfoCollections.InfoCollections.genders;
            _allDonors = StaticInfoCollections.InfoCollections.donors;

            _allGenders.Add(new DTO_Gender() { id = 0, title = "Все" });
            _allCities.Add(new DTO_City() { id = 0, title = "Все" });
            _allCategories.Add(new DTO_Category() { id = 0, title = "Все" });
            _allDonors.Add(new DTO_Donor() { id = 0, title = "Все" });
            _projects.Add(new DTO_Project_Get() { Id = 0, Title = "Все", EndDate = null, StartDate = null });

            Project_combox.ItemsSource = _projects;
            Project_combox.SelectedItem = Project_combox.Items[Project_combox.Items.Count - 1];

            Donor_combox.ItemsSource = _allDonors;
            Donor_combox.SelectedItem = Donor_combox.Items[Donor_combox.Items.Count - 1];

            Gender.ItemsSource = _allGenders;
            Gender.SelectedItem = Gender.Items[Gender.Items.Count-1];

            City.ItemsSource = _allCities;
            City.SelectedItem = City.Items[City.Items.Count-1];

            all_categories.ItemsSource = _allCategories;

            if (RestAPI.User.Role.title != "admin")
            {
                loadExcel.Visibility = Visibility.Hidden;
                loadGeo.Visibility = Visibility.Hidden;
            }

        }
        
        private System.Data.DataTable GetDataTable()
        {
            System.Data.DataTable dt = new System.Data.DataTable("Профили");
            for (int i = 0; i < data_profiles.Columns.Count; i++)
            {
                dt.Columns.Add(data_profiles.Columns[i].Header.ToString(), typeof(string));
            } 
            DataRow Row;
            foreach (Rs_Profile_Info item in data_profiles.Items)
            {
                string[] st = new string[] { item.FIO,
                    item.Age,
                    item.City,
                    item.Gender,
                    item.INN,
                    item.Passport,
                    item.Categories,
                    item.Helps
                };

                Row = dt.NewRow();
                for (int i = 0; i < data_profiles.Columns.Count; i++)
                {
                    Row[i] = st[i];
                }
                dt.Rows.Add(Row);
            }
            return dt;
        }

        private System.Data.DataTable GetDataTableForGeo()
        {
            System.Data.DataTable dt = new System.Data.DataTable("GeoHelp");

            dt.Columns.Add("Город", typeof(string));
            dt.Columns.Add("Помощь", typeof(string));
            dt.Columns.Add("Геолокация", typeof(string));

            DataRow Row;
            foreach (Rs_Profile_Info item in data_profiles.Items)
            {
                string geo = GeoHelp.GetCoordinateByCity(item.City);


                string[] st = new string[] {
                    item.City,
                    item.Helps,
                    geo
                };

                Row = dt.NewRow();

                for (int i = 0; i < st.Count(); i++)
                {
                    Row[i] = st[i];
                }
                dt.Rows.Add(Row);
            }
            return dt;
        }


        private void ExportGeo_Click(object sender, RoutedEventArgs e)
        {
            ExcelExport(false);
        }

        private void ExportProfiles_Click(object sender, RoutedEventArgs e)
        {
            ExcelExport(true);
        }

        private void ExcelExport(bool profile = true)
        {
            progressBar.Value = 5;
            progressBar.IsIndeterminate = true;
            System.Data.DataTable dt;
            try
            {
                if (profile)
                {
                    dt = GetDataTable().Copy();
                }
                else
                {
                    dt = GetDataTableForGeo().Copy();
                }

                SaveFileDialog openDlg = new SaveFileDialog();
                openDlg.FileName = "Профили №";
                openDlg.Filter = "Excel (.xls)|*.xls |Excel (.xlsx)|*.xlsx |All files (*.*)|*.*";
                openDlg.FilterIndex = 2;
                openDlg.RestoreDirectory = true;
                string path = openDlg.FileName;

                if (openDlg.ShowDialog() == true)
                {
                    var workbook = new XLWorkbook();
                    workbook.AddWorksheet(dt);
                    workbook.SaveAs(openDlg.FileName);
                }
                MessageBox.Show("Загрузка данных в Excel была успешно завершена!");
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Ошибка");
            }
            finally
            {
                progressBar.IsIndeterminate = false;
                progressBar.Value = 0;
            }
        }



        private async void Search_Click(object sender, RoutedEventArgs e)
        {
            progressBar.Value = 5;
            progressBar.IsIndeterminate = true;
            List<int> selectedCategoryId = _selectedCategories.Select((item) => item.id).ToList();
            var min = min_age.Text == "" ? 0 : Convert.ToInt32(min_age.Text);
            var max = max_age.Text == "" ? 9999 : Convert.ToInt32(max_age.Text);

            Fl_Profile_Info profile_Info = new Fl_Profile_Info()
            {
                Name = Name.Text,
                id_Categories = selectedCategoryId,
                min_age = min,
                max_age = max,
                INN = INN.Text,
                sName = Surname.Text,
                Patr = Patr.Text,
                Passport = Pasport.Text,
                id_Gender = Convert.ToInt32(Gender.SelectedValue),
                id_City = Convert.ToInt32(City.SelectedValue),
                id_Donor = Convert.ToInt32(Donor_combox.SelectedValue),
                id_Project = Convert.ToInt32(Project_combox.SelectedValue)
            };

            try
            {
                IRestResponse<List<Rs_Profile_Info>> profiles = await RestAPI.PostRestAsync<List<Rs_Profile_Info>>("/Search/ProfileInfo", profile_Info);
                data_profiles.ItemsSource = profiles.Data;
                SearchResult.Content = "Результаты поиска: " + "найдено " + profiles.Data.Count + " записей.";
                progressBar.IsIndeterminate = false;
                progressBar.Value = 0;
            }
            catch (Exception ex)
            {
                MessageBox.Show("Ошибка:" + ex.Message + "\n В методе:" + ex.TargetSite);
            }
            finally
            {
                progressBar.IsIndeterminate = false;
                progressBar.Value = 0;
                loadExcel.IsEnabled = true;
                loadGeo.IsEnabled = true;
            }
            
        }

        private void Add_category_Click(object sender, RoutedEventArgs e)
        {
            if (all_categories.SelectedItem != null)
            {
                _selectedCategories.Add((DTO_Category)all_categories.SelectedItem);
                selected_categories.ItemsSource = _selectedCategories;
                selected_categories.Items.Refresh();
                if (_selectedCategories == null) return;
                _allCategories.Remove((DTO_Category)all_categories.SelectedItem);
                all_categories.ItemsSource = _allCategories;
                all_categories.Items.Refresh();
            }
        }

        private void Remove_category_Click(object sender, RoutedEventArgs e)
        {
            if (selected_categories.SelectedItem != null)
            {
                _allCategories.Add((DTO_Category)selected_categories.SelectedItem);
                all_categories.ItemsSource = _allCategories;
                all_categories.Items.Refresh();
                _selectedCategories.Remove((DTO_Category)selected_categories.SelectedItem);
                selected_categories.ItemsSource = _selectedCategories;
                selected_categories.Items.Refresh();
            }
        }

        private void data_profiles_MouseDoubleClick(object sender, MouseButtonEventArgs e)
        {
            if (data_profiles.SelectedItem != null)
            {
                try
                {
                    Rs_Profile_Info item = (Rs_Profile_Info)data_profiles.SelectedItem;
                    StaticInfoCollections.GetInfoCollections();
                    new Prof(item.id_Profile.ToString()).ShowDialog();
                }
                catch (Exception ex)
                {
                    Console.WriteLine(ex.Message);
                }
            }
           
        }
    }
}
