using System.Collections.Generic;
using System.Net.Http;
using System.Threading.Tasks;
using System.Windows;
using BaseDTO;
using WpfApp_;
using Newtonsoft.Json;
using System;
using DDC_App;
using WpfApp_.Views;
using DDC_App.Views.Information.Need;
using DDC_App.Views.Information.Category;
using DDC_App.Views.Information.Training;
using WpfApp_.Views.Profile;
using WpfApp_.Views.Information.Project;
using WpfApp_.Views.Lead;
using WpfApp_.Views.Registration;

namespace WpfApp_
{
   
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
            UserName.Content = String.Format(" {0} {1} {2}", RestAPI.User.FName, RestAPI.User.SName, RestAPI.User.Role.title);

            if (RestAPI.User.Role.title != "admin")
            {
                RegistrationUser.Visibility = Visibility.Hidden;
            }
        }

        private void Registration_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                StaticInfoCollections.GetInfoCollections();
                new RegistrationProfile().ShowDialog();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Ошибка");
            }
        }
        
        private void Search_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                StaticInfoCollections.GetInfoCollections();
                new Search().ShowDialog();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Ошибка");
            }
        }

        private void Test_Click(object sender, RoutedEventArgs e)
        {
            //GeoHelp.Test("Донецк");
        }

        private void Projects_Click(object sender, RoutedEventArgs e)
        {
            StaticInfoCollections.GetInfoCollections();
            new Projects().Show();
        }

        private void Category_Click(object sender, RoutedEventArgs e)
        {
            StaticInfoCollections.GetInfoCollections();
            new Categories().ShowDialog();
        }
        private void Need_Click(object sender, RoutedEventArgs e)
        {
            StaticInfoCollections.GetInfoCollections();
            new Needs().ShowDialog();
        }
        private void Training_Click(object sender, RoutedEventArgs e)
        {
            StaticInfoCollections.GetInfoCollections();
            new Trainings().ShowDialog();
        }

        private void LeadSearch_Click(object sender, RoutedEventArgs e)
        {
            new LeadSearch().ShowDialog();
        }

        private void LeadProfile_Click(object sender, RoutedEventArgs e)
        {
            new HelpRequest().ShowDialog();
        }

        private void RegistrationUser_Click(object sender, RoutedEventArgs e)
        {
            new RegistrationUser().ShowDialog();
        }
    }
}
