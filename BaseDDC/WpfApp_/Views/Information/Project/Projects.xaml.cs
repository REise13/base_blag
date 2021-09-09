using System;
using System.Collections.Generic;
using BaseDTO;
using Newtonsoft.Json;
using System.Linq;
using System.Net.Http;
using System.Windows;

namespace WpfApp_.Views.Information.Project
{
    /// <summary>
    /// Логика взаимодействия для Projects.xaml
    /// </summary>
    /// 

    public partial class Projects : Window
    {
        private List<DTO_Project_Get> Project_list;


        public Projects()
        {
            InitializeComponent();
            Refresh();
        }

        private void Refresh()
        {
            using (HttpClient client = new HttpClient())
            {
                var result = client.PostAsJsonAsync(Config.Connection + "/Project/Get/", RestAPI.RequestUserObj).Result;
                string resultContent = result.Content.ReadAsStringAsync().Result;
                Project_list = JsonConvert.DeserializeObject<List<DTO_Project_Get>>(resultContent);
            }
            data_projects.ItemsSource = Project_list;
        }

        private void Add_Click(object sender, RoutedEventArgs e)
        {
            new AddProject().ShowDialog();
            Refresh();
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }
    }

}
