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

namespace WpfApp_.Views.Information.Project
{
    /// <summary>
    /// Логика взаимодействия для AddProject.xaml
    /// </summary>
    public partial class AddProject : Window
    {
        public AddProject()
        {
            InitializeComponent();
        }

        private void Add_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                if (Name.Text.Equals("") || Name.Text.Equals(" ")) throw new Exception("Не введено название проекта");
                DTO_Project_Add project_Add = new DTO_Project_Add()
                {
                    Title = Name.Text
                };

                var result = RestAPI.PostRest("/Project/Add/", project_Add);
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
    }
}
