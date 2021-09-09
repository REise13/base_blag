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

namespace DDC_App.Views.Information.Category
{
    /// <summary>
    /// Логика взаимодействия для Categories.xaml
    /// </summary>
    public partial class Categories : Window
    {

        private List<DTO_Category> categories_list { get; set; }

        public Categories()
        {
            InitializeComponent();
            categories_list = StaticInfoCollections.InfoCollections.categories;
            data_grid.DisplayMemberPath = "title";
            data_grid.SelectedValuePath = "id";
            data_grid.ItemsSource = categories_list;
        }

        private void Add_Click(object sender, RoutedEventArgs e)
        {
            new AddCategory(categories_list).ShowDialog();
            StaticInfoCollections.GetInfoCollections();
            categories_list = StaticInfoCollections.InfoCollections.categories;
            data_grid.ItemsSource = categories_list;
        }

        private void Remove_Click(object sender, RoutedEventArgs e)
        {
            var item = (DTO_Category)data_grid.SelectedItem;
            var id = item.id;
            var result =  RestAPI.PostRest("/Category/Delete/" + id);
            StaticInfoCollections.GetInfoCollections();
            categories_list = StaticInfoCollections.InfoCollections.categories;
            data_grid.ItemsSource = categories_list;
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }

        private void data_grid_MouseDoubleClick(object sender, MouseButtonEventArgs e)
        {
            var item = (DTO_Category)data_grid.SelectedItem;
            new EditCategory(categories_list, item).ShowDialog();
            StaticInfoCollections.GetInfoCollections();
            categories_list = StaticInfoCollections.InfoCollections.categories;
            data_grid.ItemsSource = categories_list;
        }
    }
}
