using BaseDTO;
using RestSharp;
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

namespace WpfApp_.Views
{
    /// <summary>
    /// Логика взаимодействия для LeadSearch.xaml
    /// </summary>
    public partial class LeadSearch : Window
    {
        private readonly Lead_Answers _answers;

        public LeadSearch()
        {
            InitializeComponent();
            
            IRestResponse<Lead_Answers> response = RestAPI.PostRest<Lead_Answers>("/Lead/Answers/");
            _answers = response.Data;
            Reason.ItemsSource = _answers.Reason;
            TypeOfHouse.ItemsSource = _answers.House;
            DistrictIsFire.ItemsSource = _answers.Bdisctrict;
            IsMigrant.ItemsSource = _answers.Migrant;
            IsHaveMinorsAnswers.ItemsSource = _answers.Childrens;
            IsEmployable.ItemsSource = _answers.Family_unempl;
            IsFullFamilyAnswers.ItemsSource = _answers.Family;

        }

        private void Search_Click(object sender, RoutedEventArgs e)
        {
            StringBuilder categories = new StringBuilder();
            foreach (ListBoxItem item in Categories.SelectedItems)
            {
                categories.Append(item.Content.ToString());
            }
            DateTime date = new DateTime();
            if (LeadDate.SelectedDate != null)
            {
                date = (DateTime)LeadDate.SelectedDate?.Date;
            }


            Fl_Lead fl = new Fl_Lead()
            {
                Fio = Representer.Text,
                Phone = Phone.Text,
                IdReason = Convert.ToInt32(Reason.SelectedValue),
                FioNeed = $"{Name.Text}  {SecondName.Text} {Patr.Text}",
                City = City.Text,
                IdTypeOfHouse = Convert.ToInt32(TypeOfHouse.SelectedValue),
                IdBdistrict = Convert.ToInt32(DistrictIsFire.SelectedValue),
                IdMigrant = Convert.ToInt32(IsMigrant.SelectedValue),
                IdFamUnemp = Convert.ToInt32(IsEmployable.SelectedValue),
                Income = IncomeYes.IsChecked == true ? (sbyte)1 : (sbyte)-1,
                IdFamily = Convert.ToInt32(IsFullFamilyAnswers.SelectedValue),
                Adopted = AdoptedYes.IsChecked == true ? (sbyte)1 : (sbyte)-1,
                Categories = categories.ToString(),
                Need = HelpAnswer.Text,
                Volunteer = VolunterYes.IsChecked == true ? (sbyte)1 : (sbyte)-1,
                IdChild = Convert.ToInt32(IsHaveMinorsAnswers.SelectedValue),
                Datelead = date
            };

            IRestResponse<List<DTO_Lead_Get>> searchResponse = RestAPI.PostRest<List<DTO_Lead_Get>>("/Search/Lead", fl);
            DataLeads.ItemsSource = searchResponse.Data;

        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }

        private void DataLeads_MouseDoubleClick(object sender, MouseButtonEventArgs e)
        {
            int id = ((DTO_Lead_Get)DataLeads.SelectedItem).Id;
            new LeadInfo(((DTO_Lead_Get)DataLeads.SelectedItem)).ShowDialog();
        }
    }
}
