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
using WpfApp_;

namespace DDC_App.Views.Information.Training
{
    /// <summary>
    /// Логика взаимодействия для Categories.xaml
    /// </summary>
    public partial class Trainings : Window
    {
        private List<DTO_Training> training_list { get; set; }

        public Trainings()
        {
            InitializeComponent();
            training_list = StaticInfoCollections.InfoCollections.trainings;
            data_grid.DisplayMemberPath = "title";
            data_grid.SelectedValuePath = "id";
            data_grid.ItemsSource = training_list;
        }

        private void Add_Click(object sender, RoutedEventArgs e)
        {
            new AddTraining(training_list).ShowDialog();
            StaticInfoCollections.GetInfoCollections();
            training_list = StaticInfoCollections.InfoCollections.trainings;
            data_grid.ItemsSource = training_list;
        }

        private void Remove_Click(object sender, RoutedEventArgs e)
        {
            var item = (DTO_Training)data_grid.SelectedItem;
            var id = item.id;
            var result = RestAPI.PostRest("/Training/Delete/" + id);
            StaticInfoCollections.GetInfoCollections();
            training_list = StaticInfoCollections.InfoCollections.trainings;
            data_grid.ItemsSource = training_list;
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }

        private void data_grid_MouseDoubleClick(object sender, MouseButtonEventArgs e)
        {
            var item = (DTO_Training)data_grid.SelectedItem;
            new EditTraining(training_list, item).ShowDialog();
            StaticInfoCollections.GetInfoCollections();
            training_list = StaticInfoCollections.InfoCollections.trainings;
            data_grid.ItemsSource = training_list;
        }
    }
}
