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
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using BaseDTO;
using Newtonsoft.Json;
using RestSharp;

namespace WpfApp_.Views.Profile
{

    public partial class Add_Help : Window
    {
        //lists for comboboxes
        private List<DTO_HelpType> _helpTypes;
        private List<DTO_Project_Get> _projects;
        private List<DTO_Donor> _donors;
        private int _profileId;

        public Add_Help(int profileId)
        {
            InitializeComponent();
            _profileId = profileId;

            _helpTypes = StaticInfoCollections.InfoCollections.helpTypes;
            _donors = StaticInfoCollections.InfoCollections.donors;

            using (HttpClient client = new HttpClient())
            {
                string json = JsonConvert.SerializeObject(RestAPI.RequestUserObj);
                var result = client.PostAsJsonAsync(Config.Connection + "/Project/Get/", RestAPI.RequestUserObj).Result;
                string resultContent = result.Content.ReadAsStringAsync().Result;
                _projects = JsonConvert.DeserializeObject<List<DTO_Project_Get>>(resultContent);
            }

            Donors_combox.ItemsSource = _donors;
            Types_combox.ItemsSource = _helpTypes;
            Projects_combox.ItemsSource = _projects;

            Donors_combox.SelectedValuePath = "id";
            Donors_combox.DisplayMemberPath = "title";
            Types_combox.SelectedValuePath = "id";
            Types_combox.DisplayMemberPath = "title";
            Projects_combox.SelectedValuePath = "Id";
            Projects_combox.DisplayMemberPath = "Title";
        }

        private async void Add_Click(object sender, RoutedEventArgs e)
        {

            try
            {
                if (Donors_combox.SelectedValue == null) throw new Exception("Донор не выбран");
                if (Types_combox.SelectedValue == null) throw new Exception("Тип помощи не выбран");
                if (Projects_combox.SelectedValue == null) throw new Exception("Проект не выбран");
                if (start_data.SelectedDate.Value == null) throw new Exception("Не выбрана дата начала проекта");
                if (end_data.SelectedDate.Value == null) throw new Exception("Не выбрана дата окончания проекта");


                DateTime data_start_to_export = new DateTime(start_data.SelectedDate.Value.Year,
                    start_data.SelectedDate.Value.Month,
                    start_data.SelectedDate.Value.Day,
                    10, 0, 0);

                DateTime data_end_to_export = new DateTime(end_data.SelectedDate.Value.Year,
                    end_data.SelectedDate.Value.Month,
                    end_data.SelectedDate.Value.Day,
                    10, 0, 0);

                DTO_Help_Add help_Add = new DTO_Help_Add()
                {
                    IdDonor = (int)Donors_combox.SelectedValue,
                    IdHelptype = (int)Types_combox.SelectedValue,
                    IdProfile = _profileId,
                    IdProject = (int)Projects_combox.SelectedValue,
                    StartDate = data_start_to_export,
                    EndDate = data_end_to_export
                };

                IRestResponse<string> response = await RestAPI.PostRestAsync<string>("/Help/Add/" + _profileId.ToString(), help_Add);
                this.Close();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Ошибка:" + ex.Message,"Ошибка");
            }

        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }
    }
}