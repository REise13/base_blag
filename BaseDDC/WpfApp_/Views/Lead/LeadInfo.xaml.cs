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
using BaseDTO;
using WpfApp_.Views.Registration;

namespace WpfApp_.Views.Lead
{
    /// <summary>
    /// Логика взаимодействия для LeadInfo.xaml
    /// </summary>
    public partial class LeadInfo : Window
    {
        DTO_Lead_Get _lead;
        public LeadInfo(DTO_Lead_Get lead)
        {
            InitializeComponent();

            _lead = lead;
            DataContext = _lead;

            Income.Content = _lead.Income == 1 ? "Да" : "Нет";
            Adopted.Content = _lead.Adopted == 1 ? "Да" : "Нет";
            Volunteer.Content = _lead.Volunteer == 1 ? "Да" : "Нет";
            Categories.ItemsSource = _lead.Categories.Split(';');

            dateAnswers.Content = $"{lead.Datelead.Day} / {lead.Datelead.Month} / {lead.Datelead.Year}";
        }

        private void Register_Click(object sender, RoutedEventArgs e)
        {
            new RegistrationProfile(_lead).Show();
            this.Close();
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }
    }
}
