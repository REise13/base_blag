using System;
using System.Collections.Generic;
using System.Linq;
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
using WpfApp_.Views.Lead;
using BaseDTO;
using RestSharp;
using Newtonsoft.Json;
namespace WpfApp_.Views.Lead
{
    public partial class HelpRequest : Window
    {
        private readonly Lead_Answers _answers;
        DTO_Lead_Reg lead;
        public HelpRequest()
        {
            InitializeComponent();
            IRestResponse<Lead_Answers> response = RestAPI.PostRest<Lead_Answers>("/Lead/Answers/");
            _answers= response.Data;

            lead = new DTO_Lead_Reg();
            DataContext = lead;
            

            Reason.ItemsSource = _answers.Reason;
            TypeOfHouse.ItemsSource = _answers.House;
            IsDistrictFire.ItemsSource = _answers.Bdisctrict;
            IsForceMigrant.ItemsSource = _answers.Migrant;
            Childrens.ItemsSource = _answers.Childrens;
            IsEmployable.ItemsSource = _answers.Family_unempl;
            FullFamily.ItemsSource = _answers.Family;
        }

        private void Window_Loaded(object sender, RoutedEventArgs e)
        {

        }

        private void Button_Click(object sender, RoutedEventArgs e)
        {
            StringBuilder categories = new StringBuilder();
            foreach (ListBoxItem item in Categories.SelectedItems)
            {
                categories.Append(item.Content.ToString() + ";");
            }
            if (Enother.IsChecked == true) categories.Append(EnotherCategory.Text);

            try
            {
                if (!String.IsNullOrEmpty(lead.Error))
                    throw new Exception(lead.Error);
                if (IncomeSourceNo.IsChecked == false && IncomeSourceYes.IsChecked == false)
                    throw new Exception("Выберите есть ли доход");
                if (IsHaveAdoptedNo.IsChecked == false && IsHaveAdoptedYes.IsChecked == false)
                    throw new Exception("Выберите есть ли приемные дети");
                if (VolunteerNo.IsChecked == false && VolunteerYes.IsChecked == false)
                    throw new Exception("Выберите желаете ли быть волонтером");

                lead.Adopted = IsHaveAdoptedYes.IsChecked == true ? (sbyte)1 : (sbyte)-1;
                lead.Income = IncomeSourceYes.IsChecked == true ? (sbyte)1 : (sbyte)-1;
                lead.Volunteer = VolunteerYes.IsChecked == true ? (sbyte)1 : (sbyte)-1;
                lead.Categories = categories.ToString();
                lead.Need = HelpType.Text;
                lead.Subcontact = Subcontact.Text;
                lead.Datelead = new DateTime(DateTime.Now.Year, DateTime.Now.Month, DateTime.Now.Day, 10, 0, 0);

                IRestResponse response = RestAPI.PostRest("/Lead/AddLead", lead);
                string id = response.Content;

            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "ERROR");
            }
           
        }

    }
}
