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

namespace DDC_App.Views.Information.Need
{
    /// <summary>
    /// Логика взаимодействия для Categories.xaml
    /// </summary>
    public partial class Needs : Window
    {

        private List<DTO_Need> needs_list { get; set; }

        public Needs()
        {
            InitializeComponent();
            needs_list = StaticInfoCollections.InfoCollections.needs;
            data_grid.DisplayMemberPath = "title";
            data_grid.SelectedValuePath = "id";
            data_grid.ItemsSource = needs_list;
        }

        private void Add_Click(object sender, RoutedEventArgs e)
        {
            new AddNeed(needs_list).ShowDialog();
            StaticInfoCollections.GetInfoCollections();
            needs_list = StaticInfoCollections.InfoCollections.needs;
            data_grid.ItemsSource = needs_list;
        }

        private void Remove_Click(object sender, RoutedEventArgs e)
        {
            var item = (DTO_Need)data_grid.SelectedItem;
            var id = item.id;
            var result =  RestAPI.PostRest("/Need/Delete/" + id);
            StaticInfoCollections.GetInfoCollections();
            needs_list = StaticInfoCollections.InfoCollections.needs;
            data_grid.ItemsSource = needs_list;
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }

        private void data_grid_MouseDoubleClick(object sender, MouseButtonEventArgs e)
        {
            var item = (DTO_Need)data_grid.SelectedItem;
            new EditNeed(needs_list, item).ShowDialog();
            StaticInfoCollections.GetInfoCollections();
            needs_list = StaticInfoCollections.InfoCollections.needs;
            data_grid.ItemsSource = needs_list;
        }
    }
}
